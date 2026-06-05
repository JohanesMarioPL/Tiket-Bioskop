<?php

namespace App\Services\Payment;

use App\Models\Transaction;
use App\Models\Payment;
use Carbon\Carbon;

/**
 * Strategy Pattern – Concrete Strategy: Credit Card
 *
 * Strategi pembayaran via Kartu Kredit/Debit.
 * Algoritma: validasi nomor kartu (Luhn check simulasi) →
 * fraud detection check → charge ke issuing bank.
 * Berbeda dari E-Wallet dan VA karena melibatkan proses
 * otorisasi multi-tahap dengan jaringan Visa/Mastercard.
 */
class CreditCardPayment implements PaymentStrategyInterface
{
    /**
     * {@inheritdoc}
     *
     * Logika Credit Card: simulasi fraud check (validasi kartu)
     * dan proses otorisasi ke jaringan kartu kredit.
     * Mencatat 4 digit terakhir kartu (simulasi) sebagai referensi.
     */
    public function process(Transaction $transaction, array $details = []): bool
    {
        // Algoritma Credit Card Step 1: Simulasi validasi Luhn / format kartu
        $last4Digits = str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
        $authCode    = strtoupper(bin2hex(random_bytes(3))); // Kode otorisasi 6 karakter

        logger()->info("[Strategy: CreditCardPayment] Memulai fraud check untuk " .
                       "Transaksi #{$transaction->transaction_code}. Kartu: **** **** **** {$last4Digits}.");

        // Algoritma Credit Card Step 2: Simulasi fraud detection
        // Dalam sistem nyata: query ke fraud scoring engine (Seon, Kount, dll)
        $fraudScore = rand(1, 30); // Skor rendah = aman (< 50)
        if ($fraudScore >= 50) {
            logger()->warning("[Strategy: CreditCardPayment] Transaksi #{$transaction->transaction_code} " .
                              "ditolak – fraud score terlalu tinggi: {$fraudScore}");
            return false;
        }

        // Algoritma Credit Card Step 3: Otorisasi ke jaringan Visa/Mastercard (simulasi)
        logger()->info("[Strategy: CreditCardPayment] Fraud score: {$fraudScore}/100 (aman). " .
                       "Otorisasi ke jaringan kartu. Auth Code: {$authCode}.");

        // Update status transaksi
        $transaction->update(['status' => 'paid']);

        // Catat record pembayaran dengan detail spesifik Credit Card
        Payment::create([
            'transaction_id' => $transaction->id,
            'payment_method' => $details['payment_method'] ?? 'CREDIT CARD',
            'payment_status' => 'success',
            'payment_time'   => Carbon::now(),
        ]);

        logger()->info("[Strategy: CreditCardPayment] Transaksi #{$transaction->transaction_code} berhasil. " .
                       "Kartu: **** {$last4Digits}. Auth: {$authCode}. Waktu: " . Carbon::now()->toDateTimeString());

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return 'Pembayaran via Kartu Kredit/Debit dengan validasi multi-tahap: ' .
               'fraud detection check → otorisasi jaringan Visa/Mastercard → charge ke issuing bank.';
    }

    /**
     * {@inheritdoc}
     */
    public function getSimulationLabel(): string
    {
        return 'Multi-Step Auth – Card Network';
    }
}
