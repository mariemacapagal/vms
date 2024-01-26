@extends('layouts/contentNavbarLayout')

@section('title', 'QR Code Scanner')

@section('page-script')
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script>
    let scanner = new Instascan.Scanner({
    video: document.getElementById('preview')
    });

    Instascan.Camera.getCameras()
    .then(function (cameras) {
        if (cameras.length > 0) {
        scanner.start(cameras[0]);
        } else {
        alert('No cameras found');
        }
    })
    .catch(function (e) {
        console.error(e);
    });

    scanner.addListener('scan', function (c) {
    document.getElementById('visitor_qrcode').value = c;
    document.getElementById('qrcodescanner').submit();
    });
</script>
@endsection

@section('content')
<h4 class="py-2">QR Code Scanner</h4>
<div class="row">
    <div class="col-md-6 mb-3">
        <video id="preview" width="100%"></video>
    </div>
    <div class="col-md-6">
        <form action="{{ route('visitlogs.store') }}" method="POST" class="form-horizontal mb-3" id="qrcodescanner">
            @csrf
            <label>SCANNED QR CODE</label>
            <input  class="form-control" type="text"  id="visitor_qrcode" name="visitor_qrcode" placeholder="QR Code" readonly>
        </form>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
</div>

<!-- Table and modals -->
<div class="card">
    <h5 class="card-header">Visit Logs</h5>
    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Log ID</th>
            <th>Visitor ID</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Log Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach ($visitlogs as $visitlog)
          @foreach ($visitors as $visitor)
            <tr><td>{{ $visitlog->id }}</td>
            <td><span class="fw-medium">{{ $visitlog->visitor_id }}</span> <a href="/" data-bs-toggle="modal" data-bs-target="#view{{ $visitlog->visitor_id }}"><i class='bx bx-qr'></i></a></td>
            <td>{{ $visitlog->check_in }}</td>
            <td>{{ $visitlog->check_out }}</td>
            <td>{{ $visitlog->log_date }}</td>
            <td>{{ $visitlog->status }}</td>
          </tr>
          <!-- VIEW Modal -->
          <div class="col-lg-4 col-md-6">
            <div>
              <!-- Modal -->
              <div class="modal fade" id="view{{ $visitor->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalCenterTitle">Visitor Details | Visitor ID: {{ $visitor->id }}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="text-center">
                        <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{ $visitor->visitor_qrcode }}" alt="QRCode{{ $visitor->id }}">
                      </div>
                      <div class="row mb-3">
                        <div class="col">
                          <label for="visitor_name" class="form-label">Visitor Name</label>
                          <input type="text" id="visitor_name" class="form-control" name="visitor_name" value="{{ $visitor->visitor_name }}" readonly>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col">
                          <label for="visit_purpose" class="form-label">Purpose of Visit</label>
                          <input type="text" id="visit_purpose" class="form-control" name="visit_purpose" value="{{ $visitor->visit_purpose }}" readonly>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <label for="license_plate" class="form-label">License Plate</label>
                          <input type="text" id="license_plate" class="form-control" name="license_plate" value="{{ $visitor->license_plate }}" readonly>
                        </div>
                        <div class="col">
                          <label for="visit_date" class="form-label">Date of Visit</label>
                          <input type="text" id="visit_date" class="form-control" name="visit_date" value="{{ $visitor->visit_date }}" readonly>
                        </div>
                      </div>
                    </div>
        
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
