<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitLog;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;

class VisitLogController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $visitlogs = VisitLog::all();
    $visitors = Visitor::all();
    return view('visitlogs.index', compact('visitlogs', 'visitors'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $date = date('Y-m-d');
    $datetime = date('Y-m-d h:i:s A');

    $visitor_qrcode = $request->input('visitor_qrcode');
    $visitor_id = DB::table('visitors')
      ->where('visitor_qrcode', $visitor_qrcode)
      ->value('id');
    $visit_date = DB::table('visitors')->where('visit_date', $date);

    if ($visitor_id) {
      // Check if the visitor_id exists in the visitlog table with status 'IN'
      $visitlog = VisitLog::where('visitor_id', $visitor_id)
        ->where('status', 'IN')
        ->first();

      if ($visitlog) {
        // Update the status to 'OUT' and set the check_out time
        $visitlog->update([
          'check_out' => $datetime,
          'status' => 'OUT',
        ]);

        return redirect()
          ->route('visitlogs.index')
          ->with('success', 'Checked out successfully!');
      } else {
        // Check if the visitor_id exists in the visitlog table with status 'OUT'
        $visitlog = VisitLog::where('visitor_id', $visitor_id)
          ->where('status', 'OUT')
          ->first();

        if ($visitlog) {
          return redirect()
            ->route('visitlogs.index')
            ->with('error', 'Visitor has already checked out.');
        } elseif ($visit_date === $date) {
          // Create a new visit log entry
          VisitLog::create([
            'visitor_id' => $visitor_id,
            'check_in' => $datetime,
            'log_date' => $date,
            'status' => 'IN',
          ]);
        } else {
          // Handle the case where the visit_date is not today
          return redirect()
            ->route('visitlogs.index')
            ->with('error', 'Visitor\'s visit is not today.');
        }
      }
    } else {
      // Handle the case where the visitor_id does not exist
      return redirect()
        ->route('visitlogs.index')
        ->with('error', 'Visitor\'s QR Code does not exist.');
    }
    return redirect()
      ->route('visitlogs.index')
      ->with('success', 'Checked in successfully.');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $visitlog = VisitLog::find($id);
    return view('visitlogs.show', compact('visitlog'));
  }
}
