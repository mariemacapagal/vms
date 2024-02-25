@extends('layouts/contentNavbarLayout')

@section('title', 'Visitor Registration')

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
  input.addEventListener('input', function() {
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
  input.addEventListener('input', function() {
    // Capitalize the input value
    this.value = this.value.toUpperCase();
  });
});
</script>
@endsection

@section('content')
<h4 class="py-2 mb-4">Visitor Registration</h4>

<!-- Visitor Form / Registration -->
<div class="row">
  <div class="col-md-6 mb-3">
    <div class="card mb-3">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Add a new visitor</h5>
      </div>
      <div class="card-body">
        <form id="visitorForm" action="{{ route('visitors.store') }}" method="POST">
          @csrf
          <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="visitor_name">Visitor's Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control capitalize-words" id="visitor_name" name="visitor_name"
                maxlength="30" required />
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="license_plate">License Plate</label>
            <div class="col-sm-9">
              <input type="text" class="form-control capitalize" id="license_plate" name="license_plate" maxlength="8"
                required />
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="visit_purpose">Purpose of Visit</label>
            <div class="col-sm-9">
              <select class="form-select" id="visit_purpose" name="visit_purpose" aria-label="Select a visit purpose"
                required>
                <option value="" disabled selected hidden>Select a visit purpose</option>
                <option value="Visiting">Visiting</option>
                <option value="Delivery">Delivery</option>
                <option value="Amenities">Amenities</option>
                <option value="Services">Services</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="resident_name">Resident's Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control capitalize-words" id="resident_name" name="resident_name"
                maxlength="60" required />
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="visit_date">Date of Visit</label>
            <div class="col-sm-9">
              <input type="date" class="form-control" id="visit_date" name="visit_date" required />
            </div>
          </div>

          <div class="row justify-content-end">
            <div class="col-sm-9">
              <button type="submit" class="btn btn-primary">
                Submit
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Show newly added visitor -->
  @if(session('lastVisitor'))
  <div class="col-md-6 mb-3">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0"><b class="text-success">Visitor Successfully Added!</b> | Visitor #
          {{ session('lastVisitor')->id }}</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 d-flex align-items-center justify-content-between">
            <img
              src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl={{ session('lastVisitor')->visitor_qrcode }}"
              alt="QRCode{{ session('lastVisitor')->id }}" class="mx-auto d-block" />
          </div>
          <div class="col-md-6">
            <div class="col mb-3">
              <label for="visitor_name" class="form-label">Visitor's Name</label>
              <input type="text" id="visitor_name" class="form-control" name="visitor_name"
                value="{{ session('lastVisitor')->visitor_name }}" readonly />
            </div>
            <div class="col mb-3">
              <label for="license_plate" class="form-label">License Plate</label>
              <input type="text" id="license_plate" class="form-control" name="license_plate"
                value="{{ session('lastVisitor')->license_plate }}" readonly />
            </div>
            <div class="col mb-3">
              <label for="visit_purpose" class="form-label">Purpose of Visit</label>
              <input type="text" id="visit_purpose" class="form-control" name="visit_purpose"
                value="{{ session('lastVisitor')->visit_purpose }}" readonly />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
</div>

