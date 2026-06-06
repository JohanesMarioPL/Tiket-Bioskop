<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MovieSeeder::class,
            LocationSeeder::class,
            StudioSeeder::class,
            SeatSeeder::class,
            ScheduleSeeder::class,
            TransactionSeeder::class,
            PaymentSeeder::class,
            ReviewSeeder::class,
            SeatReservationSeeder::class,
        ]);
    }
}
