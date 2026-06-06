<?php

namespace App\Services\Payment;

use App\Models\Transaction;

interface PaymentStrategyInterface
{
    /**
     * Process the payment for the given transaction.
     *
     * @param Transaction $transaction
     * @param array $details
     * @return bool
     */
    public function process(Transaction $transaction, array $details = []): bool;
}
