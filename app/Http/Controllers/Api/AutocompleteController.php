<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    public function autocompleteAddress(Request $request)
    {
        // Ottieni il valore della query dall'input del client
        $query = $request->input('query');

        // Imposta la chiave API di TomTom
        $apiKey = 'N4I4VUaeK36jrRC3vR5FfWqJS6fP6oTY';

        // Crea un'istanza del client GuzzleHTTP
        $client = new Client();

        // Effettua una richiesta GET all'API di TomTom per cercare gli indirizzi
        $response = $client->request(
            'GET',
            'https://api.tomtom.com/search/2/geocode/Via-Napoli.json?key=N4I4VUaeK36jrRC3vR5FfWqJS6fP6oTY',
            //  [
            //     'query' => [
            //         'key' => $apiKey,
            //     ]
            // ]
        );

        // Decodifica la risposta JSON ricevuta dall'API di TomTom
        $data = json_decode($response->getBody(), true);

        // Inizializza un array per contenere gli indirizzi ottenuti
        $addresses = [];

        // Itera su ogni risultato della ricerca per estrarre gli indirizzi completi
        foreach ($data['results'] as $result) {
            $addresses[] = $result['address']['freeformAddress'];
        }


        // Restituisci l'array degli indirizzi completi
        return $addresses;
    }
}
