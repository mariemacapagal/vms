@extends('layouts/contentNavbarLayout')

@section('title', 'Blocked Visitors')

@section('content')
@if (session('success'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<p class="fw-bold m-0">{{ session('success') }}</p>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@endif
<!-- Table -->
<div class="card">
  <div class="card-header pb-3">
    <h5 class="card-title">Blocked Visitors</h5>
  </div>

  <hr class="m-0">

  <div class="table-responsive text-nowrap">
    @if ($message)
			<p class="text-center mt-3">{{ $message }}</p>
		@else
    <table class="table table-striped" id="table_users">
        <thead>
            <tr>
              <th>#</th>
              <th>Visitor #</th>
              <th>Visitor's Name</th>
              <th>License Plate</th>
              <th>Purpose of Visit</th>
              <th>Resident's Name</th>
              <th>Last Date of Visit</th>
              <th>Registered Date</th>
              <th>Action</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0 users-data">
            @foreach ($blockedVisitors as $blockedVisitor)
                <tr>
                    <td>{{ $blockedVisitor->id }}</td>
                    <td>{{ $blockedVisitor->visitor_id }}</td>
                    <td class="text-danger">{{ $blockedVisitor->visitor_first_name }} {{ $blockedVisitor->visitor_last_name }}</td>
                    <td>{{ $blockedVisitor->license_plate }}</td>
                    <td>{{ $blockedVisitor->visit_purpose }}</td>
                    <td>{{ $blockedVisitor->resident_name }}</td>
                    <td>{{ $blockedVisitor->visit_date }}</td>
                    <td>{{ $blockedVisitor->registered_date }}</td>
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
