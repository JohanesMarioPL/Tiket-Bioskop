<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function show($transactionCode)
    {
        $transaction = Transaction::where('transaction_code', $transactionCode)
            ->with(['tickets.schedule.movie', 'tickets.schedule.studio.location', 'user'])
            ->firstOrFail();

        return view('ticket.show', compact('transaction'));
    }
}
