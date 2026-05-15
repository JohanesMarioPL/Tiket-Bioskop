<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Studio;
use App\Models\Transaction;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        $location = Location::create([
            'name' => 'Mall Kelapa Gading',
            'city' => 'Jakarta Utara',
            'address' => 'Jl. Boulevard Raya No.1'
        ]);

        $studio = Studio::create([
            'location_id' => $location->id,
            'studio_name' => 'Studio 1',
            'studio_type' => 'Regular',
            'capacity' => 50
        ]);

        $movie = Movie::create([
            'title' => 'The Avengers',
            'description' => 'Earth\'s mightiest heroes must come together...',
            'genre' => 'Action, Sci-Fi',
            'duration_minutes' => 143,
            'rating_age' => 'R13'
        ]);

        $schedule = Schedule::create([
            'movie_id' => $movie->id,
            'studio_id' => $studio->id,
            'start_time' => now()->addDays(1),
            'base_price' => 50000
        ]);

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'transaction_code' => 'TX' . strtoupper(Str::random(8)),
            'total_amount' => 55000,
            'service_fee' => 5000,
            'status' => 'success'
        ]);

        Ticket::create([
            'transaction_id' => $transaction->id,
            'schedule_id' => $schedule->id,
            'ticket_type' => 'Adult',
            'final_price' => 50000
        ]);
    }
}
