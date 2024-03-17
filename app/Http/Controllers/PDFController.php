<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;


class PDFController extends Controller
{
    public function generatePDF(Request $request)
    {

        // Ensure the user is authenticated
        if (!Auth::check()) {
            // Redirect the user to login page or show an error message
            return redirect()->route('login')->with('error', 'You must be logged in to submit a proposal.');
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
                      ->where('email', 'like', '%' . $senderName . '%')
                      ->get();

        // Extract the keys from the selectedProducts array, which are the product IDs
        $productIds = array_keys($step4Data['selectedProducts']);

        // Convert the array of product IDs to a comma-separated string
        $productIdsString = implode(',', $productIds);


        // Create or update the client information
        $client = Client::updateOrCreate(
            [
                'first_name' => $step1Data['first_name'], 
                'last_name' => $step1Data['last_name'],
                'email' => $step1Data['email']
            ], 
            $step1Data
        );
        

        // Create the data array with all the session data and any additional data for the PDF.
        $data = [
            'step1Data' => $step1Data,
            'step2Data' => $step2Data,
            'step3Data' => $step3Data,
            'step4Data' => $step4Data,
            'users' => $users,
        ];

        // Load the view and pass the data array to it.
        $pdf = PDF::loadView('pdf.sessionInfo', $data);

        // Generate the PDF to download with a dynamic filename based on proposal data.
        $filename = 'Proposal-' . $step2Data['proposal_title'] . '-' . $step2Data['start_date'] . '.pdf';

        // Return the generated PDF.
        return $pdf->download($filename);
    }
}
