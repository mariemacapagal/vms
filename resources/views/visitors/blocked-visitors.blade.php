@extends('layouts/contentNavbarLayout')

@section('title', 'Blocked Visitors')

@section('content')
<!-- Table -->
<div class="card">
  <div class="card-header pb-3">
    <h5 class="card-title">Blocked Visitors</h5>
  </div>

  <hr class="m-0">

  <div class="table-responsive text-nowrap">
    @if ($message)
			<p class="text-center mt-3">{{ $message }}</p>
		@else
    <table class="table table-striped" id="table_users">
        <thead>
            <tr>
              <th>#</th>
              <th>Visitor #</th>
              <th>Visitor's Name</th>
              <th>License Plate</th>
              <th>Purpose of Visit</th>
              <th>Resident's Name</th>
              <th>Last Date of Visit</th>
              <th>Registered Date</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0 users-data">
            @foreach ($blockedVisitors as $blockedVisitor)
                <tr>
                    <td>{{ $blockedVisitor->id }}</td>
                    <td>{{ $blockedVisitor->visitor_id }}</td>
                    <td class="text-danger">{{ $blockedVisitor->visitor_name }}</td>
                    <td>{{ $blockedVisitor->license_plate }}</td>
                    <td>{{ $blockedVisitor->visit_purpose }}</td>
                    <td>{{ $blockedVisitor->resident_name }}</td>
                    <td>{{ $blockedVisitor->visit_date }}</td>
                    <td>{{ $blockedVisitor->registered_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
  </div>
  <div class="pt-3 px-3 d-flex justify-content-end">
      {{ $blockedVisitors->links() }}
  </div>
</div>
@endsection
