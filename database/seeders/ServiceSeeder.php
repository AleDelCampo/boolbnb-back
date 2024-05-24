<?php

namespace Database\Seeders;

use App\Models\Service;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = ['wi-fi', 'piscina', 'portineria', 'posto auto', 'sauna', 'vista mare'];

        $services = [
            [
                "name" => "Wi-fi",
                "icon" => "<i class='fa-solid fa-wifi'></i>"
            ],
            [
                "name" => "Piscina",
                "icon" => "<i class='fa-solid fa-water-ladder'></i>"
            ],
            [
                "name" => "Portineria",
                "icon" => "<i class='fa-solid fa-door-closed'></i>"
            ],
            [
                "name" => "Posto auto",
                "icon" => "<i class='fa-solid fa-car'></i>"
            ],
            [
                "name" => "Sauna",
                "icon" => "<i class='fa-solid fa-person-booth'></i>"
            ],
            [
                "name" => "Vista mare",
                "icon" => "<i class='fa-solid fa-water'></i>"
            ],
        ];

        foreach ($services as $service) {
            $newService = new Service();

            $newService->name = $service['name'];
            $newService->icon = $service['icon'];

            $newService->save();
        }
    }
}
