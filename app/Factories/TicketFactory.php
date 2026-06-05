<?php

namespace App\Factories;

use App\Models\Schedule;
use App\Models\Transaction;
use App\Models\Seat;
use App\Models\Ticket;
use App\Models\Reservation;

/**
 * Factory Pattern – TicketFactory
 *
 * Factory ini bertanggung jawab untuk membuat objek Ticket
 * yang sesuai berdasarkan rating film. Controller tidak perlu
 * tahu jenis tiket apa yang akan dibuat – cukup memanggil
 * TicketFactory::createForSeat() dan factory yang memutuskan.
 *
 * Keuntungan: penambahan jenis tiket baru (misalnya "Senior",
 * "Pelajar") cukup diubah di sini tanpa menyentuh controller.
 *
 * Jenis tiket berdasarkan rating_age film:
 * - SU / G     → "Umum"      (semua umur)
 * - 13+        → "Remaja"    (13 tahun ke atas)
 * - 17+ / R    → "Dewasa"    (17 tahun ke atas)
 * - 21+        → "Dewasa 21" (21 tahun ke atas, konten khusus)
 * - default    → "Regular"
 */
class TicketFactory
{
    /**
     * Tentukan ticket_type berdasarkan rating usia film.
     *
     * @param string|null $ratingAge Rating usia dari model Movie (rating_age)
     * @return string                Tipe tiket yang sesuai
     */
    public static function resolveTicketType(?string $ratingAge): string
    {
        $rating = strtolower(trim($ratingAge ?? ''));

        return match (true) {
            in_array($rating, ['su', 'g', 'semua umur']) => 'Umum',
            in_array($rating, ['13+', '13'])             => 'Remaja',
            in_array($rating, ['17+', '17', 'r'])        => 'Dewasa',
            in_array($rating, ['21+', '21'])             => 'Dewasa 21+',
            default                                      => 'Regular',
        };
    }

    /**
     * Buat sebuah Ticket beserta Reservation-nya untuk satu kursi.
     *
     * Controller hanya memanggil method ini – tidak perlu tahu
     * logika penentuan ticket_type sama sekali.
     *
     * @param Transaction $transaction Transaksi induk
     * @param Schedule    $schedule    Jadwal tayang (sudah load movie)
     * @param Seat        $seat        Kursi yang dipilih
     * @param int         $finalPrice  Harga akhir per tiket (dari Decorator)
     * @return Ticket                  Tiket yang berhasil dibuat
     */
    public static function createForSeat(
        Transaction $transaction,
        Schedule $schedule,
        Seat $seat,
        int $finalPrice
    ): Ticket {
        // Factory memutuskan ticket_type berdasarkan rating film
        $ratingAge  = $schedule->movie->rating_age ?? null;
        $ticketType = self::resolveTicketType($ratingAge);

        logger()->info("[TicketFactory] Membuat tiket tipe '{$ticketType}' " .
                       "untuk kursi {$seat->seat_number} (Rating film: {$ratingAge}).");

        // Buat tiket
        $ticket = Ticket::create([
            'transaction_id' => $transaction->id,
            'schedule_id'    => $schedule->id,
            'ticket_type'    => $ticketType,
            'final_price'    => $finalPrice,
        ]);

        // Buat reservasi kursi
        Reservation::create([
            'ticket_id' => $ticket->id,
            'seat_id'   => $seat->id,
        ]);

        return $ticket;
    }

    /**
     * Buat beberapa tiket sekaligus untuk koleksi kursi.
     *
     * @param Transaction          $transaction
     * @param Schedule             $schedule
     * @param \Illuminate\Support\Collection $seats
     * @param int                  $pricePerTicket Harga per tiket (dari Decorator)
     * @return \Illuminate\Support\Collection      Koleksi Ticket yang dibuat
     */
    public static function createForSeats(
        Transaction $transaction,
        Schedule $schedule,
        \Illuminate\Support\Collection $seats,
        int $pricePerTicket
    ): \Illuminate\Support\Collection {
        return $seats->map(function (Seat $seat) use ($transaction, $schedule, $pricePerTicket) {
            return self::createForSeat($transaction, $schedule, $seat, $pricePerTicket);
        });
    }
}
