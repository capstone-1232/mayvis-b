<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the proposals with Clients so we can convert client_id -> first_name (client)
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $proposals = Proposal::with(['client', 'user'])
                    ->where('user_id', $userId)
                    ->paginate(5);
        } else {
            return redirect()->route('welcome');
        }

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

        
        $notifications = Auth::user()->notifications;
        
        // Pass the proposals to the view
        return view('dashboard', compact('proposals', 'proposalsData', 'notifications'));
    }

    public function destroyNotification($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id); // Please ignore the error in here. The code works as expected. The IDE just does not recognize Laravel's Magic Methods.
        $notification->delete();

        return response()->json(['success' => true]);
    }

}
