<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Livewire\Admin\Appointment\CreateAppointmentForm;
use App\Http\Livewire\Admin\Appointments\ListAppointments;
use App\Http\Livewire\Admin\Appointments\UpdateAppointmentForm;
use App\Http\Livewire\Admin\Profile\UpdateProfile;
use App\Http\Livewire\Admin\Users\ListUsers;
use App\Http\Livewire\Analytics;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->as('admin.')->middleware(['auth'])->group( function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('users', ListUsers::class)->name('users');

    Route::get('appointments', ListAppointments::class)->name('appointments');

    Route::get('appointments/create', CreateAppointmentForm::class)->name('appointments.create');

    Route::get('appointments/{appointment}/edit', UpdateAppointmentForm::class)->name('appointments.edit');

    Route::get('profile', UpdateProfile::class)->name('profile.edit');

    Route::get('analytics', Analytics::class)->name('analytics');
});
