<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'tickets.schedule.movie', 'tickets.schedule.studio']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('transaction_code', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
        }

        $transactions = $query->latest()->paginate(10);

        return view('admin-dashboard.transactions-management.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load([
            'user', 
            'tickets.schedule.movie', 
            'tickets.schedule.studio', 
            'tickets.reservation.seat' 
        ]);
        
        return view('admin-dashboard.transactions-management.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        if ($request->has('status')) {
            $request->validate([
                'status' => 'required|in:success,failed',
            ]);

            $transaction->update([
                'status' => $request->status
            ]);

            $pesan = $request->status === 'success' 
                ? 'Transaksi berhasil dikonfirmasi lunas!' 
                : 'Transaksi berhasil dibatalkan.';

            return redirect()->route('admin.transactions.show', $transaction->id)->with('success', $pesan);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'transaction_code' => 'required|string|unique:transactions,transaction_code,' . $transaction->id,
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,success,failed',
        ]);

        $transaction->update([
            'user_id' => $request->user_id,
            'transaction_code' => $request->transaction_code,
            'total_amount' => $request->total_amount,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.transactions.index')->with('success', 'Data transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
