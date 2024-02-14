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
    $totalCheckIns = $visitLogs->where('check_in')->count();
    $totalCheckOuts = $visitLogs->where('check_out')->count();
    $totalAmenities = $visitors->where('visit_purpose', 'Amenities')->count();
    $data = Visitor::select('visit_purpose', Visitor::raw('count(*) as count'))
      ->groupBy('visit_purpose')
      ->get();


    return view('content.dashboard.dashboard', compact('visitors', 'visitLogs', 'totalVisitors', 'totalVisitLogs', 'totalCheckIns', 'totalCheckOuts', 'totalAmenities', 'data'));
  }
}
