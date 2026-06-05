<?php

namespace App\Listeners;

use App\Models\Transaction;
use Carbon\Carbon;

/**
 * Observer Pattern – Concrete Observer #2: LogTransactionHistory
 *
 * Listener ini bereaksi ketika status transaksi berubah menjadi 'paid'.
 * Tugasnya: mencatat riwayat transaksi ke log sistem agar dapat
 * diaudit kapanpun. Dalam sistem produksi, ini bisa berupa pencatatan
 * ke tabel audit_logs atau integrasi dengan sistem monitoring.
 */
class LogTransactionHistory
{
    /**
     * Tangani event perubahan status transaksi.
     *
     * @param Transaction $transaction
     * @return void
     */
    public function handle(Transaction $transaction): void
    {
        $transaction->loadMissing(['payment', 'tickets.schedule.movie', 'user']);

        $movie    = $transaction->tickets->first()?->schedule?->movie?->title ?? 'Unknown';
        $method   = $transaction->payment?->payment_method ?? 'Unknown';
        $userName = $transaction->user?->name ?? 'Guest';
        $total    = number_format($transaction->total_amount, 0, ',', '.');

        logger()->info(
            "[Observer: LogTransactionHistory] RIWAYAT TRANSAKSI BARU – " .
            "Kode: {$transaction->transaction_code} | " .
            "User: {$userName} | " .
            "Film: {$movie} | " .
            "Metode: {$method} | " .
            "Total: Rp {$total} | " .
            "Waktu: " . Carbon::now()->translatedFormat('d F Y, H:i:s') . " WIB."
        );
    }
}
