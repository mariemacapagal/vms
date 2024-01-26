<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;

class VisitorController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $visitors = Visitor::all();
    return view('visitors.index', compact('visitors'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $date = date('Y-m-d');
    $datetime = date('Y-m-d h:i:s A');

    $visitor_name = $request->input('visitor_name');
    $license_plate = $request->input('license_plate');
    $visit_purpose = $request->input('visit_purpose');
    $visit_date = $request->input('visit_date');
    $visitor_qrcode = $visitor_name . '_' . $visit_date;

    Visitor::create([
      'visitor_name' => $visitor_name,
      'license_plate' => $license_plate,
      'visit_purpose' => $visit_purpose,
      'visit_date' => $visit_date,
      'visitor_qrcode' => $visitor_qrcode,
      'registered_date' => $datetime,
    ]);

    return redirect()
      ->route('visitors.index')
      ->with('success', 'Visitor created successfully.');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $visitor = Visitor::find($id);
    return view('visitors.show', compact('visitor'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $visitor_name = $request->input('visitor_name');
    $license_plate = $request->input('license_plate');
    $visit_purpose = $request->input('visit_purpose');
    $visit_date = $request->input('visit_date');
    $visitor_qrcode = $visitor_name . '_' . $visit_date;

    $visitor = Visitor::find($id);
    $visitor->update([
      'visitor_name' => $visitor_name,
      'license_plate' => $license_plate,
      'visit_purpose' => $visit_purpose,
      'visit_date' => $visit_date,
      'visitor_qrcode' => $visitor_qrcode,
    ]);

    return redirect()
      ->route('visitors.index')
      ->with('success', 'Visitor updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $visitor = Visitor::find($id);
    $visitor->delete();
    return redirect()
      ->route('visitors.index')
      ->with('success', 'Visitor deleted successfully');
  }

  public function edit($id)
  {
    $visitor = Visitor::find($id);
    return view('visitors.edit', compact('visitor'));
  }
}
