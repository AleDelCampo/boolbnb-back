<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            ApartmentSeeder::class,

        ]);
    }
}
