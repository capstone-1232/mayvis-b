<?php

namespace App\Http\Controllers;

use DateTime;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoredProposalController extends Controller
{
    public function indexStoredProposals(Request $request)
    {
        $step1Data = session('step1_data');
        $step2Data = session('step2_data');
        $step3Data = session('step3_data');
        $step4Data = session('step4_data');

        // Retrieve the link from the session
        $generatedLink = $request->session()->get('generatedLink', '');

        // Fetch the proposals with Clients so we can convert client_id -> first_name (client)
        $proposals = Proposal::with('client', 'user')->paginate(5);
        
        // Pass the proposals to the view
        return view('storedProposals.storedProposals-index', compact('proposals', 'step1Data', 'step2Data', 'step3Data', 'step4Data', 'generatedLink'));
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

    

    public function proposalsReport()
    {
        // Define a helper to format weeks
        $weekFormatter = function ($week, $year) {
            $firstDayOfWeek = new DateTime();
            $firstDayOfWeek->setISODate($year, $week);
            $monthName = $firstDayOfWeek->format('F');
            $weekOfMonth = ceil($firstDayOfWeek->format('j') / 7);
            return "Week $weekOfMonth of $monthName, $year";
        };

        // Fetch proposal prices for approved proposals by week of each month
        $approvedProposalsSumByWeek = Proposal::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('WEEK(created_at, 5) as weekOfYear'), // Mode 5 for week starting Monday
            DB::raw('SUM(proposal_price) as total_price')
        )
        ->where('status', 'Approved')
        ->groupBy('year', 'month', 'weekOfYear')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->orderBy('weekOfYear', 'asc')
        ->get()
        ->each(function ($item) {
            $item->weekOfMonth = $this->getWeekOfMonth($item->created_at);
            $item->label = "Week {$item->weekOfMonth} of " . DateTime::createFromFormat('!m', $item->month)->format('F') . ", {$item->year}";
        });


        // Assuming you will somehow combine or utilize these two collections in your view
        return view('storedProposals.report', compact('approvedProposalsSumByWeek'));
    }


    public function getWeekOfMonth($date) {
        $dt = new DateTime($date);
        $firstOfMonth = new DateTime($dt->format('Y-m-01'));
        $weekOfMonth = (int) $dt->format('W') - (int) $firstOfMonth->format('W') + 1;
        return $weekOfMonth;
    }
    

    



}
