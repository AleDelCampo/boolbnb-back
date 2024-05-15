<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StreetController extends Controller
{
    function autoComplete(){

        $query = $_GET['query'];
        $res = file_get_contents('https://api.tomtom.com/search/2/geocode/'.Str::slug($query).'.json?key=N4I4VUaeK36jrRC3vR5FfWqJS6fP6oTY');
        $res = json_decode($res,true);

        return response()->json([
            'succes'=>true,
            'result'=>$res
        ]);
        


    }
}
