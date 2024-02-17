<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\VisitLog;
use Carbon\Carbon;

class Dashboard extends Controller
{
  public function index()
  {
    $visitors = Visitor::all();
    $visitLogs = VisitLog::all();

    $today = Carbon::today();

    $totalVisitors =  $visitors->count();
    $totalVisitLogs = $visitLogs->count();

    $visitPurpose = Visitor::select('visit_purpose', Visitor::raw('count(*) as count'))
      ->groupBy('visit_purpose')
      ->get();

    // Fetch visitor count for each day of the current week
    $visitorCount = Visitor::whereBetween('visit_date', [
      now()->startOfWeek(),
      now()->endOfWeek(),
    ])->orderBy('visit_date')
      ->get()
      ->groupBy(function ($date) {
        return Carbon::parse($date->visit_date)->format('D'); // Group by day name
      })
      ->map(function ($day) {
        return $day->count();
      });

    return view('content.dashboard.dashboard', compact('visitors', 'visitLogs', 'totalVisitors', 'totalVisitLogs', 'visitPurpose', 'visitorCount'));
  }
}
