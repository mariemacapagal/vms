@extends('layouts/contentNavbarLayout')

@section('title', 'Blocked Visitors')

@section('content')
@if (session('success'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<p class="fw-bold m-0">{{ session('success') }}</p>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@endif
<ul class="nav nav-pills mb-3" role="tablist">
  <li class="nav-item" role="presentation">
    <a href="{{ route('visitors.blocked') }}" class="nav-link active">Current Blocked Visitors</a>
  </li>
  <li class="nav-item" role="presentation">
    <a href="{{ route('visitors.blockedHistory') }}" class="nav-link">History of Blocked Visitors</a>
  </li>
</ul>
<!-- Table -->
<div class="card">
  <div class="card-header pb-3">
    <h5 class="card-title">Blocked Visitors</h5>
    <div class="row pt-3">
			<form action="{{ route('visitors.blocked') }}" method="GET">
				@csrf
				<div class="row">
          <div class="col-md-4 col-lg-3 mb-3">
            <label for="visitor_first_name" class="form-label">Visitor's First Name:</label>
            <div class="input-group">
              <!-- Search -->
              <input type="search" name="fname" id="fname" placeholder="Search..."
                class="form-control" value="{{ request('fname') }}"
                aria-label="Search Visitor" aria-describedby="button-addon2">
              <button class="btn btn-outline-primary" type="submit" id="button-addon2"><i
                  class='bx bx-search'></i></button>
            </div>
          </div>

          <div class="col-md-4 col-lg-3 mb-3">
            <label for="visitor_last_name" class="form-label">Visitor's Last Name:</label>
            <div class="input-group">
              <!-- Search -->
              <input type="search" name="lname" id="lname" placeholder="Search..."
                class="form-control" value="{{ request('lname') }}"
                aria-label="Search Visitor" aria-describedby="button-addon2">
              <button class="btn btn-outline-primary" type="submit" id="button-addon2"><i
                  class='bx bx-search'></i></button>
            </div>
          </div>

          <div class="col-auto mt-4 pt-1">
            <div class="export">
              <!-- Export button -->
              <a class="btn btn-primary" href="{{ route('blockedvisitors.export', ['fname' => request('fname'), 'lname' => request('lname')]) }}">
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
    <table class="table table-striped" id="table_users">
        <thead>
            <tr>
              <th>Visitor #</th>
              <th>Visitor's Name</th>
              <th>License Plate</th>
              <th>Registered Date</th>
              <th>Blocked Date</th>
              <th>Remarks</th>
              <th>Blocked By</th>
              <th>Action</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0 users-data">
            @foreach ($blockedVisitors as $blockedVisitor)
                <tr>
                    <td>{{ $blockedVisitor->visitor_id }}</td>
                    <td class="text-danger">{{ $blockedVisitor->visitor_first_name }} {{ $blockedVisitor->visitor_last_name }}</td>
                    <td>{{ $blockedVisitor->license_plate }}</td>
                    <td>{{ $blockedVisitor->registered_date }}</td>
                    <td>{{ $blockedVisitor->blocked_date }}</td>
                    <td>{{ $blockedVisitor->remarks }}</td>
                    <td>{{ $blockedVisitor->user }}</td>
                    <td><form action="{{ route('visitors.unblock', $blockedVisitor->id) }}" method="POST">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-primary"
												onclick="return confirm('Are you sure you want to unblock this visitor?')">
												<i class="bx bx-block me-1"></i> Unblock
											</button>
										</form></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
  </div>
  <!-- Display on small screens with links at the end -->
  <div class="pt-3 px-3 d-flex justify-content-end d-sm-flex d-md-none d-lg-none d-xl-none">
    {{ $blockedVisitors->links() }}
  </div>
  <!-- Hide on small screens, display on medium and larger screens -->
  <div class="pt-3 px-3 d-none d-md-block">
    {{ $blockedVisitors->onEachSide(1)->links() }}
  </div>
</div>
@endsection
