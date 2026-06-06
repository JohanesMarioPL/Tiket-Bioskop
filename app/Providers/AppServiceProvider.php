<?php

namespace App\Providers;

use App\Models\Transaction;
use App\Observers\TransactionObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * Di sinilah TransactionObserver didaftarkan ke model Transaction.
     * Laravel akan secara otomatis memanggil method yang sesuai pada observer
     * setiap kali model Transaction mengalami event (created, updated, deleted, dll).
     */
    public function boot(): void
    {
        // Observer Pattern – Registrasi Observer
        // Transaction::observe() mendaftarkan TransactionObserver sebagai
        // "subscriber" yang mengamati semua perubahan pada model Transaction.
        Transaction::observe(TransactionObserver::class);
    }
}
