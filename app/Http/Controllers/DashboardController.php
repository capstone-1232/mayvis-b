<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the proposals with Clients so we can convert client_id -> first_name (client)
        $proposals = Proposal::with('client')->get();
        
        // Pass the proposals to the view
        return view('dashboard', compact('proposals'));
    }
}
