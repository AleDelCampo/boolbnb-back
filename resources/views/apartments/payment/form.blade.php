@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modulo di Pagamento</h1>
    <form action="{{ route('payment.process') }}" method="POST">
        @csrf
        <!-- Campi per il modulo di pagamento -->
        <input type="hidden" name="apartment_id" value="{{ $apartment_id }}">
        <input type="hidden" name="sponsorship_id" value="{{ $sponsorship_id }}">
        <input type="hidden" name="price" value="{{ $price }}">
        <!-- Aggiungi altri campi per i dettagli del pagamento -->
        <button type="submit" class="btn btn-primary">Procedi al pagamento</button>
    </form>
</div>
@endsection

