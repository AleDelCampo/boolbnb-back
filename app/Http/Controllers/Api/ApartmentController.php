<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    // Metodo per ottenere tutti gli appartamenti
    public function index() {
        $apartments = Apartment::all();
        return response()->json([
            "success" => true,
            "results" => $apartments
        ]);
    }

    // Metodo per ottenere un appartamento specifico tramite slug
    public function show($slug) {
        $apartment = Apartment::with(['sponsorships','services'])->where('slug', $slug)->firstOrFail();
        return response()->json([
            "success" => true,
            "apartment" => $apartment
        ]);
    }

    // Metodo per cercare appartamenti in base alla posizione
    public function search(Request $request) {
        // Ottenere latitudine e longitudine dalla richiesta
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius', 20); // Raggio in km, di default 20 km

        // Query per trovare appartamenti entro un certo raggio utilizzando la formula di Haversine
        $apartments = Apartment::selectRaw("*, (
                6371 * acos(
                    cos(radians(?)) *
                    cos(radians(latitude)) *
                    cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(latitude))
                )
            ) AS distance", [$latitude, $longitude, $latitude])
            ->having('distance', '<', $radius)  //Seleziona solo gli appartameti in cui il valore della colonna distance è inferiore al valore del raggio specificato dall'utente.
            ->orderBy('distance')
            ->get();

        // Restituisce i risultati della ricerca
        return response()->json([
            "success" => true,
            "results" => $apartments
        ]);
    }
}
