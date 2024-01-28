<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Dashboard;
use App\Http\Controllers\menu\QRCodeScanner;
use App\Http\Controllers\menu\VisitorRegistration;
use App\Http\Controllers\menu\VisitorsRecords;
use App\Http\Controllers\menu\VisitLogsRecords;
use App\Http\Controllers\menu\Reports;
use App\Http\Controllers\menu\Settings;

use App\Http\Controllers\VisitorController;
use App\Http\Controllers\VisitLogController;

Route::get('/', function () {
  return view('auth/login');
});

Auth::routes();

// All Admins Route List
Route::middleware(['auth', 'user-access:Admin'])->group(function () {
  Route::get('/reports', [Reports::class, 'index'])->name('reports');
  Route::get('/settings', [Settings::class, 'index'])->name('settings');
});

// All Users Route List - Accessible to all users
Route::middleware(['auth'])->group(function () {
  Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

  /* Routes for Visitors */
  // returns the page for visitor registration
  Route::get('/visitor-registration', VisitorController::class . '@index')->name('visitors.index');
  // adds a visitor to the database
  Route::post('/visitors', VisitorController::class . '@store')->name('visitors.store');
  // returns the form for editing a visitor
  Route::get('/visitors/{visitor}/edit', VisitorController::class . '@edit')->name('visitors.edit');
  // updates a visitor
  Route::put('/visitors/{visitor}', VisitorController::class . '@update')->name('visitors.update');
  // deletes a visitor
  Route::delete('/visitors/{visitor}', VisitorController::class . '@destroy')->name('visitors.destroy');
  //records for visitors
  Route::get('/visitors-records', [VisitorController::class, 'records'])->name('visitors.records');

  Route::get('/search', [VisitorController::class, 'search'])->name('visitors.search');
  Route::get('/export', [VisitorController::class, 'export'])->name('visitors.export');

  /* Routes for Visit Logs */
  // returns the page with the qr code scanner
  Route::get('/qrcode-scanner', VisitLogController::class . '@index')->name('visitlogs.index');
  // adds a visitlog to the database
  Route::post('/visitlogs', VisitLogController::class . '@store')->name('visitlogs.store');
  // all visit logs records
  Route::get('/visitlogs', [VisitLogsRecords::class, 'index'])->name('visit-logs-records');
});

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::get('/login', [LoginController::class, 'index'])->name('login');
