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
    document.getElementById('text').value = c;
    document.forms[0].submit();
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
        <form action="insert.php" method="post" class="form-horizontal mb-3">
            <label>SCANNED QR CODE</label>
            <input type="text" name="text" id="text" readonly="" placeholder="QR Code"
                class="form-control">
        </form>
    </div>
@endsection
