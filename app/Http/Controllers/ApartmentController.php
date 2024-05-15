<?php

namespace App\Http\Controllers;

use App\Models\Apartment;

use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;



class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::all();
        return view('apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //prendiamo i servizi da db e le passiamo alla view
        $services = Service::all();

        return view('apartments.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {
        // $request->validated();

        $newApartment = new Apartment();

        if ($request->hasFile('image')) {

            $path = Storage::disk('public')->put('bnb_images', $request->image);

            $newApartment->image = $path;
        }

        $newApartment->fill($request->all());

        $newApartment->slug = Str::slug($newApartment->title);


        //collegamento appartamento al'utente che si è loggato
        $newApartment->user_id = Auth::id();

        $newApartment->save();

        //inserimento dati in tabella ponte
        $newApartment->services()->attach($request->services);

        return redirect()->route('apartments.show', $newApartment->id);
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
        //prendiamo i servizi da db e le passiamo alla view
        $services = Service::all();

        return view('apartments.edit', compact('apartment', 'service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreApartmentRequest $request, Apartment $apartment)
    {
        // $request->validated();


        if ($request->hasFile('image')) {

            $path = Storage::disk('public')->put('bnb_images', $request->image);

            $apartment->image = $path;
        }

        $apartment->slug = Str::slug($request->title);

        $apartment->update($request->all());


        //collegamento appartamento al'utente che si è loggato
        // $apartment->user_id = Auth::id();

        $apartment->save();

        // modifichiamo i services collegati al apartment
        $apartment->services()->sync($request->services);



        return redirect()->route('apartments.show', $apartment->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();

        return redirect()->route('apartment.index');
    }
}
