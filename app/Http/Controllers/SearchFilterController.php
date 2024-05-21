<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;

class SearchFilterController extends Controller
{
    public function filter(Request $request){

        $n_rooms=null;
        $n_bath=null;
        $n_beds=null;
        $n_square=null;

        if($request->filled('n_rooms')){
            $n_rooms = $request->query('n_rooms');
        }

        if($request->filled('n_bath') )
        {
            $n_bath = $request->query('n_bath');
        }
        if($request->filled('m_beds'))
        {
            $n_beds = $request->query('m_beds');
        }
        if($request->filled('n_square'))
        {
            $n_square = $request->query('n_square');
        }

        $apartments = Apartment::when($n_rooms, function($query, $n_rooms){
            return $query->where('n_rooms', $n_rooms);
        })->when($n_bath, function($query, $n_bath){
            return $query->where('n_bath', $n_bath);
        })->when($n_beds, function($query, $n_beds){
            return $query->where('n_beds', $n_beds);
        })->when($n_beds, function($query, $n_square){
            return $query->where('n_square', $n_square);
        });

        return response()->json([
            "success" => true,
            "results" => $apartments
        ]);

    }
}
