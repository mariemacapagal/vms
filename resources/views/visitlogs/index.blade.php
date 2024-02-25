@extends('layouts/contentNavbarLayout')

@section('title', 'QR Code Scanner')

@section('page-script')
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script type="text/javascript" src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
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
<h4 class="py-2 mb-4">Scan the Visitor's QR Code</h4>
<div class="row">
  <div class="col-md-6 mb-3">
      <video id="preview" width="100%" playsinline></video>
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
          <th>#</th>
          <th>Visitor #</th>
          <th>Check In</th>
          <th>Check Out</th>
          <th>Log Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($visitlogs as $visitlog)
        <tr>
          <td><span class="fw-medium">{{ $visitlog->id }}</span> <a href="#" data-bs-toggle="modal" data-bs-target="#view{{ $visitlog->id }}"><i class='bx bx-notepad'></i></a></td>
          <td>{{ $visitlog->visitor_id }}</td>
          <td>{{ $visitlog->check_in }}</td>
          <td>{{ $visitlog->check_out }}</td>
          <td>{{ $visitlog->log_date }}</td>
          <td><span class="badge me-1 {{ $visitlog->status == 'OUT' ? 'bg-label-success' : 'bg-label-info'}}">{{ $visitlog->status }}</span></td>
        </tr>

        <!-- VIEW Modal -->
        <div class="col-lg-4 col-md-6">
          <div>
            <!-- Modal -->
            <div class="modal fade" id="view{{ $visitlog->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Visit Details | Visitor # {{ $visitlog->visitor_id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row mb-3">
                      <div class="col">
                        <label for="visit_purpose" class="form-label">Purpose of Visit</label>
                        <input type="text" id="visit_purpose" class="form-control" name="visit_purpose"
                          value="{{ $visitlog->visit_purpose }}" readonly />
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col">
                        <label for="resident_name" class="form-label">Resident's Name</label>
                        <input type="text" id="resident_name" class="form-control" name="resident_name"
                          value="{{ $visitlog->resident_name }}" readonly />
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
        </div>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>
  <div class="pt-3 px-3 d-flex justify-content-end">
    {{ $visitlogs->links() }}
  </div>
</div>
@endsection
