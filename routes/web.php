<?php

use App\Http\Controllers\HardwarePartsController;
use App\Http\Controllers\NetworkLogfileController;
use App\Http\Controllers\ServerSoftwaresController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\InternetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProcessController;
use App\Http\Controllers\UsersExternalStorageController;
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

    # Task Manager
    Route::get('/tasks', [UserProcessController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/cpu', [UserProcessController::class, 'cpu_index'])->name('tasks.cpu');
    Route::get('/tasks/network', [UserProcessController::class, 'network_index'])->name('tasks.network');
    Route::get('/tasks/running', [UserProcessController::class, 'running_index'])->name('tasks.running');

    # Task Actions
    Route::get('/tasks/status', [UserProcessController::class, 'status'])->name('tasks.status');
    Route::post('/tasks/{process}/finalize', [UserProcessController::class, 'finalize'])->name('tasks.finalize');
    Route::post('/tasks/{process}/cancel', [UserProcessController::class, 'cancel'])->name('tasks.cancel');
    Route::post('/tasks/{task}/uninstall', [UserProcessController::class, 'uninstall'])->name('tasks.uninstall');
    Route::post('/tasks/{software}/install', [UserProcessController::class, 'install'])->name('tasks.install');

    # User Software
    Route::get('/software', [ServerSoftwaresController::class, 'index'])->name('software.index');
    Route::post('/software/{software}/delete', [ServerSoftwaresController::class, 'destroy'])->name('software.destroy');

    Route::get('/software/external', [UsersExternalStorageController::class, 'index'])->name('software.external');
    Route::post('/software/external/{software}/copy', [UsersExternalStorageController::class, 'copy'])->name('software.external.copy');
    Route::post('/software/external/{software}/backup', [UsersExternalStorageController::class, 'backup'])->name('software.external.backup');
    Route::post('/software/external/{software}/destroy', [UsersExternalStorageController::class, 'destroy'])->name('software.external.destroy');

    # Get info for the software
    Route::get('/software/{software}/json', [ServerSoftwaresController::class, 'json'])->name('internet.software.json');

    # Internet
    Route::get('/internet', [InternetController::class, 'index'])->name('internet.index');
    Route::get('/internet/{ip}', [InternetController::class, 'show'])->where('ip', '[0-9\.]+')->name('internet.show');

    Route::get('/internet/{ip}/login', [InternetController::class, 'loginShow'])->name('internet.loginShow');
    Route::post('/internet/{ip}/login', [InternetController::class, 'login'])->where('ip', '[0-9\.]+')->name('internet.login');

    Route::get('/internet/{ip}/hack', [InternetController::class, 'hackShow'])->name('internet.hackShow');

    # Target Bruteforce
    Route::post('/internet/{ip}/attack/bruteforce', [InternetController::class, 'bruteforce'])->name('internet.attack.bruteforce');

    # Download and Upload from the target server
    Route::post('/internet/target/software/{software}/download', [UserProcessController::class, 'startDownload'])->name('target.software.download');
    Route::post('/internet/target/software/upload', [UserProcessController::class, 'startUpload'])->name('target.software.upload');

    # Display victim logs/software.
    Route::get('/internet/target', [TargetController::class, 'index'])->name('target.index');
    Route::get('/internet/target/logs', [NetworkLogfileController::class, 'show'])->name('target.logs');
    Route::get('/internet/target/software', [TargetController::class, 'software'])->name('target.software');

    # Save logs to the database this should be reworked
    Route::post('/networks/{networkId}/logs', [NetworkLogfileController::class, 'save'])->middleware('throttle:10,1')->name('target.logs.save');
    Route::get('/networks/{networkId}/log-save-status', [NetworkLogfileController::class, 'logSaveStatus']);
    Route::get('/networks/{networkId}/logs/content', [NetworkLogfileController::class, 'content']);
    Route::post('/networks/{networkId}/log-save/finalize', [NetworkLogfileController::class, 'finalizeLogSave']);

    # Target logout
    Route::get('/internet/target/logout', [TargetController::class, 'logout'])->name('target.logout');

    # Log file
    Route::get('/logs', [UserController::class, 'logs_index'])->name('user.logs');
    Route::post('/logs/save', [UserController::class, 'logs_save'])->name('user.logs.save');

    # Hardware
    Route::get('/hardware', [HardwarePartsController::class, 'index'])->name('user.hardware');
    Route::get('/hardware/server/{server}', [HardwarePartsController::class, 'server'])->name('user.hardware.server');

});
require __DIR__.'/auth.php';
