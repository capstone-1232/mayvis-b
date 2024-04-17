<?php

namespace App\Http\Controllers;

use DateTime;

use App\Models\Proposal;
use App\Models\Product;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoredProposalController extends Controller
{
    public function indexStoredProposals(Request $request)
    {
        // Fetch the proposals with Clients and User for each proposal
        $proposals = Proposal::with('client', 'user')->paginate(5);
        
        // Assign the permanent link to each proposal
        foreach ($proposals as $proposal) {
            $proposal->viewLink = route('proposals.view-by-token', ['token' => $proposal->unique_token]);
        }

        // Pass the proposals to the view
        return view('storedProposals.storedProposals-index', compact('proposals'));
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

    // Show the Proposal Method
    public function showProposal($proposalId)
    {
        $proposal = Proposal::findOrFail($proposalId);

        // Explode the CSVs into an array
        $productIds = explode(',', $proposal->product_id);
        // Use the unique delimiter '|||' to explode project scopes
        $projectScopes = explode('|||', $proposal->project_scope);

        // Fetch the products using the array of IDs
        $products = Product::findMany($productIds);

        return view('storedProposals.show', compact('proposal', 'products', 'projectScopes'));
    }



    

    public function proposalsReport()
    {
        // Helper function to format periods
        $periodFormatter = function ($startDate) {
            return $startDate->format('F Y');
        };

        // Fetch proposal prices for both approved and denied proposals aggregated over 30-day periods
        $proposalsData = Proposal::select(
            DB::raw('YEAR(start_date) as year'),
            DB::raw('MONTH(start_date) as month'),
            DB::raw('SUM(case when status = "Approved" then proposal_price else 0 end) as total_approved_price'),
            DB::raw('SUM(case when status = "Denied" then proposal_price else 0 end) as total_denied_price')
        )
        ->where('status', 'Approved')
        ->orWhere('status', 'Denied')
        ->groupBy(DB::raw('YEAR(start_date)'), DB::raw('MONTH(start_date)'))
        ->orderBy(DB::raw('YEAR(start_date)'), 'asc')
        ->orderBy(DB::raw('MONTH(start_date)'), 'asc')
        ->get()
        ->map(function ($item) use ($periodFormatter) {
            $startDate = new DateTime("{$item->year}-{$item->month}-01");
            $item->label = $periodFormatter($startDate);
            return $item;
        });

        return view('storedProposals.report', compact('proposalsData'));
    }



    public function getWeekOfMonth($date) {
        $dt = new DateTime($date);
        $firstOfMonth = new DateTime($dt->format('Y-m-01'));
        $weekOfMonth = (int) $dt->format('W') - (int) $firstOfMonth->format('W') + 1;
        return $weekOfMonth;
    }
}