<?php

namespace Database\Seeders;

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
        // User::factory() removed — User model does not use HasFactory.
        // Add manual user seeds here if needed:
        // DB::table('users')->insert([...]);

        $this->call(MovieSeeder::class);
    }
}

