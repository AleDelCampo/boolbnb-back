@extends('layouts.app')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        // Funzione per ottenere i dati delle visite per un dato anno
        function getVisitsData(year) {
            return axios.get('/api/visits', {
                params: { year: year }
            });
        }

        // Funzione per ottenere i label in base all'anno
        function getLabelsForYear(year) {
            return ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
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

        // Funzione per aggiornare il grafico con i dati delle visite
        function updateChart(year) {
            const apartmentId = {{$apartment->id}}; // Ottieni l'ID dell'appartamento dal PHP

            axios.get(`/api/visits/${apartmentId}?year=${year}`)
                .then(res => {
                    const visitsData = res.data.result;
                    const labels = getLabelsForYear(year);
                    const data = Array(12).fill(0); // Inizializza con 0 visite per ogni mese

                    // Popola i dati con le visite ricevute
                    visitsData.forEach(visit => {
                        const monthIndex = visit.month - 1; // Gennaio è 1, Febbraio è 2, etc.
                        data[monthIndex] = visit.total_visits;
                    });

                    myChart.data.labels = labels;
                    myChart.data.datasets[0].data = data;

                    myChart.update();

                })
                .catch(error => {
                    console.error('Errore nel caricamento dei dati delle visite:', error);
                });
        }
        
        // Imposta l'anno iniziale
        let defaultYear = '2022';
        let selectedYear = defaultYear;
        
        // Disegna il grafico sulla canvas
        let myChart = new Chart(
            document.getElementById('myChart').getContext('2d'),
            {
                type: 'bar',
                data: {
                    labels: getLabelsForYear(defaultYear),
                    datasets: [{
                        label: 'Statistiche Visualizzazioni:',
                        backgroundColor: getBarColors(12), // Considerando 12 mesi
                        borderColor: 'rgb(255, 99, 132)',
                        borderWidth: 1,
                        hoverBackgroundColor: 'rgba(255, 99, 132, 0.4)',
                        hoverBorderColor: 'rgb(255, 99, 132)',
                        data: Array(12).fill(0), // Inizializza con 0 visite per ogni mese
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }
        );
        
        // Aggiorna il grafico quando cambia l'anno selezionato
        function handleYearChange() {
            updateChart(selectedYear);
            document.getElementById('yearLabel').textContent = selectedYear;
        }
        
        // Listener per il click sulle frecce di switch anno
        document.getElementById('prevYear').addEventListener('click', function () {
            if (selectedYear === '2024') selectedYear = '2023';
            else if (selectedYear === '2023') selectedYear = '2022';
            handleYearChange();
        });
        
        document.getElementById('nextYear').addEventListener('click', function () {
            if (selectedYear === '2022') selectedYear = '2023';
            else if (selectedYear === '2023') selectedYear = '2024';
            handleYearChange();
        });
        
        // Imposta l'anno iniziale nel label e carica i dati del grafico
        document.getElementById('yearLabel').textContent = defaultYear;
        updateChart(defaultYear);

        
        var form = document.getElementById('payment-form');
        var client_token = "{{ $clientToken }}";    
    
        braintree.dropin.create({
            authorization: client_token,
            container: '#dropin-container'
        }, function (createErr, instance) {
            if (createErr) {
                console.error(createErr);
                return;
            }
    
            form.addEventListener('submit', function (event) {
                event.preventDefault();
    
                instance.requestPaymentMethod(function (err, payload) {
                    if (err) {
                        console.error(err);
                        return;
                    }
    
                    var nonceInput = document.createElement('input');
                    nonceInput.name = 'payment_method_nonce';
                    nonceInput.type = 'hidden';
                    nonceInput.value = payload.nonce;
                    form.appendChild(nonceInput);
    
                    form.submit();
                });
            });
        });  

        let btn_sponsor = document.getElementById('cta-sponsor')
                
        btn_sponsor.addEventListener('click', function(){
            document.getElementById('box-payment').classList.toggle('d-none')
        })

        

      
        
        
        

    });

    function change(value){

    console.log(value)

    const divs = document.querySelectorAll('.text-hide');

    divs.forEach(div => {
        div.classList.add('d-none');
    });


    document.querySelector('#box-description #text-description-' + value).classList.remove('d-none')
    }
    
    
</script>



<div class="container pb-4">

    <div class="card mt-4">
        <div class="d-flex flex-wrap">
            <div class="card-body col-12">
                
                <h2 class="ms-4 card-title">
                    <strong>{{$apartment->title}}</strong>

                
                </h2>
                {{-- room position --}}
                <div class="ms-4 position pb-3">
                    {{$apartment->address}}
                </div>

                {{-- link apartment image --}}
                <img src="{{asset('storage/' . $apartment->image)}}" class="card-img-top"
                    alt="immagine dell'appartamento" style="max-width: 100%; max-height: 400px; object-fit: cover"
                >

            </div>

            <div class="card-body col-12 ">
                
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif 


                <div class="row">

                    <div class="col-xs-12 col-md-6">
                        
        
                        {{-- room infos --}}
                        <div class="d-flex gap-3 mb-3 justify-content-center ">
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
        
                        {{-- room description --}}
                        <p>
                            {{$apartment->description}}
                        </p>
        
                        <hr>
        
                        {{-- room services --}}
                        <strong class="mb-3">
                            Servizi
                        </strong>
                        <ul id="services-list" class="d-flex gap-5 flex-wrap p-3">
                            @foreach($apartment->services as $service)
                            <li>
                                <div>
                                    {{$service->name}}
        
                                </div>
                                <div>
                                    <i :class="{{$service->icon}}"></i>
                                </div>
                            </li>
                            @endforeach
                        </ul>   

                    </div>

                    <div id="box-description">

                        <div id="text-description-1" class="text-hide d-none">{{$sponsorships[0]->description}}</div>
                        <div id="text-description-2" class="text-hide d-none">{{$sponsorships[1]->description}}</div>
                        <div id="text-description-3" class="text-hide d-none">{{$sponsorships[2]->description}}</div>
                        

                    </div>

                    <div class="col-xs-12 col-md-6  px-5">

                        <button id="cta-sponsor" class="btn btn-success mb-4">Attiva sponsorizzazione</button>

                        <div id="box-payment" class="d-none">
                            <form id="payment-form" action="{{ route('payment.process') }}" method="POST">
                                @csrf
                                <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
                                <select id="sponsorship_id" class="form-select"  name="sponsorship_id" onclick="change(value)">
                                    <option>Seleziona sponsorizzazione</option>
                                    @foreach ($sponsorships as $sponsorship)
                                    <option  class="option" value="{{$sponsorship->id}}">{{$sponsorship->title}}</option>
                    
                                    @endforeach
                                    
                                </select>

                                
                                <div id="dropin-container"></div>
                                <button type="submit" class="btn btn-primary">Acquista</button>            
                                
                                
                            </form>

                        </div>

                    </div>

                </div>               

            </div>

        </div>

        

        <div class="card-footer d-flex justify-content-center p-3 gap-1">

            
            {{-- link to room edit page --}}
            <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-outline-warning">Modifica</a>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                data-bs-target="#deleteRoomModal">
                Elimina
            </button>

            {{-- Test --}}
            {{-- <a href="{{route('leads.index', $apartment->id)}}" class="btn btn-outline-warning">Messaggi</a> --}}
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
            <span id="prevYear" class="year-nav">&lt;</span>
            <span id="yearLabel" class="mx-3"></span>
            <span id="nextYear" class="year-nav">&gt;</span>
        </div>
        <canvas id="myChart" width="400" height="200" class="w-100"></canvas>
    </div>
</div>

<script>



</script>

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