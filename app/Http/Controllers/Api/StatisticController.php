<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visit;


class StatisticController extends Controller
{
    public function counter() {
        $year = $_GET['year'];
        $month = $_GET['month'];
        $visits = Visit::whereYear('timestamp_visit',$year)->whereMonth('timestamp_visit',$month)->count();

        return response()->json([
            'success' => true,
            'result' => $visits,
        ]);

    }

    public function store(Request $request){

        $newVisit = new Visit();

        $newVisit['timestamp_visit'] = date('Y-m-d');
        $newVisit['ip_address'] = $request->ip;
        $newVisit['apartment_id'] = $request->apartment;

        $newVisit->save();

        return response()->json([
            'success' => true,
            'result' => 'siumm'
        ]);

    }
}
