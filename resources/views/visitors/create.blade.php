@extends('layouts/contentNavbarLayout')

@section('title', 'Visitor Registration')

@section('content')
<h4 class="py-2 mb-4">Visitor Registration</h4>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
  <!-- Basic Layout -->
  <div class="col-xxl-6">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Add a new visitor</h5>
      </div>
      <div class="card-body">
        <form id="visitorForm" action="{{ route('visitors.store') }}" method="POST">
          @csrf
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="visitor_name">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="visitor_name" name="visitor_name" />
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="license_plate">License Plate</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="license_plate" name="license_plate" />
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="visit_purpose">Purpose of Visit</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="visit_purpose" name="visit_purpose" />
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-md-2 col-form-label" for="visit_date">Date of Visit</label>
            <div class="col-md-10">
              <input class="form-control" type="date" id="visit_date" name="visit_date" />
            </div>
          </div>
          <div class="row justify-content-end">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    // Get today's date in the format YYYY-MM-DD
    const today = new Date().toISOString().split('T')[0];
  
    // Set the value of the date input field to today's date
    document.getElementById('visit_date').value = today;
</script>
@endsection
