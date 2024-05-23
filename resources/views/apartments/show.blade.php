@extends('layouts.app')

@section('content')

<div class="container pb-4">

    {{-- @dd($apartment); --}}
    
    <div class="card mt-4">
        <div class="d-flex">
            <div class="card-body col-6">
                {{-- link apartment image --}}
                <img src="{{asset('storage/' . $apartment->image)}}" class="card-img-top" alt="immagine dell'appartamento" style="max-width: 100%">
            </div>
            
            <div class="card-body col-6">
                <div class="mb-3">
                    <h2 class="card-title"><strong>{{$apartment->title}}</strong></h2>
    
                    {{-- room infos --}}
                    <div class="d-flex gap-3 mb-3">
                        <small>
                        <span class="m2">
                            {{$apartment->squared_meters}}m²
                        </span>
                        -
                        <span class="rooms">
                            {{$apartment->n_rooms}} camera da letto
                        </span>
                        -
                        <span class="beds">
                            {{$apartment->n_beds}} posti letto
                        </span>
                        -
                        <span class="bathrooms">
                            {{$apartment->n_bathrooms}} bagni
                        </span>
                        </small>
                    </div>
    
                    <hr>
    
                    <div class="mb-3">
                        Proprietario: {{$apartment->user->name}}
                    </div>
                </div>
    
                <hr>
                
                {{-- room description --}}
                <p>
                    {{$apartment->description}}
                </p>
    
                <hr>
                
                {{-- room services --}}
                <strong class="mb-3">
                    Servizi
                </strong>
                <ul id="services-list" class="d-flex gap-5">
                    @foreach($apartment->services as $services)
                    <li>
                        {{$services->name}}
                    </li>
                    @endforeach
                </ul>
                
                <hr>
    
                {{-- room position --}}
                <div class="position">
                    {{$apartment->address}}
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-center p-3 gap-3">
            {{-- link to room edit page --}}
            <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-outline-warning">Modifica</a>

            <a href="{{route('leads.index', $apartment->id)}}" class="btn btn-outline-warning">Messaggi</a>


            <!-- Button trigger modal -->
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteRoomModal">
                Elimina
            </button>
            <a href="{{route('admin.apartments.index', $apartment)}}" class="btn btn-outline-success">Homepage</a>

            <!-- Modal -->
            <div class="modal fade" id="deleteRoomModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5">{{$apartment->title}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Sei sicuro di voler eliminare l'appartamento {{ $apartment->title }}?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <form action="{{route('admin.apartments.destroy', $apartment)}}" method="POST">
                        @csrf
                        @method("DELETE")
                        <button class="btn btn-danger">Elimina</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
    
</div>

<style>
body {
    background-color: #5F8B8D;
}

#services-list {
    list-style-type: none;
}

</style>

@endsection











  