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

        foreach ($services as $service) {
            $newService = new Service();

            $newService->name = $service;

            $newService->save();
        }
    }
}
