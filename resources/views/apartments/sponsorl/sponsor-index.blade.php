@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sponsorizzazioni per {{ $apartment->title }}</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
        <thead>
            
            <tr>
                <th>Appartamento</th>
                <th>Pacchetto</th>
                <th>Durata</th>
                <th>Data Fine</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach($sponsorships as $sponsorship)
            
                <tr> 
                    <td>{{ $apartment->title }}</td>

                    <td>{{ $sponsorship->title }}</td>
                    <td>{{ $sponsorship->h_duration }} ore</td>
                    <td>{{ $sponsorship->pivot->end_sponsorship }}</td>
                
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

