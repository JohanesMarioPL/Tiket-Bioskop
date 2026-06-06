<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Studio;
use Illuminate\Database\Seeder;

class StudioSeeder extends Seeder
{
    public function run(): void
    {
        $studios = [
            [
                'location_name' => 'Grand XXI',
                'studio_name' => 'Studio 1',
                'studio_type' => 'Regular 2D',
                'capacity' => 50,
            ],
            [
                'location_name' => 'Grand XXI',
                'studio_name' => 'Studio 2',
                'studio_type' => 'IMAX 3D',
                'capacity' => 40,
            ],
            [
                'location_name' => 'Paskal Hyper Square CGV',
                'studio_name' => 'Audi 1',
                'studio_type' => 'Regular 2D',
                'capacity' => 50,
            ],
            [
                'location_name' => 'Paskal Hyper Square CGV',
                'studio_name' => 'Starium',
                'studio_type' => 'Starium 2D',
                'capacity' => 60,
            ],
            [
                'location_name' => 'Paris Van Java Cinepolis',
                'studio_name' => 'Studio 1',
                'studio_type' => 'Regular 2D',
                'capacity' => 50,
            ],
            [
                'location_name' => 'Paris Van Java Cinepolis',
                'studio_name' => 'Studio 2',
                'studio_type' => 'Premiere',
                'capacity' => 24,
            ],
            [
                'location_name' => 'CGV MikoMall',
                'studio_name' => 'Studio 1',
                'studio_type' => 'Regular 2D',
                'capacity' => 50,
            ],
            [
                'location_name' => 'Cinepolis ABC',
                'studio_name' => 'Studio 1',
                'studio_type' => 'Regular 2D',
                'capacity' => 50,
            ],
        ];

        foreach ($studios as $studioData) {

            $location = Location::where(
                'name',
                $studioData['location_name']
            )->first();

            if (!$location) {
                continue;
            }

            Studio::create([
                'location_id' => $location->id,
                'studio_name' => $studioData['studio_name'],
                'studio_type' => $studioData['studio_type'],
                'capacity' => $studioData['capacity'],
            ]);
        }
    }
}