@extends('layouts/contentNavbarLayout')

@section('title', 'Visitor Registration')

@section('content')
<h4 class="py-2 mb-4">Visitor Registration</h4>

<!-- Basic Layout & Basic with Icons -->
<div class="row">
  <div class="col-8">
    <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{ $visitor->id }}" alt="" srcset="">
  </div>
</div>
@endsection
