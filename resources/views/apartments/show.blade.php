@extends('layouts.app')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Funzione per generare dati casuali per un determinato anno
        function generateRandomData(year) {
            let randomData = []; // Se l'anno è 2024, genera dati fino a maggio, altrimenti per tutti i mesi
            
            for (let i = 0; i < 12; i++) { // Genera dati per ogni mese
                axios.get('http://127.0.0.1:8000/api/visits',{
                    params:{year:year, month:i+1 }
                }).then(res=> {
                    console.log(res)
                    randomData.push(res.data.result); // Genera un numero casuale compreso tra 1 e 2000
                })
            }
            console.log(randomData)
            return randomData;
        }

        // Definisci i dati per ciascun appartamento
        let apartmentData = [
            { year: '2022', data: generateRandomData('2022') },
            { year: '2023', data: generateRandomData('2023') },
            { year: '2024', data: generateRandomData('2024') }
        ];

        let defaultYear = '2022';
        let selectedYear = defaultYear;
        let initialData = getDataForYear(defaultYear);

        // Funzione per ottenere i dati per un determinato anno
        function getDataForYear(year) {
            let data = apartmentData.find(apartment => apartment.year === year);
            return data ? data.data : [];
        }

        // Funzione per aggiornare il grafico quando cambia l'anno selezionato
        function updateChart() {
            let newData = getDataForYear(selectedYear);
            myChart.data.datasets[[1]].data = newData;
            myChart.data.datasets[[1]].backgroundColor = getBarColors(newData.length);
            document.getElementById('yearLabel').textContent = selectedYear;
            myChart.update();
        }

        // Funzione per ottenere i colori delle barre
        function getBarColors(length) {
            let colors = [];
            for (let i = 0; i < length; i++) {
                let color = 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',0.2)';
                colors.push(color);
            }
            return colors;
        }

        let config = {
            type: 'bar',
            data: {
                labels: getLabelsForYear(defaultYear),
                datasets: [{
                    label: 'Statistiche Visualizzazioni:',
                    backgroundColor: getBarColors(initialData),
                    borderColor: 'rgb(255, 99, 132)',
                    borderWidth: 1,
                    hoverBackgroundColor: 'rgba(255, 99, 132, 0.4)',
                    hoverBorderColor: 'rgb(255, 99, 132)',
                    data: initialData,
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        };

        function getLabelsForYear(year) {
            return ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
        }

        // Disegna il grafico sulla canvas
        let myChart = new Chart(
            document.getElementById('myChart'), config);

        // Aggiungi listener per il click sulle frecce di switch anno
        document.getElementById('prevYear').addEventListener('click', function () {
            if (selectedYear === '2024') selectedYear = '2023';
            else if (selectedYear === '2023') selectedYear = '2022';
            updateChart();
        });

        document.getElementById('nextYear').addEventListener('click', function () {
            if (selectedYear === '2022') selectedYear = '2023';
            else if (selectedYear === '2023') selectedYear = '2024';
            updateChart();
        });

        // Imposta l'anno iniziale nel label
        document.getElementById('yearLabel').textContent = defaultYear;
    });
</script>

<div class="container pb-4">
    <div class="card mt-4">
        <div class="d-flex flex-wrap">
            <div class="card-body col-12 col-md-6">
                {{-- link apartment image --}}
                <img src="{{asset('storage/' . $apartment->image)}}" class="card-img-top" alt="immagine dell'appartamento" style="max-width: 100%">
            </div>

            <div class="card-body col-12 col-md-6">
                <div class="mb-3">
                    <h2 class="card-title"><strong>{{$apartment->title}}</strong></h2>
                    {{-- room infos --}}
                    <div class="d-flex gap-3 mb-3">
                        <small>
                            <span class="m2">{{$apartment->squared_meters}}m²</span> -
                            <span class="rooms">{{$apartment->n_rooms}} camera da letto</span> -
                            <span class="beds">{{$apartment->n_beds}} posti letto</span> -
                            <span class="bathrooms">{{$apartment->n_bathrooms}} bagni</span>
                        </small>
                    </div>

                    <hr>

                    <div class="mb-3">
                        Proprietario: {{$apartment->user->name}}
                    </div>
                </div>

                <hr>

                {{-- room description --}}
                <p>{{$apartment->description}}</p>

                <hr>

                {{-- room services --}}
                <strong class="mb-3">Servizi</strong>
                <ul id="services-list" class="d-flex gap-5 flex-wrap">
                    @foreach($apartment->services as $services)
                        <li>{{$services->name}}</li>
                    @endforeach
                </ul>

                <hr>

                {{-- room position --}}
                <div class="position">{{$apartment->address}}</div>
                <div class="container">
                    {{-- Altri contenuti della pagina --}}
                    <div class="mt-5">
                        <h1>Crea una Sponsorizzazione per {{ $apartment->title }}</h1>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('admin.sponsor.store', ['apartment' => $apartment->slug]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="sponsorship_id">Sponsorship</label>
                                <select name="sponsorship_id" id="sponsorship_id" class="form-control">
                                    @foreach($sponsorshipsAvailable as $sponsorship)
                                        <option value="{{ $sponsorship->id }}">
                                            {{ $sponsorship->title }} - €{{ $sponsorship->price }} - {{ $sponsorship->h_duration }} ore
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="form-group">
                                <label for="apartment_id">Appartamento</label>
                                <select name="apartment_id" id="apartment_id" class="form-control">
                                    <option value="{{ $apartment->slug }}">
                                        {{ $apartment->title }}
                                    </option>
                                </select>
                            </div>
                        
                            <button type="submit" class="btn btn-primary">Crea Sponsorizzazione</button>
                            <a class="btn btn-secondary" href="{{ route('admin.sponsor.show', $apartment->slug) }}">Le tue sponsorizzazioni</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-center p-3 gap-3">
            {{-- link to room edit page --}}
            <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-outline-warning">Modifica</a>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                data-bs-target="#deleteRoomModal">
                Elimina
            </button>

            <a href="{{route('admin.leads.index', $apartment->id)}}" class="btn btn-outline-info">Messaggi</a>
            
            <a href="{{route('admin.apartments.index', $apartment)}}" class="btn btn-outline-success">Homepage</a>

            <!-- Modal -->
            <div class="modal fade" id="deleteRoomModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">{{$apartment->title}}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Sei sicuro di voler eliminare l'appartamento {{ $apartment->title }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                            <form action="{{route('admin.apartments.destroy', $apartment)}}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-danger">Elimina</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center align-items-center position-relative mt-4">
            <span id="prevYear" class="year-nav"><</span>
            <span id="yearLabel" class="mx-3"></span>
            <span id="nextYear" class="year-nav">></span>
        </div>
        <canvas id="myChart" width="400" height="200" class="w-100"></canvas>
    </div>
</div>

<!-- Inizia la parte copiata da sponsor-show.blade.php -->
@if ($sponsorships->isNotEmpty())
    <div class="container mt-5">
        <h1>Sponsorizzazioni per {{ $apartment->title }}</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Titolo Sponsorizzazione</th>
                    <th>Data Inizio</th>
                    <th>Data Fine</th>
                    <th>Durata</th>
                    <th>Durata Rimanente</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sponsorships as $sponsorship)
                    <tr>
                        <td>{{ $sponsorship->title }}</td>
                        <td>{{ $sponsorship->pivot->start_sponsorship ?? '' }}</td>
                        <td>{{ $sponsorship->pivot->end_sponsorship ?? '' }}</td>
                        <td>{{ $sponsorship->h_duration ?? '' }} ore</td>
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

                                            // Pad the hours, minutes, and seconds with leading zeros
                                            hours = hours < 10 ? "0" + hours : hours;
                                            minutes = minutes < 10 ? "0" + minutes : minutes;
                                            seconds = seconds < 10 ? "0" + seconds : seconds;

                                            // Display the result
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
            </tbody>
        </table>
    </div>
@endif
<!-- Fine parte copiata -->

<style>
    body {
        background-color: #5F8B8D;
    }

    #services-list {
        list-style-type: none;
    }

    .year-nav {
        cursor: pointer;
        border-radius: 50%;
    }
</style>

@endsection