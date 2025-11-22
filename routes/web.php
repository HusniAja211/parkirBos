<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;


// Halaman Index
Route::get('/', function () {
    return view('parkir');
});

// ===============================
//  Group untuk admin
// ===============================
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    // Untuk ke page employeeList, bisa dianggap sebagai dashboard milik admin
    Route::get('/admin/employeeList', function () {
        return view('admin.employeeList');
    })->name('admin.employeeList');

    // Untuk ke page create admin
     Route::get('/admin/create', function () {
        return view('admin.createEmployee');
    })->name('admin.createEmployee');

    //Untuk ke page laporan pembayaran member
    Route::get('/admin/member', function () {
        return view('admin.memberReport');
    })->name('admin.memberReport');
    
    //Untuk ke page laporan pembayaran non member
    Route::get('/admin/nonmember', function () {
        return view('admin.nonMemberReport');
    })->name('admin.nonMemberReport');
});

// ===============================
//  Register petugas sebagai tapi harus login sebagai admin dulu
// ===============================
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::post('/admin/create-employee', [RegisteredUserController::class, 'storeAdmin'])
        ->name('admin.employee.store');
});

// ===============================
// 🧩Group untuk petugas
// ===============================
Route::middleware(['auth', 'verified', 'role:petugas'])->group(function () {
    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    })->name('petugas.dashboard');
});

// ===============================
//  Profile Routes
// ===============================
Route::middleware('auth')->group(function () {
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth (login, register, dsb)
require __DIR__.'/auth.php';
