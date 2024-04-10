<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitLog;
use App\Models\Visitor;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Illuminate\Support\Facades\Auth;

class VisitLogController extends Controller
{
  // display index page
  public function index()
  {
    $visitors = Visitor::all();
    $visitlogs = VisitLog::orderBy('id', 'desc')
      ->paginate(5)
      ->fragment('table_visitlogs');

    if ($visitlogs->isEmpty()) {
      $message = 'No data found.';
    } else {
      $message = null;
    }

    return view('visitlogs.index', compact('visitlogs', 'visitors', 'message'));
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

    $visitlogs = $this->filterVisitLogs($filter, $status,)->paginate(10);


    if ($visitlogs->isEmpty()) {
      $message = 'No data found.';
    } else {
      $message = null;
    }

    return view('visitlogs.visit-logs-records', compact('visitlogs', 'visitors', 'message'));
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
    $sheet->setCellValue('C1', 'Visit Purpose');
    $sheet->setCellValue('D1', 'Resident Name');
    $sheet->setCellValue('E1', 'Check In');
    $sheet->setCellValue('F1', 'Check Out');
    $sheet->setCellValue('G1', 'Log Date');
    $sheet->setCellValue('H1', 'Status');

    // Add visitor data
    $row = 2;
    foreach ($visitlogs as $visitlog) {
      $sheet->setCellValue('A' . $row, $visitlog->id);
      $sheet->setCellValue('B' . $row, $visitlog->visitor_id);
      $sheet->setCellValue('C' . $row, $visitlog->visit_purpose);
      $sheet->setCellValue('D' . $row, $visitlog->resident_name);
      $sheet->setCellValue('E' . $row, $visitlog->check_in);
      $sheet->setCellValue('F' . $row, $visitlog->check_out);
      $sheet->setCellValue('G' . $row, $visitlog->log_date);
      $sheet->setCellValue('H' . $row, $visitlog->status);
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
    $user = Auth::user();
    $today = date('Y-m-d');
    $datetime = date('Y-m-d h:i:s A');

    if ($request->has('visitor_qrcode')) {
      $visitor_qrcode = $request->input('visitor_qrcode');

      // Find visitor by QR code
      $visitor = Visitor::where('visitor_qrcode', $visitor_qrcode)->first();

      if ($visitor) {
        // Find visit log by the visitor ID
        $visitlog = VisitLog::where('visitor_id', $visitor->id)->latest()->first();

        if ($visitlog) {
          if ($visitlog->status == 'IN') {
            $visitlog->update(['check_out' => $datetime, 'status' => 'OUT']);
            $action = 'Checked out';
          } elseif ($today >= $visitor->from_visit_date && $today <= $visitor->to_visit_date) {
            VisitLog::create([
              'visitor_id' => $visitor->id,
              'visit_purpose' => $visitor->visit_purpose,
              'resident_name' => $visitor->resident_name,
              'check_in' => $datetime,
              'log_date' => $today,
              'status' => 'IN',
              'user' => $user->name
            ]);
            $action = 'Checked in';
          } else {
            return redirect()
              ->route('visitlogs.index')
              ->with('error', 'Visitor is not scheduled for visit today.');
          }
        } else {
          // No visit log found, create a new one
          VisitLog::create([
            'visitor_id' => $visitor->id,
            'visit_purpose' => $visitor->visit_purpose,
            'resident_name' => $visitor->resident_name,
            'check_in' => $datetime,
            'log_date' => $today,
            'status' => 'IN',
            'user' => $user->name
          ]);
          $action = 'Checked in';
        }

        // Retrieve the last created log's visitor
        $lastLogVisitor = Visitor::find($visitor->id);

        return redirect()
          ->route('visitlogs.index')
          ->with(['success' => $action . ' successfully!', 'lastLog' => $lastLogVisitor]);
      } else {
        return redirect()
          ->route('visitlogs.index')
          ->with('error', 'QR Code does not match our records.');
      }
    } else {
      return redirect()
        ->route('visitlogs.index')
        ->with('error', 'Please scan your QR Code.');
    }
  }
}
