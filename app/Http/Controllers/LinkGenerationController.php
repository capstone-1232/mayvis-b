<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Proposal;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Draft;
use App\Mail\FeedbackSubmitted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LinkGenerationController extends Controller
{
    public function generateLink(Request $request)
    {
        $stepData = [
            'step1_data' => $request->session()->get('step1_data'),
            'step2_data' => $request->session()->get('step2_data'),
            'step3_data' => $request->session()->get('step3_data'),
            'step4_data' => $request->session()->get('step4_data'),
        ];

        if (array_search(null, $stepData, true) !== false) {
            return redirect()->route('dashboard')->with('error', 'Your session has expired. Please try again.');
        }

        $client = Client::updateOrCreate(
            [
                'first_name' => $stepData['step1_data']['first_name'],
                'last_name' => $stepData['step1_data']['last_name'],
                'email' => $stepData['step1_data']['email'],
                'phone_number' => $stepData['step1_data']['phone_number'],
            ],
            [
                'company_name' => $stepData['step1_data']['company_name'] ?? 'Default Company',
            ]
        );
        
        
        $uniqueToken = Str::random(60); // Generate a unique token

        $proposalData = [
            'created_by' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
            'proposal_title' => $stepData['step2_data']['proposal_title'],
            'start_date' => $stepData['step2_data']['start_date'],
            'proposal_price' => $stepData['step4_data']['proposalTotal'] ?? "No Price",
            'status' => 'Pending',
            'client_id' => $client->id,
            'user_id' => Auth::id(),
            'product_id' => implode(',', array_keys($stepData['step4_data']['selectedProducts'] ?? [])),
            'unique_token' => $uniqueToken,
        ];

        $proposal = Proposal::updateOrCreate(
            [
                // Assuming these fields together uniquely identify a proposal.
                'client_id' => $client->id,
                'user_id' => Auth::id(),
                'proposal_title' => $stepData['step2_data']['proposal_title'],
                'start_date' => Carbon::parse($stepData['step2_data']['start_date'])->format('Y-m-d'),
            ],
            $proposalData
        );
        
        // Save the proposal as a draft
        $this->saveProposalAsDraft($proposal);

        // Generate the view link for the proposal
        $viewLink = route('proposals.view-by-token', ['token' => $uniqueToken]);
        $proposal->view_link = $viewLink;
        $proposal->save();

        $draftId = $request->session()->get('draftId');
    
        $request->session()->forget(['step1_data', 'step2_data', 'step3_data', 'step4_data', 'draftId']);

        return view('links.link-generated', ['link' => $viewLink]);
    }

    public function linkFeedback(Request $request)
    {
        $proposalId = $request->input('proposalId');
        $proposal = Proposal::findOrFail($proposalId);
        $updateStatus = $request->input('updateStatus');
        $clientMessage = $request->input('clientMessage') ?? '';

        $validator = Validator::make($request->all(), [
            'updateStatus' => 'required|in:1,2',
        ], [
            'updateStatus.required' => 'You must select a status update option.',
            'updateStatus.in' => 'Invalid selection for status update.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Update the proposal status based on the client's feedback
            $proposal->status = $updateStatus == '1' ? 'Approved' : 'Denied';
            $proposal->save();

            // Handle the draft based on the proposal's new status
            if ($updateStatus == '1') {
                // Fetch the formatted start date
                $formattedStartDate = $proposal->start_date instanceof \Carbon\Carbon ? 
                                      $proposal->start_date->format('Y-m-d') : 
                                      $proposal->start_date;
    
                // Identify and delete the draft based on composite keys
                $draft = Draft::where([
                    'user_id' => $proposal->user_id,
                    'client_id' => $proposal->client_id,
                    'proposal_title' => $proposal->proposal_title,
                    'start_date' => $formattedStartDate,
                ])->first();
    
                if ($draft) {
                   $draft->delete();
                }
            } elseif ($updateStatus == '2') {
                $formattedStartDate = $proposal->start_date;

                // If $proposal->start_date is an instance of Carbon, then format it.
                if ($proposal->start_date instanceof \Carbon\Carbon) {
                    $formattedStartDate = $proposal->start_date->format('Y-m-d');
                }
                $draft = Draft::where([
                    'user_id' => $proposal->user_id,
                    'client_id' => $proposal->client_id,
                    'proposal_title' => $proposal->proposal_title,
                    'start_date' => $formattedStartDate,
                ])->first();

                if ($draft) {
                    $draft->status = 'Denied';
                    $draft->save();
                }

            }

            // Send feedback email
            $user = User::findOrFail($proposal->user_id);
            Mail::to($user->email)->send(new FeedbackSubmitted(
                $proposal->proposal_title,
                $proposal->status,
                $clientMessage,
                $user->first_name . ' ' . $user->last_name
            ));

            DB::commit();

            return $updateStatus == '1'
                ? redirect()->route('proposals.success')->with('status', 'Feedback submitted successfully!')
                : redirect()->route('proposals.denied')->with('status', 'Feedback submitted and proposal denied.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error processing feedback: " . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An error occurred while processing your feedback.');
        }
    }



    public function saveProposalAsDraft(Proposal $proposal)
    {
        $productIdsString = $proposal->product_id;

        // Collect all data related to the proposal
        $stepData = [
            'step1_data' => session('step1_data', []),
            'step2_data' => session('step2_data', []),
            'step3_data' => session('step3_data', []),
            'step4_data' => session('step4_data', [])
        ];

        // Check if session data is empty and use data from the Proposal if needed
        foreach ($stepData as $key => $value) {
            if (empty($value) && isset($proposal->$key)) {
                $stepData[$key] = $proposal->$key;
            }
        }


        $stepDataJson = json_encode($stepData);

        // Use updateOrCreate to save or update the draft
        $draft = Draft::updateOrCreate(
            [
                'proposal_title' => $proposal->proposal_title,
                'start_date' => $proposal->start_date ? Carbon::parse($proposal->start_date)->format('Y-m-d') : null,
                'user_id' => $proposal->user_id,
                'client_id' => $proposal->client_id,     
            ],
            [
                'status' => 'Pending',
                'created_by' => $proposal->created_by,
                'proposal_price' => $proposal->proposal_price,
                'product_id' => $productIdsString,
                'unique_token' => $proposal->unique_token,
                'data' => $stepDataJson,
            ]
        );
    }




    public function viewProposalByToken(Request $request, $token)
    {
        $proposal = Proposal::where('unique_token', $token)->firstOrFail();

        // Decode the 'data' field from the proposal
        $data = json_decode($proposal->data, true);

        // Check if the proposal was denied and we have 'selectedProducts' in the 'data' field
        if ($proposal->status === 'Denied' && isset($data['step4_data']['selectedProducts'])) {
            $products = collect($data['step4_data']['selectedProducts']); // Convert array to collection if needed
        } else {
            // Fetch the products based on product_id or an alternative method
            $productIds = explode(',', $proposal->product_id);
            $products = Product::whereIn('id', $productIds)->get();
        }

        // Fetch the client and user data associated with the proposal
        $client = $proposal->client; 
        $user = $proposal->user; 

        // Pass the necessary data to the view
        return view('proposals.view-by-token', [
            'proposal' => $proposal,
            'products' => $products, // This is now either a collection from the 'data' field or from the database
            'users' => $user ? [$user] : [], // Wrap the user in an array for consistency
            // 'quantities' is not needed if quantities are included in 'selectedProducts'
            'selectedProducts' => $products,
            'proposalTotal' => $proposal->status === 'Denied' ? $data['step4_data']['proposalTotal'] : null,
        ]);
    }







    // public function viewLink(Request $request, $token)
    // {
    //     $proposal = Proposal::where('unique_token', $token)->firstOrFail();

    //     $step1Data = session('step1_data');
    //     $step2Data = session('step2_data');
    //     $step3Data = session('step3_data');
    //     $step4Data = session('step4_data');

    //     $senderName = $step3Data['sender'] ?? '';
    //     $users = User::select('job_title', 'automated_message', 'first_name', 'last_name', 'profile_image')
    //                   ->where('email', 'like', '%' . $senderName . '%')
    //                   ->get();

    //     $proposalId = $request->session()->get('proposalId');

    //     if (!$proposalId) {
    //         return redirect()->back()->with('error', 'Proposal ID not found in session.');
    //     }

    //     return view('links.view-link', compact('step1Data', 'step2Data', 'step3Data', 'step4Data', 'users') + ['proposalId' => $proposalId]);
    // }

}
