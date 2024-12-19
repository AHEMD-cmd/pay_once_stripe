<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\PaymentRedirectController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // dd(app('stripe')) ;
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::middleware(['auth', 'if.member'])->group(function () {

    Route::get('/payments', PaymentController::class);
    Route::post('/payments/redirect', PaymentRedirectController::class)->name('payments.redirect');
    
});

Route::middleware(['member'])->group(function () {

    Route::get('/members', MemberController::class);
    
});

Route::any('/stripe/webhook', StripeWebhookController::class);
