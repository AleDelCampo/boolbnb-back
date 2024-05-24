@extends('layouts.app')

@section('content')

<section>
    <div class="container py-4">
        <h1>Messaggi</h1>
        
        <div class="container">
            <div class="row p-0">
                @forelse ($leads as $lead)
                <div id="tile" class="col-11 m-3 border border-dark">
                    <div class="row p-3 my-3">
                        <div class="row">
                            <div class="col-3">
                                <div class="fw-bold pt-1pb-2">
                                    {{$lead->name}} {{$lead->surname}}
                                </div>
                                <div>
                                    <small>
                                        Email: {{$lead->mail_address}}
                                    </small>
                                </div>
                                <div>
                                    <small>
                                        Ricevuto: {{$lead->created_at}}
                                    </small>
                                </div>
                            </div>

                            <div class="col-8">
                                <h6>Messaggio:</h6>
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
