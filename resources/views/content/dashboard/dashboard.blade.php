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
  <div class="col-3 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class='bx bxs-user rounded p-2 text-bg-primary'></i>
          </div>
        </div>
        <span class="d-block mb-1">Total Visitors</span>
        <h3 class="card-title text-nowrap mb-2">$2,456</h3>
        <small class="text-danger fw-medium"><i class="bx bx-down-arrow-alt"></i> -14.82%</small>
      </div>
    </div>
  </div>

</div>

@endsection
