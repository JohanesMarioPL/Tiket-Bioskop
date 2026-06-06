<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Listeners\UpdateSeatStatus;
use App\Listeners\LogTransactionHistory;
use App\Listeners\SendTicketNotification;

/**
 * Observer Pattern – Subject Observer (Eloquent Observer)
 *
 * TransactionObserver "mengamati" model Transaction.
 * Ketika status transaksi berubah menjadi 'paid', observer ini
 * secara otomatis memicu seluruh Listener (Observer) yang terdaftar
 * secara berurutan – tanpa perlu polling atau pengecekan manual.
 *
 * Ini menggantikan peran "webhook dari Midtrans" dalam skenario simulasi:
 * perubahan status transaksi = trigger utama bagi semua observer.
 *
 * Observer yang terdaftar:
 * 1. UpdateSeatStatus      – tandai kursi sebagai terisi
 * 2. LogTransactionHistory – catat riwayat transaksi
 * 3. SendTicketNotification – kirim notifikasi E-Ticket
 */
class TransactionObserver
{
    /**
     * Dipanggil setelah model Transaction berhasil di-update di database.
     *
     * Hanya bereaksi ketika atribut 'status' berubah menjadi 'paid'.
     * Ini mencegah listener terpanggil pada update kolom lain.
     *
     * @param Transaction $transaction
     * @return void
     */
    public function updated(Transaction $transaction): void
    {
        // Hanya proses jika status berubah menjadi 'paid'
        if ($transaction->wasChanged('status') && $transaction->status === 'paid') {

            logger()->info(
                "[TransactionObserver] Status transaksi #{$transaction->transaction_code} " .
                "berubah menjadi 'paid'. Memicu " . count($this->listeners()) . " observer..."
            );

            // Panggil semua listener secara berurutan
            foreach ($this->listeners() as $listenerClass) {
                try {
                    $listener = new $listenerClass();
                    $listener->handle($transaction);
                } catch (\Exception $e) {
                    logger()->error(
                        "[TransactionObserver] Gagal menjalankan {$listenerClass}: " . $e->getMessage()
                    );
                }
            }

            logger()->info(
                "[TransactionObserver] Semua observer selesai dijalankan untuk " .
                "transaksi #{$transaction->transaction_code}."
            );
        }
    }

    /**
     * Daftar Listener (Concrete Observer) yang akan dipanggil.
     * Menambah observer baru cukup dengan menambahkan class-nya di sini.
     *
     * @return array
     */
    private function listeners(): array
    {
        return [
            UpdateSeatStatus::class,
            LogTransactionHistory::class,
            SendTicketNotification::class,
        ];
    }
}
