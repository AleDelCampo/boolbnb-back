<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index() {

        $apartment = Apartment::all();

        // per ricevere gli apartments con paginazione
        // $apartment = Apartment::paginate(5);

        

        return response()->json([
            "success" => true,
            "results" => $apartment
        ]);

    }
    
    public function show($slug) {

        // possiamo scrivere la stessa cosa in questo modo:
        // ->find() cerca la riga della tabella che abbia la chiave primaria (id) uguale al valore che passiamo tra parentesi
        $apartment = Apartment::with(['sponsorships','services'])->where('slug', $slug)->firstOrFail();

        if($apartment) {
            return response()->json([
                "success" => true,
                "apartment" => $apartment
            ]);

        } else {
            return response()->json([
                "success" => false,
                "error" => "Apartment not found"
            ]);
        }

}
}
