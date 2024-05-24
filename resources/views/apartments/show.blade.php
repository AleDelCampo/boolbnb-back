@extends('layouts.app')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Funzione per generare dati casuali per un determinato anno
        function generateRandomData(year) {
            //let randomData = []; // Se l'anno è 2024, genera dati fino a maggio, altrimenti per tutti i mesi
            //for (let i = 0; i < 12; i++) { // Genera dati per ogni mese
                //randomData.push(Math.floor(Math.random() * 60) + 1); // Genera un numero casuale compreso tra 1 e 2000
                
            // }
            // return randomData;
            axios.get('http://127.0.0.1:8000/api/visits').then(res=> {
                console.log(res)
            })
        }

        // Definisci i dati per ciascun appartamento
        let apartmentData = [
            {
                year: '2022',
                data: generateRandomData('2022')
            },
            {
                year: '2023',
                data: generateRandomData('2023')
            },
            {
                year: '2024',
                data: generateRandomData('2024')
            }
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
        myChart.data.datasets[0].data = newData;
        myChart.data.datasets[0].backgroundColor = getBarColors(newData.length);
        document.getElementById('yearLabel').textContent = selectedYear;
        myChart.update();
    }

        // Funzione per ottenere i colori delle barre
    function getBarColors(length) {
        let colors = [];
        for (let i = 0; i < length; i++) {
            // Genera un colore casuale in formato RGBA
            let color = 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',0.2)';
            colors.push(color);
        }
        return colors;
    }

        // Configurazione del grafico
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
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    // Funzione per ottenere i label in base all'anno
    function getLabelsForYear(year) {
        return ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
    }

    // Disegna il grafico sulla canvas
    let myChart = new Chart(
        document.getElementById('myChart'),
        config
    );

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
                <img src="{{asset('storage/' . $apartment->image)}}" class="card-img-top"
                    alt="immagine dell'appartamento" style="max-width: 100%">
            </div>

            <div class="card-body col-12 col-md-6">
                <div class="mb-3">
                    <h2 class="card-title"><strong>{{$apartment->title}}</strong></h2>

                    {{-- room infos --}}
                    <div class="d-flex gap-3 mb-3">
                        <small>
                            <span class="m2">
                                {{$apartment->squared_meters}}m²
                            </span>
                            -
                            <span class="rooms">
                                {{$apartment->n_rooms}} camera da letto
                            </span>
                            -
                            <span class="beds">
                                {{$apartment->n_beds}} posti letto
                            </span>
                            -
                            <span class="bathrooms">
                                {{$apartment->n_bathrooms}} bagni
                            </span>
                        </small>
                    </div>

                    <hr>

                    <div class="mb-3">
                        Proprietario: {{$apartment->user->name}}
                    </div>
                </div>

                <hr>

                {{-- room description --}}
                <p>
                    {{$apartment->description}}
                </p>

                <hr>

                {{-- room services --}}
                <strong class="mb-3">
                    Servizi
                </strong>
                <ul id="services-list" class="d-flex gap-5 flex-wrap">
                    @foreach($apartment->services as $services)
                    <li>
                        {{$services->name}}
                    </li>
                    @endforeach
                </ul>

                <hr>

                {{-- room position --}}
                <div class="position">
                    {{$apartment->address}}
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
            <span id="prevYear" class="year-nav">&lt;</span>
            <span id="yearLabel" class="mx-3"></span>
            <span id="nextYear" class="year-nav">&gt;</span>
        </div>
        <canvas id="myChart" width="400" height="200" class="w-100"></canvas>
    </div>
</div>

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