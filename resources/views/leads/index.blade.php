@extends('layouts.app')

@section('content')    
<h1>Prova</h1>

<div class="container">
    @forelse ($leads as $lead)
        
    <div>
        <div>
            {{$lead->name}}
        </div>
        <div>
            {{$lead->surname}}
        </div>
    </div>
    @empty
    <div class="text-center">
        Nessun messaggio
        <hr>
    </div>
    @endforelse
@endsection
