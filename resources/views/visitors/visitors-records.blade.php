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
		<h5 class="card-title">Registered Visitors</h5>
		<div class="row pt-3">
			<form action="{{ route('visitors.records') }}" method="GET">
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
              <a class="btn btn-primary" href="{{ route('visitors.export', ['filter' => request('filter'), 'purpose' => request('purpose'), 'fname' => request('fname'), 'lname' => request('lname')]) }}">
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
			<table class="table table-striped" id="table_visitors">
        <thead>
					<tr>
						<th>Visitor #</th>
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
							<td>
								<span class="fw-medium">{{ $visitor->id }}</span>
								<a href="#" data-bs-toggle="modal" data-bs-target="#view{{ $visitor->id }}">
                  <i class="bx bx-qr"></i>
                </a>
							</td>
							<td>{{ $visitor->visitor_first_name }}</td>
              <td>{{ $visitor->visitor_last_name }}</td>
							<td>{{ $visitor->license_plate }}</td>
							<td>{{ $visitor->visit_purpose }}</td>
							<td>{{ $visitor->resident_name }}</td>
							<td>{{ $visitor->visit_date }}</td>
							<td>{{ $visitor->registered_date }}</td>
							<td>
								<div class="dropdown">
									<button type="button" class="btn p-0 dropdown-toggle hide-arrow"
										data-bs-toggle="dropdown">
										<i class="bx bx-dots-vertical-rounded"></i>
									</button>
									<div class="dropdown-menu">
										<button type="button" class="dropdown-item" data-bs-toggle="modal"
											data-bs-target="#edit{{ $visitor->id }}">
											<i class="bx bx-edit-alt me-1"></i> Edit
										</button>
                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                    data-bs-target="#block{{ $visitor->id }}">
                      <i class="bx bx-block me-1"></i> Block
                    </button>
									</div>
								</div>
							</td>
						</tr>
						<!-- VIEW Modal -->
            <div class="col-lg-4 col-md-6" id="print-modal">
              <div>
                <!-- Modal -->
                <div class="modal fade" id="view{{ $visitor->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Visitor Details | # {{ $visitor->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="text-center">
                          <img
                            src="https://quickchart.io/qr?text={{ $visitor->visitor_qrcode }}"
                            alt="QRCode{{ $visitor->id }}" />
                          <p class="text-wrap">QR Code: {{ $visitor->visitor_qrcode }}</p>
                        </div>
                        <div class="row">
                          <div class="col-sm mb-3">
                            <label for="visitor_first_name" class="form-label">Visitor's First Name</label>
                            <input type="text" id="visitor_first_name" class="form-control capitalize-words" name="visitor_first_name"
                              value="{{ $visitor->visitor_first_name }}" readonly />
                          </div>
                          <div class="col-sm mb-3">
                            <label for="visitor_last_name" class="form-label">Visitor's Last Name</label>
                            <input type="text" id="visitor_last_name" class="form-control capitalize-words" name="visitor_last_name"
                              value="{{ $visitor->visitor_last_name }}" readonly />
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm mb-3">
                            <label for="license_plate" class="form-label">License Plate</label>
                            <input type="text" id="license_plate" class="form-control" name="license_plate"
                              value="{{ $visitor->license_plate }}" readonly />
                          </div>
                          <div class="col-sm mb-3">
                            <label for="registered_date" class="form-label">Registered Date</label>
                            <input type="text" id="registered_date" class="form-control" name="registered_date"
                              value="{{ $visitor->registered_date }}" readonly />
                          </div>
                        </div>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="window.print()">Print</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
						<!-- EDIT Modal -->
            <div class="col-lg-4 col-md-6">
              <div>
                <!-- Modal -->
                <div class="modal fade" id="edit{{ $visitor->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Edit Visitor Details | Visitor # {{ $visitor->id }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="{{ route('visitors.update', $visitor->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-body">
                          <div class="text-center">
                            <img
                              src="https://quickchart.io/qr?text={{ $visitor->visitor_qrcode }}"
                              alt="QRCode{{ $visitor->id }}"/>
                            <p class="text-wrap">QR Code: {{ $visitor->visitor_qrcode }}</p>
                          </div>

                          <div class="row">
                            <div class="col-sm mb-3">
                              <label for="visitor_first_name" class="form-label">Visitor's First Name</label>
                              <input type="text" id="visitor_first_name" class="form-control capitalize-words" name="visitor_first_name"
                                value="{{ $visitor->visitor_first_name }}" maxlength="60" />
                            </div>
                            <div class="col-sm mb-3">
                              <label for="visitor_last_name" class="form-label">Visitor's Last Name</label>
                              <input type="text" id="visitor_last_name" class="form-control capitalize-words" name="visitor_last_name"
                                value="{{ $visitor->visitor_last_name }}" maxlength="60" />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm mb-3">
                              <label for="license_plate" class="form-label">License Plate</label>
                              <input type="text" id="license_plate" class="form-control capitalize" name="license_plate"
                                value="{{ $visitor->license_plate }}" maxlength="13" />
                            </div>
                            <div class="col-sm mb-3">
                              <label for="visit_date" class="form-label">Date of Visit</label>
                              <input type="date" id="visit_date" class="form-control" name="visit_date"
                                value="{{ $visitor->visit_date }}" />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm mb-3">
                              <label for="visit_purpose" class="form-label">Purpose of Visit</label>
                              <select class="form-select" id="visit_purpose" name="visit_purpose"
                                aria-label="Select a visit purpose">
                                <option value="" disabled selected hidden>Select a visit purpose</option>
                                <option value="Visiting" {{ $visitor->visit_purpose === "Visiting" ? "selected" : "" }}>
                                  Visiting</option>
                                <option value="Delivery" {{ $visitor->visit_purpose === "Delivery" ? "selected" : "" }}>
                                  Delivery</option>
                                <option value="Amenities" {{ $visitor->visit_purpose === "Amenities" ? "selected" : "" }}>
                                  Amenities</option>
                                <option value="Services" {{ $visitor->visit_purpose === "Services" ? "selected" : "" }}>
                                  Services</option>
                              </select>
                            </div>
                            <div class="col-sm">
                              <label for="resident_name" class="form-label">Resident's Name</label>
                              <input type="text" id="resident_name" class="form-control capitalize-words"
                                name="resident_name" value="{{ $visitor->resident_name }}" maxlength="60" />
                            </div>
                          </div>
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- BLOCK REMARKS Modal -->
            <div class="col-lg-4 col-md-6">
              <div>
                <!-- Modal -->
                <div class="modal fade" id="block{{ $visitor->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Are you sure you want to block {{ $visitor->visitor_first_name }} {{ $visitor->visitor_last_name }}?
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="{{ route('visitors.block', $visitor->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <div class="modal-body">
                          <div class="col-sm mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <input type="text" id="remarks" class="form-control" name="remarks" placeholder="Enter the reason" required/>
                          </div>
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary">Block</button>
                        </div>
                      </form>
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
    {{ $visitors->links() }}
  </div>
  <!-- Hide on small screens, display on medium and larger screens -->
  <div class="pt-3 px-3 d-none d-md-block">
    {{ $visitors->onEachSide(1)->links() }}
  </div>
</div>

@endsection
