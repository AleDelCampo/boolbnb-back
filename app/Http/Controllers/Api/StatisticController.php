<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visit;


class StatisticController extends Controller
{
    public function counter() {
        $visits = Visit::count();

        return response()->json([
            'success' => true,
            'result' => $visits,
        ]);

    }
}
