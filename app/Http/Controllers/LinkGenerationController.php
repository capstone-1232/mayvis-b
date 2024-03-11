<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class LinkGenerationController extends Controller
{
    public function generateLink(Request $request)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        // Retrieve session data
        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');
        $step4Data = session('step4_data');

        // Extract the keys from the selectedProducts array, which are the product IDs
        $productIds = array_keys($step4Data['selectedProducts']);

        // Convert the array of product IDs to a comma-separated string
        $productIdsString = implode(',', $productIds);


        // Create or update the client information
        $client = Client::updateOrCreate(
            ['email' => $step1Data['email']], // Unique identifier for the client
            $step1Data
        );

        // Prepare proposal data
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

        // Create a new proposal
        $proposal = Proposal::create($proposalData);

        $request->session()->put('proposalId', $proposal->id);

        // Generate a random or unique token for the session data
        $uniqueToken = uniqid();

        // Store the session data in the database or cache with the token as a key if needed,
        // or use the token to retrieve the session data directly.

        // For now, we'll just store the token in the session for simplicity
        $request->session()->put('uniqueToken', $uniqueToken);

        // Generate the view link with the token
        $link = URL::temporarySignedRoute(
            'link.view', now()->addMinutes(2880), ['token' => $uniqueToken]
        );

        // Return a view that displays the generated link
        return view('links.link-generated', ['link' => $link]);
    }

    public function viewLink(Request $request, $token)
    {
        // Check for a valid signature and token
        if (!$request->hasValidSignature() || $request->session()->get('uniqueToken') !== $token) {
            abort(403);
        }

        $proposalId = $request->session()->get('proposalId');
    
        // Make sure you check if the proposalId was retrieved successfully
        if (!$proposalId) {
            // Handle the error, perhaps redirect back with an error message
            return redirect()->back()->with('error', 'Proposal ID not found in session.');
        }

        // Retrieve the session data using the token
        $step1Data = $request->session()->get('step1_data');
        $step2Data = $request->session()->get('step2_data');
        $step3Data = $request->session()->get('step3_data');
        $step4Data = $request->session()->get('step4_data');

        // Return a view that displays the data
        return view('links.view-link', compact('step1Data', 'step2Data', 'step3Data', 'step4Data') + ['proposalId' => $proposalId]);
    }

    public function linkFeedback(Request $request){
        $proposalId = $request->input('proposalId');
        $proposal = Proposal::findOrFail($proposalId);
        $updateStatus = $request->input('updateStatus');

        // Check if the updateStatus checkbox was checked and its value is '1'
        if ($updateStatus == '1') {
            // Perform the action you need if updateStatus is checked (value = '1')
            $proposal->status = 'Approved'; 
        } else if($updateStatus == '2'){
            $proposal->status = 'Denied';
        }

        $proposal->save();

        // Handle the client message here as before
        $message = $request->input('clientMessage');
        // Process the message as needed

        // Prevent the client from refreshing the page and populating the database.
        return redirect()->route('proposals.success')->with('status', 'Form submitted successfully!');
    }
}
