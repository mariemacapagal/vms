<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VisitLogsRecords extends Controller
{
  public function index()
  {
    return view('content.menu.visit-logs-records');
  }
}
