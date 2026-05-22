<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display the e-ticket for the transaction.
     */
    public function show(Transaction $transaction)
    {
        // Require the transaction to be paid/success to see the ticket
        if (!in_array($transaction->status, ['paid', 'success'])) {
            return redirect()->route('payment.show', $transaction)
                ->with('error', 'Silakan selesaikan pembayaran Anda terlebih dahulu.');
        }

        $transaction->load(['tickets.reservation.seat', 'tickets.schedule.movie', 'tickets.schedule.studio.location', 'payment']);

        return view('tickets.show', compact('transaction'));
    }
}
