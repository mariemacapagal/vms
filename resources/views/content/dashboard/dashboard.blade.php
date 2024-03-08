@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('content')
<div class="row">
  <div class="col-md-3 col-sm-3 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between m-0">
          <div class="avatar flex-shrink-0 me-3">
            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-group"></i></span>
          </div>
          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
            <div class="me-2">
              <span class="d-block mb-1">Total Visitors</span>
              <h3 class="card-title text-nowrap mb-2">{{ $totalVisitors }}</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-3 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between m-0">
          <div class="avatar flex-shrink-0 me-3">
            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-log-in"></i></span>
          </div>
          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
            <div class="me-2">
              <span class="d-block mb-1">Total Check-ins</span>
              <h3 class="card-title text-nowrap mb-2">{{ $visitLogs->where('check_in')->count() }}</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-3 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between m-0">
          <div class="avatar flex-shrink-0 me-3">
            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-log-out"></i></span>
          </div>
          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
            <div class="me-2">
              <span class="d-block mb-1">Total Check-outs</span>
              <h3 class="card-title text-nowrap mb-2">{{ $visitLogs->where('check_out')->count() }}</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-3 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between m-0">
          <div class="avatar flex-shrink-0 me-3">
            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-group"></i></span>
          </div>
          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
            <div class="me-2">
              <span class="d-block mb-1">Total Pre-registration</span>
              <h3 class="card-title text-nowrap mb-2">{{ $totalPreReg }}</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Purpose of Visit -->
<div class="row">
  <div class="col-sm-12 col-md-4 order-2 order-md-3 order-lg-2 mb-4">
    <div class="card">
      <div class="row row-bordered g-0">
        <div class="col">
          <h5 class="card-header m-0 me-2 pb-2">Visitor Weekly Statistics</h5>
          <div class="px-2">
            <div class="card-body">
              <div style="">
                <canvas id="visitorChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-12 col-md-8 order-2 order-md-3 order-lg-2 mb-4">
    <div class="card">
      <div class="row row-bordered g-0">
        <div class="col-md-6">
          <h5 class="card-header m-0 me-2 pb-3">Purpose of Visit</h5>
          <div class="px-2">
            <div class="card-body">
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
                      <small class="fw-medium">{{$visitLogs->where('visit_purpose', 'Amenities')->count()}}</small>
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
                      <small class="fw-medium">{{$visitLogs->where('visit_purpose', 'Delivery')->count()}}</small>
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
                      <small class="fw-medium">{{$visitLogs->where('visit_purpose', 'Services')->count()}}</small>
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
                      <small class="fw-medium">{{$visitLogs->where('visit_purpose', 'Visiting')->count()}}</small>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="row justify-content-center">
            <div class="col-10 my-3" style="width: 70%; margin: auto;">
              <div class="text-center fw-medium mb-3">Purpose of Visit</div>
              <canvas id="purposeChart"></canvas>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>




<script>
  var ctx = document.getElementById('visitorChart').getContext('2d');
  var visitorCount = <?php echo json_encode($visitorCount); ?>;

  var chart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: Object.keys(visitorCount),
          datasets: [{
              label: 'Visitors',
              data: Object.values(visitorCount),
              backgroundColor: '#e1e8f8',
              borderColor: '#5b83da',
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              y: {
                  beginAtZero: true
              }
          }
      }
  });
</script>
<script>
  var data = @json($visitPurpose);
  var labels = data.map(item => item.visit_purpose);
  var counts = data.map(item => item.count);

  var ctx = document.getElementById('purposeChart').getContext('2d');
  var purposeChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
          labels: labels,
          datasets: [{
              data: counts,
              backgroundColor: [
                  '#ddf1e1', //amenities
                  '#fff2d6', //delivery
                  '#e1e8f8', //services
                  '#f9dfe1' //visitin
              ],
              borderColor: [
                  '#38ad52',
                  '#ffab00',
                  '#5b83da',
                  '#dc3545'
              ],
              borderWidth: 1
          }]
      },
      options: {
          responsive: true
      }
  });
</script>
@endsection
