<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Database\Query\Builder as DatabaseQueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    // Metodo per cercare appartamenti in base alla posizione
    public function filter(Request $request)
    {
        // Ottengo il numero di stanze
        $rooms = $request->input('rooms');
        $beds = $request->input('beds');
        $bathrooms = $request->input('bathrooms');
        $sqMeters = $request->input('sqMeters');


        // if (isset($rooms)) {
        //     $apartments = Apartment::where('n_rooms', '=', $request->input('rooms'))->get();
        // } else {
        //     // $apartments = Apartment::all();
        //     if (isset($beds)) {
        //         $apartments = Apartment::where('n_beds', '=', $request->input('beds'))->get();
        //     } else {
        //         // $apartments = Apartment::all();
        //         if (isset($bathrooms)) {
        //             $apartments = Apartment::where('n_bathrooms', '=', $request->input('bathrooms'))->get();
        //         } else {
        //             // $apartments = Apartment::all();
        //             if (isset($sqMeters)) {
        //                 $apartments = Apartment::where('squared_meters', '=', $request->input('sqMeters'))->get();
        //             } else {
        //                 $apartments = Apartment::all();
        //             }
        //         }
        //     }
        // }

        // $users = DB::table('users')
        //         ->when($role, function (Builder $query, string $role) {
        //             $query->where('role_id', $role);
        //         })
        //         ->get();



        $apartments = DB::table('apartments')
            // ->when($rooms, function (Builder $query, int $rooms) {
            //     $query->where('n_rooms', (int) $rooms);
            // })

            ->when($rooms, function (DatabaseQueryBuilder $query, int $rooms) {
                $query->where('n_rooms', $rooms);
            })
            // ->where('n_beds', '=', $beds)
            ->when($beds, function (DatabaseQueryBuilder $query, int $beds) {
                $query->where('n_beds', $beds);
            })
            ->when($bathrooms, function (DatabaseQueryBuilder $query, int $bathrooms) {
                $query->where('n_bathrooms', $bathrooms);
            })
            ->when($sqMeters, function (DatabaseQueryBuilder $query, int $sqMeters) {
                $query->where('squared_meters', $sqMeters);
            })
            ->get();



        return response()->json([
            'succes' => true,
            'result' => $apartments

        ]);
    }
}

// $users = DB::table('users')
//                 ->when($role, function (Builder $query, string $role) {
//                     $query->where('role_id', $role);
//                 })
//                 ->get();