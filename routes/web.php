<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\InternetController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    # Dashboard
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

    # Internet
    Route::get('/internet', [InternetController::class, 'index'])->name('internet.index');
    Route::get('/internet/{ip}', [InternetController::class, 'show'])->where('ip', '[0-9\.]+')->name('internet.show');
});
require __DIR__.'/auth.php';
