<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PDFController extends Controller
{
    public function generatePDF(Request $request)
    {
        // Assuming you have session information stored as an associative array
        $sessionData = $request->session()->all();
        
        // Load a view where you pass the session data
        $pdf = PDF::loadView('pdf.sessionInfo', compact('sessionData'));
        
        // Return the generated PDF
        return $pdf->download('session-information.pdf');
    }
}
