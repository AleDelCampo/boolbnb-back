<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Sponsorship;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApartmentSponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            [
                'apartment_id' => 1,
                'sponsorship_id' => 2,
                'start_sponsorship' => '2021-10-03',
                'end_sponsorship' => '2021-11-05'
            ],
            [
                'apartment_id' => 2,
                'sponsorship_id' => 1,
                'start_sponsorship' => '2021-10-03',
                'end_sponsorship' => '2021-11-05'
            ],
            [
                'apartment_id' => 3,
                'sponsorship_id' => 3,
                'start_sponsorship' => '2021-10-03',
                'end_sponsorship' => '2021-11-05'
            ],
        ];

        DB::table('apartment_sponsorship')->insert($data);
    }
}
