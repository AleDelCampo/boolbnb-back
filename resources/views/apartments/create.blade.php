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
        <label for="n-rooms" class="form-label">Numero stanze: </label>
        <input type="number" class="form-control" id="n-rooms" name="n-rooms">
      </div>

      <div class="mb-2">
        <label for="n-beds" class="form-label">Numero letti: </label>
        <input type="number" class="form-control" id="n-beds" name="n-beds">
      </div>

      <div class="mb-2">
        <label for="n-bathrooms" class="form-label">Numero bagni: </label>
        <input type="number" class="form-control" id="n-bathrooms" name="n-bathrooms">
      </div>

      <div class="mb-2">
        <label for="squared-meters" class="form-label">Metri quadri: </label>
        <input type="number" class="form-control" id="squared-meters" name="squared-meters">
      </div>

      <button type="submit" class="btn btn-primary"></i>Registra!!</button>

    </form>
  </div>

</body>
@endsection