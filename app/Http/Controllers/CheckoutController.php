<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Transaction;
use App\Models\Ticket;
use App\Models\Seat;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show the order summary / checkout confirmation page.
     */
    public function show(Request $request, Schedule $schedule)
    {
        $seatIdsStr = $request->query('seat_ids');
        
        if (!$seatIdsStr) {
            return redirect()->route('booking.show', $schedule)
                ->with('error', 'Silakan pilih kursi terlebih dahulu.');
        }

        $seatIds = explode(',', $seatIdsStr);
        $seats = Seat::whereIn('id', $seatIds)->get();

        if ($seats->isEmpty()) {
            return redirect()->route('booking.show', $schedule)
                ->with('error', 'Kursi yang dipilih tidak valid.');
        }

        $schedule->load(['movie', 'studio.location']);
        
        $quantity = $seats->count();
        $basePrice = $schedule->base_price;
        $serviceFee = 2000 * $quantity;
        $totalAmount = ($basePrice * $quantity) + $serviceFee;

        return view('checkout.show', compact('schedule', 'seats', 'quantity', 'serviceFee', 'totalAmount', 'seatIdsStr'));
    }

    /**
     * Process checkout submission: create transaction, tickets, and seat reservations.
     */
    public function store(Request $request, Schedule $schedule)
    {
        $request->validate([
            'seat_ids' => 'required|string',
            'payment_method' => 'required|string|in:gopay,ovo,dana,bca_va,mandiri_va,bni_va,credit_card',
        ]);

        $seatIds = explode(',', $request->seat_ids);
        $seats = Seat::whereIn('id', $seatIds)->get();

        if ($seats->isEmpty()) {
            return redirect()->route('booking.show', $schedule)
                ->with('error', 'Pilihan kursi tidak valid.');
        }

        $quantity = $seats->count();
        $basePrice = $schedule->base_price;
        $serviceFee = 2000 * $quantity;
        $totalAmount = ($basePrice * $quantity) + $serviceFee;

        // DB Transaction to store everything atomically
        $transaction = DB::transaction(function () use ($schedule, $seats, $quantity, $basePrice, $serviceFee, $totalAmount, $request) {
            // Create Transaction in 'pending' status
            $transaction = Transaction::create([
                'user_id' => auth()->id() ?? 1, // Fallback for testing/unauthenticated
                'transaction_code' => 'TB-' . strtoupper(Str::random(10)),
                'total_amount' => $totalAmount,
                'service_fee' => $serviceFee,
                'tax' => 0,
                'discount' => 0,
                'status' => 'pending', // Pending payment
            ]);

            // Create Tickets & Seat Reservations for each selected seat
            foreach ($seats as $seat) {
                $ticket = Ticket::create([
                    'transaction_id' => $transaction->id,
                    'schedule_id' => $schedule->id,
                    'ticket_type' => 'Regular',
                    'final_price' => $basePrice,
                ]);

                Reservation::create([
                    'ticket_id' => $ticket->id,
                    'seat_id' => $seat->id,
                ]);
            }

            // Save the chosen payment method in the session temporarily for simulation purposes
            session(['selected_payment_method_' . $transaction->id => $request->payment_method]);

            return $transaction;
        });

        // Redirect to payment simulation page
        return redirect()->route('payment.show', $transaction);
    }
}
