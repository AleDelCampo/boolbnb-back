@extends('layouts.app')

@section('content')    
<h1>Prova</h1>

<div class="container">
    @forelse ($leads as $lead)
        
    <div class="py-3">
        <div>
            {{$lead->name}} {{$lead->surname}}
        </div>
        <div>
            {{$lead->mail_address}}
        </div>
        <div>
            {{$lead->message}}
        </div>
    </div>
    @empty
    <div class="text-center">
        Nessun messaggio
        <hr>
    </div>
    @endforelse
@endsection
