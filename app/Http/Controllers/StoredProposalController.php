<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;

class StoredProposalController extends Controller
{
    public function indexStoredProposals(Request $request)
    {
        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');
        $step4Data = session('step4_data'); 

        $sessionData = $request->session()->all();

        // Fetch the proposals with Clients so we can convert client_id -> first_name (client)
        $proposals = Proposal::with('client', 'user')->get();
        
        // Pass the proposals to the view
        return view('storedProposals.storedProposals-index', compact('proposals', 'step1Data', 'step2Data', 'step3Data', 'step4Data'));
    }

    public function searchProposals(Request $request) {
        $searchTerm = $request->input('search_term');
    
        $searchResults = Proposal::with('client', 'user')
                        ->where(function($query) use ($searchTerm) {
                            $query->where('proposal_title', 'LIKE', '%' . $searchTerm . '%')
                                ->orWhereHas('client', function($query) use ($searchTerm) {
                                    $query->where('first_name', 'LIKE', '%' . $searchTerm . '%');
                                });
                        })->get();

    
        // Return JSON response
        return response()->json($searchResults);
    }
}
