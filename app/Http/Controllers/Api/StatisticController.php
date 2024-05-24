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
}
