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
    $rooms = $request->input('rooms');
    $beds = $request->input('beds');
    $bathrooms = $request->input('bathrooms');
    $sqMeters = $request->input('sqMeters');
    $services = $request->input('services');
    $apartments = Apartment::query()
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
            'succes' => true,
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
