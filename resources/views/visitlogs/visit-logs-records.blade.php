@extends('layouts/contentNavbarLayout')

@section('title', 'Records: Visit Logs')

@section('content')
<!-- Table and modals -->
<div class="card">
  <div class="card-header pb-3">
    <h5 class="card-title">Visit Logs</h5>
    <div class="row pt-3">
      <form action="{{ route('visitlogs.records') }}" method="GET">
        @csrf
        <div class="row">
          <div class="col-auto mb-3">
            <label for="visit_status" class="form-label">Visit Status:</label>
            <div class="dropdown">
              <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="" selected>Select Status</option>
                <option value="In" {{ request('status') === 'In' ? 'selected' : '' }}>In</option>
                <option value="Out" {{ request('status') === 'Out' ? 'selected' : '' }}>Out</option>
              </select>
            </div>
          </div>
          <div class="col-auto mb-3">
            <label for="visit_date" class="form-label">Visit Date Range:</label>
            <div class="dropdown">
              <select name="filter" class="form-select" onchange="this.form.submit()">
                <option value="" selected>Select Date Range</option>
                <option value="today" {{ request('filter') === 'today' ? 'selected' : '' }}>Today</option>
                <option value="this_week" {{ request('filter') === 'this_week' ? 'selected' : '' }}>This Week</option>
                <option value="this_month" {{ request('filter') === 'this_month' ? 'selected' : '' }}>This Month</option>
              </select>
            </div>
          </div>
          <div class="col mt-4 pt-1">
            <div class="export">
              <!-- Export button -->
              <a class="btn btn-primary" href="{{ route('visitlogs.export', ['filter' => request('filter'), 'status' => request('status')]) }}">
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
          <th>Log #</th>
          <th>Visitor #</th>
          <th>Purpose of Visit</th>
          <th>Resident Name</th>
          <th>Check In</th>
          <th>Check Out</th>
          <th>Log Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($visitlogs as $visitlog)
          <tr>
            <td><span class="fw-medium">{{ $visitlog->id }}</span></td>
            <td>{{ $visitlog->visitor_id }}</td>
            <td>{{ $visitlog->visit_purpose }}</td>
            <td>{{ $visitlog->resident_name }}</td>
            <td>{{ $visitlog->check_in }}</td>
            <td>{{ $visitlog->check_out }}</td>
            <td>{{ $visitlog->log_date }}</td>
            <td><span class="badge me-1 {{ $visitlog->status == 'OUT' ? 'bg-label-success' : 'bg-label-info'}}">{{ $visitlog->status }}</span></td>
          </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>
  <!-- Display on small screens with links at the end -->
  <div class="pt-3 px-3 d-flex justify-content-end d-sm-flex d-md-none d-lg-none d-xl-none">
    {{ $visitlogs->links() }}
  </div>
  <!-- Hide on small screens, display on medium and larger screens -->
  <div class="pt-3 px-3 d-none d-md-block">
    {{ $visitlogs->onEachSide(1)->links() }}
  </div>
</div>
@endsection
