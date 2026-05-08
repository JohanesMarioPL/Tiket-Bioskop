<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Location Routes
Route::prefix('locations')->group(function () {
    Route::get('/', [LocationController::class, 'index'])->name('locations.index');
    Route::get('/search', [LocationController::class, 'search'])->name('locations.search');
    Route::get('/city/{city}', [LocationController::class, 'getByCity'])->name('locations.city');
    Route::get('/{location}', [LocationController::class, 'show'])->name('locations.show');
});

Route::get('/location/{id}/schedules', function ($id) {
    return view('locations.schedules', ['locationId' => $id]);
})->name('location.schedules');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
