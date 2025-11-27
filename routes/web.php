<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NonMemberController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ParkingController;

// Halaman Index
Route::get('/', function () {
    return view('parkir');
});

// ===============================
// Group untuk admin
// ===============================
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Resource employeeList (index, create, store, show, edit, update, destroy)
        Route::resource('employeeList', UserController::class);

        // page laporan pembayaran member
        Route::resource('member', PaymentController::class)->only(['index']);
        Route::resource('nonmember', NonMemberController::class)->only(['index']);

        // Register petugas tapi harus login sebagai admin dulu
        Route::post('/create-employee', [RegisteredUserController::class, 'storeAdmin'])
            ->name('employee.store');
    });

// ===============================
// Group untuk petugas
// ===============================
Route::middleware(['auth', 'verified'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {
        Route::resource('dashboard', UserController::class);
        Route::resource('member', MemberController::class);
        Route::resource('parking', ParkingController::class);

    });

// ===============================
// Profile Routes
// ===============================
Route::middleware('auth')->group(function () {
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth (login, register, dsb)
require __DIR__.'/auth.php';
