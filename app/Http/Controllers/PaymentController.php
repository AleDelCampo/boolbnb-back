<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Sponsorship;
use Braintree\Gateway;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Metodo per visualizzare il modulo di pagamento  
    public function show(Request $request, Gateway $gateway)
    {
        $apartment_id = $request->input('apartment_id');
        $sponsorship_id = $request->input('sponsorship_id');

        $sponsorship = Sponsorship::findOrFail($sponsorship_id);
        $price = $sponsorship->price;
        $title = $sponsorship->title;

        $clientToken = $gateway->clientToken()->generate();

        return view('apartments.payment.form', compact('apartment_id', 'sponsorship_id', 'price', 'clientToken', 'title'));
    }

    public function process(Request $request)
    {
        $apartment_id = $request->input('apartment_id');
        $sponsorship_id = $request->input('sponsorship_id');

        $sponsorship = Sponsorship::findOrFail($sponsorship_id);
        $apartment = Apartment::findOrFail($apartment_id);

        // Pagamento

        return redirect()->route('payment.success')->with(['apartment' => $apartment, 'sponsorship' => $sponsorship]);
    }

    public function success()
    {
        $apartment = session('apartment');
        $sponsorship = session('sponsorship');

        if (!$apartment || !$sponsorship) {
            return redirect()->route('admin.sponsor.create')->withErrors('Dati non trovati per visualizzare la sponsorizzazione.');
        }

        return view('apartments.sponsorl.sponsor-show', compact('apartment', 'sponsorship'));
    }
}

