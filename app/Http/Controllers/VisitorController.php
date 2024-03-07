<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use App\Models\Visitor;
use App\Models\BlockedVisitor;
use App\Models\PreRegisteredVisitor;
use Illuminate\Support\Str;

class VisitorController extends Controller
{
  public function index()
  {
    $visitors = Visitor::orderBy('id', 'desc')
      ->paginate(5)
      ->fragment('table_visitors');

    if ($visitors->isEmpty()) {
      $message = 'No data found.';
    } else {
      $message = null;
    }

    return view('visitors.index', compact('visitors', 'message'));
  }

  // Store a newly created resource in storage.
  public function store(Request $request)
  {
    $registered_date = date('Y-m-d');
    $visitor_first_name = $request->input('visitor_first_name');
    $visitor_last_name = $request->input('visitor_last_name');
    $license_plate = $request->input('license_plate');
    $visit_purpose = $request->input('visit_purpose');
    $resident_name = $request->input('resident_name');
    $visit_date = $request->input('visit_date');

    // Validate if the visitor is in the blocked list
    $blockedVisitor = BlockedVisitor::where([
      'visitor_first_name' => $visitor_first_name,
      'visitor_last_name' => $visitor_last_name,
      'license_plate' => $license_plate,
    ])->first();

    if ($blockedVisitor) {
      return redirect()->back()->with('error', 'Visitor is blocked.');
    }

    // Check if the visitor is already existing in the Visitor model
    $existingVisitor = Visitor::where([
      'visitor_first_name' => $visitor_first_name,
      'visitor_last_name' => $visitor_last_name,
      'license_plate' => $license_plate,
    ])->first();

    if ($existingVisitor) {
      return redirect()->back()->with('error', 'Visitor is already registered.');
    }

    // Get the last used ID from the visitors table
    $lastVisitorId = Visitor::max('id');

    // Get the last used ID from the blocked visitor table
    $lastBlockedId = BlockedVisitor::max('visitor_id');

    // Initialize the new ID with the higher of the two last IDs
    $visitor_id = max($lastVisitorId, $lastBlockedId) + 1;

    Visitor::create([
      'id' => $visitor_id,
      'visitor_first_name' => $visitor_first_name,
      'visitor_last_name' => $visitor_last_name,
      'license_plate' => $license_plate,
      'visit_purpose' => $visit_purpose,
      'resident_name' => $resident_name,
      'visit_date' => $visit_date,
      'visitor_qrcode' => 'VMS_' . hash('md5', $visitor_first_name . $visitor_last_name . $license_plate),
      'registered_date' => $registered_date,
    ]);

    // Retrieve the last created visitor
    $lastVisitor = Visitor::latest()->first();

    return redirect()
      ->route('visitors.index')
      ->with(['lastVisitor' => $lastVisitor]);
  }

  // Filter Visitors
  private function filterVisitors($modelClass, $filter, $purpose, $fname, $lname)
  {
    $entities = $modelClass::query();

    $entities = $entities
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
      ->when(!empty($fname), function ($query) use ($fname) {
        return $query->where('visitor_first_name', 'like', $fname . '%');
      })
      ->when(!empty($lname), function ($query) use ($lname) {
        return $query->where('visitor_last_name', 'like', $lname . '%');
      });

    return $entities;
  }


  // records
  public function records(Request $request)
  {
    $filter = $request->input('filter');
    $purpose = $request->input('purpose');
    $fname = $request->input('fname');
    $lname = $request->input('lname');


    $visitors = $this->filterVisitors(Visitor::class, $filter, $purpose, $fname, $lname)->paginate(10);

    if ($visitors->isEmpty()) {
      $message = 'No data found.';
    } else {
      $message = null;
    }

    return view('visitors.visitors-records', compact('visitors', 'message'));
  }

  // export records
  public function visitorsExport(Request $request)
  {
    $filter = $request->input('filter');
    $purpose = $request->input('purpose');
    $fname = $request->input('fname');
    $lname = $request->input('lname');


    $visitors = $this->filterVisitors(Visitor::class, $filter, $purpose, $fname, $lname)->get();

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add headers
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Visitor\'s First Name');
    $sheet->setCellValue('C1', 'Visitor\'s Last Name');
    $sheet->setCellValue('D1', 'License Plate');
    $sheet->setCellValue('E1', 'Visit Purpose');
    $sheet->setCellValue('F1', 'Resident\'s Name');
    $sheet->setCellValue('G1', 'Visit Date');
    $sheet->setCellValue('H1', 'Visitor QR Code');
    $sheet->setCellValue('I1', 'Registered Date');

