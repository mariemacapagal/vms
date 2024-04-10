@extends('layouts/contentNavbarLayout')

@section('title', 'QR Code Scanner')

@section('page-script')
  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
  <script type="text/javascript" src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
  <script>
    let scanner = new Instascan.Scanner({
      video: document.getElementById('preview'),
      mirror: false
    });

    Instascan.Camera.getCameras().then(function (cameras) {
      if (cameras.length > 0) {
        // Choose the back camera if available, otherwise use the first camera
        const selectedCamera = cameras.find(camera => camera.name.toLowerCase().includes('back')) || cameras[0];
        scanner.start(selectedCamera);
      } else {
        console.error('No cameras found.');
      }
    }).catch(function (e) {
      console.error(e);
    });

    scanner.addListener('scan', function (c) {
      document.getElementById('visitor_qrcode').value = c;
      document.getElementById('qrcodescanner').submit();
    });
  </script>
@endsection

@section('content')
  <h4 class="py-2 mb-4">Scan the Visitor's QR Code</h4>
  <div class="row">
    <div class="col-md-6 mb-3">
      <video id="preview" width="100%" playsinline></video>
    </div>
    <div class="col-md-6">
      <form action="{{ route('visitlogs.store') }}" method="POST" class="form-horizontal" id="qrcodescanner">
        @csrf
        <input class="form-control d-none" type="text"  id="visitor_qrcode" name="visitor_qrcode" placeholder="QR Code" readonly>
      </form>

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <p class="fw-bold">{{ session('success') }}</p>
          @if(session('lastLog'))
            <p class="text-black mb-1">Visitor's Full Name: <span class="fw-bold">{{ session('lastLog')->visitor_first_name }} {{ session('lastLog')->visitor_last_name }}</span></p>
            <p class="text-black mb-1">License Plate: <span class="fw-bold">{{ session('lastLog')->license_plate }}</span></p>
            <p class="text-black mb-1">Valid ID: </p>
            <img src="./images/{{ session('lastLog')->valid_id }}" class="col-8" alt="ValidID_{{ session('lastLog')->valid_id }}">
          @endif
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <p class="fw-bold m-0">{{ session('error') }}</p>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
    </div>
  </div>

  <!-- Table and modal -->
  <div class="card">
    <h5 class="card-header">Visit Logs</h5>
    <div class="table-responsive text-nowrap">
      @if ($message)
        <p class="text-center">{{ $message }}</p>
      @else
        <table class="table table-striped" id="table_visitlogs">
          <thead>
            <tr>
              <th>Log #</th>
              <th>Visitor #</th>
              <th>Purpose of Visit</th>
              <th>Resident Name</th>
              <th>Check In</th>
              <th>Check Out</th>
              <th>Log Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach ($visitlogs as $visitlog)
              <tr>
                <td><span class="fw-medium">{{ $visitlog->id }}</span></td>
                <td>{{ $visitlog->visitor_id }}</td>
                <td>{{ $visitlog->visit_purpose }}</td>
                <td>{{ $visitlog->resident_name }}</td>
                <td>{{ $visitlog->check_in }}</td>
                <td>{{ $visitlog->check_out }}</td>
                <td>{{ $visitlog->log_date }}</td>
                <td><span class="badge me-1 {{ $visitlog->status == 'OUT' ? 'bg-label-success' : 'bg-label-info'}}">{{ $visitlog->status }}</span></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
    <!-- Display on small screens with links at the end -->
    <div class="pt-3 px-3 d-flex justify-content-end d-sm-flex d-md-none d-lg-none d-xl-none">
      {{ $visitlogs->links() }}
    </div>
    <!-- Hide on small screens, display on medium and larger screens -->
    <div class="pt-3 px-3 d-none d-md-block">
      {{ $visitlogs->onEachSide(1)->links() }}
    </div>
  </div>
@endsection
