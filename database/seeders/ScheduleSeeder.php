<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\Studio;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Locations
        $locations = [
            ['name' => 'Grand Indonesia XXI', 'city' => 'Jakarta Pusat', 'address' => 'Jl. MH Thamrin No.1'],
            ['name' => 'Senayan City XXI', 'city' => 'Jakarta Pusat', 'address' => 'Jl. Asia Afrika Lot 19'],
            ['name' => 'Pakuwon Mall CGV', 'city' => 'Surabaya', 'address' => 'Jl. Mayjen Yono Suwoyo No.2'],
        ];

        foreach ($locations as $locData) {
            $location = Location::create($locData);

            // 2. Create Studios for each location
            $studios = [
                ['studio_name' => 'Studio 1', 'studio_type' => 'Regular', 'capacity' => 50],
                ['studio_name' => 'Studio 2', 'studio_type' => 'IMAX', 'capacity' => 80],
                ['studio_name' => 'Premiere 1', 'studio_type' => 'Premiere', 'capacity' => 24],
            ];

            foreach ($studios as $studioData) {
                $studioData['location_id'] = $location->id;
                $studio = Studio::create($studioData);

                // 3. Create Seats for each studio
                $rows = ['A', 'B', 'C', 'D', 'E'];
                $cols = 10;
                if ($studio->studio_type === 'Premiere') {
                    $rows = ['A', 'B', 'C'];
                    $cols = 8;
                }

                foreach ($rows as $row) {
                    for ($i = 1; $i <= $cols; $i++) {
                        Seat::create([
                            'studio_id' => $studio->id,
                            'seat_number' => $row . $i,
                        ]);
                    }
                }
            }
        }

        // 4. Create Schedules for existing movies
        $movies = Movie::all();
        $studios = Studio::all();

        foreach ($movies as $movie) {
            // Give each movie 2-3 random schedules
            $count = rand(2, 4);
            for ($i = 0; $i < $count; $i++) {
                $studio = $studios->random();
                
                // Random time today or tomorrow
                $startTime = Carbon::now()
                    ->addDays(rand(0, 1))
                    ->setHour(rand(10, 22))
                    ->setMinute(collect([0, 15, 30, 45])->random())
                    ->setSecond(0);

                $price = 35000;
                if ($studio->studio_type === 'IMAX') $price = 60000;
                if ($studio->studio_type === 'Premiere') $price = 100000;

                Schedule::create([
                    'movie_id' => $movie->id,
                    'studio_id' => $studio->id,
                    'start_time' => $startTime,
                    'base_price' => $price,
                ]);
            }
        }
    }
}
