<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Sponsorship;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Metodo per visualizzare il modulo di pagamento 
    public function show(Request $request)
    {
        // Recupera i dettagli necessari dal request
        $apartment_id = $request->input('apartment_id');
        $sponsorship_id = $request->input('sponsorship_id');

        // Trova il prezzo del pacchetto di sponsorizzazione
        $sponsorship = Sponsorship::findOrFail($sponsorship_id);
        $price = $sponsorship->price;

        // Passa i dettagli del pagamento alla vista
        // Passiamo anche l'oggetto apartment per utilizzarlo nella vista di pagamento
        return view('apartments.payment.form', compact('apartment_id', 'sponsorship_id', 'price'));
    }

    public function process(Request $request)
    {
        // Recupera i dati necessari dal request
        $apartment_id = $request->input('apartment_id');
        $sponsorship_id = $request->input('sponsorship_id');

        // Trova il prezzo del pacchetto di sponsorizzazione
        $sponsorship = Sponsorship::findOrFail($sponsorship_id);
        $h_duration = $sponsorship->h_duration;

        // Imposta la data di inizio della sponsorizzazione come l'ora corrente
        $start_sponsorship = now();

        // Converte l'orario in ore, minuti e secondi
        list($hours, $minutes, $seconds) = explode(':', $h_duration);
        $start_sponsorship = Carbon::parse($start_sponsorship);

        // Calcola la data di fine della sponsorizzazione aggiungendo la durata del pacchetto di sponsorizzazione
        $end_sponsorship = $start_sponsorship->copy()->addHours($hours)->addMinutes($minutes)->addSeconds($seconds);

        // Salva la sponsorizzazione nel database evitando duplicati
        $apartment = Apartment::findOrFail($apartment_id);
        $existingSponsorship = $apartment->sponsorships()
            ->where('sponsorship_id', $sponsorship_id)
            ->first();

        if ($existingSponsorship) {
            // Se già esiste, aggiornalo
            $apartment->sponsorships()->updateExistingPivot($sponsorship_id, [
                'start_sponsorship' => $start_sponsorship,
                'end_sponsorship' => $end_sponsorship,
            ]);
        } else {
            // Altrimenti, attaccalo
            $apartment->sponsorships()->attach($sponsorship_id, [
                'start_sponsorship' => $start_sponsorship,
                'end_sponsorship' => $end_sponsorship,
            ]);
        }

        // Passa i dati necessari per la vista success
        return redirect()->route('payment.success')
            ->with([
                'apartment' => $apartment,
                'sponsorships' => $apartment->sponsorships
            ]);
    }

    // Metodo per visualizzare la pagina di successo del pagamento (demo)
    public function success()
    {
        // Recupera l'oggetto apartment dalla sessione
        $apartment = session('apartment');
        $sponsorships = session('sponsorships');

        // Verifica che apartment non sia null
        if (!$apartment || !$sponsorships) {
            return redirect()->route('home')->withErrors('Dati non trovati per visualizzare la sponsorizzazione.');
        }

        return view('apartments.sponsorl.sponsor-show', compact('apartment', 'sponsorships'));
    }
}

