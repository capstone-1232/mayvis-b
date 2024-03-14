<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the proposals with Clients so we can convert client_id -> first_name (client)
        if (Auth::check()) {
            $userId = Auth::user()->id; // Get the currently logged-in user's ID
            $proposals = Proposal::with(['client', 'user'])
                    ->where('user_id', $userId)
                    ->paginate(5);
        } else {
            return redirect()->route('login');
        }
        
        
        // Pass the proposals to the view
        return view('dashboard', compact('proposals'));
    }
}
