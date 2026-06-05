<?php

namespace App\Listeners;

use App\Models\Transaction;
use Carbon\Carbon;

/**
 * Observer Pattern – Concrete Observer #3: SendTicketNotification
 *
 * Listener ini bereaksi ketika status transaksi berubah menjadi 'paid'.
 * Tugasnya: mengirimkan notifikasi bahwa E-Ticket siap kepada pengguna.
 * Dalam sistem produksi ini akan men-trigger pengiriman email via
 * Mail::to($user)->send(new ETicketMail($transaction)).
 * Untuk keperluan simulasi, notifikasi dicatat ke log sistem.
 */
class SendTicketNotification
{
    /**
     * Tangani event perubahan status transaksi.
     *
     * @param Transaction $transaction
     * @return void
     */
    public function handle(Transaction $transaction): void
    {
        $transaction->loadMissing(['user', 'tickets.schedule.movie']);

        $userEmail = $transaction->user?->email ?? 'guest@example.com';
        $userName  = $transaction->user?->name  ?? 'Pelanggan';
        $movie     = $transaction->tickets->first()?->schedule?->movie?->title ?? 'Film';
        $ticketUrl = url('/ticket/' . $transaction->id);

        // Simulasi pengiriman email (dalam produksi: Mail::to($userEmail)->send(...))
        logger()->info(
            "[Observer: SendTicketNotification] 📧 E-Ticket SIAP – " .
            "Notifikasi dikirim ke: {$userEmail} ({$userName}). " .
            "Film: {$movie}. " .
            "Kode Transaksi: {$transaction->transaction_code}. " .
            "Link E-Ticket: {$ticketUrl}. " .
            "Waktu notifikasi: " . Carbon::now()->toDateTimeString() . "."
        );
    }
}
