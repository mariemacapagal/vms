@extends('layouts/blankLayout')

@section('title', 'Pre-Register')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/pre-reg.css')}}">
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
<div class="container-fluid bg-image" style="background-image: url('assets/img/backgrounds/villa-teresa.png'); background-size: cover; background-repeat: no-repeat; min-width: 100vw; min-height: 100vh;">
  <div style="position: fixed; top: 0; left: 0; min-width: 100vw; min-height: 100vh; background-color: rgba(0, 0, 0, 0.6); z-index: 1;"></div>
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="#" class="app-brand-link">
              <span class="h4 text-body text-wrap fw-bold text-primary text-center mb-0">Visitor Management System</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Pre-registration</h4>
          <p class="mb-3">Please fill out the form below to pre-register as a visitor.</p>
          @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p class="fw-bold m-0">{{ session('error') }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
          @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p class="fw-bold m-0">{{ session('success') }}</p>
            <p class="fw-bold m-0">Check the status of your pre-registration through the link below.</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
          <form id="visitorForm" action="{{ route('visitors.pre-register') }}" method="POST">
            @csrf
            <div class="col">
              <label for="visitor_name" class="form-label">Visitor's Name</label>
              <div class="row">
                <div class="col-sm mb-3">
                  <input type="text" class="form-control capitalize-words" id="visitor_first_name" name="visitor_first_name"
                    maxlength="40" placeholder="First Name" required />
                </div>
                <div class="col-sm mb-3">
                  <input type="text" class="form-control capitalize-words" id="visitor_last_name" name="visitor_last_name"
                    maxlength="40" placeholder="Last Name" required />
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="form-label" for="license_plate">License Plate</label>
              <div class="col-sm">
                <input type="text" class="form-control capitalize" id="license_plate" name="license_plate" maxlength="13"
                  required />
              </div>
            </div>
            <div class="row mb-3">
              <label class="form-label" for="visit_purpose">Purpose of Visit</label>
              <div class="col-sm">
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
              <label class="form-label" for="resident_name">Resident's Name</label>
              <div class="col-sm">
                <input type="text" class="form-control capitalize-words" id="resident_name" name="resident_name"
                  maxlength="80" required />
              </div>
            </div>
            <div class="row mb-3">
              <label class="form-label" for="visit_date">Date of Visit</label>
              <div class="col-sm">
                <input type="date" class="form-control" id="visit_date" name="visit_date" required />
              </div>
            </div>

            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Submit</button>
            </div>
          </form>
          <p class="mb-0">Already pre-registered? <a href="{{ route('inquiry') }}">Check the status here.</a></p>
          <hr>
          <i class="bx bx-user-pin me-1 bx-sm"></i><a href="{{ route('login') }}" class="text-center">Security Personnel Login</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
