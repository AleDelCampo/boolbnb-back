@extends('layouts.app') 

@section('content') 
<h1 class="text-center pt-4 ">I miei appartamenti sponsorizzati</h1> 

<div class="cont-spons container p-5 my-3 border rounded-3 shadow-lg "> 
    <div class="card-deck "> 
        
        @if ($apartments->isEmpty()) 
            <div class="alert alert-warning text-center" role="alert"> 
                Non hai appartamenti sponsorizzati al momento.
            </div>
        @else
            @foreach($apartments as $apartment)
                @foreach($apartment->sponsorships as $sponsorship) 
                    <div class="card shadow-lg position-relative sponsorship-card rounded-3 border-0"> 
                        <a href="{{ route('admin.apartments.show', $apartment) }}" > 

                            <img class="card-img-top" src="{{ asset('storage/' . $apartment->image) }}" alt="" style="object-fit: cover; height: 200px; width: 100%;">
                            <div class="overlay-sponsorship px-3 py-1">
                                <div class="row">
                                    
                                    <div class="col-6">
                                        <div class="content py-2">
                                            <h5 class="apartment-title">{{ $apartment->title }}</h5> 
                                            <p>{{ $apartment->address }}</p> 
                                        </div>
                                    </div>
                                    
                                    <div class="col-6 text-end fw-bold">
                                        <div class="content py-2 sponsorship-details  ">
                                            <p>{{ $sponsorship->title }} <span>{{ intval($sponsorship->h_duration) }}h</span></p> 
                                            <p>{{ \Carbon\Carbon::parse($sponsorship->pivot->end_sponsorship)->format('d/m/Y') }}</p> 
                                            <span class="timer-box p-1 border-2 rounded " id="timer-{{ $apartment->id }}-{{ $sponsorship->id }}"></span> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            function startTimer(duration, display) {
                                var timer = duration, hours, minutes, seconds;
                                setInterval(function () {
                                    hours = parseInt(timer / 3600, 10);
                                    minutes = parseInt((timer % 3600) / 60, 10);
                                    seconds = parseInt(timer % 60, 10);
    
                                    // Formato per visualizzare ore:minuti
                                    hours = hours < 10 ? "0" + hours : hours;
                                    minutes = minutes < 10 ? "0" + minutes : minutes;
                                    seconds = seconds < 10 ? "0" + seconds : seconds;
    
                                    display.textContent = hours + ":" + minutes + ":" + seconds;
    
                                    if (--timer < 0) {
                                        timer = 0;
                                    }
                                }, 1000);
                            }
    
                            var now = new Date().getTime();
                            var end = new Date('{{ \Carbon\Carbon::parse($sponsorship->pivot->end_sponsorship) }}').getTime();
                            var duration = Math.floor((end - now) / 1000);
                            var display = document.querySelector('#timer-{{ $apartment->id }}-{{ $sponsorship->id }}');
                            if (duration > 0) {
                                startTimer(duration, display);
                            } else {
                                display.textContent = '00:00:00';
                            }
                        });
                    </script>
                @endforeach
            @endforeach
        @endif
    </div>
</div>

@endsection

