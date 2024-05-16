@extends('layouts.app')

@section('content')

<body class="bg-edit">

    <div class="container py-4">
        <h1>Modifica il tuo Appartamento!!</h1>

        <form action="{{route('admin.apartments.update', $apartment)}}" method="POST" enctype="multipart/form-data">
            @csrf

            @method("PUT")

            <div class="mb-2">
                <label for="title" class="form-label">Nome struttura: </label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                    value="{{ old('title') ?? $apartment->title }}" name=" title" required>
                @error('title')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="description" class="form-label">Descrizione struttura: </label>
                <textarea type="text" class="form-control @error('description') is-invalid @enderror"
                    id="description" name="description"
                    required>{{ old('description') ?? $apartment->description }}</textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="mb-2" id="address-box">
                <label for="address" class="form-label">Indirizzo: </label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" value="{{ old('address') ?? $apartment->address }}"  onkeyup="handleKeyUp()" name="address">
                
                <div class="auto-complete-box hide">
                    <ul id="suggested-roads-list">
                    </ul>
                </div>
                
                @error('address')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="mb-2 bg-black">
                <label for="image" class="form-label">Anteprima: </label>
                <img class="img-size" src="{{ asset('storage/' . $apartment->image) }}" alt="">
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                @error('image')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="n_rooms" class="form-label">Numero stanze: </label>
                <input type="number" class="form-control @error('n_rooms') is-invalid @enderror" id="n_rooms" value="{{ old('n_rooms') ?? $apartment->n_rooms }}" name="n_rooms" min="0" max="100">
                @error('n_rooms')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="n_beds" class="form-label">Numero letti: </label>
                <input type="number" class="form-control @error('n_beds') is-invalid @enderror" id="n_beds" value="{{ old('n_beds') ?? $apartment->n_beds }}" name="n_beds" min="0" max="100">
                @error('n_beds')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="n_bathrooms" class="form-label">Numero bagni: </label>
                <input type="number" class="form-control @error('n_bathrooms') is-invalid @enderror" id="n_bathrooms" value="{{ old('n_bathrooms') ?? $apartment->n_bathrooms }}" name="n_bathrooms" min="0" max="100">
                @error('n_bathrooms')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="squared_meters" class="form-label">Metri quadri: </label>
                <input type="number" class="form-control @error('squared_meters') is-invalid @enderror" id="squared_meters" value="{{ old('squared_meters') ?? $apartment->squared_meters }}" name="squared_meters" min="0" max="100">
                @error('squared_meters')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_visible" id="is_visible" value="true" {{ $apartment->is_visible || old('is_visible') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_visible" style="user-select: none; background-color:rgba(0,0,0,.7)">
                    Vuoi rendere l'appartamento visibile agli utenti?
                </label>
            </div>

            <div class="mb-4">
                <label class="mb-2" for="">Servizi</label>
                <div class="d-flex gap-4">

                    @foreach($services as $service)
                    <div class="form-check ">

                        <input type="checkbox" name="services[]" value="{{$service->id}}" class="form-check-input"
                            id="service-{{$service->id}}" 
                            
                            @if ($errors->any())
                                {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
                            @else
                                {{ $apartment->services->contains($service) ? 'checked' : '' }}
                            @endif
                        >

                        <label for="service-{{$service->id}}" class="form-check-label">{{$service->name}}</label>

                    </div>
                    @endforeach

                </div>

            </div>

            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-arrows-rotate"></i> Registra!!</button>

        </form>
    </div>

    <script>
    
        let streets=[];
      
        function handleKeyUp(event) {
            const UlEle = document.getElementById('suggested-roads-list');
            UlEle.innerHTML='';
          
      
            const input = document.getElementById('address').value;
            // controllo sull'input che non sia vuoto
            if(input.trim()!= ''){

                axios.get('http://127.0.0.1:8000/api/autocomplete-address?query=' + input)
                .then(response => {
                // console.log(response.data);
            
                // inserita l'array dei risultati in un array locale
                streets=response.data.result.results;
            
                console.log(streets);
            
                })
                .catch(error => {
                console.error(error);
                });
            }else{

                document.querySelector('.auto-complete-box').classList.add('hide');

            }

      
      
          console.log(streets.length);
          if(streets.length != 0){
      
      
            for(let i=0; i<streets.length;i++){
      
              const liEl=document.createElement('li');
        
              const divEl=document.createElement('div');
        
              divEl.innerText=streets[i].address.freeformAddress + ', ' + streets[i].address.country;
        
              liEl.append(divEl);
        
              UlEle.append(liEl);
      
              liEl.addEventListener('click', function(){
      
                document.getElementById('address').value = liEl.innerText;
                document.querySelector('.auto-complete-box').classList.add('hide');
      
              });
        
        
            }
      
            document.querySelector('.auto-complete-box').classList.remove('hide');
      
          } else {
      
            document.querySelector('.auto-complete-box').classList.add('hide');
      
          }
      
      }
      
    </script>
</body>

@endsection