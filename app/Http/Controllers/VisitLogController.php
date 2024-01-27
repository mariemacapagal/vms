<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitLog;
use App\Models\Visitor;

class VisitLogController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $visitors = Visitor::all();
    $visitlogs = VisitLog::orderBy('id', 'desc')
      ->simplePaginate(5)
      ->fragment('table_visitlogs');
    return view('visitlogs.index', compact('visitlogs', 'visitors'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $date = date('Y-m-d');
    $datetime = date('Y-m-d h:i:s A');

    if ($request->has('visitor_qrcode')) {
      $visitor_qrcode = $request->input('visitor_qrcode');

      // Find visitor by QR code
      $visitor = Visitor::where('visitor_qrcode', $visitor_qrcode)->first();

      if ($visitor->visit_date == $date) {
        // Find visit log by the visitor ID
        $visitlog = VisitLog::where('visitor_id', $visitor->id)->first();
        if ($visitlog) {
          if ($visitlog->status == 'OUT') {
            return redirect()
              ->route('visitlogs.index')
              ->with('error', 'QR Code has already been used and is now invalid.');
          } else {
            $visitlog->update(['check_out' => $datetime, 'status' => 'OUT']);
            return redirect()
              ->route('visitlogs.index')
              ->with('success', 'Checked out successfully!');
          }
        } else {
          // Create a new visit log entry
          VisitLog::create([
            'visitor_id' => $visitor->id,
            'check_in' => $datetime,
            'log_date' => $date,
            'status' => 'IN',
          ]);

          return redirect()
            ->route('visitlogs.index')
            ->with('success', 'Checked in successfully!');
        }
      } else {
        return redirect()
          ->route('visitlogs.index')
          ->with('error', 'QR Code is not registered for visit today.');
      }
    } else {
      return redirect()
        ->route('visitlogs.index')
        ->with('error', 'Please scan your QR Code.');
    }
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
