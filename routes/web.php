<?php

use App\Http\Controllers\NetworkLogfileController;
use App\Http\Controllers\ServerSoftwaresController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\InternetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProcessController;
use App\Models\ServerSoftwares;
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

    Route::get('/internet/{ip}/login', [InternetController::class, 'loginShow'])->name('internet.loginShow');
    Route::post('/internet/{ip}/login', [InternetController::class, 'login'])->where('ip', '[0-9\.]+')->name('internet.login');

    Route::get('/internet/{ip}/hack', [InternetController::class, 'hackShow'])->name('internet.hackShow');

    Route::get('/internet/target', [TargetController::class, 'index'])->name('target.index');
    Route::get('/internet/target/software', [TargetController::class, 'software'])->name('target.software');

    # Download and Upload from the target server
    Route::post('/internet/target/software/{software}/download', [UserProcessController::class, 'startDownload'])->name('target.software.download');
    Route::post('/internet/target/software/upload', [UserProcessController::class, 'startUpload'])->name('target.software.upload');

    # Save and read logs from the target server
    Route::get('/internet/target/logs', [NetworkLogfileController::class, 'show'])->name('target.logs');
    Route::post('/networks/{networkId}/logs', [NetworkLogfileController::class, 'save'])->middleware('throttle:10,1')->name('target.logs.save');

    # Target logout
    Route::get('/internet/target/logout', [TargetController::class, 'logout'])->name('target.logout');

    # Get info for the software
    Route::get('/internet/software/{software}/json', [ServerSoftwaresController::class, 'json'])->name('internet.software.json');

});
require __DIR__.'/auth.php';
