<?php

namespace App\Services\Payment;

use App\Models\Transaction;
use App\Models\Payment;
use Carbon\Carbon;

/**
 * Strategy Pattern – Concrete Strategy: Virtual Account (VA)
 *
 * Strategi pembayaran via Virtual Account bank (BCA, Mandiri, BNI).
 * Algoritma: generate nomor VA unik → tunggu konfirmasi transfer
 * dari bank (disimulasikan). Berbeda dari E-Wallet karena melibatkan
 * sistem perbankan eksternal dan membutuhkan rekonsiliasi.
 */
class VAPayment implements PaymentStrategyInterface
{
    /**
     * {@inheritdoc}
     *
     * Logika VA: generate nomor Virtual Account unik,
     * lakukan simulasi pengecekan konfirmasi dari bank,
     * lalu tandai transaksi sebagai lunas.
     */
    public function process(Transaction $transaction, array $details = []): bool
    {
        // Algoritma Virtual Account: generate VA number unik per transaksi
        $vaNumber = '8808' . str_pad($transaction->id, 8, '0', STR_PAD_LEFT) . rand(100, 999);
        $bankName = strtoupper(str_replace(['_va', '_VA'], '', $details['payment_method'] ?? 'bank'));

        // Simulasi: rekonsiliasi dengan sistem bank (delay marker)
        // Dalam implementasi nyata, ini adalah async webhook dari bank
        logger()->info("[Strategy: VAPayment] Nomor VA dibuat: {$vaNumber} ({$bankName}). " .
                       "Menunggu konfirmasi transfer untuk Transaksi #{$transaction->transaction_code}.");

        // Setelah konfirmasi (simulasi), update status
        $transaction->update(['status' => 'paid']);

        // Catat record pembayaran dengan detail spesifik VA
        Payment::create([
            'transaction_id' => $transaction->id,
            'payment_method' => $details['payment_method'] ?? 'VIRTUAL ACCOUNT',
            'payment_status' => 'success',
            'payment_time'   => Carbon::now(),
        ]);

        logger()->info("[Strategy: VAPayment] Transfer dikonfirmasi. Transaksi #{$transaction->transaction_code} " .
                       "berhasil. VA: {$vaNumber}. Bank: {$bankName}. Waktu: " . Carbon::now()->toDateTimeString());

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return 'Pembayaran via transfer ke nomor Virtual Account yang di-generate unik per transaksi. ' .
               'Memerlukan rekonsiliasi dengan sistem perbankan.';
    }

    /**
     * {@inheritdoc}
     */
    public function getSimulationLabel(): string
    {
        return 'VA Transfer – Bank Reconciliation';
    }
}
