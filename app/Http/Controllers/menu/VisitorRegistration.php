<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;

class VisitorRegistration extends Controller
{
  public function index()
  {
    return view('content.menu.visitor-registration');
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string',
      'license_plate' => 'required|string',
      'purpose' => 'required|string',
      'date_of_visit' => 'required|date',
    ]);

    $visitor = new Visitor();
    $visitor->visitor_name = $request->input('visitor_name');
    $visitor->license_plate = $request->input('license_plate');
    $visitor->visit_purpose = $request->input('visit_purpose');
    $visitor->visit_date = $request->input('visit_date');
    $visitor->save();

    // Additional logic or redirection after successful data storage

    return redirect()
      ->back()
      ->with('success', 'Visitor stored successfully!');
  }
}