<!-- Table and modals -->
<div class="card">
  <h5 class="card-header">Registered Visitors</h5>
  <div class="table-responsive text-nowrap">
    @if ($message)
    <p class="text-center">{{ $message }}</p>
    @else
    <table class="table table-striped" id="table_visitors">
      <thead>
        <tr>
          <th>Visitor #</th>
          <th>Visitor's Name</th>
          <th>License Plate</th>
          <th>Purpose of Visit</th>
          <th>Resident's Name</th>
          <th>Date of Visit</th>
          <th>Registered Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($visitors as $visitor)
        <tr>
          <td>
            <span class="fw-medium">{{ $visitor->id }}</span>
            <a href="#" data-bs-toggle="modal" data-bs-target="#view{{ $visitor->id }}"><i class="bx bx-qr"></i></a>
          </td>
          <td>{{ $visitor->visitor_name }}</td>
          <td>{{ $visitor->license_plate }}</td>
          <td>{{ $visitor->visit_purpose }}</td>
          <td>{{ $visitor->resident_name }}</td>
          <td>{{ $visitor->visit_date }}</td>
          <td>{{ $visitor->registered_date }}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu">
                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                  data-bs-target="#edit{{ $visitor->id }}">
                  <i class="bx bx-edit-alt me-1"></i> Edit
                </button>
                <form action="{{ route('visitors.delete', $visitor->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="dropdown-item"
                    onclick="return confirm('Are you sure you want to delete this visitor?')">
                    <i class="bx bx-trash me-1"></i> Delete
                  </button>
                </form>
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
                        src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{ $visitor->visitor_qrcode }}"
                        alt="QRCode{{ $visitor->id }}" />
                      <p class="text-wrap">QR Code: {{ $visitor->visitor_qrcode }}</p>
                    </div>
                    <div class="row mb-3">
                      <div class="col">
                        <label for="visitor_name" class="form-label">Visitor's Name</label>
                        <input type="text" id="visitor_name" class="form-control capitalize-words" name="visitor_name"
                          value="{{ $visitor->visitor_name }}" readonly />
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col">
                        <label for="visit_purpose" class="form-label">Purpose of Visit</label>
                        <input type="text" id="visit_purpose" class="form-control" name="visit_purpose"
                          value="{{ $visitor->visit_purpose }}" readonly />
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col">
                        <label for="resident_name" class="form-label">Resident's Name</label>
                        <input type="text" id="resident_name" class="form-control" name="resident_name"
                          value="{{ $visitor->resident_name }}" readonly />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col mb-3">
                        <label for="license_plate" class="form-label">License Plate</label>
                        <input type="text" id="license_plate" class="form-control" name="license_plate"
                          value="{{ $visitor->license_plate }}" readonly />
                      </div>
                      <div class="col">
                        <label for="visit_date" class="form-label">Date of Visit</label>
                        <input type="text" id="visit_date" class="form-control" name="visit_date"
                          value="{{ $visitor->visit_date }}" readonly />
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
                  <form action="{{ route('visitors.update', $visitor->id) }}" method="post">
                    @csrf @method('PUT')
                    <div class="modal-body">
                      <div class="text-center">
                        <img
                          src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{ $visitor->visitor_qrcode }}"
                          alt="QRCode{{ $visitor->id }}" />
                        <p class="text-wrap">QR Code: {{ $visitor->visitor_qrcode }}</p>
                      </div>

                      <div class="row mb-3">
                        <div class="col">
                          <label for="visitor_name" class="form-label">Visitor's Name</label>
                          <input type="text" id="visitor_name" class="form-control capitalize-words" name="visitor_name"
                            value="{{ $visitor->visitor_name }}" maxlength="60" />
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col">
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
                      </div>
                      <div class="row mb-3">
                        <div class="col">
                          <label for="resident_name" class="form-label">Resident's Name</label>
                          <input type="text" id="resident_name" class="form-control capitalize-words"
                            name="resident_name" value="{{ $visitor->resident_name }}" maxlength="60" />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col mb-3">
                          <label for="license_plate" class="form-label">License Plate</label>
                          <input type="text" id="license_plate" class="form-control capitalize" name="license_plate"
                            value="{{ $visitor->license_plate }}" maxlength="8" />
                        </div>
                        <div class="col">
                          <label for="visit_date" class="form-label">Date of Visit</label>
                          <input type="date" id="visit_date" class="form-control" name="visit_date"
                            value="{{ $visitor->visit_date }}" />
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
        @endforeach
      </tbody>
    </table>
    @endif
  </div>
  <div class="pt-3 px-3 d-flex justify-content-end">
    {{ $visitors->links() }}
  </div>
</div>
@endsection
