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
  Route::get('/register', [RegisterController::class, 'index'])->name('register');
});

// All Users Route List - Accessible to all users
Route::middleware(['auth'])->group(function () {
  Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');
  //Route::get('/qrcode-scanner', [QRCodeScanner::class, 'index'])->name('qrcode-scanner');
  //Route::get('/visitor-registration', [VisitorRegistration::class, 'index'])->name('visitor-registration');
  //Route::post('/visitor-registration', [VisitorRegistration::class, 'store'])->name('visitor-registration');
  //Route::get('/visitors', [VisitorsRecords::class, 'index'])->name('visitors-records');
  //Route::get('/visitlogs', [VisitLogsRecords::class, 'index'])->name('visit-logs-records');

  Route::get('/login', [LoginController::class, 'index'])->name('login');
  Route::get('/register', [RegisterController::class, 'index'])->name('register');

  // returns the home page with all visitors
  Route::get('/visitor-registration', VisitorController::class . '@index')->name('visitors.index');
  // adds a visitor to the database
  Route::post('/visitors', VisitorController::class . '@store')->name('visitors.store');
  // returns a page that shows a full visitors
  Route::get('/visitors/{visitor}', VisitorController::class . '@show')->name('visitors.show');
  // returns the form for editing a visitor
  Route::get('/visitors/{visitor}/edit', VisitorController::class . '@edit')->name('visitors.edit');
  // updates a visitor
  Route::put('/visitors/{visitor}', VisitorController::class . '@update')->name('visitors.update');
  // deletes a visitor
  Route::delete('/visitors/{visitor}', VisitorController::class . '@destroy')->name('visitors.destroy');

  // returns the home page with the qr code scanner
  Route::get('/qrcode-scanner', VisitLogController::class . '@index')->name('visitlogs.index');
  // adds a visitlog to the database
  Route::post('/visitlogs', VisitLogController::class . '@store')->name('visitlogs.store');
  // returns a page that shows a full visitlogs
  Route::get('/visitlogs/{visitlog}', VisitLogController::class . '@show')->name('visitlogs.show');
  // returns the form for editing a visitlog
  Route::get('/visitlogs/{visitlog}/edit', VisitLogController::class . '@edit')->name('visitlogs.edit');
  // updates a visitlog
  Route::put('/visitlogs/{visitlog}', VisitLogController::class . '@update')->name('visitlogs.update');
});