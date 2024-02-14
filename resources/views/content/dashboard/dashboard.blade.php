@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')
<div class="row">
  <div class="col-md-4 col-sm-3 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0 me-3">
            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-home-alt"></i></span>
          </div>
        </div>
        <span class="d-block mb-1">Total Visitors</span>
        <h3 class="card-title text-nowrap mb-2">{{ $totalVisitors }}</h3>
      </small>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-3 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0 me-3">
            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-log-in"></i></span>
          </div>
        </div>
        <span class="d-block mb-1">Total Check-ins</span>
        <h3 class="card-title text-nowrap mb-2">{{ $visitLogs->where('check_in')->count() }}</h3>
      </small>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-3 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0 me-3">
            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-log-out"></i></span>
          </div>
        </div>
        <span class="d-block mb-1">Total Check-outs</span>
        <h3 class="card-title text-nowrap mb-2">{{ $visitLogs->where('check_out')->count() }}</h3>
      </small>
      </div>
    </div>
  </div>
</div>
<!-- Total Revenue -->
<div class="col-12 col-lg-6 order-2 order-md-3 order-lg-2 mb-4">
  <div class="card">
    <div class="row row-bordered g-0">
      <div class="col-md-6">
        <h5 class="card-header m-0 me-2 pb-3">Total Visits</h5>
        <div class="px-2">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="d-flex flex-column align-items-center gap-1">
                <h2 class="mb-2">8,258</h2>
                <span>Total Orders</span>
              </div>
            </div>
            <ul class="p-0 m-0">
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-success"><i class="bx bx-home-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Amenities</h6>
                    <small class="text-muted">Courts, Park, Clubhouse</small>
                  </div>
                  <div class="purpose-progress">
                    <small class="fw-medium">{{$visitors->where('visit_purpose', 'Amenities')->count()}}</small>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-warning"><i class='bx bxs-package'></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Delivery</h6>
                    <small class="text-muted">Shopping, Food, Appliances</small>
                  </div>
                  <div class="purpose-progress">
                    <small class="fw-medium">{{$visitors->where('visit_purpose', 'Delivery')->count()}}</small>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-primary"><i class='bx bx-wrench'></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Services</h6>
                    <small class="text-muted">Repairs, Cleaning, Installing</small>
                  </div>
                  <div class="purpose-progress">
                    <small class="fw-medium">{{$visitors->where('visit_purpose', 'Services')->count()}}</small>
                  </div>
                </div>
              </li>
              <li class="d-flex">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-danger"><i class='bx bx-home-heart'></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Visiting</h6>
                    <small class="text-muted">Family, Friends, Relatives</small>
                  </div>
                  <div class="purpose-progress">
                    <small class="fw-medium">{{$visitors->where('visit_purpose', 'Visiting')->count()}}</small>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="row justify-content-center">
          <div class="col-10 my-3">
            <div class="text-center fw-medium pt-3 mb-3">Purpose of Visit</div>
            <canvas id="purposeChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
