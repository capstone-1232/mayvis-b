<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\DB;

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
            return redirect()->route('welcome');
        }

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
        
        
        // Pass the proposals to the view
        return view('dashboard', compact('proposals', 'approvedProposalsSumByWeek'));
    }

    public function getWeekOfMonth($date) {
        $dt = new DateTime($date);
        $firstOfMonth = new DateTime($dt->format('Y-m-01'));
        $weekOfMonth = (int) $dt->format('W') - (int) $firstOfMonth->format('W') + 1;
        return $weekOfMonth;
    }
}
