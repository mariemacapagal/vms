@extends('layouts/contentNavbarLayout')

@section('title', 'Settings')

@section('content')

<h4 class="py-2 mb-4">
  <span class="text-muted fw-light">Settings /</span> User Management
</h4>

@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Table and modals -->
<div class="card">
  <div class="card-header pb-3">
    <h5 class="card-title">Users</h5>
    <div class="row">
      <form action="" method="GET">
        @csrf
        <div class="row">
          <div class="col d-flex justify-content-end">
            <button type="button" class="btn btn-primary ms-3" data-bs-toggle="modal"
                data-bs-target="#add-user">
                <i class="bx bx-plus me-1"></i> Add User
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <hr class="m-0">

  <div class="table-responsive text-nowrap">
    <table class="table table-striped" id="table_users">
        <thead>
            <tr>
                <th>#</th>
                <th>Employee Name</th>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0 users-data">
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->type }}</td>
                    <td>
                        <div class="dropdown" style="overflow: visible;">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu" style="overflow: visible;">
                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#edit{{ $user->id }}">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </button>
                                <form action="{{ route('settings.destroy', $user->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item"
                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="bx bx-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                <!-- EDIT Modal -->
                <div class="col-lg-4 col-md-6">
                    <div>
                        <!-- Modal -->
                        <div class="modal fade" id="edit{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">Edit User Details | User #
                                            {{ $user->id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formAuthentication"
                                            action="{{ route('settings.update', $user->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="mb-3">
                                                <label for="name"
                                                    class="form-label">{{ __('Name') }}</label>
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    name="name" required autocomplete="name" maxlength="60"
                                                    autofocus value="{{ $user->name }}">

                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="username"
                                                    class="form-label">{{ __('Username') }}</label>
                                                <input id="username" type="username"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    name="username" minlength="6" maxlength="15"
                                                    autocomplete="username" required value="{{ $user->username }}">

                                                @error('username')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3 form-password-toggle">
                                                <label for="password"
                                                    class="form-label">{{ __('New Password') }}</label>
                                                <div class="input-group input-group-merge">
                                                    <input id="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" minlength="8" autocomplete="new-password">
                                                    <span class="input-group-text cursor-pointer"><i
                                                            class="bx bx-hide"></i></span>

                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3 form-password-toggle">
                                                <label for="password-confirm"
                                                    class="form-label">{{ __('Confirm New Password') }}</label>
                                                <div class="input-group input-group-merge">
                                                    <input id="password-confirm" type="password"
                                                        class="form-control" name="password_confirmation"
                                                        autocomplete="new-password">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="type"
                                                    class="form-label">{{ __('User Type') }}</label>
                                                <select name="type" class="form-select">
                                                    <option value="0"
                                                        {{ $user->type === 'User' ? 'selected' : '' }}>Guard / User
                                                    </option>
                                                    <option value="1"
                                                        {{ $user->type === 'Admin' ? 'selected' : '' }}>OIC / Admin
                                                    </option>
                                                </select>
                                            </div>

                                            <button type="submit"
                                                class="btn btn-primary d-grid w-100">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
  </div>
  <div class="pt-3 px-3 d-flex justify-content-end">
      {{ $users->links() }}
  </div>
</div>

<!-- Add User Modal -->
<div class="col-lg-4 col-md-6">
  <div class="col-4">
      <!-- Modal -->
      <div class="modal fade" id="add-user" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="modalCenterTitle">Add a user</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"
                          aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                      <form id="formAuthentication" class="mb-3" action="{{ route('register') }}"
                          method="POST">
                          @csrf
                          <div class="mb-3">
                              <label for="name" class="form-label">{{ __('Name') }}</label>
                              <input id="name" type="text"
                                  class="form-control @error('name') is-invalid @enderror" name="name"
                                  value="{{ old('name') }}" required autocomplete="name" maxlength="60"
                                  autofocus>

                              @error('name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>

                          <div class="mb-3">
                              <label for="username" class="form-label">{{ __('Username') }}</label>
                              <input id="username" type="username"
                                  class="form-control @error('username') is-invalid @enderror" name="username"
                                  value="{{ old('username') }}" minlength="6" maxlength="15"
                                  autocomplete="username" required>

                              @error('username')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>

                          <div class="mb-3 form-password-toggle">
                              <label for="password" class="form-label">{{ __('Password') }}</label>
                              <small class="text-muted"> (must contain lowercase and uppercase letters, a special
                                  character, and a digit)</small>
                              <div class="input-group input-group-merge">
                                  <input id="password" type="password"
                                      class="form-control @error('password') is-invalid @enderror" name="password"
                                      minlength="8" autocomplete="new-password" required>
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
                                  <input id="password-confirm" type="password" class="form-control"
                                      name="password_confirmation" required autocomplete="new-password">
                              </div>
                          </div>

                          <div class="mb-3">
                              <label for="type" class="form-label">{{ __('User Type') }}</label>
                              <select name="type" class="form-select">
                                  <option value="0">Guard / User</option>
                                  <option value="1">OIC / Admin</option>
                              </select>
                          </div>

                          <button type="submit" class="btn btn-primary d-grid w-100" id="addUserBtn">Add</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
      document.getElementById("addUserBtn").addEventListener("click", function(event) {
          event.preventDefault(); // Prevent the form from submitting

          // You can add additional validation or processing logic here before submitting the form
          document.getElementById("formAuthentication").submit();
      });
  });
</script>

@endsection
