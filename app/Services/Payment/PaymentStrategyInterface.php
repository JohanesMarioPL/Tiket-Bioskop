<?php

namespace App\Services\Payment;

use App\Models\Transaction;

/**
 * Strategy Pattern – Interface
 *
 * Mendefinisikan kontrak yang harus diimplementasikan
 * oleh setiap strategi metode pembayaran.
 * PaymentProcessor bertindak sebagai "Context" yang
 * memilih dan menjalankan strategi secara dinamis.
 */
interface PaymentStrategyInterface
{
    /**
     * Proses pembayaran untuk transaksi yang diberikan.
     *
     * @param Transaction $transaction
     * @param array $details
     * @return bool
     */
    public function process(Transaction $transaction, array $details = []): bool;

    /**
     * Dapatkan deskripsi singkat strategi ini.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Dapatkan label simulasi untuk ditampilkan ke user.
     *
     * @return string
     */
    public function getSimulationLabel(): string;
}
