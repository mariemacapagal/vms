@extends('layouts/contentNavbarLayout')

@section('title', 'Records: Visit Logs')

@section('content')
<!-- Table and modals -->
<div class="card">
  <div class="card-header pb-3">
    <h5 class="card-title">Visit Logs</h5>
    <div class="row">
      <form action="{{ route('visitlogs.records') }}" method="GET" id="searchForm">
        <div class="row">

          <div class="col mt-3 d-flex justify-content-sm-between justify-content-md-end">
            <!-- Dropdowns -->
            <div class="dropdown">
              <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="" selected>Select Status</option>
                <option value="In" {{ request('status') === 'In' ? 'selected' : '' }}>In</option>
                <option value="Out" {{ request('status') === 'Out' ? 'selected' : '' }}>Out</option>
              </select>
            </div>
            <div class="dropdown ms-3">
              <select name="filter" class="form-select" onchange="this.form.submit()">
                <option value="" selected>Select Date Range</option>
                <option value="today" {{ request('filter') === 'today' ? 'selected' : '' }}>Today</option>
                <option value="this_week" {{ request('filter') === 'this_week' ? 'selected' : '' }}>This Week</option>
                <option value="this_month" {{ request('filter') === 'this_month' ? 'selected' : '' }}>This Month</option>
              </select>
            </div>
            <div class="export">
              <!-- Export button -->
              <a class="btn btn-secondary ms-3" href="{{ route('visitlogs.export', ['filter' => request('filter'), 'status' => request('status')]) }}">
                <span>
                  <i class='bx bx-export'></i>
                  <span class="d-none d-sm-inline-block">Save CSV</span>
                </span>
              </a>
            </div>

          </div>
        </div>
      </form>
    </div>
  </div>

  <hr class="m-0">

  <div class="table-responsive text-nowrap">
    @if ($message)
    <p class="text-center mt-3">{{ $message }}</p>
    @else
    <table class="table table-striped" id="table_visitlogs">
      <thead>
        <tr>
          <th>#</th>
          <th>Visitor #</th>
          <th>Check In</th>
          <th>Check Out</th>
          <th>Log Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0 visitlogs-data">
        @foreach ($visitlogs as $visitlog)
          <tr>
            <td>{{ $visitlog->id }}</td>
            <td><span class="fw-medium">{{ $visitlog->visitor_id }}</span> <a href="#" data-bs-toggle="modal" data-bs-target="#view{{ $visitlog->visitor_id }}"><i class='bx bx-qr'></i></a></td>
            <td>{{ $visitlog->check_in }}</td>
            <td>{{ $visitlog->check_out }}</td>
            <td>{{ $visitlog->log_date }}</td>
            <td><span class="badge me-1 {{ $visitlog->status == 'OUT' ? 'bg-label-info' : 'bg-label-success'}}">{{ $visitlog->status }}</span></td>
          </tr>
        @foreach ($visitors as $visitor)
          <!-- VIEW Modal -->
          <div class="col-lg-4 col-md-6">
          <div>
            <!-- Modal -->
            <div class="modal fade" id="view{{ $visitor->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Visitor Details | Visitor # {{ $visitor->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="text-center">
                      <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{ $visitor->visitor_qrcode }}" alt="QRCode{{ $visitor->id }}">
                    </div>
                    <div class="row mb-3">
                      <div class="col">
                        <label for="visitor_name" class="form-label">Visitor Name</label>
                        <input type="text" id="visitor_name" class="form-control" name="visitor_name" value="{{ $visitor->visitor_name }}" readonly>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col">
                        <label for="visit_purpose" class="form-label">Purpose of Visit</label>
                        <input type="text" id="visit_purpose" class="form-control" name="visit_purpose" value="{{ $visitor->visit_purpose }}" readonly>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <label for="license_plate" class="form-label">License Plate</label>
                        <input type="text" id="license_plate" class="form-control" name="license_plate" value="{{ $visitor->license_plate }}" readonly>
                      </div>
                      <div class="col">
                        <label for="visit_date" class="form-label">Date of Visit</label>
                        <input type="text" id="visit_date" class="form-control" name="visit_date" value="{{ $visitor->visit_date }}" readonly>
                      </div>
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        @endforeach
      </tbody>
      <tbody id="content-visitlogs" class="search-visitlogs-data"></tbody>
    </table>
    @endif
  </div>
  <div class="pt-3 px-3">
    {{ $visitlogs->links() }}
  </div>
</div>
@endsection
