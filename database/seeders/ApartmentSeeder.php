<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Apartment::create([
            'title' => 'Suites Rome',
            'n_rooms' => '2',
            'n_beds' => '3',
            'n_bathrooms' => '2',
            'squared_meters' => '48',
            'image' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/511610364.jpg?k=88a249f10f8cb0470814ef0b1b64c3944b18c85afedeb28f28954dce44966a4f&o=&hp=1',
            'description' => 'Al numero 67 della antica Via della Croce, a due passi da Piazza di Spagna e dallo shopping esclusivo di Via Condotti e Via Borgognona, dalle gallerie di arte e dagli show room antiquari di Via Margutta e di Via del Babuino, SuitesRome offre quattro deliziose suites nel cuore di Roma. Diverse le une dalle altre, deliziose come camere esclusive, esattamente come un Boutique hotel di lusso, sono ideali per vivere Roma con la comodità di un appartamento ed i servizi di un albergo.',
            'address' => 'Via della Croce 67, 00187 Roma',
            'latitude' => '41.90609',
            'longitude' => '12.47899',
            'slug' => 'suites-rome',
            'user_id' => '1',
        ]);
    }
}
