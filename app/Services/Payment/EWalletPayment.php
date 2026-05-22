<?php

namespace App\Services\Payment;

use App\Models\Transaction;
use App\Models\Payment;
use Carbon\Carbon;

class EWalletPayment implements PaymentStrategyInterface
{
    /**
     * Process E-Wallet payment.
     *
     * @param Transaction $transaction
     * @param array $details
     * @return bool
     */
    public function process(Transaction $transaction, array $details = []): bool
    {
        // Update transaction status to paid
        $transaction->update(['status' => 'paid']);

        // Create the payment record
        Payment::create([
            'transaction_id' => $transaction->id,
            'payment_method' => $details['payment_method'] ?? 'E-Wallet',
            'payment_status' => 'success',
            'payment_time' => Carbon::now(),
        ]);

        return true;
    }
}
