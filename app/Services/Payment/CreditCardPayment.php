<?php

namespace App\Services\Payment;

use App\Models\Transaction;
use App\Models\Payment;
use Carbon\Carbon;

class CreditCardPayment implements PaymentStrategyInterface
{
    /**
     * Process Credit Card payment.
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
            'payment_method' => $details['payment_method'] ?? 'Credit Card',
            'payment_status' => 'success',
            'payment_time' => Carbon::now(),
        ]);

        return true;
    }
}
