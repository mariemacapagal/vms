<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\VisitLog;
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

    // Choose the model based on the selected table
    $model = ($tableSelection === 'visitors') ? new Visitor : new VisitLog;


    // Fetch data from the database based on the date range
    $fetchedData = $model->whereBetween('created_at', [$start_date, $end_date_full])->paginate(10);
    return view('content.menu.reports', compact('tableSelection', 'fetchedData', 'start_date', 'end_date_full'));
  }

  public function exportToCsv(Request $request)
  {
    $tableSelection = $request->input('table_selection');
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    $end_date_full = date('Y-m-d 23:59:59', strtotime($end_date));

    $model = ($tableSelection === 'visitors') ? new Visitor : new VisitLog;

    $fetchedData = $model->whereBetween('created_at', [$start_date, $end_date_full])->get();

    // Determine the type for the filename
    $type = ($tableSelection === 'visitors') ? 'Visitors' : 'Visit Logs';

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
