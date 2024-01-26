@extends('layouts/contentNavbarLayout')

@section('title', '403 Error')

@section('content')
<!-- Error -->
<div class="container-xxl container-p-y text-center">
  <div class="misc-wrapper">
    <h2 class="mb-2 mx-2">403 | ACCESS FORBIDDEN</h2>
    <p class="mb-4 mx-2">Access to this page is denied!</p>
    <div class="mt-3">
      <img src="{{asset('assets/img/illustrations/403-error.png')}}" alt="page-misc-error-light" width="400" class="img-fluid">
    </div>
  </div>
</div>
<!-- /Error -->
@endsection
