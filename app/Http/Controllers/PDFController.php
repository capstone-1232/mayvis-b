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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DOMDocument;

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
        $products = Product::whereIn('id', $productIds)->get();

        // Extract descriptions (project scopes) from the selected products <-- Project Scopes are basically descriptions just exploded in the database.
        $projectScopes = collect($step4Data['selectedProducts'])
        ->pluck('description')
        ->map(function ($description) {
            return $this->processDescription($description);
        })
        ->all();

        // Edited Prices will be plucked via this code
        $updatedPrices = collect($step4Data['selectedProducts'] ?? [])
        ->pluck('price')
        ->implode(',');

        // Create or update client information
        $client = Client::updateOrCreate(
            [
                'first_name' => $step1Data['first_name'],
                'last_name' => $step1Data['last_name'],
                'email' => $step1Data['email']
            ],
            $step1Data
        );

        $senderName = $step3Data['sender'] ?? '';
        $automatedMessage = $step3Data['automated_message'] ?? '';

        // Prepare the data for the PDF
        $pdfData = [
            'step1Data' => $step1Data,
            'step2Data' => $step2Data,
            'step3Data' => $step3Data,
            'step4Data' => $step4Data,
            'client' => $client,
            'users' => [],
            'projectScopes' => $projectScopes,
            'updatedPrices' => $updatedPrices,
            'products' => $products,
        ];

        // Filter users based on sender's name
        if ($senderName) {
            $query = User::where('email', 'like', '%' . $senderName . '%')
                        ->select(['job_title', 'first_name', 'last_name', 'profile_image', 'proposal_message']);

            if ($automatedMessage) {
                $pdfData['users'] = $query->selectRaw('job_title, first_name, last_name, profile_image, proposal_message, ? as automated_message', 
                                                    [$automatedMessage])->get();
            } else {
                $pdfData['users'] = $query->addSelect('automated_message')->get();
            }
        }


        // Create a new instance of mPDF
        $mpdf = new Mpdf();

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

    private function processDescription($html)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $headerTags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
        foreach ($headerTags as $tag) {
            $headers = $dom->getElementsByTagName($tag);
            foreach (iterator_to_array($headers) as $header) {
                $br = $dom->createElement('br');
                $header->parentNode->insertBefore($br, $header);
            }
        }

        return $dom->saveHTML();
    }

}
