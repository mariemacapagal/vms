<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\VisitLog;
use App\Models\PreRegisteredVisitor;
use Carbon\Carbon;

class Dashboard extends Controller
{
  public function index()
  {
    $visitors = Visitor::all();
    $visitLogs = VisitLog::all();
    $preReg = PreRegisteredVisitor::all();

    $totalVisitors =  $visitors->count();
    $totalVisitLogs = $visitLogs->count();
    $totalPreReg = $preReg->count();

    $visitPurpose = VisitLog::select('visit_purpose', VisitLog::raw('count(*) as count'))
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

    return view('content.dashboard.dashboard', compact('visitors', 'visitLogs', 'totalVisitors', 'totalVisitLogs', 'visitPurpose', 'visitorCount', 'totalPreReg'));
  }
}
