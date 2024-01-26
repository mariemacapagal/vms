@extends('layouts/blankLayout')

@section('title', 'Sign up')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection


@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-text text-body fw-bold">{{config('variables.systemName')}}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Register</h4>
          <p class="mb-4">Enter the details of a new user.</p>

          <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="mb-3">
              <label for="name" class="form-label">{{ __('Name') }}</label>
              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

              @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="mb-3">
              <label for="username" class="form-label">{{ __('Username') }}</label>
              <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">

              @error('username')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="mb-3 form-password-toggle">
              <label for="password" class="form-label">{{ __('Password') }}</label>
              <div class="input-group input-group-merge">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              
                @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="mb-3 form-password-toggle">
              <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
              <div class="input-group input-group-merge">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
              </div>
            </div>

            <button class="btn btn-primary d-grid w-100">
              Register
            </button>
          </form>
        </div>
      </div>
      <!-- Register Card -->
    </div>
  </div>
</div>
@endsection
