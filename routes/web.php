<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\ReservasiController;
use App\Http\Controllers\RuanganController as ControllersRuanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// User Route
Route::middleware(['auth', 'userMiddleware'])->group(function() {
  
    Route::get('dashboard',[UserController::class, 'index'])->name('dashboard');

});

// Admin Route
// Route::middleware(['auth', 'adminMiddleware'])->group(function() {
  
//     Route::get('/admin/dashboard',[AdminController::class, 'index'])->name('admin.dashboard');
//     Route::get('/admin/ruangan',[RuanganController::class, 'index'])->name('admin.ruangan.index');

// });

Route::prefix('admin')->middleware(['auth', 'adminMiddleware'])->group(function() {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('ruangan', RuanganController::class)->middleware(['auth']);
    Route::resource('reservasi', ReservasiController::class)->middleware(['auth']);
});