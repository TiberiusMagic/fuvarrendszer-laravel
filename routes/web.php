<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DriverController;
//use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    $user = request()->user();

    if (! $user) {
        return redirect()->route('home');
    }

    if ($user->role === 'Admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('driver.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin felület
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/jobs/create', [AdminController::class, 'createJob'])->name('admin.jobs.create');
    Route::post('/admin/jobs', [AdminController::class, 'storeJob'])->name('admin.job.store');
    Route::post('/admin/jobs/{job}/assign', [AdminController::class, 'assignDriver'])
     ->name('admin.jobs.assign')->middleware(['auth', 'role:Admin']);
    Route::get('/jobs/{job}/edit', [AdminController::class, 'editJob'])->name('admin.job.edit');
    Route::put('/jobs/{job}', [AdminController::class, 'updateJob'])->name('admin.job.update');
    Route::delete('/jobs/{job}', [AdminController::class, 'destroyJob'])->name('admin.job.destroy');
});

// Fuvarozó felület
Route::middleware(['auth', 'role:Driver'])->group(function () {
    Route::get('/driver/dashboard', [DriverController::class, 'index'])->name('driver.dashboard');
    Route::post('/driver/jobs/{job}/status', [DriverController::class, 'updateStatus'])->name('driver.jobs.updateStatus');
    Route::post('/driver/jobs/{job}/status', [DriverController::class, 'updateStatus'])
     ->name('driver.jobs.updateStatus')->middleware(['auth', 'role:Driver']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
