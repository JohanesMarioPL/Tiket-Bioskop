<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the user's transactions.
     */
    public function history()
    {
        $transactions = Transaction::with(['tickets.schedule.movie', 'payment'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transactions.history', compact('transactions'));
    }
}
