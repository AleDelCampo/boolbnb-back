@extends('layouts.app')

@section('content')

<section id="main">
    <div class="container py-2">

        <a href="{{route('admin.apartments.show', $slug)}}" class="btn my_bg_color mt-1">Torna</a>

        <h1 class="p-2">Messaggi</h1>
        
        <div class="container">
            <div class="row p-5 justify-content-center form-container rounded rounded-3">
                @forelse ($leads as $lead)
                <div id="" class="mb-3 border rounded rounded-2 bg-light">
                    <div class="row p-1 m-1">
                        <div class="row p-2">
                            <div class="col-3">
                                <div class="pt-1 pb-2">
                                    <div>   
                                        <strong>
                                            {{$lead->name}} {{$lead->surname}}
                                        </strong>
                                    </div>
                                    <div>
                                        <small>
                                            Email: {{$lead->mail_address}}
                                        </small>
                                    </div>
                                </div>
                                <div>
                                    <small>Ricevuto: {{$lead->created_at}}</small>
                                </div>
                            </div>

                            <div class="col-9">
                                <h6>
                                    <strong>Messaggio:</strong>
                                </h6>
                                <div>
                                    {{$lead->message}}
                                </div>
                            </div>
                            {{-- <div class="col-3 d-flex justify-content-end align-items-center">
                                <div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center">
                    Nessun messaggio
                    <hr>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</section>

@endsection
