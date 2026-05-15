<?php

namespace App\Http\Controllers;
 
use App\Models\Schedule;
use App\Models\Seat;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function show(Schedule $schedule)
    {
        $schedule->load(['movie', 'studio.location']);
        
        // Get seats for this studio
        $seats = Seat::where('studio_id', $schedule->studio_id)
            ->orderBy('seat_number')
            ->get();

        // Get already reserved seats for this schedule
        $reservedSeatIds = \App\Models\Reservation::whereHas('ticket', function($q) use ($schedule) {
            $q->where('schedule_id', $schedule->id);
        })->pluck('seat_id')->toArray();

        return view('booking.show', compact('schedule', 'seats', 'reservedSeatIds'));
    }
}
