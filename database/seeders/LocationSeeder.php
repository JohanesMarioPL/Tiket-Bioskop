<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Studio;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Locations
        $locations = [
            [
                'name' => 'XXI Cibinong',
                'city' => 'Bogor',
                'address' => 'Jl. Raya Cibinong No. 1, Cibinong, Bogor, Jawa Barat',
            ],
            [
                'name' => 'XXI Sentosa',
                'city' => 'Jakarta',
                'address' => 'Jl. Jend. Sudirman No. 1, Jakarta Pusat, DKI Jakarta',
            ],
            [
                'name' => 'XXI Kelapa Gading',
                'city' => 'Jakarta',
                'address' => 'Jl. Boulevard Kelapa Gading, Jakarta Utara, DKI Jakarta',
            ],
            [
                'name' => 'XXI Bandung',
                'city' => 'Bandung',
                'address' => 'Jl. Diponegoro No. 52, Bandung, Jawa Barat',
            ],
            [
                'name' => 'XXI Lippo Karawaci',
                'city' => 'Tangerang',
                'address' => 'Jl. MH. Thamrin Blok Y No. 1, Lippo Karawaci, Tangerang, Banten',
            ],
            [
                'name' => 'XXI Blitz Megaplex',
                'city' => 'Jakarta',
                'address' => 'Jl. Benda Raya No. 1, Kemang, Jakarta Selatan, DKI Jakarta',
            ],
            [
                'name' => 'CGV Grand Indonesia',
                'city' => 'Jakarta',
                'address' => 'Jl. MH. Thamrin No. 1, Jakarta Pusat, DKI Jakarta',
            ],
            [
                'name' => 'Cinemaxx Indonesia',
                'city' => 'Jakarta',
                'address' => 'Jl. Jambatan Blok M, Jakarta Selatan, DKI Jakarta',
            ],
        ];

        foreach ($locations as $locationData) {
            $location = Location::create($locationData);

            // Create studios for each location
            $studioTypes = ['2D', '3D', '4DX', 'IMAX'];
            $studioCount = rand(2, 5);

            for ($i = 1; $i <= $studioCount; $i++) {
                $studioType = $studioTypes[array_rand($studioTypes)];
                
                Studio::create([
                    'location_id' => $location->id,
                    'studio_name' => "Studio {$i} ({$studioType})",
                    'studio_type' => $studioType,
                    'capacity' => rand(100, 250),
                ]);
            }
        }
    }
}
