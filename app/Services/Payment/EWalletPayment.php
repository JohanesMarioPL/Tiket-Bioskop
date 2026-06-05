<?php

namespace App\Services\Payment;

use App\Models\Transaction;
use App\Models\Payment;
use Carbon\Carbon;

/**
 * Strategy Pattern – Concrete Strategy: E-Wallet
 *
 * Strategi pembayaran via E-Wallet (GoPay, OVO, DANA).
 * Algoritma: instant approval – verifikasi langsung tanpa
 * pengecekan tambahan karena saldo e-wallet real-time.
 */
class EWalletPayment implements PaymentStrategyInterface
{
    /**
     * {@inheritdoc}
     *
     * Logika E-Wallet: persetujuan instan, tidak memerlukan
     * pengecekan bank eksternal. Waktu pembayaran dicatat
     * dengan presisi penuh (termasuk detik).
     */
    public function process(Transaction $transaction, array $details = []): bool
    {
        // Algoritma E-Wallet: instant approval
        // Tidak ada delay/pengecekan eksternal – saldo langsung terdebit
        $approvalCode = strtoupper(bin2hex(random_bytes(4))); // Kode approval unik

        // Update status transaksi menjadi lunas
        $transaction->update(['status' => 'paid']);

        // Catat record pembayaran dengan detail spesifik E-Wallet
        Payment::create([
            'transaction_id' => $transaction->id,
            'payment_method' => $details['payment_method'] ?? 'E-WALLET',
            'payment_status' => 'success',
            'payment_time'   => Carbon::now(),
            // Komentar: approval_code & metadata dicatat di log untuk simulasi
        ]);

        logger()->info("[Strategy: EWalletPayment] Transaksi #{$transaction->transaction_code} berhasil. " .
                       "Metode: {$details['payment_method']}. Approval Code: {$approvalCode}. " .
                       "Waktu: " . Carbon::now()->toDateTimeString());

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return 'Pembayaran instan via saldo E-Wallet. Verifikasi dilakukan secara real-time ' .
               'tanpa keterlibatan pihak bank eksternal.';
    }

    /**
     * {@inheritdoc}
     */
    public function getSimulationLabel(): string
    {
        return 'Instant Approval – E-Wallet';
    }
}
