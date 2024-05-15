<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:100',
            'description' => 'max:8000',
            'image' => 'file|max:2048|nullable|mimes:jpg,png',
            'n_rooms' => 'required|max:100',
            'n_beds' => 'required|max:100',
            'n_bathrooms' => 'required|max:100',
            'squared_meters' => 'required|max:4000',
            'address' => 'required|max:100',
            'service_id' => 'nullable|exists:services,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Inserisci nome Albergo',
            'title.max' => "Puoi usare al massimo :max caratteri",
            'description.max' => "Puoi usare al massimo :max caratteri",
            'image.mimes' => "Inserisci un immagine",
            'image.max' => "Peso limite 2048 KB",
            'n_rooms.required' => 'Inserisci almeno una stanza',
            'n_rooms.max' => ':max stanze',
            'n_beds.required' => 'Inserisci almeno un posto letto',
            'n_beds.max' => ':max letti',
            'n_bathrooms.required' => 'Inserisci almeno un bagno',
            'n_bathrooms.max' => ':max bathrooms',
            'squared_meters.required' => 'Inserisci area Albergo',
            'squared_meters.max' => 'Area massima di :max metri quadrati',
            'address.required' => 'Inserisci un indirizzo valido',
            'address.max' => 'Non credo esistano vie lunghe :max caratteri!!',
            'service_id.exists' => "PERCHE' NON PROVI AD HACKERARMI I ....",
        ];
    }
}
