<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\SponsorshipController;
use App\Http\Controllers\PaymentController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::resource('apartments', ApartmentController::class)->parameters(['apartments' => 'apartment:slug']);

        // Definisci le rotte per le sponsorizzazioni
        Route::get('sponsorship/create/{apartment:slug}', [SponsorshipController::class, 'create'])->name('sponsor.create');
        Route::post('sponsorship/store/{apartment:slug}', [SponsorshipController::class, 'store'])->name('sponsor.store');
        Route::get('sponsorship/show/{apartment:slug}', [SponsorshipController::class, 'show'])->name('sponsor.show');
    });

        Route::middleware(['auth', 'verified'])->group(function () {
            Route::get('payment/form', [PaymentController::class, 'show'])->name('payment.form');
            Route::post('payment/process', [PaymentController::class, 'process'])->name('payment.process');
            Route::get('payment/success', [PaymentController::class, 'success'])->name('payment.success');
            Route::get('/payment/show', [PaymentController::class, 'show'])->name('payment.show');

});



