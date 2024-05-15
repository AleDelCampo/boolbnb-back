@extends('layouts.app')

@section('content')

<body class="bg-create">

  <div class="container py-4">
    <h1>Inserisci il tuo Appartamento!!</h1>

    <form action="{{route('apartments.store')}}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="mb-2">
        <label for="title" class="form-label">Nome struttura: </label>
        <input type="text" class="form-control" id="title" name="title"
          value="{{ old('title') }}" required>
      </div>

      <div class="mb-2">
        <label for="description" class="form-label">Descrizione struttura: </label>
        <textarea type="text" class="form-control" id="description"
          name="description" required>{{ old('description') }}</textarea>
      </div>

      <div class="mb-2">
        <label for="address" class="form-label">Indirizzo: </label>
        <input type="text" class="form-control" id="address" name="address">
      </div>

      <div class="mb-2">
        <label for="image" class="form-label">Anteprima: </label>
        <input type="file" class="form-control" id="image" name="image">
      </div>

      <div class="mb-2">
        <label for="n_rooms" class="form-label">Numero stanze: </label>
        <input type="number" class="form-control" id="n_rooms" name="n_rooms">
      </div>

      <div class="mb-2">
        <label for="n_beds" class="form-label">Numero letti: </label>
        <input type="number" class="form-control" id="n_beds" name="n_beds">
      </div>

      <div class="mb-2">
        <label for="n_bathrooms" class="form-label">Numero bagni: </label>
        <input type="number" class="form-control" id="n_bathrooms" name="n_bathrooms">
      </div>

      <div class="mb-2">
        <label for="squared_meters" class="form-label">Metri quadri: </label>
        <input type="number" class="form-control" id="squared_meters" name="squared_meters">
      </div>

      
      <div>Vuoi rendere visibile l'appartamento?</div>

      <div class="form-check">
        <input class="form-check-input" type="radio" name="is_visible" id="is_visible1" value="1">
        <label class="form-check-label" for="is_visible1">
          Sì
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="is_visible" id="is_visible2" value="0">
        <label class="form-check-label" for="is_visible2">
          No
        </label>
      </div>
      
      
      <div class="mb-4">
        <label class="mb-2" for="">Servizi</label>
        <div class="d-flex gap-4">
          
          @foreach($services as $service)
          <div class="form-check ">

            <input 
            type="checkbox" 
            name="services[]"
            value="{{$service->id}}" 
            class="form-check-input" 
            id="service-{{$service->id}}"
            {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
            > 
            
            <label for="service-{{$service->id}}" class="form-check-label">{{$service->name}}</label>

          </div>
          @endforeach

        </div>

      </div>

      <button type="submit" class="btn btn-primary"></i>Registra!!</button>

    </form>
  </div>

</body>
@endsection