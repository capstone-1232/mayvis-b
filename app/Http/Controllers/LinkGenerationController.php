<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class LinkGenerationController extends Controller
{
    public function generateLink(Request $request)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        if ($request->session()->get('feedback_submitted', false)) {
            return redirect()->route('dashboard')->with('message', 'Feedback already processed.');
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

        // Assuming $proposalData contains 'proposal_title' and other relevant data

        // Condition based on the 'proposal_title' attribute
        $condition = ['proposal_title' => $proposalData['proposal_title']];


        // Data for updating the record
        // Remove 'proposal_title' from $updateValues if you don't want to update it
        $updateValues = $proposalData;

        // Update an existing record or create a new one based on the condition
        $proposal = Proposal::updateOrCreate($condition, $updateValues);

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

        // Retrieve session data
        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');
        $step4Data = session('step4_data');

        /* This Snippet of code filters the database to display the profile_image, automated_message, first + last name of the user entered as a "sender" on step 3.*/

        // Filter users based on sender's name
        $senderName = $step3Data['sender'] ?? ''; // Make sure this key exists and has a default
        $users = User::select('job_title', 'automated_message', 'first_name', 'last_name', 'profile_image')
                      ->where('last_name', 'like', '%' . $senderName . '%')
                      ->get();

        $userData = $users;

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
        return view('links.view-link', compact('step1Data', 'step2Data', 'step3Data', 'step4Data', 'userData') + ['proposalId' => $proposalId]);
    }

    public function linkFeedback(Request $request){
        $proposalId = $request->input('proposalId');
        $proposal = Proposal::findOrFail($proposalId);
        $updateStatus = $request->input('updateStatus');

        // Validate the request
        $rules = [
            'updateStatus' => 'required|in:1,2', // Ensure updateStatus is required and its value must be '1' or '2'
            // Add any other fields you need to validate here
        ];

        $messages = [
            'updateStatus.required' => 'You must select a status update option.',
            'updateStatus.in' => 'Invalid selection for status update.', // Custom message for invalid input
            // Add any other custom messages for other fields here
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // Redirect back to the form with input and errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if the updateStatus checkbox was checked and its value is '1'
        if ($updateStatus == '1') {
            $proposal->status = 'Approved'; 
        } else if($updateStatus == '2'){
            $proposal->status = 'Denied';
        }

        $proposal->save();

        // This is a flag that allows us to no longer change its status on the database when feedback has already been submitted.
        $request->session()->put('feedback_submitted', true);

        // Handle the client message here as before
        $message = $request->input('clientMessage');
        // Process the message as needed

        // Prevent the client from refreshing the page and populating the database.
        return redirect()->route('proposals.success')->with('status', 'Form submitted successfully!');
    }
}
