<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function index()
  {
    return view('auth.login');
  }
  /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  /**
   * Create a new controller instance.
   *
   * @return RedirectResponse
   */
  public function login(Request $request): RedirectResponse
  {
    $input = $request->all();

    $this->validate($request, [
      'username' => 'required',
      'password' => 'required',
    ]);

    if (auth()->attempt(['username' => $input['username'], 'password' => $input['password']])) {
      if (auth()->user()->type == 'Admin') {
        Auth::logoutOtherDevices(request('password'));
        return redirect()->route('dashboard');
      } else {
        Auth::logoutOtherDevices(request('password'));
        return redirect()->route('dashboard');
      }
    } else {
      return redirect()
        ->route('login')
        ->with('error', 'Username or Password is invalid.');
    }
  }
}
