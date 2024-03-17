<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Proposal;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Draft;
use App\Mail\FeedbackSubmitted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LinkGenerationController extends Controller
{
    public function generateLink(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        // If feedback was already submitted, redirect to dashboard to prevent duplication
        if ($request->session()->get('feedback_submitted', false)) {
            // Clean up session related to proposal creation to start fresh next time
            $request->session()->forget(['feedback_submitted', 'step1_data', 'step2_data', 'step3_data', 'step4_data', 'proposalId', 'uniqueToken', 'generatedLink']);
            return redirect()->route('dashboard')->with('message', 'Feedback already processed. Starting a new session.');
        }

        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');
        $step4Data = session('step4_data');

        // Checks if any of the session data is empty to avoid exceptions
        if ($step1Data === null || $step2Data === null || $step3Data === null || $step4Data === null) {
            return redirect()->route('dashboard')->with('error', 'Your session has expired. Please try again.');
        }

        // Client updateOrCreate
        $client = Client::updateOrCreate(
            [
                'first_name' => $step1Data['first_name'],
                'last_name' => $step1Data['last_name'],
                'email' => $step1Data['email'],
                'phone_number' => $step1Data['phone_number'],
            ],
            $step1Data
        );

        $proposalData = [
            'created_by' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
            'proposal_title' => $step2Data['proposal_title'],
            'start_date' => $step2Data['start_date'],
            'proposal_price' => $step4Data['proposalTotal'] ?? "No Price",
            'status' => 'Pending',
            'client_id' => $client->id,
            'user_id' => Auth::id(),
            'product_id' => implode(',', array_keys($step4Data['selectedProducts'])),
        ];

        $proposal = Proposal::updateOrCreate(
            [
                'client_id' => $proposalData['client_id'],
                'user_id' => $proposalData['user_id'],
                'proposal_title' => $proposalData['proposal_title'],
                'start_date' => $proposalData['start_date'],
            ],
            $proposalData
        );

        // Store Proposal ID into the session
        $request->session()->put('proposalId', $proposal->id);

        // Unique Token initialization
        $uniqueToken = uniqid();

        // Unique token will allow us to uniquely identify the feedback
        $request->session()->put('uniqueToken', $uniqueToken);

        $link = URL::temporarySignedRoute('link.view', now()->addMinutes(2880), ['token' => $uniqueToken]);
        $request->session()->put('generatedLink', $link);

        // Draft deletion logic is kept as is
        if ($draftId = session('draftId')) {
            $draft = Draft::find($draftId);
            if ($draft) {
                $draft->delete();
                session()->forget('draftId');
            }
        }

        return view('links.link-generated', ['link' => $link]);
    }

    public function viewLink(Request $request, $token)
    {
        if (!$request->hasValidSignature() || $request->session()->get('uniqueToken') !== $token) {
            abort(403);
        }

        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');
        $step4Data = session('step4_data');

        $senderName = $step3Data['sender'] ?? '';
        $users = User::select('job_title', 'automated_message', 'first_name', 'last_name', 'profile_image')
                      ->where('email', 'like', '%' . $senderName . '%')
                      ->get();

        $proposalId = $request->session()->get('proposalId');

        if (!$proposalId) {
            return redirect()->back()->with('error', 'Proposal ID not found in session.');
        }

        return view('links.view-link', compact('step1Data', 'step2Data', 'step3Data', 'step4Data', 'users') + ['proposalId' => $proposalId]);
    }

    public function linkFeedback(Request $request)
    {
        $proposalId = $request->input('proposalId');
        $proposal = Proposal::findOrFail($proposalId);
        $updateStatus = $request->input('updateStatus');
        $userName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $clientMessage = $request->input('clientMessage') ?? ''; // Default to an empty string if not provided

        // Early return if feedback was already processed, to avoid duplicating actions
        if ($request->session()->get('feedback_submitted', false)) {
            return redirect()->route('dashboard')->with('message', 'Feedback has already been processed.');
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'updateStatus' => 'required|in:1,2',
        ], [
            'updateStatus.required' => 'You must select a status update option.',
            'updateStatus.in' => 'Invalid selection for status update.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Process feedback based on the update status
        if ($updateStatus == '1') { // Approved
            $proposal->status = 'Approved';
            $proposal->save();
        } elseif ($updateStatus == '2') { // Denied
            $proposal->status = 'Denied';
            $proposal->save();

            // Saving the proposal as a draft if denied
            $this->saveProposalAsDraft($proposal);

            // Flagging the feedback as submitted to prevent re-submission
            $request->session()->put('feedback_submitted', true);

            // Redirecting to the draft list or an appropriate page
            return redirect()->route('proposals.denied');
        }

        // Send feedback email for both approved and denied scenarios
        Mail::to(Auth::user()->email)->send(new FeedbackSubmitted(
            $proposal->proposal_title,
            $proposal->status,
            $clientMessage,
            $userName
        ));

        // Flag feedback as submitted to prevent re-submission, for both approved and denied scenarios
        $request->session()->put('feedback_submitted', true);

        // Clearing session data related to the proposal process
        $request->session()->forget(['step1_data', 'step2_data', 'step3_data', 'step4_data', 'proposalId', 'uniqueToken']);

        // Redirect to a success page or dashboard after feedback submission
        return redirect()->route('proposals.success')->with('status', 'Feedback submitted successfully!');
    }


    public function saveProposalAsDraft(Proposal $proposal)
    {
        $productIdsString = $proposal->product_id; 

        // Collect all data related to the proposal
        // Use the step data from the session
            $stepDataJson = json_encode([
                'step1_data' => session('step1_data', []),
                'step2_data' => session('step2_data', []),
                'step3_data' => session('step3_data', []),
                'step4_data' => session('step4_data', [])
            ]);

            // Create a new draft entry using the data from the proposal
            $draft = Draft::create([
                'user_id' => $proposal->user_id,
                'created_by' => $proposal->created_by,
                'proposal_title' => $proposal->proposal_title,
                'status' => 'Denied',
                'start_date' => $proposal->start_date ? Carbon::parse($proposal->start_date)->format('Y-m-d') : null,
                'proposal_price' => $proposal->proposal_price,
                'client_id' => $proposal->client_id,
                'product_id' => $productIdsString,
                'data' => $stepDataJson, // Use the step data JSON
            ]);

        
    }

}
