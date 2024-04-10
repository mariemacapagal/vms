@extends('layouts/contentNavbarLayout')

@section('title', 'Records: Visitors')

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/modal-print.css')}}">
@endsection

@section('page-script')
<script>
  // Get today's date
  const today = new Date().toLocaleDateString('en-GB').split('/').reverse().join('-');
  document.getElementById('visit_date').value = today;

  // Add event listeners to all input fields with class "capitalize-words"
  document.querySelectorAll('.capitalize-words').forEach(input => {
    input.addEventListener('input', function () {
      // Split the input value into words
      let words = this.value.split(' ');
      // Capitalize the first letter of each word
      words = words.map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase());
      // Join the words back together and set as input value
      this.value = words.join(' ');
    });
  });

  // Add event listeners to all input fields with class "capitalize"
  document.querySelectorAll('.capitalize').forEach(input => {
    input.addEventListener('input', function () {
      // Capitalize the input value
      this.value = this.value.toUpperCase();
    });
  });
</script>
@endsection

@section('content')
@if (session('success'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<p class="fw-bold m-0">{{ session('success') }}</p>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@endif
<!-- Table and modals -->
<div class="card">
	<div class="card-header pb-3">
		<h5 class="card-title">Pre-registered Visitors</h5>
		<div class="row pt-3">
			<form action="{{ route('visitors.preRegisteredList') }}" method="GET">
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

          <div class="col-md-3 col-lg-2 mb-3">
            <label for="purpose" class="form-label">Visit Purpose:</label>
              <div class="dropdown">
                <select name="purpose" class="form-select" onchange="this.form.submit()">
                  <option value="" selected>Select Purpose</option>
                  <option value="Visiting" {{ request('purpose') === 'Visiting' ? 'selected' : '' }}>Visiting</option>
                  <option value="Delivery" {{ request('purpose') === 'Delivery' ? 'selected' : '' }}>Delivery</option>
                  <option value="Amenities" {{ request('purpose') === 'Amenities' ? 'selected' : '' }}>Amenities</option>
                  <option value="Services" {{ request('purpose') === 'Services' ? 'selected' : '' }}>Services</option>
                </select>
              </div>
          </div>

          <div class="col-md-3 col-lg-2">
            <label for="purpose" class="form-label">Visit Date Range:</label>
            <div class="dropdown">
              <select name="filter" class="form-select" onchange="this.form.submit()">
                <option value="" selected>Select Visit Date</option>
                <option value="today" {{ request('filter') === 'today' ? 'selected' : '' }}>Today</option>
                <option value="this_week" {{ request('filter') === 'this_week' ? 'selected' : '' }}>This Week</option>
                <option value="this_month" {{ request('filter') === 'this_month' ? 'selected' : '' }}>This Month</option>
              </select>
            </div>
          </div>

          <div class="col-auto mt-4 pt-1">
            <div class="export">
              <!-- Export button -->
              <a class="btn btn-primary" href="{{ route('preregvisitors.export', ['filter' => request('filter'), 'purpose' => request('purpose'), 'fname' => request('fname'), 'lname' => request('lname')]) }}">
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
			<table class="table table-striped">
        <thead>
					<tr>
						<th>#</th>
						<th>Visitor's First Name</th>
            <th>Visitor's Last Name</th>
						<th>License Plate</th>
						<th>Purpose of Visit</th>
						<th>Resident's Name</th>
						<th>Date of Visit</th>
						<th>Registered Date</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody class="table-border-bottom-0 visitors-data">
					@foreach ($visitors as $visitor)
						<tr>
							<td>{{ $visitor->id }}</td>
							<td>{{ $visitor->visitor_first_name }}</td>
              <td>{{ $visitor->visitor_last_name }}</td>
							<td>{{ $visitor->license_plate }}</td>
							<td>{{ $visitor->visit_purpose }}</td>
							<td>{{ $visitor->resident_name }}</td>
							<td>{{ $visitor->from_visit_date }} to {{ $visitor->to_visit_date }}</td>
							<td>{{ $visitor->registered_date }}</td>
							<td>
								<div class="dropdown">
									<button type="button" class="btn p-0 dropdown-toggle hide-arrow"
										data-bs-toggle="dropdown">
										<i class="bx bx-dots-vertical-rounded"></i>
									</button>
									<div class="dropdown-menu">
                    <form action="{{ route('visitors.accept', $visitor->id) }}" method="POST">
											@csrf
											<button type="submit" class="dropdown-item text-success">
											<i class="bx bx-check me-1"></i> Accept
										</button>
										</form>
										<form action="{{ route('visitors.decline', $visitor->id) }}" method="POST">
											@csrf
											@method('DELETE')
											<button type="submit" class="dropdown-item text-danger"
												onclick="return confirm('Are you sure you want to decline this potential visitor?')">
												<i class="bx bx-x me-1"></i> Decline
											</button>
										</form>
									</div>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endif
	</div>
  <!-- Display on small screens with links at the end -->
  <div class="pt-3 px-3 d-flex justify-content-end d-sm-flex d-md-none d-lg-none d-xl-none">
    {{ $visitors->links() }}
  </div>
  <!-- Hide on small screens, display on medium and larger screens -->
  <div class="pt-3 px-3 d-none d-md-block">
    {{ $visitors->onEachSide(1)->links() }}
  </div>
</div>

@endsection
