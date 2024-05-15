@extends('layouts.app')

@section('content')

<body class="bg-create">
  
  <div class="container py-4">
    <h1>Inserisci il tuo Appartamento!!</h1>
    
    
    <form action="{{route('admin.apartments.store')}}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="mb-2">
        <label for="title" class="form-label">Nome struttura: </label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
          value="{{ old('title') }}" required>
        @error('title')
        <div class="invalid-feedback">
          {{$message}}
        </div>
        @enderror
      </div>

      <div class="mb-2">
        <label for="description" class="form-label">Descrizione struttura: </label>
        <textarea type="text" class="form-control @error('description') is-invalid @enderror" id="description"
          name="description" required>{{ old('description') }}</textarea>
           @error('description')
        <div class="invalid-feedback">
          {{$message}}
        </div>
        @enderror
      </div>


      <div class="mb-2">
        <label for="address" class="form-label">Indirizzo: </label>
        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" onkeyup="handleKeyUp('ciao')">
        
        @error('address')
        <div class="invalid-feedback">
          {{$message}}
        </div>
        @enderror
      </div>

      <div class="mb-2">
        <label for="image" class="form-label">Anteprima: </label>
        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
        @error('image')
        <div class="invalid-feedback">
          {{$message}}
        </div>
        @enderror
      </div>

      <div class="mb-2">
        <label for="n_rooms" class="form-label">Numero stanze: </label>
        <input type="number" class="form-control @error('n_rooms') is-invalid @enderror" id="n_rooms" value="{{ old('n_rooms') }}" name="n_rooms">
        @error('n_rooms')
        <div class="invalid-feedback">
          {{$message}}
        </div>
        @enderror
      </div>

      <div class="mb-2">
        <label for="n_beds" class="form-label">Numero letti: </label>
        <input type="number" class="form-control @error('n_beds') is-invalid @enderror" id="n_beds" value="{{ old('n_beds') }}" name="n_beds">
        @error('n_beds')
        <div class="invalid-feedback">
          {{$message}}
        </div>
        @enderror
      </div>

      <div class="mb-2">
        <label for="n_bathrooms" class="form-label">Numero bagni: </label>
        <input type="number" class="form-control @error('n_bathrooms') is-invalid @enderror" id="n_bathrooms" value="{{ old('n_bathrooms') }}" name="n_bathrooms">
        @error('n_bathrooms')
        <div class="invalid-feedback">
          {{$message}}
        </div>
        @enderror
      </div>

      <div class="mb-2">
        <label for="squared_meters" class="form-label">Metri quadri: </label>
        <input type="number" class="form-control @error('squared_meters') is-invalid @enderror" id="squared_meters" value="{{ old('squared_meters') }}" name="squared_meters">
        @error('squared_meters')
        <div class="invalid-feedback">
          {{$message}}
        </div>
        @enderror
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

<script>


  function handleKeyUp(event) {

    const input = document.getElementById('address').value;

  axios.get('http://127.0.0.1:8000/api/autocomplete-address?query=' + input)
    .then(response => {
      console.log(response.data);
    })
    .catch(error => {
      console.error(error);
    });
}

</script>
@endsection