<?php

namespace App\Listeners;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;

/**
 * Observer Pattern – Concrete Observer #1: UpdateSeatStatus
 *
 * Listener ini bereaksi ketika status transaksi berubah menjadi 'paid'.
 * Tugasnya: menandai semua kursi pada transaksi sebagai "terisi" (occupied)
 * dengan cara mengupdate is_occupied pada seat_reservations / seats.
 *
 * Dalam sistem nyata, ini memastikan kursi tidak bisa dipesan dua kali.
 */
class UpdateSeatStatus
{
    /**
     * Tangani event perubahan status transaksi.
     *
     * @param Transaction $transaction
     * @return void
     */
    public function handle(Transaction $transaction): void
    {
        // Load tiket beserta reservasi dan kursinya
        $transaction->loadMissing(['tickets.reservation.seat']);

        $seatNumbers = [];

        foreach ($transaction->tickets as $ticket) {
            if ($ticket->reservation && $ticket->reservation->seat) {
                $seat        = $ticket->reservation->seat;
                $seatNumbers[] = $seat->seat_number;

                // Update kolom is_occupied jika ada, atau catat via log (simulasi)
                // Jika kolom belum ada di schema, kita log sebagai simulasi
                if (in_array('is_occupied', \Schema::getColumnListing('seats'))) {
                    $seat->update(['is_occupied' => true]);
                }
            }
        }

        logger()->info(
            "[Observer: UpdateSeatStatus] Transaksi #{$transaction->transaction_code} – " .
            "Kursi ditandai terisi: " . implode(', ', $seatNumbers) . "."
        );
    }
}
