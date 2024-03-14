<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Proposal;
use App\Models\User;
use App\Models\Draft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class LinkGenerationController extends Controller
{
    public function generateLink(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');
        $step4Data = session('step4_data');

        // This checks if any of the session data is empty to avoid throwing an exception when attempting to acccess array for $client
        if ($step1Data === null || $step2Data === null || $step3Data === null || $step4Data === null) {
            // Redirect to dashboard with an error message
            return redirect()->route('dashboard')->with('error', 'Your session has expired. Please try again.');
        }

        if ($request->session()->get('feedback_submitted', false)) {
            return redirect()->route('dashboard')->with('message', 'Feedback already processed.');
        }

        $productIds = array_keys($step4Data['selectedProducts']);
        $productIdsString = implode(',', $productIds);

        $client = Client::updateOrCreate(
            ['email' => $step1Data['email']],
            $step1Data
        );

        $proposalData = [
            'created_by' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
            'proposal_title' => $step2Data['proposal_title'],
            'start_date' => $step2Data['start_date'],
            'proposal_price' => $step4Data['proposalTotal'] ? $step4Data['proposalTotal'] : "No Price",
            'status' => 'Pending',
            'client_id' => $client->id,
            'user_id' => Auth::id(),
            'product_id' => $productIdsString,
        ];

        $proposal = Proposal::updateOrCreate(
            ['proposal_title' => $proposalData['proposal_title']],
            $proposalData
        );

        $request->session()->put('proposalId', $proposal->id);

        $uniqueToken = uniqid();
        $request->session()->put('uniqueToken', $uniqueToken);

        $link = URL::temporarySignedRoute(
            'link.view', now()->addMinutes(2880), ['token' => $uniqueToken]
        );

        // After successfully finalizing the proposal
        if ($draftId = session('draftId')) {
            $draft = Draft::find($draftId);
            if ($draft) {
                $draft->delete();
                session()->forget('draftId'); // Clean up the session
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

        $validator = Validator::make($request->all(), [
            'updateStatus' => 'required|in:1,2',
        ], [
            'updateStatus.required' => 'You must select a status update option.',
            'updateStatus.in' => 'Invalid selection for status update.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $proposal->status = $updateStatus == '1' ? 'Approved' : 'Denied';
        $proposal->save();

        $request->session()->put('feedback_submitted', true);

        // Forget all proposal-related session data after submission
        $request->session()->forget(['step1_data', 'step2_data', 'step3_data', 'step4Data', 'proposalId', 'uniqueToken', 'feedback_submitted']);

        // dd(session()->all());

        return redirect()->route('proposals.success')->with('status', 'Form submitted successfully!');
    }
}
