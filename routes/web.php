<?php

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

Route::get('admin/dashboard', App\Http\Controllers\Admin\DashboardController::class)->name('admin.dashboard');

Route::get('admin/users', App\Http\Livewire\Admin\Users\ListUsers::class)->name('admin.users');
