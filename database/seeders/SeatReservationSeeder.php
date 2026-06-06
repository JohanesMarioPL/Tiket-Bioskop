<?php

namespace Database\Seeders;

use App\Models\Seat;
use App\Models\Ticket;
use App\Models\Reservation;
use Illuminate\Database\Seeder;

class SeatReservationSeeder extends Seeder
{
    public function run(): void
    {
        $usedSeats = [];
        $tickets = Ticket::with('schedule.studio')->get();

        foreach ($tickets as $ticket) {
            $studioId = $ticket->schedule->studio_id;
            $availableSeat = Seat::where('studio_id', $studioId)
                ->whereNotIn('id', $usedSeats)
                ->inRandomOrder()
                ->first();

            if (!$availableSeat) {
                continue;
            }

            Reservation::create([
                'ticket_id' => $ticket->id,
                'seat_id' => $availableSeat->id,
            ]);

            $usedSeats[] = $availableSeat->id;
        }
    }
}