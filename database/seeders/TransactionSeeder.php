<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $schedules = Schedule::all();

        foreach ($users as $user) {
            $transactionCount = rand(2, 5);

            for ($i = 0; $i < $transactionCount; $i++) {
                $schedule = $schedules->random();
                $ticketCount = rand(1, 3);
                $subtotal = $schedule->base_price * $ticketCount;

                $serviceFee = 2000;
                $tax = $subtotal * 0.1;
                $discount = 0;

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'transaction_code' => 'TX-' . strtoupper(Str::random(8)),
                    'total_amount' => $subtotal + $serviceFee + $tax,
                    'service_fee' => $serviceFee,
                    'tax' => $tax,
                    'discount' => $discount,
                    'status' => collect([
                        'paid',
                        'paid',
                        'paid',
                        'pending',
                        'cancelled',
                        'refunded'
                    ])->random(),
                ]);

                for ($j = 0; $j < $ticketCount; $j++) {

                    Ticket::create([
                        'transaction_id' => $transaction->id,
                        'schedule_id' => $schedule->id,
                        'ticket_type' => 'Regular',
                        'final_price' => $schedule->base_price,
                    ]);
                }
            }
        }
    }
}