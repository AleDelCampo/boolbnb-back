@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pagamento per {{ $title }}</h1>
    <form action="{{ route('payment.process') }}" method="POST">
        @csrf
        <input type="hidden" name="apartment_id" value="{{ $apartment_id }}">
        <input type="hidden" name="sponsorship_id" value="{{ $sponsorship_id }}">
        <braintree-drop-in ref="btDropin" :authorization="clientToken" @nonce="getP(() => this.form.submit())"></braintree-drop-in>
        <button type="submit" class="btn btn-primary">Paga €{{ $price }}</button>
    </form>
</div>
@endsection

