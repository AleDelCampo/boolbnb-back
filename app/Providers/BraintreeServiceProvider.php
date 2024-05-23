<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Braintree\Gateway;

class BraintreeServiceProvider extends ServiceProvider
{
    // Metodo per registrare il servizio Braintree
    public function register()
    {
        // Definizione di un singleton per il gateway Braintree
        $this->app->singleton(Gateway::class, function ($app) {
            // Creazione di una nuova istanza del gateway Braintree
            return new Gateway([
                'environment' => config('services.braintree.environment'), // Ambiente di lavoro (sandbox o produzione)
                'merchantId' => config('services.braintree.merchantId'),   // ID del commerciante
                'publicKey' => config('services.braintree.publicKey'),     // Chiave pubblica
                'privateKey' => config('services.braintree.privateKey'),   // Chiave privata
            ]);
        });
    }

    // Metodo boot, non implementato in questo caso
    public function boot()
    {
        // Non ci sono operazioni specifiche da eseguire durante il booting
    }
}
