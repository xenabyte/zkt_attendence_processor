<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('staff.auth.login');
});

Route::group(['prefix' => 'admin'], function () {
  Route::get('/', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
  Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
  Route::post('/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');

  // Route::get('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
  // Route::post('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'register']);

  Route::post('/password/email', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.request');
  Route::post('/password/reset', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'reset'])->name('password.email');
  Route::get('/password/reset', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.reset');
  Route::get('/password/reset/{token}', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'showResetForm']);

  Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index']);
  Route::get('/staffs', [App\Http\Controllers\Admin\HomeController::class, 'staffs']);
  Route::post('/uploadAttendance', [App\Http\Controllers\Admin\HomeController::class, 'uploadAttendance'])->name('uploadAttendance');
  Route::get('/pastAttendance/{staffId}', [App\Http\Controllers\Admin\HomeController::class, 'pastAttendance']);
  Route::post('/pastAttendanceRecords', [App\Http\Controllers\Admin\HomeController::class, 'pastAttendanceRecords']);
  Route::post('/pastGeneralAttendanceRecords', [App\Http\Controllers\Admin\HomeController::class, 'pastGeneralAttendanceRecords']);
  Route::get('/monthlyAttendance/{staffId}', [App\Http\Controllers\Admin\HomeController::class, 'monthlyAttendance']);
  Route::get('/updateAttendance/{staffId}', [App\Http\Controllers\Admin\HomeController::class, 'updateAttendance']);

  Route::get('/leaveApplication', [App\Http\Controllers\Admin\HomeController::class, 'leaveApplication']);
  Route::post('/manageLeaveApplication', [App\Http\Controllers\Admin\HomeController::class, 'manageLeaveApplication']);

  Route::get('/holiday', [App\Http\Controllers\Admin\HomeController::class, 'holiday']);
  Route::post('/addHoliday', [App\Http\Controllers\Admin\HomeController::class, 'addHoliday']);
  Route::post('/deleteHoliday', [App\Http\Controllers\Admin\HomeController::class, 'deleteHoliday']);

  

});

Route::group(['prefix' => 'staff'], function () {
  Route::get('/', [App\Http\Controllers\Staff\Auth\LoginController::class, 'showLoginForm'])->name('login');
  Route::get('/login', [App\Http\Controllers\Staff\Auth\LoginController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [App\Http\Controllers\Staff\Auth\LoginController::class, 'login']);
  Route::post('/logout', [App\Http\Controllers\Staff\Auth\LoginController::class, 'logout'])->name('logout');

  Route::post('/completeRegistration', [App\Http\Controllers\HomeController::class, 'completeRegistration']);
  // Route::post('/register', [App\Http\Controllers\Staff\Auth\RegisterController::class, 'register']);

  Route::post('/password/email', [App\Http\Controllers\Staff\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.request');
  Route::post('/password/reset', [App\Http\Controllers\Staff\Auth\ResetPasswordController::class, 'reset'])->name('password.email');
  Route::get('/password/reset', [App\Http\Controllers\Staff\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.reset');
  Route::get('/password/reset/{token}', [App\Http\Controllers\Staff\Auth\ResetPasswordController::class, 'showResetForm']);

  Route::get('/home', [App\Http\Controllers\Staff\HomeController::class, 'index']);
  Route::get('/attendance', [App\Http\Controllers\Staff\HomeController::class, 'Attendance']);
  Route::get('/leaveDays', [App\Http\Controllers\Staff\HomeController::class, 'leaveDays']);
  Route::post('/applyLeaveDays', [App\Http\Controllers\Staff\HomeController::class, 'applyLeaveDays']);
  Route::post('/deleteLeave', [App\Http\Controllers\Staff\HomeController::class, 'deleteLeave']);

});
