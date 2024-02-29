@extends('layouts/contentNavbarLayout')

@section('title', 'Reports')

@section('content')
  <h4 class="py-2 mb-4">Generate Report</h4>
  <div class="row">
      <div class="col-md-12 mb-3">
          <div class="card mb-3">
              <div class="card-body">
                  <form action="{{ route('reports') }}" method="GET" id="exportForm">
                      @csrf
                      <div class="row">
                          <div class="col-md-3 col-lg-2 mb-3 mb-md-0">
                              <label for="table_selection" class="form-label">Select Table:</label>
                              <select name="table_selection" id="table_selection" class="form-select" required>
                                  <option value="visitors"
                                      {{ request('table_selection') === 'visitors' ? 'selected' : '' }}>Visitors</option>
                                  <option value="visit_logs"
                                      {{ request('table_selection') === 'visit_logs' ? 'selected' : '' }}>Visit Logs
                                  </option>
                              </select>
                          </div>

                          <div class="col-md-3 col-lg-2 mb-3 mb-md-0">
                              <label for="start_date" class="form-label">Start Date:</label>
                              <input type="date" id="start_date" name="start_date" class="form-control"
                                  value="{{ request('start_date') }}" required>
                          </div>

                          <div class="col-md-3 col-lg-2">
                              <label for="end_date" class="form-label">End Date:</label>
                              <input type="date" id="end_date" name="end_date" class="form-control"
                                  value="{{ request('end_date') }}" required>
                          </div>

                          <div class="col-auto mt-4 pt-1">
                              <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                          @if (!request('start_date') || !request('end_date') || !request('table_selection') || $fetchedData->isEmpty())
                          @else
                              <div class="col-auto mt-4 pt-1">
                                  <a href="{{ route('reports.export', ['table_selection' => $tableSelection, 'start_date' => $start_date, 'end_date' => $end_date_full]) }}"
                                      class="btn btn-primary">Save CSV</a>
                              </div>
                          @endif
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <!-- Display fetched data in a table -->
  @if (!request('start_date') || !request('end_date') || !request('table_selection'))
  @elseif ($fetchedData->isEmpty())
      <p class="text-center">No records found for the selected date range.</p>
  @else
      <!-- Table and modals -->
      <div class="card">
          <h5 class="card-header">
              @if ($tableSelection === 'visitors')
                  Visitors Report
              @else
                  Visit Logs Report
              @endif
          </h5>
          <div class="table-responsive text-nowrap">
              <table class="table table-striped">
                  <thead>
                      <tr>
                          @if ($tableSelection === 'visitors')
                              <th>#</th>
                              <th>Visitor's Name</th>
                              <th>License Plate</th>
                              <th>Purpose of Visit</th>
                              <th>Resident's Name</th>
                              <th>Date of Visit</th>
                          @else
                              <th>#</th>
                              <th>Visitor #</th>
                              <th>Check In</th>
                              <th>Check Out</th>
                              <th>Log Date</th>
                              <th>Status</th>
                          @endif
                      </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                      @foreach ($fetchedData as $data)
                          <tr>
                              <td>{{ $data->id }}</td>
                              @if ($tableSelection === 'visitors')
                                  <td>{{ $data->visitor_first_name }}</td>
                                  <td>{{ $data->visitor_last_name }}</td>
                                  <td>{{ $data->license_plate }}</td>
                                  <td>{{ $data->visit_purpose }}</td>
                                  <td>{{ $data->resident_name }}</td>
                                  <td>{{ $data->visit_date }}</td>
                              @else
                                  <td>{{ $data->visitor_id }}</td>
                                  <td>{{ $data->check_in }}</td>
                                  <td>{{ $data->check_out }}</td>
                                  <td>{{ $data->log_date }}</td>
                                  <td><span
                                          class="badge me-1 {{ $data->status == 'OUT' ? 'bg-label-success' : 'bg-label-info' }}">{{ $data->status }}</span>
                                  </td>
                              @endif
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
          <!-- Display on small screens with links at the end -->
          <div class="pt-3 px-3 d-flex justify-content-end d-sm-flex d-md-none d-lg-none d-xl-none">
            {{ $fetchedData->links() }}
          </div>
          <!-- Hide on small screens, display on medium and larger screens -->
          <div class="pt-3 px-3 d-none d-md-block">
            {{ $fetchedData->onEachSide(1)->links() }}
          </div>
      </div>
  @endif
@endsection
