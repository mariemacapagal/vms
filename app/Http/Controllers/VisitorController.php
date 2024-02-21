<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use App\Models\Visitor;
use App\Models\DeletedVisitor;
use App\Models\VisitorHistory;

class VisitorController extends Controller
{
  public function index()
  {
    $visitors = Visitor::orderBy('id', 'desc')
      ->simplePaginate(5)
      ->fragment('table_visitors');

    if ($visitors->isEmpty()) {
      $message = 'No data found.';
    } else {
      $message = null;
    }

    return view('visitors.index', compact('visitors', 'message'));
  }

  // Filter Visitors
  private function filterVisitors($filter, $purpose, $search)
  {
    $visitors = Visitor::query();

    $visitors = $visitors
      ->when($filter == 'today', function ($query) {
        return $query->wherebetween('visit_date', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()]);
      })
      ->when($filter == 'this_week', function ($query) {
        return $query->wherebetween('visit_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
      })
      ->when($filter == 'this_month', function ($query) {
        return $query->wherebetween('visit_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
      })
      ->when(!empty($purpose), function ($query) use ($purpose) {
        return $query->where('visit_purpose', $purpose);
      })
      ->when(!empty($search), function ($query) use ($search) {
        return $query->where('visitor_name', 'Like', $search . '%');
      });

    return $visitors;
  }

  // records
  public function records(Request $request)
  {
    $filter = request('filter');
    $purpose = request('purpose');
    $search = $request->input('search');

    $visitors = $this->filterVisitors($filter, $purpose, $search)->paginate(10);

    if ($visitors->isEmpty()) {
      $message = 'No data found.';
    } else {
      $message = null;
    }

    return view('visitors.visitors-records', compact('visitors', 'message'));
  }

  // export records
  public function export(Request $request)
  {
    $filter = request('filter');
    $purpose = request('purpose');
    $search = $request->input('search');

    $visitors = $this->filterVisitors($filter, $purpose, $search)->get();

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add headers
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Visitor\'s First Name');
    $sheet->setCellValue('C1', 'License Plate');
    $sheet->setCellValue('D1', 'Visit Purpose');
    $sheet->setCellValue('E1', 'Resident\'s Name');
    $sheet->setCellValue('F1', 'Visit Date');
    $sheet->setCellValue('G1', 'Visitor QR Code');
    $sheet->setCellValue('H1', 'Registered Date');

    // Add visitor data
    $row = 2;
    foreach ($visitors as $visitor) {
      $sheet->setCellValue('A' . $row, $visitor->id);
      $sheet->setCellValue('B' . $row, $visitor->visitor_name);
      $sheet->setCellValue('C' . $row, $visitor->license_plate);
      $sheet->setCellValue('D' . $row, $visitor->visit_purpose);
      $sheet->setCellValue('E' . $row, $visitor->resident_name);
      $sheet->setCellValue('F' . $row, $visitor->visit_date);
      $sheet->setCellValue('G' . $row, $visitor->visitor_qrcode);
      $sheet->setCellValue('H' . $row, $visitor->registered_date);
      $row++;
    }

    // Create a temporary file path
    $filePath = tempnam(sys_get_temp_dir(), 'visitors') . '.csv';

    // Save the spreadsheet to a CSV file
    $writer = new Csv($spreadsheet);
    $writer->setDelimiter(',');
    $writer->setEnclosure('"');
    $writer->setLineEnding("\r\n");
    $writer->setUseBOM(true);
    $writer->save($filePath);

    // Download the file
    return response()->download($filePath, 'Visitors.csv')->deleteFileAfterSend();
  }

  // Store a newly created resource in storage.
  public function store(Request $request)
  {
    $datetime = date('Y-m-d h:i:s A');

    $visitor_name = $request->input('visitor_name');
    $license_plate = $request->input('license_plate');
    $visit_purpose = $request->input('visit_purpose');
    $resident_name = $request->input('resident_name');
    $visit_date = $request->input('visit_date');

    $visitor = Visitor::create([
      'visitor_name' => $visitor_name,
      'license_plate' => $license_plate,
      'visit_purpose' => $visit_purpose,
      'resident_name' => $resident_name,
      'visit_date' => $visit_date,
      'registered_date' => $datetime,
    ]);

    $visitor_qrcode = hash('md5', $visitor->id);
    $visitor->update(['visitor_qrcode' => 'VMS' . $visitor_qrcode]);

    // Create a new record in visitor_histories table
    $visitorHistory = new VisitorHistory();
    $visitorHistory->visitor_id = $visitor->id;
    $visitorHistory->fill($visitor->toArray());
    $visitorHistory->save();

    // Retrieve the last created visitor
    $lastVisitor = Visitor::latest()->first();

    return redirect()
      ->route('visitors.index')
      ->with(['success' => 'Visitor added successfully.', 'lastVisitor' => $lastVisitor]);
  }

  // Update the specified resource in storage.
  public function update(Request $request, string $id)
  {
    $visitor_name = $request->input('visitor_name');
    $license_plate = $request->input('license_plate');
    $visit_purpose = $request->input('visit_purpose');
    $resident_name = $request->input('resident_name');
    $visit_date = $request->input('visit_date');

    $visitor = Visitor::find($id);
    $visitor->update([
      'visitor_name' => $visitor_name,
      'license_plate' => $license_plate,
      'visit_purpose' => $visit_purpose,
      'resident_name' => $resident_name,
      'visit_date' => $visit_date,
    ]);

    // Create a new record in visitor_histories table
    $visitorHistory = new VisitorHistory();
    $visitorHistory->visitor_id = $id;
    $visitorHistory->fill($visitor->toArray());
    $visitorHistory->save();

    return redirect()
      ->back()
      ->with('success', 'Visitor updated successfully.');
  }

  public function edit($id)
  {
    $visitor = Visitor::find($id);

    return view('visitors.edit', compact('visitor'));
  }

  public function deleteVisitors($id)
  {
    $visitor = Visitor::find($id);

    // Create a new record in deleted_visitors table
    $deletedVisitor = new DeletedVisitor();
    $deletedVisitor->visitor_id = $id;
    $deletedVisitor->fill($visitor->toArray());
    $deletedVisitor->save();

    // Delete the record from the visitors table
    $visitor->delete();

    return redirect()
      ->back()
      ->with('success', 'Visitor deleted successfully.');
  }
}
