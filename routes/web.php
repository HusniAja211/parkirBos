<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MonthlyBillController;
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
        Route::resource('member', MonthlyBillController::class)->only(['index']);
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
        Route::resource('payment', PaymentController::class);

        // Scan tiket
        Route::get('/payment/scan', [PaymentController::class, 'scanOutForm'])->name('payment.scan');
        Route::post('/payment/scan', [PaymentController::class, 'processScan'])->name('payment.processScan');

        // Checkout
        Route::get('/checkout/{parking}', [PaymentController::class, 'checkOut'])->name('checkout.show');

        // Store payment
        Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store');

         // ======= Member Payment Bulanan =======
        Route::get('/member-payment', [PaymentController::class, 'scanMemberForm'])->name('memberPayment'); // form scan member
        Route::post('/member-payment', [PaymentController::class, 'processMemberScan'])->name('processMemberScan'); // proses scan ID member
        Route::post('/member-payment/pay', [PaymentController::class, 'payMember'])->name('payMember'); // proses bayar
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
