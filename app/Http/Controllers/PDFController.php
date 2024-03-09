<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;


class PDFController extends Controller
{
    public function generatePDF(Request $request)
    {
        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');
        $step4Data = session('step4_data'); 

        $sessionData = $request->session()->all();

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
            'created_by' => Auth::user()->name,
            'proposal_title' => $step2Data['proposal_title'],
            'start_date' => $step2Data['start_date'],
            'client_id' => $client->id,
            'user_id' => Auth::id(),
            'product_id' => $productIdsString,
        ];

        // Create a new proposal
        $proposal = Proposal::create($proposalData);
        
        
        // Load a view where you pass the session data
        $pdf = PDF::loadView('pdf.sessionInfo', compact('step1Data', 'step2Data', 'step3Data', 'step4Data', 'sessionData'));
        
        // Return the generated PDF
        return $pdf->download('session-information.pdf');
    }
}
