<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function logout() {
        auth() -> logout();
        return redirect('/')->with('success', 'You are now logged out');
    }
    public function showHomepage() {
        if(auth()->check()){
            return  view('dashboard');
        }else{
            return view('homepage');
        }
    }

    public function login(Request $request){
        $incomingFields = $request->validate([
            'login-email' => 'required',
            'login-password' => 'required'
        ]);

        if (auth()->attempt(['email' => $incomingFields['login-email'], 'password' => $incomingFields['login-password']])) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'You have syccessfully logged in');
        } else {
            return redirect('/')->with('failure', 'Invalid login.');
        }
    }

    public function showRegistrationForm(){
        return view('users.register');
    }

    public function register(Request $request){
        $incomingFields = $request->validate([
            "first_name" => ["required", 'min:4', 'max:20', 'string'],
            "last_name" => ["required", 'min:4', 'max:20', 'string'],
            "email"=> ["required","email", Rule::unique("users","email")],
            "password"=> ["required","min:8","confirmed"],
        ]);
        $incomingFields["password"] = bcrypt($incomingFields['password']);
        
        User::create($incomingFields);
        // auth() ->login($user);
        return redirect('/')->with('success', 'Thank you for creating an account');
    }
}
