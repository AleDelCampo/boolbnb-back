<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\Api\AutocompleteController;
use App\Http\Controllers\LeadController;
use App\Models\Apartment;
use Illuminate\Support\Facades\Route;
use Psy\Readline\Hoa\Autocompleter;

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

Route::get('/errors.404', function () {
    return view('errors.404');
})->middleware(['auth', 'verified'])->name('errors.404');

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(
        function () {
            // qui ci metto tutte le rotte che voglio che siano:
            // raggruppate sotto lo stesso middelware
            // i loro nomi inizino tutti con "admin.
            // tutti i loro url inizino con "admin/"

            // Route::get('/', [DashboardController::class, 'index'])->name('index');

            // Route::get('/users', [DashboardController::class, 'users'])->name('users');

            //rotta per chiamata API

            // rotte di risorsa per gli appartamenti
            Route::group(['middleware' => 'validated'], function () {
                Route::resource('apartments', ApartmentController::class)->parameters(['apartments' => 'apartment:slug']);
                // Route::get('user/{id}', function () {
                //     //Only user with id 1 can see profile of user with id 1
                // });
            });
            // ;
            // Route::group(['middleware' => 'validated'], function () {
            //     Route::resource('leads', LeadController::class);
            //      return view('emails.new-contact');
            // });
        }
    );

     Route::get('/leads', [LeadController::class, 'index'])->middleware(['auth', 'verified'])->name('leads.index');

    // Route::group(['middleware' => 'validated'], function () {
    //   Route::resource('leads', LeadController::class);
    //     return view('leads.index');
    // });