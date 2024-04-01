<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\dashboard\Dashboard;
use App\Http\Controllers\menu\Reports;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\VisitLogController;

// Redirect '/' to the appropriate route based on authentication status
Route::get('/', function () {
  if (Auth::check()) {
    return redirect()->route('dashboard');
  } else {
    return redirect()->route('pre-register');
  }
});

// Authentication Routes
Auth::routes();

// All Admins Route List
Route::middleware(['auth', 'user-access:Admin'])->group(function () {
  Route::get('/reports', Reports::class . '@index')->name('reports');
  Route::get('/reports/export', Reports::class . '@export')->name('reports.export');

  Route::get('/settings', RegisterController::class . '@index')->name('settings');
  Route::post('/settings', RegisterController::class . '@register')->name('settings.register');
  Route::put('/settings/{user}', RegisterController::class . '@update')->name('settings.update');
  Route::delete('/settings/{user}', RegisterController::class . '@destroy')->name('settings.destroy');
});

// All Users Route List - Accessible to all user types
Route::middleware(['auth'])->group(function () {
  Route::get('/dashboard', Dashboard::class . '@index')->name('dashboard');

  //Routes for Pre-registered Visitors
  Route::get('records/pre-registered', VisitorController::class . '@preRegisteredList')->name('visitors.preRegisteredList');
  Route::match(['post', 'delete'], '/pre-registered/{visitor}', VisitorController::class . '@acceptVisitors')->name('visitors.accept');
  Route::delete('/pre-registered/decline/{visitor}', VisitorController::class . '@declineVisitors')->name('visitors.decline');
  Route::get('/pre-registered/export', VisitorController::class . '@preRegVisitorsExport')->name('preregvisitors.export');

  // Routes for Visitors
  Route::get('/register', VisitorController::class . '@index')->name('visitors.index');
  Route::post('/register', VisitorController::class . '@store')->name('visitors.store');
  Route::get('/visitors-records/{visitor}/edit', VisitorController::class . '@edit')->name('visitors.edit');
  Route::match(['put', 'post'], '/visitors-records/{visitor}', VisitorController::class . '@update')->name('visitors.update');
  Route::match(['post', 'delete'], '/visitors-records/{visitor}', VisitorController::class . '@blockVisitors')->name('visitors.block');

  Route::get('/records/visitors', VisitorController::class . '@records')->name('visitors.records');
  Route::get('/visitors-records/search', VisitorController::class . '@search')->name('visitors.search');
  Route::get('/visitors-records/export', VisitorController::class . '@visitorsExport')->name('visitors.export');

  // Routes for Visit Logs
  Route::get('/qrcode-scanner', VisitLogController::class . '@index')->name('visitlogs.index');
  Route::post('/visitlogs', VisitLogController::class . '@store')->name('visitlogs.store');

  Route::get('records/visitlogs', VisitLogController::class . '@records')->name('visitlogs.records');
  Route::get('/visitlogs-records/search', VisitLogController::class .  '@search')->name('visitlogs.search');
  Route::get('/visitlogs-records/export', VisitLogController::class . '@export')->name('visitlogs.export');

  // Route for Blocked Visitors
  Route::get('records/blocked-visitors', VisitorController::class . '@blockedList')->name('visitors.blocked');
  Route::match(['post', 'delete'], '/blocked-visitors/{visitor}', VisitorController::class . '@unblockVisitors')->name('visitors.unblock');
  Route::get('/blocked-visitors/export', VisitorController::class . '@blockedVisitorsExport')->name('blockedvisitors.export');
});

Route::get('/pre-register', VisitorController::class . '@preRegisterPage')->name('pre-register');
Route::post('/pre-register', VisitorController::class . '@preRegister')->name('visitors.pre-register');
Route::get('/inquiry', VisitorController::class . '@inquiryPage')->name('inquiry');
Route::post('/inquiry', VisitorController::class . '@inquiry')->name('post.inquiry');
