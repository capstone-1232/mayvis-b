<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Proposal;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PDFController extends Controller
{
    public function generatePDF(Request $request)
    {
        // Retrieve session data
        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');
        $step4Data = session('step4_data');

        // Ensure all necessary session data exists
        if (in_array(null, [$step1Data, $step2Data, $step3Data, $step4Data], true)) {
            return redirect()->route('dashboard')->with('error', 'Your session has expired. Please try again.');
        }

        // Fetch product details using product IDs
        $productIds = array_keys($step4Data['selectedProducts']);
        // Fetch detailed product information instead of just names
        $products = Product::whereIn('id', $productIds)->get(); // Fetch full product objects


        // Create or update client information
        $client = Client::updateOrCreate(
            [
                'first_name' => $step1Data['first_name'],
                'last_name' => $step1Data['last_name'],
                'email' => $step1Data['email']
            ],
            $step1Data
        );

        // Generate the PDF data
        $pdfData = [
            'step1Data' => $step1Data,
            'step2Data' => $step2Data,
            'step3Data' => $step3Data,
            'step4Data' => $step4Data,
            'client' => $client,
            'users' => [],
            'products' => $products, // Pass product details to the view
        ];

        // Filter users based on sender's name
        $senderName = $step3Data['sender'] ?? '';
        if ($senderName) {
            $pdfData['users'] = User::select('job_title', 'automated_message', 'first_name', 'last_name', 'profile_image', 'proposal_message')
                ->where('email', 'like', '%' . $senderName . '%')
                ->get();
        }

        // Generate a unique filename for the PDF
        $filename = 'Proposal-' . $step2Data['proposal_title'] . '-' . $step2Data['start_date'] . '.pdf';

        // Generate the PDF using the data
        $pdf = PDF::loadView('pdf.sessionInfo', $pdfData);

        // Download the PDF
        return $pdf->download($filename);
    }
}
