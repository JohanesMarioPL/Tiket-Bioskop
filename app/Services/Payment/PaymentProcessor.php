<?php

namespace App\Services\Payment;

use App\Models\Transaction;
use Exception;

/**
 * Strategy Pattern – Context
 *
 * PaymentProcessor bertindak sebagai "Context" dalam Strategy Pattern.
 * Ia tidak tahu cara memproses pembayaran secara langsung – tugasnya
 * hanya memilih strategi yang tepat (via getStrategy) dan mendelegasikan
 * eksekusi ke strategi yang dipilih (via execute).
 *
 * Ini memungkinkan penukaran algoritma pembayaran secara dinamis
 * tanpa mengubah kode controller atau logika bisnis utama.
 */
class PaymentProcessor
{
    /**
     * Strategi pembayaran yang sedang aktif (bisa diset dari luar).
     */
    private ?PaymentStrategyInterface $strategy = null;

    /**
     * Set strategi pembayaran secara eksplisit (dependency injection).
     * Memungkinkan pengujian unit dengan strategy mock.
     *
     * @param PaymentStrategyInterface $strategy
     */
    public function setStrategy(PaymentStrategyInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    /**
     * Resolve strategi yang tepat berdasarkan string metode pembayaran.
     * Ini adalah factory method internal untuk memilih Concrete Strategy.
     *
     * @param string $method
     * @return PaymentStrategyInterface
     * @throws Exception
     */
    public static function getStrategy(string $method): PaymentStrategyInterface
    {
        $method = strtolower($method);

        // Concrete Strategy: E-Wallet (GoPay, OVO, DANA)
        if (in_array($method, ['gopay', 'ovo', 'dana'])) {
            return new EWalletPayment();
        }

        // Concrete Strategy: Virtual Account (BCA, Mandiri, BNI)
        if (in_array($method, ['bca_va', 'mandiri_va', 'bni_va'])) {
            return new VAPayment();
        }

        // Concrete Strategy: Kartu Kredit/Debit
        if ($method === 'credit_card') {
            return new CreditCardPayment();
        }

        throw new Exception("Metode pembayaran '{$method}' tidak didukung.");
    }

    /**
     * Eksekusi pembayaran: pilih strategi → delegasikan proses.
     * Controller cukup memanggil method ini tanpa tahu algoritma di dalamnya.
     *
     * @param Transaction $transaction
     * @param string $method
     * @param array $details
     * @return bool
     */
    public function execute(Transaction $transaction, string $method, array $details = []): bool
    {
        try {
            // Gunakan strategi yang sudah di-set, atau resolve otomatis
            $strategy = $this->strategy ?? self::getStrategy($method);

            logger()->info("[PaymentProcessor] Menggunakan strategi: " . get_class($strategy) .
                           " ({$strategy->getSimulationLabel()}) untuk metode '{$method}'.");

            $details['payment_method'] = strtoupper(str_replace('_', ' ', $method));
            return $strategy->process($transaction, $details);

        } catch (Exception $e) {
            logger()->error("[PaymentProcessor] Gagal memproses pembayaran: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Dapatkan deskripsi strategi untuk metode pembayaran tertentu.
     * Berguna untuk ditampilkan di UI atau log.
     *
     * @param string $method
     * @return string
     */
    public static function getStrategyDescription(string $method): string
    {
        try {
            return self::getStrategy($method)->getDescription();
        } catch (Exception $e) {
            return 'Metode pembayaran tidak dikenali.';
        }
    }
}
