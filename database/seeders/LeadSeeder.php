<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lead;
use App\Models\Apartment;
use Faker\Factory as Faker;

class LeadSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $apartments = Apartment::all();

        foreach ($apartments as $apartment) {
            for ($i = 0; $i < 20; $i++) {
                $newLead = new Lead();

                $newLead->name = $faker->firstName;
                $newLead->surname = $faker->lastName;
                $newLead->mail_address = $faker->unique()->safeEmail;
                $newLead->message = $faker->sentence;
                $newLead->apartment_id = $apartment->id;
                $newLead->created_at = $faker->dateTimeBetween('2022-01-01', 'now');
                $newLead->updated_at = $faker->dateTimeBetween($newLead->created_at, 'now');

                $newLead->save();
            }
        }
    }
}
