<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Sponsorship;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{
    // Mostra il form per creare una nuova sponsorizzazione
    public function index(Apartment $apartment)
    {
        $sponsorships = Sponsorship::all();
        $apartments = Apartment::all();


        return view('apartments.sponsorl.sponsor-index', compact('apartment', 'sponsorships', 'apartments'));
    }

    public function create(Apartment $apartment)
    {
        // Recupera tutti i pacchetti di sponsorizzazione disponibili
        $sponsorships = Sponsorship::all();

        // Recupera tutti gli appartamenti disponibili
        $apartments = Apartment::all();

        // Restituisce la vista con il form per creare una sponsorizzazione,
        // passando i dati relativi all'appartamento e ai pacchetti di sponsorizzazione
        return view('apartments.sponsorl.sponsor', compact('apartment', 'sponsorships', 'apartments'));
    }

    // Salva la sponsorizzazione
    public function store(Request $request, $slug)
    {
        // Trova l'appartamento per slug
        $apartment = Apartment::where('slug', $slug)->firstOrFail();

        // Controlla se l'appartamento è già sponsorizzato
        if ($this->isApartmentSponsored($apartment)) {
            return redirect()->back()->withErrors('Questo appartamento è già sponsorizzato.');
        }

        // Trova il pacchetto di sponsorizzazione specificato nel form tramite il suo ID
        $sponsorship = Sponsorship::findOrFail($request->sponsorship_id);

        // Aggiungi la sponsorizzazione all'appartamento (trattamento pivot table)
        $apartment->sponsorships()->attach($sponsorship->id, [
            'start_sponsorship' => now(),
            'end_sponsorship' => now()->addHours($sponsorship->h_duration),
        ]);

        // Effettua il redirect alla pagina di pagamento con i dettagli necessari
        return redirect()->route('payment.show', ['apartment_id' => $apartment->id, 'sponsorship_id' => $sponsorship->id]);
    }

    private function isApartmentSponsored($apartment)
    {
        return $apartment->sponsorships()->exists();
    }


    // Mostra i dettagli della sponsorizzazione
    public function show($slug)
    {
        $apartment = Apartment::where('slug', $slug)->firstOrFail();
        $sponsorships = $apartment->sponsorships;
        return view('apartments.sponsorl.sponsor-show', compact('apartment', 'sponsorships'));
    }

    public function removeExpiredSponsorships()
    {
        $now = Carbon::now();
        Apartment::whereHas('sponsorships', function ($query) use ($now) {
            $query->where('end_sponsorship', '<', $now);
        })->each(function ($apartment) use ($now) {
            $apartment->sponsorships()->wherePivot('end_sponsorship', '<', $now)->detach();
        });

        return response()->json(['status' => 'success']);
    }
}




    
    