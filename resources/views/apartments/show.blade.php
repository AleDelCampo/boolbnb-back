@extends('layouts.app')

@section('content')

<div class="container">

{{-- @dd($apartment); --}}

    <div class="card">
        {{-- link apartment image --}}
        <img src="{{asset('storage/' . $apartment->image)}}" class="card-img-top" alt="immagine dell'appartamento">
        <div class="card-body">
            <h5 class="card-title">{{$apartment->title}}</h5>

            <h6 class="mb-3">
                Proprietario: {{$apartment->user->name}}
            </h6>
            
            {{-- room services --}}
            <strong>
                Servizi
            </strong>
            <ul class="d-flex gap-4">
                @foreach($apartment->services as $services)
                <li>
                    {{$services->name}}
                </li>
                @endforeach
            </ul>
            {{-- room infos --}}
            <div class="d-flex gap-3 mb-3">
                <div class="m2">
                    Grandezza: {{$apartment->squared_meters}}m²
                </div>
                <div class="rooms">
                    Stanze: {{$apartment->n_rooms}}
                </div>
                <div class="beds">
                   Posti letto: {{$apartment->n_beds}}
                </div>
                <div class="bathrooms">
                    Bagni: {{$apartment->n_bathrooms}}
                </div>
            </div>

            {{-- room description --}}
            <p>
                {{$apartment->description}}
            </p>

            {{-- room position --}}
            <div class="position">
                {{$apartment->address}}
            </div>
        </div>
        <div class="card-footer">
            {{-- link to room edit page --}}
            <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-outline-warning">Modifica</a>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteRoomModal">
                Elimina
            </button>
            <!-- Modal -->
            <div class="modal fade" id="deleteRoomModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5">Eliminazione appartamento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Sei sicuro di voler eliminare il tuo appartamento?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <form action="{{route('admin.apartments.destroy', $apartment)}}" method="POST">
                        @csrf
                        @method("DELETE")
                        <button class="btn btn-primary">Elimina</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
    
</div>

@endsection











  