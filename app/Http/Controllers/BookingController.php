<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Seat;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display the visual seat map for the schedule.
     */
    public function show(Schedule $schedule)
    {
        $schedule->load(['movie', 'studio.location']);

        // Fetch all seats in the studio
        $seats = Seat::where('studio_id', $schedule->studio_id)
            ->orderBy('seat_number')
            ->get();

        // Get IDs/Numbers of already reserved seats for this schedule
        $reservedSeatIds = DB::table('seat_reservations')
            ->join('tickets', 'seat_reservations.ticket_id', '=', 'tickets.id')
            ->where('tickets.schedule_id', $schedule->id)
            ->pluck('seat_reservations.seat_id')
            ->toArray();

        return view('booking.show', compact('schedule', 'seats', 'reservedSeatIds'));
    }
}
