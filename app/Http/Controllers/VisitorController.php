<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class VisitorController extends Controller
{
  public function index()
  {
    $visitors = Visitor::orderBy('id', 'desc')
      ->simplePaginate(5)
      ->fragment('table_visitors');

    if ($visitors->isEmpty()) {
      $message = 'No data yet!';
    } else {
      $message = null;
    }

    return view('visitors.index', compact('visitors', 'message'));
  }

  // records
  public function records(Request $request)
  {
    $filter = $request->input('filter');
    $visitors = Visitor::query();

    switch ($filter) {
      case 'today':
        $visitors->whereDate('visit_date', Carbon::today());
        break;
      case 'this_week':
        $visitors->whereBetween('visit_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        break;
      case 'this_month':
        $visitors->whereYear('visit_date', Carbon::now()->year)->whereMonth('visit_date', Carbon::now()->month);
        break;
      default:
        // Do nothing, fetch all visitors
        break;
    }

    $visitors = $visitors->orderBy('id', 'asc')->paginate(10)->appends(['filter' => $filter]);

    if ($visitors->isEmpty()) {
      $message = 'No data found.';
    } else {
      $message = null;
    }

    return view('visitors.visitors-records', compact('visitors', 'message'));
  }

  //search records
  public function search(Request $request)
  {
    $output = '';
    $visitors = Visitor::where('visitor_name', 'Like', '%' . $request->search . '%')
      ->orWhere('visit_purpose', 'Like', '%' . $request->search . '%')
      ->get();

    if ($visitors->isEmpty()) {
      $output = '
        <tr>
          <td colspan="8" class="text-center">No matching records found.  </td>
        </tr>
      ';
    } else {
      foreach ($visitors as $visitor) {
        $output .= '
          <tr>
              <td>
                  <span class="fw-medium">' . $visitor->id . '</span>
                  <a href="#" data-bs-toggle="modal" data-bs-target="#view' . $visitor->id . '"><i class="bx bx-qr"></i></a>
              </td>
              <td>' . $visitor->visitor_name . '</td>
              <td>' . $visitor->license_plate . '</td>
              <td>' . $visitor->visit_purpose . '</td>
              <td>' . $visitor->visit_date . '</td>
              <td>' . $visitor->visitor_qrcode . '</td>
              <td>' . $visitor->registered_date . '</td>
              <td>
                  <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                          <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                          <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit' . $visitor->id . '">
                              <i class="bx bx-edit-alt me-1"></i> Edit
                          </button>
                          <form action="' . route('visitors.destroy', $visitor->id) . '" method="post">
                              ' . csrf_field() . '
                              ' . method_field('DELETE') . '
                              <button type="submit" class="dropdown-item"><i class="bx bx-trash me-1"></i> Delete</button>
                          </form>
                      </div>
                  </div>
              </td>
          </tr>
          ';
      }
    }
    return response($output);
  }

  // export records
  public function export(Request $request)
  {
    $filter = $request->input('filter');

    // Fetch visitors data based on filter criteria
    $visitors = Visitor::query();

    switch ($filter) {
      case 'today':
        $visitors->whereDate('visit_date', Carbon::today());
        break;
      case 'this_week':
        $visitors->whereBetween('visit_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        break;
      case 'this_month':
        $visitors->whereYear('visit_date', Carbon::now()->year)->whereMonth('visit_date', Carbon::now()->month);
        break;
      default:
        // Do nothing, fetch all visitors
        break;
    }

    $visitors = $visitors->get();
    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add headers
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Visitor Name');
    $sheet->setCellValue('C1', 'License Plate');
    $sheet->setCellValue('D1', 'Visit Purpose');
    $sheet->setCellValue('E1', 'Visit Date');
    $sheet->setCellValue('F1', 'Visitor QR Code');
    $sheet->setCellValue('G1', 'Registered Date');

    // Add visitor data
    $row = 2;
    foreach ($visitors as $visitor) {
      $sheet->setCellValue('A' . $row, $visitor->id);
      $sheet->setCellValue('B' . $row, $visitor->visitor_name);
      $sheet->setCellValue('C' . $row, $visitor->license_plate);
      $sheet->setCellValue('D' . $row, $visitor->visit_purpose);
      $sheet->setCellValue('E' . $row, $visitor->visit_date);
      $sheet->setCellValue('F' . $row, $visitor->visitor_qrcode);
      $sheet->setCellValue('G' . $row, $visitor->registered_date);
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

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $datetime = date('Y-m-d h:i:s A');

    $visitor_name = $request->input('visitor_name');
    $license_plate = $request->input('license_plate');
    $visit_purpose = $request->input('visit_purpose');
    $visit_date = $request->input('visit_date');
    $visitor_qrcode = hash('md5', $visitor_name . '_' . $license_plate . '_' . $datetime);

    Visitor::create([
      'visitor_name' => $visitor_name,
      'license_plate' => $license_plate,
      'visit_purpose' => $visit_purpose,
      'visit_date' => $visit_date,
      'visitor_qrcode' => $visitor_qrcode,
      'registered_date' => $datetime,
    ]);

    // Retrieve the last created visitor
    $lastVisitor = Visitor::latest()->first();

    return redirect()
      ->route('visitors.index')
      ->with(['success' => 'Visitor added successfully.', 'lastVisitor' => $lastVisitor]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $datetime = date('Y-m-d h:i:s A');

    $visitor_name = $request->input('visitor_name');
    $license_plate = $request->input('license_plate');
    $visit_purpose = $request->input('visit_purpose');
    $visit_date = $request->input('visit_date');
    $visitor_qrcode = hash('md5', $visitor_name . '_' . $license_plate . '_' . $datetime);

    $visitor = Visitor::find($id);
    $visitor->update([
      'visitor_name' => $visitor_name,
      'license_plate' => $license_plate,
      'visit_purpose' => $visit_purpose,
      'visit_date' => $visit_date,
      'visitor_qrcode' => $visitor_qrcode,
    ]);

    return redirect()
      ->back()
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
      ->back()
      ->with('success', 'Visitor deleted successfully');
  }

  public function edit($id)
  {
    $visitor = Visitor::find($id);
    return view('visitors.edit', compact('visitor'));
  }
}