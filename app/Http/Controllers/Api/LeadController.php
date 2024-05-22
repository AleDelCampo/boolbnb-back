<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewContact;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function store(Request $request) {

        // validazioni
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'mail_address' => 'required|email',
            'message' => 'required',


            // test
            'apartment_id' => 'nullable'

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
        $newLead = new Lead();
        $newLead->fill($request->all());
        $newLead->save();


        // invio della mail
        Mail::to('pool.gutierrezv@gmail.com')->send(new NewContact($newLead));


        // risposta client

        //restituiamo json con success true
        return response()->json([
            'success' => true,
            'request' => $request->all(),
        ]);

    }
}