    // Add visitor data
    $row = 2;
    foreach ($visitors as $visitor) {
      $sheet->setCellValue('A' . $row, $visitor->id);
      $sheet->setCellValue('B' . $row, $visitor->visitor_first_name);
      $sheet->setCellValue('C' . $row, $visitor->visitor_last_name);
      $sheet->setCellValue('D' . $row, $visitor->license_plate);
      $sheet->setCellValue('E' . $row, $visitor->visit_purpose);
      $sheet->setCellValue('F' . $row, $visitor->resident_name);
      $sheet->setCellValue('G' . $row, $visitor->visit_date);
      $sheet->setCellValue('H' . $row, $visitor->visitor_qrcode);
      $sheet->setCellValue('I' . $row, $visitor->registered_date);
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

  public function blockedVisitorsExport(Request $request)
  {
    $filter = $request->input('filter');
    $purpose = $request->input('purpose');
    $fname = $request->input('fname');
    $lname = $request->input('lname');


    $visitors = $this->filterVisitors(BlockedVisitor::class, $filter, $purpose, $fname, $lname)->get();

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add headers
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Visitor\'s First Name');
    $sheet->setCellValue('C1', 'Visitor\'s Last Name');
    $sheet->setCellValue('D1', 'License Plate');
    $sheet->setCellValue('E1', 'Registered Date');
    $sheet->setCellValue('F1', 'Blocked Date');
    $sheet->setCellValue('G1', 'Remarks');

    // Add visitor data
    $row = 2;
    foreach ($visitors as $visitor) {
      $sheet->setCellValue('A' . $row, $visitor->visitor_id);
      $sheet->setCellValue('B' . $row, $visitor->visitor_first_name);
      $sheet->setCellValue('C' . $row, $visitor->visitor_last_name);
      $sheet->setCellValue('D' . $row, $visitor->license_plate);
      $sheet->setCellValue('E' . $row, $visitor->registered_date);
      $sheet->setCellValue('F' . $row, $visitor->blocked_date);
      $sheet->setCellValue('G' . $row, $visitor->remarks);
      $row++;
    }


    // Create a temporary file path
    $filePath = tempnam(sys_get_temp_dir(), 'blockedvisitors') . '.csv';

    // Save the spreadsheet to a CSV file
    $writer = new Csv($spreadsheet);
    $writer->setDelimiter(',');
    $writer->setEnclosure('"');
    $writer->setLineEnding("\r\n");
    $writer->setUseBOM(true);
    $writer->save($filePath);

    // Download the file
    return response()->download($filePath, 'BlockedVisitors.csv')->deleteFileAfterSend();
  }

  public function preRegVisitorsExport(Request $request)
  {
    $filter = $request->input('filter');
    $purpose = $request->input('purpose');
    $fname = $request->input('fname');
    $lname = $request->input('lname');


    $visitors = $this->filterVisitors(PreRegisteredVisitor::class, $filter, $purpose, $fname, $lname)->get();

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add headers
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Visitor\'s First Name');
    $sheet->setCellValue('C1', 'Visitor\'s Last Name');
    $sheet->setCellValue('D1', 'License Plate');
    $sheet->setCellValue('E1', 'Visit Purpose');
    $sheet->setCellValue('F1', 'Resident\'s Name');
    $sheet->setCellValue('G1', 'Visit Date');
    $sheet->setCellValue('I1', 'Registered Date');

    // Add visitor data
    $row = 2;
    foreach ($visitors as $visitor) {
      $sheet->setCellValue('A' . $row, $visitor->id);
      $sheet->setCellValue('B' . $row, $visitor->visitor_first_name);
      $sheet->setCellValue('C' . $row, $visitor->visitor_last_name);
      $sheet->setCellValue('D' . $row, $visitor->license_plate);
      $sheet->setCellValue('E' . $row, $visitor->visit_purpose);
      $sheet->setCellValue('F' . $row, $visitor->resident_name);
      $sheet->setCellValue('G' . $row, $visitor->visit_date);
      $sheet->setCellValue('I' . $row, $visitor->registered_date);
      $row++;
    }


    // Create a temporary file path
    $filePath = tempnam(sys_get_temp_dir(), 'preregistered') . '.csv';

    // Save the spreadsheet to a CSV file
    $writer = new Csv($spreadsheet);
    $writer->setDelimiter(',');
    $writer->setEnclosure('"');
    $writer->setLineEnding("\r\n");
    $writer->setUseBOM(true);
    $writer->save($filePath);

