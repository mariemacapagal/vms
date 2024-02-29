@extends('layouts/contentNavbarLayout')

@section('title', 'Records: Visit Logs')

@section('content')
<!-- Table and modals -->
<div class="card">
  <div class="card-header pb-3">
    <h5 class="card-title">Visit Logs</h5>
    <div class="row">
      <form action="{{ route('visitlogs.records') }}" method="GET">
        @csrf
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
              <a class="btn btn-primary ms-3" href="{{ route('visitlogs.export', ['filter' => request('filter'), 'status' => request('status')]) }}">
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
      <tbody class="table-border-bottom-0">
        @foreach ($visitlogs as $visitlog)
          <tr>
            <td><span class="fw-medium">{{ $visitlog->id }}</span> <a href="#" data-bs-toggle="modal" data-bs-target="#view{{ $visitlog->id }}"><i class='bx bx-notepad'></i></a></td>
            <td>{{ $visitlog->visitor_id }}</td>
            <td>{{ $visitlog->check_in }}</td>
            <td>{{ $visitlog->check_out }}</td>
            <td>{{ $visitlog->log_date }}</td>
            <td><span class="badge me-1 {{ $visitlog->status == 'OUT' ? 'bg-label-success' : 'bg-label-info'}}">{{ $visitlog->status }}</span></td>
          </tr>
        <!-- for visit logs -->
          <!-- VIEW Modal -->
          <div class="col-lg-4 col-md-6">
            <div>
              <!-- Modal -->
              <div class="modal fade" id="view{{ $visitlog->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalCenterTitle">Visit Details | Visitor # {{ $visitlog->visitor_id }}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row mb-3">
                        <div class="col">
                          <label for="visit_purpose" class="form-label">Purpose of Visit</label>
                          <input type="text" id="visit_purpose" class="form-control" name="visit_purpose"
                            value="{{ $visitlog->visit_purpose }}" readonly />
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col">
                          <label for="resident_name" class="form-label">Resident's Name</label>
                          <input type="text" id="resident_name" class="form-control" name="resident_name"
                            value="{{ $visitlog->resident_name }}" readonly />
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
        </div>

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
