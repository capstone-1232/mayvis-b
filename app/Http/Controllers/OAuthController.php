<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class OAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Find or create the user based on their email
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()], // Check for the user based on their email
                [
                    'first_name' => $googleUser->user['given_name'], // Set only on initial creation
                    'last_name' => $googleUser->user['family_name'],  // Set only on initial creation
                    'job_title' => "No Job Title",
                    'google_id' => $googleUser->getId(),               // Set only on initial creation
                    'password' => Hash::make(uniqid()),                // Set only on initial creation
                ]
            );
        

            Auth::login($user, true);

            return redirect()->intended('dashboard');
        } catch (\Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to login using Google. Please try again.');
        }
    }


}

