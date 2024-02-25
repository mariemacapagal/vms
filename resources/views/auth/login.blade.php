@extends('layouts/blankLayout')

@section('title', 'Login')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-fluid bg-image" style="background-image: url('assets/img/backgrounds/villa-teresa.png'); background-size: cover; background-repeat: no-repeat; width: 100vw; height: 100vh;">
  <div style="position: absolute; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.6); z-index: 1;"></div>
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link">
              <span class="h4 text-body text-wrap fw-bold text-primary text-center mb-0">{{config('variables.systemName')}}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Login</h4>
          <p class="mb-3">Please log in to your account.</p>
          @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
          <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input id="username" type="text" class="form-control" name="username" placeholder="Enter your username" autofocus>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">{{ __('Login') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</div>
@endsection
