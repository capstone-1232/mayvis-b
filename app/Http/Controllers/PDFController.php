<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Proposal;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Mpdf\Mpdf;
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
        $products = Product::whereIn('id', $productIds)->get(); // Fetch full product objects

        // Extract descriptions (project scopes) from the selected products
        $projectScopes = collect($step4Data['selectedProducts'])
            ->pluck('description')
            ->map(function ($description) {
                return strip_tags($description); // Strip HTML tags if you just want the text
            })
            ->all(); // Convert the collection to an array

        // Create or update client information
        $client = Client::updateOrCreate(
            [
                'first_name' => $step1Data['first_name'],
                'last_name' => $step1Data['last_name'],
                'email' => $step1Data['email']
            ],
            $step1Data
        );

        // Prepare the data for the PDF
        $pdfData = [
            'step1Data' => $step1Data,
            'step2Data' => $step2Data,
            'step3Data' => $step3Data,
            'step4Data' => $step4Data,
            'client' => $client,
            'users' => [],
            'projectScopes' => $projectScopes,
            'products' => $products,
        ];

        // Filter users based on sender's name
        $senderName = $step3Data['sender'] ?? '';
        if ($senderName) {
            $pdfData['users'] = User::where('email', 'like', '%' . $senderName . '%')
                ->get(['job_title', 'automated_message', 'first_name', 'last_name', 'profile_image', 'proposal_message']);
        }

        // Create a new instance of mPDF
        $mpdf = new Mpdf();

        // Load your view with data
        // Note: mPDF does not have a direct loadView method like DomPDF, so you use the view() helper to get the HTML content
        $html = view('pdf.sessionInfo', $pdfData)->render();

        // Write the HTML content to the PDF
        $mpdf->WriteHTML($html);

        // Generate a unique filename for the PDF
        $filename = 'Proposal-' . $step2Data['proposal_title'] . '-' . Str::slug($step2Data['start_date']) . '.pdf';

        // Output the PDF as a download
        return response($mpdf->Output($filename, 'I'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

}
