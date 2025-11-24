<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NonMemberController;
use App\Http\Controllers\UserController;

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
        Route::resource('member', MemberController::class)->only(['index']);
        Route::resource('nonmember', NonMemberController::class)->only(['index']);

        // Register petugas tapi harus login sebagai admin dulu
        Route::post('/create-employee', [RegisteredUserController::class, 'storeAdmin'])
            ->name('employee.store');
    });

// ===============================
// Group untuk petugas
// ===============================
Route::middleware(['auth', 'verified', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', [UserController::class, 'indexPetugas'])->name('dashboard');
        Route::get('/dashboard/create', [UserController::class, 'createPetugas'])->name('dashboard.create');
        Route::post('/dashboard', [UserController::class, 'storePetugas'])->name('dashboard.store');
        Route::get('/dashboard/{user}/edit', [UserController::class, 'editPetugas'])->name('dashboard.edit');
        Route::put('/dashboard/{user}', [UserController::class, 'updatePetugas'])->name('dashboard.update');
        Route::delete('/dashboard/{user}', [UserController::class, 'destroyPetugas'])->name('dashboard.destroy');
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
