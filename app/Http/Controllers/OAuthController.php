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
            // We can probably also grab their image here but not really necessary.
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()], // Check for the user based on their email
                [
                    'first_name' => $googleUser->user['given_name'], 
                    'last_name' => $googleUser->user['family_name'], 
                    'job_title' => "No Job Title",
                    'profile_image' => "default_profile.jpg",
                    'google_id' => $googleUser->getId(),               
                    'password' => Hash::make(uniqid()),       
                ]
            );
        

            Auth::login($user, true);
            
            
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to login using Google. Please try again.');
        }
    }


}

