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
        // Ottengo il numero di stanze
        $rooms = $request->input('rooms');
        $beds = $request->input('beds');
        $bathrooms = $request->input('bathrooms');
        $sqMeters = $request->input('sqMeters');


        $apartments = DB::table('apartments')

            //filtri: quando viene trovato il campo effettua il filtro per quel campo

            ->when($rooms, function (DatabaseQueryBuilder $query, int $rooms) {
                $query->where('n_rooms', $rooms);
            })
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

        $services = Apartment::with('services')->get();


        return response()->json([
            'succes' => true,
            'results' => $apartments,
            'services' => $services


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
        // $services = Service::all();

        $services = $request->input('ids');

        $apartments = Apartment::with('services')
            ->where('ids', '=', $services)

            ->get();




        // $services = Apartment::with('services')->get();

        return response()->json([
            'succes' => true,
            'results' => $apartments
        ]);
    }
}
