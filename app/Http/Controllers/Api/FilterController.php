<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Database\Query\Builder as DatabaseQueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    // Metodo per cercare appartamenti in base alla posizione
    public function filter(Request $request)
{
    // Ottenere latitudine e longitudine dalla richiesta
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $radius = $request->input('radius', 20); // Raggio in km, di default 20 km

    $rooms = $request->input('rooms');
    $beds = $request->input('beds');
    $bathrooms = $request->input('bathrooms');
    $sqMeters = $request->input('sqMeters');
    $services = $request->input('services');
    $apartments = Apartment::selectRaw("*, (
        6371 * acos(
            cos(radians(?)) *
            cos(radians(latitude)) *
            cos(radians(longitude) - radians(?)) +
            sin(radians(?)) *
            sin(radians(latitude))
        )
    ) AS distance", [$latitude, $longitude, $latitude])
        ->when($rooms, function ($query, $rooms) {
            $query->where('n_rooms', $rooms);
        })
        ->when($beds, function ($query, $beds) {
            $query->where('n_beds', $beds);
        })
        ->when($bathrooms, function ($query, $bathrooms) {
            $query->where('n_bathrooms', $bathrooms);
        })
        ->when($sqMeters, function ($query, $sqMeters) {
            $query->where('squared_meters', $sqMeters);
        })
        ->when($services, function ($query, $services) {
            $query->whereHas('services', function ($subQuery) use ($services) {
                $subQuery->whereIn('id', $services);
            });
        })
        ->having('distance', '<', $radius)  //Seleziona solo gli appartameti in cui il valore della colonna distance è inferiore al valore del raggio specificato dall'utente.
        ->orderBy('distance')
        ->get();

    return response()->json([
        'success' => true,
        'results' => $apartments
    ]);
}

    public function service()
    {
        $services = Service::all();
        return response()->json([
            'success' => true,
            'results' => $services
        ]);
    }

    public function serviceFilter(Request $request)
{
    $services = $request->input('services');

    $apartments = Apartment::with('services')
        ->whereHas('services', function ($query) use ($services) {
            $query->whereIn('id', $services);
        })
        ->get();

    return response()->json([
        'success' => true,
        'results' => $apartments
    ]);
}
}