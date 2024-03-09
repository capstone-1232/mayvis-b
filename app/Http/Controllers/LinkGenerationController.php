<?php

namespace App\Http\Controllers;

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

        // Generate a random or unique token for the session data
        $uniqueToken = uniqid();

        // Store the session data in the database or cache with the token as a key if needed,
        // or use the token to retrieve the session data directly.

        // For now, we'll just store the token in the session for simplicity
        $request->session()->put('uniqueToken', $uniqueToken);

        // Generate the view link with the token
        $link = URL::temporarySignedRoute(
            'link.view', now()->addMinutes(30), ['token' => $uniqueToken]
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

        // Retrieve the session data using the token
        $step1Data = $request->session()->get('step1_data');
        $step2Data = $request->session()->get('step2_data');
        $step3Data = $request->session()->get('step3_data');
        $step4Data = $request->session()->get('step4_data');

        // Return a view that displays the data
        return view('links.view-link', compact('step1Data', 'step2Data', 'step3Data', 'step4Data'));
    }
}
