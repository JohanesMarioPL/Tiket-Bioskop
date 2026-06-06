<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\Payment\PaymentProcessor;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display the payment simulation page.
     */
    public function show(Transaction $transaction)
    {
        // If the transaction is already paid, redirect to the e-ticket
        if ($transaction->status === 'paid' || $transaction->status === 'success') {
            return redirect()->route('ticket.show', $transaction)
                ->with('info', 'Transaksi ini sudah lunas.');
        }

        $transaction->load(['tickets.reservation.seat', 'tickets.schedule.movie', 'tickets.schedule.studio.location']);
        
        $paymentMethod = session('selected_payment_method_' . $transaction->id, 'gopay');
        
        return view('payment.show', compact('transaction', 'paymentMethod'));
    }

    /**
     * Simulate a successful payment using the Strategy Design Pattern.
     */
    public function simulate(Request $request, Transaction $transaction)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $processor = new PaymentProcessor();
        $success = $processor->execute($transaction, $request->payment_method);

        if ($success) {
            // Clear temp session value
            session()->forget('selected_payment_method_' . $transaction->id);

            return redirect()->route('ticket.show', $transaction)
                ->with('success', 'Pembayaran Berhasil! Tiket Elektronik Anda telah diterbitkan.');
        }

        return redirect()->back()->with('error', 'Gagal memproses simulasi pembayaran.');
    }
}
