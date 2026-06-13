<?php

use App\Http\Controllers\LandingPageController;
// use App\Http\Controllers\LocationController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Analytics\AnalyticsController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\Admin\Management\MoviesController;
use App\Http\Controllers\Admin\Management\ReviewsController;
use App\Http\Controllers\Admin\Management\ScheduleController;
use App\Http\Controllers\Admin\Management\LocationController;
use App\Http\Controllers\Admin\Management\SeatsController;
use App\Http\Controllers\Admin\Management\StudioController;
use App\Http\Controllers\Admin\Management\TicketController;
use App\Http\Controllers\Admin\UserManagement\UserController;
use App\Http\Controllers\Admin\Management\TransactionController as AdminTransactionController;
use App\Http\Controllers\User\ReviewController;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/cinemas', [CinemaController::class, 'index'])->name('cinemas.index');
Route::get('/cinemas/{id}', [CinemaController::class, 'show'])->name('cinemas.show');
Route::get('/booking/{schedule}', [App\Http\Controllers\BookingController::class, 'show'])->name('booking.show');
Route::get('/checkout/{schedule}', [App\Http\Controllers\CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/{schedule}', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{transaction}', [App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/{transaction}', [App\Http\Controllers\PaymentController::class, 'simulate'])->name('payment.simulate');
Route::get('/ticket/{transaction}', [App\Http\Controllers\TicketController::class, 'show'])->name('ticket.show');

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') {
        return redirect()->route('admin.analytics.index');
    }
    return redirect()->route('landing');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/transactions', [TransactionController::class, 'history'])->name('transactions.history');
});

Route::get('/my-reviews', [ReviewController::class, 'index'])->name('user.reviews.index');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::prefix('admin-dashboard')->name('admin.')->group(function () {
    Route::get('/', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/export', [AnalyticsController::class, 'exportPDF'])->name('analytics.export');

    Route::prefix('movies')->name('movies.')->group(function () {
        Route::get('/', [MoviesController::class, 'index'])->name('index');
        Route::get('/create', [MoviesController::class, 'create'])->name('create');
        Route::post('/', [MoviesController::class, 'store'])->name('store');
        Route::get('/{movie}', [MoviesController::class, 'show'])->name('show');
        Route::get('/{movie}/edit', [MoviesController::class, 'edit'])->name('edit');
        Route::put('/{movie}', [MoviesController::class, 'update'])->name('update');
        Route::delete('/{movie}', [MoviesController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewsController::class, 'index'])->name('index');
        Route::delete('/{review}', [ReviewsController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('locations')->name('locations.')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('index');
        Route::get('/create', [LocationController::class, 'create'])->name('create');
        Route::post('/', [LocationController::class, 'store'])->name('store');
        Route::get('/{location}', [LocationController::class, 'show'])->name('show');
        Route::get('/{location}/edit', [LocationController::class, 'edit'])->name('edit');
        Route::put('/{location}', [LocationController::class, 'update'])->name('update');
        Route::delete('/{location}', [LocationController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('studio')->name('studio.')->group(function () {
        Route::get('/', [StudioController::class, 'index'])->name('index');
        Route::get('/create', [StudioController::class, 'create'])->name('create');
        Route::post('/', [StudioController::class, 'store'])->name('store');
        Route::get('/{studio}', [StudioController::class, 'show'])->name('show');
        Route::get('/{studio}/edit', [StudioController::class, 'edit'])->name('edit');
        Route::put('/{studio}', [StudioController::class, 'update'])->name('update');
        Route::delete('/{studio}', [StudioController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('showtimes')->name('showtimes.')->group(function () {
        Route::get('/', [ScheduleController::class, 'index'])->name('index');
        Route::get('/create', [ScheduleController::class, 'create'])->name('create');
        Route::post('/', [ScheduleController::class, 'store'])->name('store');
        Route::get('/{schedule}', [ScheduleController::class, 'show'])->name('show');
        Route::get('/{schedule}/edit', [ScheduleController::class, 'edit'])->name('edit');
        Route::put('/{schedule}', [ScheduleController::class, 'update'])->name('update');
        Route::delete('/{schedule}', [ScheduleController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [AdminTransactionController::class, 'index'])->name('index');
        Route::get('/{transaction}', [AdminTransactionController::class, 'show'])->name('show');
        Route::post('/{transaction}', [AdminTransactionController::class, 'update'])->name('update');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

});

require __DIR__.'/auth.php';
