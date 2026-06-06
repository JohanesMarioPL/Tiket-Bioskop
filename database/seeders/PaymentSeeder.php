<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $transactions = Transaction::all();

        foreach ($transactions as $transaction) {
            $status = match ($transaction->status) {
                'paid' => 'settlement',
                'cancelled' => 'failed',
                'refunded' => 'failed',
                default => 'pending',
            };

            Payment::create([
                'transaction_id' => $transaction->id,
                'payment_method' => collect([
                    'GoPay',
                    'OVO',
                    'DANA',
                    'ShopeePay',
                    'BCA VA',
                    'BNI VA',
                    'BRI VA',
                ])->random(),

                'payment_status' => $status,
                'payment_time' => $transaction->status === 'success'
                    ? now()->subDays(rand(0, 30))
                    : null,
            ]);
        }
    }
}