<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\VisitLog;
use App\Models\BlockedList;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class Reports extends Controller
{
  public function index(Request $request)
  {
    $tableSelection = $request->input('table_selection');
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    // Convert the end date to include the full timestamp (end of the day)
    $end_date_full = date('Y-m-d 23:59:59', strtotime($end_date));

    if ($tableSelection === 'visitors') {
      $model = new Visitor;
    } elseif ($tableSelection === 'visit_logs') {
      $model = new VisitLog;
    } else {
      $model = new BlockedList;
    }

    // Fetch data from the database based on the date range
    $fetchedData = $model->whereBetween('created_at', [$start_date, $end_date_full])->paginate(10);
    return view('content.menu.reports', compact('tableSelection', 'fetchedData', 'start_date', 'end_date_full'));
  }

  public function export(Request $request)
  {
    $tableSelection = $request->input('table_selection');
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    $end_date_full = date('Y-m-d 23:59:59', strtotime($end_date));

    if ($tableSelection === 'visitors') {
      $model = new Visitor;
    } elseif ($tableSelection === 'visit_logs') {
      $model = new VisitLog;
    } else {
      $model = new BlockedList;
    }

    $fetchedData = $model->whereBetween('created_at', [$start_date, $end_date_full])->get();

    if ($tableSelection === 'visitors') {
      $type = 'Visitors';
    } elseif ($tableSelection === 'visit_logs') {
      $type = 'Visit Logs';
    } else {
      $type = 'Blocked List';
    }

    // Create a new Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Add headers to the Spreadsheet
    $sheet = $spreadsheet->getActiveSheet();
    $headers = array_keys($fetchedData->first()->toArray());
    $sheet->fromArray([$headers], null, 'A1');

    // Add data to the Spreadsheet starting from the second row
    $dataRows = $fetchedData->toArray();
    $sheet->fromArray($dataRows, null, 'A2');

    // Create a CSV writer
    $csvWriter = new Csv($spreadsheet);

    // Set the headers for CSV file download
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment;filename="Report_' . $type . '_' . date('Ymd') . '.csv"');
    header('Cache-Control: max-age=0');

    // Redirect output to a php://output
    $csvWriter->save('php://output');
    exit;
  }
}
