<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Grand XXI',
                'city' => 'Bandung',
                'address' => 'Jl. Surya Sumantri No. 65, Sukajadi',
            ],
            [
                'name' => 'Paskal Hyper Square CGV',
                'city' => 'Bandung',
                'address' => 'Paskal 23 Mall Lantai 3, Jl. Pasir Kaliki No. 25',
            ],
            [
                'name' => 'Paris Van Java Cinepolis',
                'city' => 'Bandung',
                'address' => 'Paris Van Java Mall, Jl. Sukajadi No. 131',
            ],
            [
                'name' => 'CGV MikoMall',
                'city' => 'Bandung',
                'address' => 'Jl. Kopo',
            ],
            [
                'name' => 'Cinepolis ABC',
                'city' => 'Bandung',
                'address' => 'Jl. Peta',
            ],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}