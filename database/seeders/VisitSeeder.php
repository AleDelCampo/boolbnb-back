<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Visit;
use App\Models\Apartment;
use Faker\Factory as Faker;

class VisitSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $apartments = Apartment::all();

        for ($i = 1; $i < 20; $i++) {

            $newVisit = new Visit();

            $timestamp = $faker->dateTimeBetween('-2 years', now());
            $ipAddress = $faker->ipv4;

            $randomApartment = rand(1, 10);

            $newVisit->timestamp_visit = $timestamp;
            $newVisit->ip_address = $ipAddress;
            $newVisit->apartment_id = $randomApartment;

            $newVisit->save();
        }
    }
}
