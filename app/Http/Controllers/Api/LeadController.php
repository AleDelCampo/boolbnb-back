<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function store(Request $request) {

        // validazioni
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'mail_address' => 'required|email',
            'message' => 'required'
        ], [
            'name.required' => "Devi inserire il tuo nome",
            'surname.required' => "Devi inserire il tuo cognome",
            'mail_address.required' => "Devi inserire la tua email",
            'mail_address.email' => "Devi inserire una email corretta",
            'message.required' => "Devi inserire un messaggio",
        ]);


        // validazione non di successo
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        // salvataggio nel db


        // invio della mail

        // risposta client

        //restituiamo json con success true
        return response()->json([
            'success' => true,
        ]);

    }
}
