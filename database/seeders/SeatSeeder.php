<?php

namespace Database\Seeders;

use App\Models\Seat;
use App\Models\Studio;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
        $studios = Studio::all();

        foreach ($studios as $studio) {

            $capacity = $studio->capacity;
            $columns = 10;
            $rowsNeeded = ceil($capacity / $columns);

            for ($row = 0; $row < $rowsNeeded; $row++) {
                $rowLetter = chr(65 + $row);
                for ($seat = 1; $seat <= $columns; $seat++) {
                    $seatNumber = ($row * $columns) + $seat;
                    if ($seatNumber > $capacity) {
                        break;
                    }

                    Seat::create([
                        'studio_id' => $studio->id,
                        'seat_number' => $rowLetter . $seat,
                    ]);
                }
            }
        }
    }
}