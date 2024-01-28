@extends('layouts/contentNavbarLayout')

@section('title', 'Records: Visitors')
@section('page-script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
    $('#search').on('keyup',function() {
        $value = $(this).val();

        if($value){
          $('.visitors_data').hide();
          $('.search_visitors_data').show();
        }
        else {
          $('.visitors_data').show();
          $('.search_visitors_data').hide();
        }

        $.ajax({
            url:"{{URL::to('search')}}",
            type:"GET",
            data:{'search':$value},

            success:function (data) {
                $('#content').html(data);
            }
        })
    });
</script>
@endsection

@section('content')
<!-- Table and modals -->
<div class="card">
  <div class="card-header pb-3">
    <h5 class="card-title">Registered Visitors</h5>
    <div class="row">
      <div class="col-auto mt-3">
        <!-- Search bar -->
        <div class="search">
          <input type="search" name="search" id="search" placeholder="Search..." class="form-control">
        </div>
      </div>
      <div class="col mt-3 d-flex justify-content-sm-between justify-content-md-end">
        <!-- Filter dropdown -->
        <form action="{{ route('visitors.records') }}" method="GET">
          <select name="filter" class="form-select" onchange="this.form.submit()">
            <option value="today" {{ request('filter') === 'today' ? 'selected' : '' }}>Today</option>
            <option value="this_week" {{ request('filter') === 'this_week' ? 'selected' : '' }}>This Week</option>
            <option value="this_month" {{ request('filter') === 'this_month' ? 'selected' : '' }}>This Month</option>
            <option value="all" {{ (request('filter') === 'all' || !request()->has('filter')) ? 'selected' : '' }}>All</option>
          </select>
        </form>
        <!-- Export button -->
        <a class="btn btn-secondary ms-3" href="{{ route('visitors.export') }}?filter={{ request('filter') }}">
          <span>
            <i class='bx bx-export'></i>
            <span class="d-none d-sm-inline-block">Export to CSV</span>
          </span>
        </a>
      </div>
    </div>
  </div>

  <hr class="m-0">

  <div class="table-responsive text-nowrap">
    @if ($message)
    <p class="text-center mt-3">{{ $message }}</p>
    @else
    <table class="table table-striped" id="table_visitors">
      <thead>
        <tr>
          <th>Visitor #</th>
          <th>Visitor Name</th>
          <th>License Plate</th>
          <th>Purpose of Visit</th>
          <th>Date of Visit</th>
          <th>QR Code</th>
          <th>Registered Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0 visitors_data">
        @foreach ($visitors as $visitor)
        <tr>
          <td>
            <span class="fw-medium">{{ $visitor->id }}</span>
            <a href="#" data-bs-toggle="modal" data-bs-target="#view{{ $visitor->id }}"><i class="bx bx-qr"></i></a>
          </td>
          <td>{{ $visitor->visitor_name }}</td>
          <td>{{ $visitor->license_plate }}</td>
          <td>{{ $visitor->visit_purpose }}</td>
          <td>{{ $visitor->visit_date }}</td>
          <td>{{ $visitor->visitor_qrcode }}</td>
          <td>{{ $visitor->registered_date }}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu">
                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit{{ $visitor->id }}">
                  <i class="bx bx-edit-alt me-1"></i> Edit
                </button>
                <form action="{{ route('visitors.destroy', $visitor->id) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="dropdown-item"><i class="bx bx-trash me-1"></i> Delete</button>
                </form>
              </div>
            </div>
          </td>
        </tr>
        <!-- VIEW Modal -->
        <div class="col-lg-4 col-md-6">
          <div>
            <!-- Modal -->
            <div class="modal fade" id="view{{ $visitor->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Visitor Details | # {{ $visitor->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="text-center">
                      <img
                        src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{ $visitor->visitor_qrcode }}"
                        alt="QRCode{{ $visitor->id }}" />
                    </div>
                    <div class="row mb-3">
                      <div class="col">
                        <label for="visitor_name" class="form-label">Visitor Name</label>
                        <input type="text" id="visitor_name" class="form-control" name="visitor_name"
                          value="{{ $visitor->visitor_name }}" readonly />
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col">
                        <label for="visit_purpose" class="form-label">Purpose of Visit</label>
                        <input type="text" id="visit_purpose" class="form-control" name="visit_purpose"
                          value="{{ $visitor->visit_purpose }}" readonly />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <label for="license_plate" class="form-label">License Plate</label>
                        <input type="text" id="license_plate" class="form-control" name="license_plate"
                          value="{{ $visitor->license_plate }}" readonly />
                      </div>
                      <div class="col">
                        <label for="visit_date" class="form-label">Date of Visit</label>
                        <input type="text" id="visit_date" class="form-control" name="visit_date"
                          value="{{ $visitor->visit_date }}" readonly />
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
        <!-- EDIT Modal -->
        <div class="col-lg-4 col-md-6">
          <div>
            <!-- Modal -->
            <div class="modal fade" id="edit{{ $visitor->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Edit Visitor Details | # {{ $visitor->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="{{ route('visitors.update', $visitor->id) }}" method="post">
                    @csrf @method('PUT')
                    <div class="modal-body">
                      <div class="text-center">
                        <img
                          src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{ $visitor->visitor_qrcode }}"
                          alt="QRCode{{ $visitor->id }}" />
                      </div>
                      <div class="row mb-3">
                        <div class="col">
                          <label for="visitor_name" class="form-label">Visitor Name</label>
                          <input type="text" id="visitor_name" class="form-control capitalize-words" name="visitor_name"
                            value="{{ $visitor->visitor_name }}" maxlength="50" />
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col">
                          <label for="visit_purpose" class="form-label">Purpose of Visit</label>
                          <input type="text" id="visit_purpose" class="form-control capitalize-words"
                            name="visit_purpose" value="{{ $visitor->visit_purpose }}" maxlength="50" />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <label for="license_plate" class="form-label">License Plate</label>
                          <input type="text" id="license_plate" class="form-control capitalize" name="license_plate"
                            value="{{ $visitor->license_plate }}" maxlength="8" />
                        </div>
                        <div class="col">
                          <label for="visit_date" class="form-label">Date of Visit</label>
                          <input type="date" id="visit_date" class="form-control" name="visit_date"
                            value="{{ $visitor->visit_date }}" />
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </tbody>
      <tbody id="content" class="search_visitors_data"></tbody>
    </table>
    @endif
  </div>
  <div class="pt-3 px-3">
    {{ $visitors->links() }}
  </div>
</div>
@endsection