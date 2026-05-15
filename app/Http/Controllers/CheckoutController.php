<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Transaction;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show(Schedule $schedule)
    {
        $schedule->load(['movie', 'studio.location']);
        return view('checkout.show', compact('schedule'));
    }

    public function store(Request $request, Schedule $schedule)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $quantity = $request->quantity;
        $basePrice = $schedule->base_price;
        $serviceFee = 2000 * $quantity;
        $totalAmount = ($basePrice * $quantity) + $serviceFee;

        return DB::transaction(function () use ($schedule, $quantity, $basePrice, $serviceFee, $totalAmount) {
            // Create Transaction
            $transaction = Transaction::create([
                'user_id' => auth()->id() ?? 1, // Fallback to 1 for testing
                'transaction_code' => 'TB-' . strtoupper(Str::random(10)),
                'total_amount' => $totalAmount,
                'service_fee' => $serviceFee,
                'tax' => 0,
                'discount' => 0,
                'status' => 'paid', // Instant paid for demo purposes
            ]);

            // Create Tickets
            for ($i = 0; $i < $quantity; $i++) {
                Ticket::create([
                    'transaction_id' => $transaction->id,
                    'schedule_id' => $schedule->id,
                    'ticket_type' => 'Regular',
                    'final_price' => $basePrice,
                ]);
            }

            return redirect()->back()->with('success', 'Pesanan berhasil dikonfirmasi! Kode Booking: ' . $transaction->transaction_code);
        });
    }
}
