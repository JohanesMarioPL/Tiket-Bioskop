<?php

namespace App\Http\Controllers;

use App\Factories\TicketFactory;
use App\Models\Schedule;
use App\Models\Transaction;
use App\Models\Seat;
use App\Services\Pricing\BaseTicketPrice;
use App\Services\Pricing\ServiceFeeDecorator;
use App\Services\Pricing\TaxDecorator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Bangun decorator chain untuk perhitungan harga tiket.
     *
     * Decorator Pattern – penggunaan:
     *   BaseTicketPrice          (komponen dasar)
     *     └─ ServiceFeeDecorator (+ biaya layanan)
     *         └─ TaxDecorator    (+ pajak 5%)
     *
     * Untuk menambah/hapus komponen harga, cukup tambah/hapus satu baris
     * tanpa mengubah kelas yang sudah ada.
     *
     * @param int $basePrice  Harga dasar per tiket
     * @param int $quantity   Jumlah tiket
     * @return \App\Services\Pricing\TicketPricingInterface
     */
    private function buildPricingChain(int $basePrice, int $quantity)
    {
        // Layer 1 – Komponen dasar (ConcreteComponent)
        $pricing = new BaseTicketPrice($basePrice, $quantity);

        // Layer 2 – Dekorator biaya layanan
        $pricing = new ServiceFeeDecorator($pricing, $quantity);

        // Layer 3 – Dekorator pajak 5%
        $pricing = new TaxDecorator($pricing, 0.05);

        return $pricing;
    }

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
        $seats   = Seat::whereIn('id', $seatIds)->get();

        if ($seats->isEmpty()) {
            return redirect()->route('booking.show', $schedule)
                ->with('error', 'Kursi yang dipilih tidak valid.');
        }

        $schedule->load(['movie', 'studio.location']);

        $quantity  = $seats->count();
        $basePrice = $schedule->base_price;

        // Decorator Pattern – bangun chain dan hitung total
        $pricing     = $this->buildPricingChain($basePrice, $quantity);
        $totalAmount = $pricing->calculate();
        $breakdown   = $pricing->getBreakdown();

        // Hitung nilai individual untuk view (backward compat)
        $serviceFee = 2000 * $quantity;
        $taxAmount  = $totalAmount - ($basePrice * $quantity) - $serviceFee;

        return view('checkout.show', compact(
            'schedule', 'seats', 'quantity',
            'serviceFee', 'taxAmount', 'totalAmount',
            'breakdown', 'seatIdsStr'
        ));
    }

    /**
     * Process checkout: buat transaksi, tiket (via Factory), dan reservasi kursi.
     *
     * Menggunakan:
     * - Decorator Pattern untuk menghitung harga akhir
     * - Factory Pattern untuk membuat tiket sesuai rating film
     */
    public function store(Request $request, Schedule $schedule)
    {
        $request->validate([
            'seat_ids'       => 'required|string',
            'payment_method' => 'required|string|in:gopay,ovo,dana,bca_va,mandiri_va,bni_va,credit_card',
        ]);

        $seatIds = explode(',', $request->seat_ids);
        $seats   = Seat::whereIn('id', $seatIds)->get();

        if ($seats->isEmpty()) {
            return redirect()->route('booking.show', $schedule)
                ->with('error', 'Pilihan kursi tidak valid.');
        }

        // Load movie agar TicketFactory bisa membaca rating_age
        $schedule->load('movie');

        $quantity  = $seats->count();
        $basePrice = $schedule->base_price;

        // Decorator Pattern – hitung total dari chain
        $pricing        = $this->buildPricingChain($basePrice, $quantity);
        $totalAmount    = $pricing->calculate();
        $breakdown      = $pricing->getBreakdown();

        // Breakdown individual
        $serviceFee = 2000 * $quantity;
        $taxAmount  = $totalAmount - ($basePrice * $quantity) - $serviceFee;

        // DB Transaction – simpan semua secara atomik
        $transaction = DB::transaction(function () use (
            $schedule, $seats, $quantity, $basePrice,
            $serviceFee, $taxAmount, $totalAmount, $request
        ) {
            // Buat transaksi utama
            $transaction = Transaction::create([
                'user_id'          => auth()->id() ?? 1,
                'transaction_code' => 'TB-' . strtoupper(Str::random(10)),
                'total_amount'     => $totalAmount,
                'service_fee'      => $serviceFee,
                'tax'              => $taxAmount,
                'discount'         => 0,
                'status'           => 'pending',
            ]);

            // Factory Pattern – buat tiket untuk setiap kursi
            // Controller tidak tahu logika ticket_type, Factory yang memutuskan
            TicketFactory::createForSeats($transaction, $schedule, $seats, $basePrice);

            // Simpan metode pembayaran di session untuk halaman simulasi
            session(['selected_payment_method_' . $transaction->id => $request->payment_method]);

            return $transaction;
        });

        return redirect()->route('payment.show', $transaction);
    }
}
