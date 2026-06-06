<?php

namespace App\Services\Payment;

use App\Models\Transaction;
use Exception;

class PaymentProcessor
{
    /**
     * Resolve the strategy based on payment method.
     *
     * @param string $method
     * @return PaymentStrategyInterface
     * @throws Exception
     */
    public static function getStrategy(string $method): PaymentStrategyInterface
    {
        $method = strtolower($method);

        if (in_array($method, ['gopay', 'ovo', 'dana'])) {
            return new EWalletPayment();
        }

        if (in_array($method, ['bca_va', 'mandiri_va', 'bni_va'])) {
            return new VAPayment();
        }

        if ($method === 'credit_card') {
            return new CreditCardPayment();
        }

        throw new Exception("Metode pembayaran '{$method}' tidak didukung.");
    }

    /**
     * Process a transaction with a given payment method.
     *
     * @param Transaction $transaction
     * @param string $method
     * @param array $details
     * @return bool
     */
    public function execute(Transaction $transaction, string $method, array $details = []): bool
    {
        try {
            $strategy = self::getStrategy($method);
            $details['payment_method'] = strtoupper(str_replace('_', ' ', $method));
            return $strategy->process($transaction, $details);
        } catch (Exception $e) {
            logger()->error("Gagal memproses pembayaran: " . $e->getMessage());
            return false;
        }
    }
}
