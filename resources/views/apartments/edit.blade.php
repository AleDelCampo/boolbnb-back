@extends('layouts.app')

@section('content')

<body class="bg-edit">

    <div class="container py-4">
        <h1>Modifica il tuo Appartamento!!</h1>

        <form action="{{route('admin.apartments.update', $apartment)}}" method="POST">
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

            <div class="mb-2">
                <label for="address" class="form-label">Indirizzo: </label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address">
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
                <input type="number" class="form-control @error('n_rooms') is-invalid @enderror" id="n_rooms" name="n_rooms">
                @error('n_rooms')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="n_beds" class="form-label">Numero letti: </label>
                <input type="number" class="form-control @error('n_beds') is-invalid @enderror" id="n_beds" name="n_beds">
                @error('n_beds')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="n_bathrooms" class="form-label">Numero bagni: </label>
                <input type="number" class="form-control @error('n_bathrooms') is-invalid @enderror" id="n_bathrooms" name="n_bathrooms">
                @error('n_bathrooms')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="squared_meters" class="form-label">Metri quadri: </label>
                <input type="number" class="form-control @error('squared_meters') is-invalid @enderror" id="squared_meters" name="squared_meters">
                @error('squared_meters')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div>Vuoi oscurare l'appartamento?</div>

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

                        <input type="checkbox" name="services[]" value="{{$service->id}}" class="form-check-input"
                            id="service-{{$service->id}}" {{ in_array($service->id, old('services', [])) ? 'checked' :
                        '' }}
                        >

                        <label for="service-{{$service->id}}" class="form-check-label">{{$service->name}}</label>

                    </div>
                    @endforeach

                </div>

            </div>

            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-arrows-rotate"></i> Registra!!</button>

        </form>
    </div>

</body>
@endsection