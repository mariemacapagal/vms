<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
  public function index()
  {
    $users = User::simplePaginate(5);

    //return view('auth.register');
    return view('content.menu.settings', compact('users'));
  }
  /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

  use RegistersUsers;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::LOGIN;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name' => ['required', 'string', 'max:50'],
      'username' => ['required', 'string', 'max:15', 'unique:users'],
      'password' => [
        'required', 'string', 'min:8', 'confirmed',
        'regex:/[a-z]/',      // must contain at least one lowercase letter
        'regex:/[A-Z]/',      // must contain at least one uppercase letter
        'regex:/[0-9]/',      // must contain at least one digit
        'regex:/[@$!%*#?&]/', // must contain a special character
        'regex:/^\S*$/u',     // cannot contain spaces
      ],
      'type' => ['required'],
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\Models\User
   */
  protected function create(array $data)
  {
    return User::create([
      'name' => $data['name'],
      'username' => $data['username'],
      'password' => Hash::make($data['password']),
      'type' => $data['type'],
    ]);
  }

  public function register(Request $request)
  {
    $this->validator($request->all())->validate();

    event(new Registered($user = $this->create($request->all())));

    $response = $this->registered($request, $user);

    if ($response) {
      return $response;
    } else {
      return redirect()->route('settings')->with('success', 'New User is successfully added!');
    }
  }

  // Update the specified resource in storage.
  public function update(Request $request, string $id)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:50'],
      'username' => ['required', 'string', 'max:15',],
      'password' => [
        'nullable', 'string', 'min:8', 'confirmed',
        'regex:/[a-z]/',      // must contain at least one lowercase letter
        'regex:/[A-Z]/',      // must contain at least one uppercase letter
        'regex:/[0-9]/',      // must contain at least one digit
        'regex:/[@$!%*#?&]/', // must contain a special character
        'regex:/^\S*$/u',     // cannot contain spaces
      ],
      'type' => ['required'],
    ]);

    $user = User::find($id);
    $user->update([
      'name' => $request->input('name'),
      'username' => $request->input('username'),
      'password' => $request->input('password') ? Hash::make($request->input('password')) : $user->password,
      'type' => $request->input('type'),
    ]);

    return redirect()
      ->back()
      ->with('success', 'User updated successfully.');
  }

  // Remove the specified resource from storage.
  public function destroy($id)
  {
    $user = User::find($id);
    $user->delete();
    return redirect()
      ->back()
      ->with('success', 'User deleted successfully.');
  }

  public function edit($id)
  {
    $user = User::find($id);
    return view('settings.edit', compact('user'));
  }
}