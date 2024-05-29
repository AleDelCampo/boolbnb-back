@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>I miei appartamenti sponsorizzati</h1>
    @if ($apartments->isEmpty())
        <p>Non hai appartamenti sponsorizzati al momento.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Immagine</th>
                    <th>Titolo Appartamento</th>
                    <th>Indirizzo</th>
                    <th>Sponsorizzazione</th>
                    <th>Data Inizio</th>
                    <th>Data Fine</th>
                    <th>Durata</th>
                    <th>Durata Rimanente</th>
                </tr>
            </thead>
            <tbody>
                @foreach($apartments as $apartment)
                    @foreach($apartment->sponsorships as $sponsorship)
                        <tr>
                            <td><img src="{{ asset('storage/' . $apartment->image) }}" alt="Immagine" style="max-width: 100px;"></td>
                            <td>{{ $apartment->title }}</td>
                            <td>{{ $apartment->address }}</td>
                            <td>{{ $sponsorship->title }}</td>
                            <td>{{ $sponsorship->pivot->start_sponsorship }}</td>
                            <td>{{ $sponsorship->pivot->end_sponsorship }}</td>
                            <td>{{ $sponsorship->h_duration }} ore</td>
                            <td>
                                <span id="timer-{{ $sponsorship->id }}"></span>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        function startTimer(duration, display) {
                                            var timer = duration, hours, minutes, seconds;
                                            setInterval(function () {
                                                hours = parseInt(timer / 3600, 10);
                                                minutes = parseInt((timer % 3600) / 60, 10);
                                                seconds = parseInt(timer % 60, 10);

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
                                        var display = document.querySelector('#timer-{{ $sponsorship->id }}');
                                        if (duration > 0) {
                                            startTimer(duration, display);
                                        } else {
                                            display.textContent = '00:00:00';
                                        }
                                    });
                                </script>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

