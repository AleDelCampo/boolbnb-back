<?php

namespace App\Http\Controllers;

use App\Models\Apartment;

use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $services = Service::all();
        // dd($services);

        // prelevo tutti i tag dal database e li passo alla vista

        return view('apartments.create', compact('services'));

        // return view('apartments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {
        $request->validated();

        $newApartment = new Apartment();

        if ($request->hasFile('image')) {

            $path = Storage::disk('public')->put('bnb_images', $request->image);

            $newApartment->image = $path;
        }

        $newApartment->fill($request->all());

        //collegamento appartamento al'utente che si è loggato
        $newApartment->user_id = Auth::id();

        $newApartment->save();

        //inserimento dati in tabella ponte
        $newApartment->services()->attach($request->services);

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        return view('apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return redirect()->route('admin.apartments.index');
    }
}
