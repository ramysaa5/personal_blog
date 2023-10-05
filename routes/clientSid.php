<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth', 'is_admin:user')->prefix('clientpanel/')->name('clientpanel.')->group(function () {


    Route::get('/', [ClientController::class, 'dashboard']);
    Route::get('dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
    Route::get('index', [ClientController::class, 'index'])->name('index');
    Route::view('about', 'client.about')->name('about');
    Route::get('show/{id}', [ClientController::class, 'show'])->name('show');
});
