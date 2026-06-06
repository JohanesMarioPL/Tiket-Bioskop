<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Studio;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $movies = Movie::all();
        $studios = Studio::all();

        foreach ($movies as $movie) {
            $scheduleCount = rand(3, 5);

            for ($i = 0; $i < $scheduleCount; $i++) {
                $studio = $studios->random();
                $startTime = Carbon::now()
                    ->addDays(rand(0, 7))
                    ->setHour(collect([
                        10, 13, 16, 19, 21
                    ])->random())
                    ->setMinute(0);

                $price = match ($studio->studio_type) {
                    'IMAX 3D' => 60000,
                    'Premiere' => 100000,
                    'Starium 2D' => 75000,
                    default => 35000,
                };

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