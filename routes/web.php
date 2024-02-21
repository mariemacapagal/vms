<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Dashboard;

use App\Http\Controllers\menu\Reports;
use App\Http\Controllers\menu\Settings;

use App\Http\Controllers\VisitorController;
use App\Http\Controllers\VisitLogController;

// Redirect '/' to the appropriate route based on authentication status
Route::get('/', function () {
  if (Auth::check()) {
    return redirect()->route('dashboard');
  } else {
    return redirect()->route('login');
  }
});

Auth::routes();

// All Admins Route List
Route::middleware(['auth', 'user-access:Admin'])->group(function () {
  Route::get('/reports', Reports::class . '@index')->name('reports');
  Route::get('/reports/export', Reports::class . '@export')->name('reports.export');

  Route::get('/settings', RegisterController::class . '@index')->name('settings');
  Route::put('/settings/{user}', RegisterController::class . '@update')->name('settings.update');
  Route::get('/settings/{user}/edit', RegisterController::class . '@edit')->name('settings.edit');
  Route::put('/settings/{user}', RegisterController::class . '@update')->name('settings.update');
  Route::delete('/settings/{user}', RegisterController::class . '@destroy')->name('settings.destroy');
});

// All Users Route List - Accessible to all user types
Route::middleware(['auth'])->group(function () {
  Route::get('/dashboard', Dashboard::class . '@index')->name('dashboard');

  /* Routes for Visitors */
  Route::get('/visitor-registration', VisitorController::class . '@index')->name('visitors.index');
  Route::post('/visitor-registration', VisitorController::class . '@store')->name('visitors.store');
  Route::get('/visitors-records/{visitor}/edit', VisitorController::class . '@edit')->name('visitors.edit');
  Route::match(['put', 'post'], '/visitors-records/{visitor}', VisitorController::class . '@update')->name('visitors.update');
  Route::match(['post', 'delete'], '/visitors-records/{visitor}', VisitorController::class . '@deleteVisitors')->name('visitors.delete');

  Route::get('/visitors-records', VisitorController::class . '@records')->name('visitors.records');
  Route::get('/visitors-records/search', VisitorController::class . '@search')->name('visitors.search');
  Route::get('/visitors-records/export', VisitorController::class . '@export')->name('visitors.export');

  /* Routes for Visit Logs */
  Route::get('/qrcode-scanner', VisitLogController::class . '@index')->name('visitlogs.index');
  Route::post('/visitlogs', VisitLogController::class . '@store')->name('visitlogs.store');

  Route::get('/visitlogs-records', VisitLogController::class . '@records')->name('visitlogs.records');
  Route::get('/visitlogs-records/search', VisitLogController::class .  '@search')->name('visitlogs.search');
  Route::get('/visitlogs-records/export', VisitLogController::class . '@export')->name('visitlogs.export');
});
