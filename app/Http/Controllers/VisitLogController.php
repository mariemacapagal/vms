<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitLog;
use App\Models\Visitor;
use App\Models\VisitorHistory;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class VisitLogController extends Controller
{
  // display index page
  public function index()
  {
    $visitors = Visitor::all();
    $visitorHistory = VisitorHistory::all();
    $visitlogs = VisitLog::orderBy('id', 'desc')
      ->simplePaginate(5)
      ->fragment('table_visitlogs');

    if ($visitlogs->isEmpty()) {
      $message = 'No data found.';
    } else {
      $message = null;
    }
    return view('visitlogs.index', compact('visitlogs', 'visitors', 'visitorHistory', 'message'));
  }

  // Filter Visit Logs
  private function filterVisitLogs($filter, $status)
  {

    $visitlogs = VisitLog::query();

    $visitlogs = $visitlogs
      ->when($filter == 'today', function ($query) {
        return $query->wherebetween('log_date', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()]);
      })
      ->when($filter == 'this_week', function ($query) {
        return $query->wherebetween('log_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
      })
      ->when($filter == 'this_month', function ($query) {
        return $query->wherebetween('log_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
      })
      ->when(!empty($status), function ($query) use ($status) {
        return $query->where('status', $status);
      });
    return $visitlogs;
  }

  // records
  public function records(Request $request)
  {
    $filter = request('filter');
    $status = request('status');
    $visitors = Visitor::all();
    $visitorHistory = VisitorHistory::all();

    $visitlogs = $this->filterVisitLogs($filter, $status,)->paginate(10);


    if ($visitlogs->isEmpty()) {
      $message = 'No data found.';
    } else {
      $message = null;
    }

    return view('visitlogs.visit-logs-records', compact('visitlogs', 'visitors', 'visitorHistory', 'message'));
  }

  // export records
  public function export(Request $request)
  {
    $filter = $request->input('filter');

    // Fetch visitors data based on filter criteria
    $visitlogs = VisitLog::query();

    switch ($filter) {
      case 'today':
        $visitlogs->whereDate('visit_date', Carbon::today());
        break;
      case 'this_week':
        $visitlogs->whereBetween('visit_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        break;
      case 'this_month':
        $visitlogs->whereYear('visit_date', Carbon::now()->year)->whereMonth('visit_date', Carbon::now()->month);
        break;
      default:
        // Do nothing, fetch all visit logs
        break;
    }

    $visitlogs = $visitlogs->get();
    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add headers
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Visitor ID');
    $sheet->setCellValue('C1', 'Check In');
    $sheet->setCellValue('D1', 'Check Out');
    $sheet->setCellValue('E1', 'Log Date');
    $sheet->setCellValue('F1', 'Status');

    // Add visitor data
    $row = 2;
    foreach ($visitlogs as $visitlog) {
      $sheet->setCellValue('A' . $row, $visitlog->id);
      $sheet->setCellValue('B' . $row, $visitlog->visitor_id);
      $sheet->setCellValue('C' . $row, $visitlog->check_in);
      $sheet->setCellValue('D' . $row, $visitlog->check_out);
      $sheet->setCellValue('E' . $row, $visitlog->log_date);
      $sheet->setCellValue('F' . $row, $visitlog->status);
      $row++;
    }

    // Create a temporary file path
    $filePath = tempnam(sys_get_temp_dir(), 'visitlogs') . '.csv';

    // Save the spreadsheet to a CSV file
    $writer = new Csv($spreadsheet);
    $writer->setDelimiter(',');
    $writer->setEnclosure('"');
    $writer->setLineEnding("\r\n");
    $writer->setUseBOM(true);
    $writer->save($filePath);

    // Download the file
    return response()->download($filePath, 'VisitLogs.csv')->deleteFileAfterSend();
  }

  // Store a newly created resource in storage.
  public function store(Request $request)
  {
    $date = date('Y-m-d');
    $datetime = date('Y-m-d h:i:s A');

    if ($request->has('visitor_qrcode')) {
      $visitor_qrcode = $request->input('visitor_qrcode');

      // Find visitor by QR code
      $visitor = Visitor::where('visitor_qrcode', $visitor_qrcode)->first();

      if ($visitor && $visitor->visit_date == $date) {
        // Find visit log by the visitor ID
        $visitlog = VisitLog::where('visitor_id', $visitor->id)->latest()->first();

        if ($visitlog) {
          if ($visitlog->status == 'OUT') {
            // Create a new visit log entry for check-in
            VisitLog::create([
              'visitor_id' => $visitor->id,
              'visit_purpose' => $visitor->visit_purpose,
              'resident_name' => $visitor->resident_name,
              'check_in' => $datetime,
              'log_date' => $date,
              'status' => 'IN',
            ]);

            return redirect()
              ->route('visitlogs.index')
              ->with('success', 'Checked in successfully!');
          } elseif ($visitlog->status == 'IN') {
            // Update the visit log for check-out
            $visitlog->update(['check_out' => $datetime, 'status' => 'OUT']);

            return redirect()
              ->route('visitlogs.index')
              ->with('success', 'Checked out successfully!');
          }
        } else {
          // Create a new visit log entry for check-in
          VisitLog::create([
            'visitor_id' => $visitor->id,
            'visit_purpose' => $visitor->visit_purpose,
            'resident_name' => $visitor->resident_name,
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




  // Display the specified resource.
  public function show(string $id)
  {
    $visitlog = VisitLog::find($id);
    return view('visitlogs.show', compact('visitlog'));
  }
}
