<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Sponsorship;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // SponsorshipSeeder::class,
            // ServiceSeeder::class,
            // ApartmentSeeder::class,

        ]);

        foreach (Apartment::all() as $apartment) {

            $randomNum = rand(1, 6);

            $nRandomArray = [];

            for ($i = 1; $i <= $randomNum; $i++) {

                $randomId = rand(1, 6);

                if (!in_array($randomId, $nRandomArray)) {

                    array_push($nRandomArray, $randomId);

                    $service = Service::where('id', '=', $randomId)->first();

                    $apartment->services()->attach($service->id);

                    $apartment->save();
                }
            }
        }
    }
}