    // Download the file
    return response()->download($filePath, 'Pre-registered_Visitors.csv')->deleteFileAfterSend();
  }

  // Update the specified resource in storage.
  public function update(Request $request, string $id)
  {
    $visitor_first_name = $request->input('visitor_first_name');
    $visitor_last_name = $request->input('visitor_last_name');
    $license_plate = $request->input('license_plate');
    $visit_purpose = $request->input('visit_purpose');
    $resident_name = $request->input('resident_name');
    $visit_date = $request->input('visit_date');

    $visitor = Visitor::find($id);
    $visitor->update([
      'visitor_first_name' => $visitor_first_name,
      'visitor_last_name' => $visitor_last_name,
      'license_plate' => $license_plate,
      'visit_purpose' => $visit_purpose,
      'resident_name' => $resident_name,
      'visit_date' => $visit_date,
    ]);

    return redirect()
      ->back()
      ->with('success', 'Visitor updated successfully.');
  }

  // BLOCKED VISITORS RECORDS
  public function blockedList(Request $request)
  {
    $filter = $request->input('filter');
    $purpose = $request->input('purpose');
    $fname = $request->input('fname');
    $lname = $request->input('lname');


    $blockedVisitors = $this->filterVisitors(BlockedVisitor::class, $filter, $purpose, $fname, $lname)->paginate(10);

    if ($blockedVisitors->isEmpty()) {
      $message = 'No data found.';
    } else {
      $message = null;
    }

    return view('visitors.blocked-visitors', compact('blockedVisitors', 'message'));
  }

  public function blockVisitors($id, Request $request)
  {
    $visitor = Visitor::find($id);
    $remarks = $request->input('remarks');
    $blocked_date = date('Y-m-d');

    // Create a new record in blocked_visitors table
    $blockedVisitor = new BlockedVisitor([
      'visitor_id' => $id,
      'visitor_first_name' => $visitor->visitor_first_name,
      'visitor_last_name' => $visitor->visitor_last_name,
      'license_plate' => $visitor->license_plate,
      'registered_date' => $visitor->registered_date,
      'blocked_date' => $blocked_date,
      'remarks' => $remarks
    ]);

    $blockedVisitor->save();

    // Delete the record from the visitors table
    $visitor->delete();

    return redirect()
      ->back()
      ->with('success', 'Visitor has been blocked.');
  }

  public function unblockVisitors($id)
  {
    $blockedVisitor = BlockedVisitor::find($id);

    // Create a new record in the visitors table
    $visitor = new Visitor([
      'id' => $blockedVisitor->visitor_id,
      'visitor_first_name' => $blockedVisitor->visitor_first_name,
      'visitor_last_name' => $blockedVisitor->visitor_last_name,
      'license_plate' => $blockedVisitor->license_plate,
      'visitor_qrcode' => 'VMS_' . hash('md5', $blockedVisitor->visitor_first_name . $blockedVisitor->visitor_last_name . $blockedVisitor->license_plate),
      'registered_date' => $blockedVisitor->registered_date,
    ]);

    $visitor->save();


    // Delete the record from the blocked_visitors table
    $blockedVisitor->delete();

    return redirect()->back()->with('success', 'Visitor has been unblocked.');
  }

  public function preRegisteredList(Request $request)
  {
    $filter = request('filter');
    $purpose = request('purpose');
    $fname = $request->input('fname');
    $lname = $request->input('lname');

    $visitors = $this->filterVisitors(PreRegisteredVisitor::class, $filter, $purpose, $fname, $lname)->paginate(10);

    if ($visitors->isEmpty()) {
      $message = 'No data found.';
    } else {
      $message = null;
    }

    return view('visitors.pre-registered', compact('visitors', 'message'));
  }

  //pre-register
  public function preRegisterPage()
  {
    return view('welcome');
  }


  public function preRegister(Request $request)
  {
    $registered_date = date('Y-m-d');
    $visitor_first_name = $request->input('visitor_first_name');
    $visitor_last_name = $request->input('visitor_last_name');
    $license_plate = $request->input('license_plate');
    $visit_purpose = $request->input('visit_purpose');
    $resident_name = $request->input('resident_name');
    $visit_date = $request->input('visit_date');

    // Validate if the visitor is in the blocked list
    $blockedVisitor = BlockedVisitor::where([
      'visitor_first_name' => $visitor_first_name,
      'visitor_last_name' => $visitor_last_name,
      'license_plate' => $license_plate,
    ])->first();

    if ($blockedVisitor) {
      return redirect()->back()->with('error', 'Visitor is blocked.');
    }

    // Check if the visitor is already existing in the Visitor model
    $existingVisitor = Visitor::where([
      'visitor_first_name' => $visitor_first_name,
      'visitor_last_name' => $visitor_last_name,
      'license_plate' => $license_plate,
    ])->first();

    if ($existingVisitor) {
      return redirect()->back()->with('error', 'Visitor is already registered.');
    }

    // Check if the visitor is already existing in the Visitor model
    $preVisitor = PreRegisteredVisitor::where([
      'visitor_first_name' => $visitor_first_name,
      'visitor_last_name' => $visitor_last_name,
      'license_plate' => $license_plate,
    ])->first();

    if ($preVisitor) {
      return redirect()->back()->with('error', 'Visitor has already pre-registered.');
    }

    PreRegisteredVisitor::create([
      'visitor_first_name' => $visitor_first_name,
      'visitor_last_name' => $visitor_last_name,
      'license_plate' => $license_plate,
      'visit_purpose' => $visit_purpose,
      'resident_name' => $resident_name,
      'visit_date' => $visit_date,
      'registered_date' => $registered_date,
    ]);

    return redirect()
      ->back()
      ->with('success', 'Thank you for submitting the form. Your registration is pending approval.');
  }

  public function acceptVisitors($id)
  {
    $preVisitor = PreRegisteredVisitor::find($id);

    // Get the last used ID from the visitors table
    $lastVisitorId = Visitor::max('id');

    // Get the last used ID from the blocked visitor table
    $lastBlockedId = BlockedVisitor::max('visitor_id');

    // Initialize the new ID with the higher of the two last IDs
    $visitor_id = max($lastVisitorId, $lastBlockedId) + 1;

    // Create a new record in the visitors table
    $visitor = new Visitor([
      'id' => $visitor_id,
      'visitor_first_name' => $preVisitor->visitor_first_name,
      'visitor_last_name' => $preVisitor->visitor_last_name,
      'license_plate' => $preVisitor->license_plate,
      'visit_purpose' => $preVisitor->visit_purpose,
      'resident_name' => $preVisitor->resident_name,
      'visit_date' => $preVisitor->visit_date,
      'visitor_qrcode' => 'VMS_' . hash('md5', $preVisitor->visitor_first_name . $preVisitor->visitor_last_name . $preVisitor->license_plate),
      'registered_date' => $preVisitor->registered_date,
    ]);
    $visitor->save();

    // Delete the record from the pre-reg visitors table
    $preVisitor->delete();

    return redirect()
      ->back()
      ->with('success', 'Pre-registration has been accepted.');
  }

  public function declineVisitors($id)
  {
    $preVisitor = PreRegisteredVisitor::find($id);

    // Delete the record from the pre-reg visitors table
    $preVisitor->delete();

    return redirect()
      ->back()
      ->with('success', 'Pre-registration has been declined.');
  }

  //pre-register
  public function inquiryPage()
  {
    return view('inquiry');
  }


  public function inquiry(Request $request)
  {
    $visitor_first_name = $request->input('visitor_first_name');
    $visitor_last_name = $request->input('visitor_last_name');
    $license_plate = $request->input('license_plate');

    // Check if the visitor is in the PreRegisteredVisitor table
    $preRegisteredVisitor = PreRegisteredVisitor::where('visitor_first_name', $visitor_first_name)
      ->where('visitor_last_name', $visitor_last_name)
      ->where('license_plate', $license_plate)
      ->first();

    if ($preRegisteredVisitor) {
      // The visitor is in the pre-registered table
      return redirect()
        ->back()
        ->with('error', 'Your pre-registration hasn\'t been approved yet.');
    }

    // Check if the visitor is in the Visitor table
    $registeredVisitor = Visitor::where('visitor_first_name', $visitor_first_name)
      ->where('visitor_last_name', $visitor_last_name)
      ->where('license_plate', $license_plate)
      ->first();

    if ($registeredVisitor) {
      // The visitor is in the registered table
      $qrCode = $registeredVisitor->visitor_qrcode;
      return redirect()
        ->back()
        ->with([
          'success' => 'You are a registered visitor.', 'qrCode' => $qrCode
        ]);
    }

    return redirect()
      ->back()
      ->with('error', 'Your registration does not exist or may have been declined.');
  }
}
