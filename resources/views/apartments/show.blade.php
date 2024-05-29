@extends('layouts.app')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ottiene l'ID dell'appartamento dal backend Laravel
        const apartmentId = {{$apartment->id}};
        let defaultYear = '2024'; // Anno predefinito
        let selectedYear = defaultYear; // Anno selezionato inizialmente

        // Funzione per ottenere i dati delle visite per un determinato anno
        const getVisitsData = (year) => {
            return axios.get(`/api/visits/${apartmentId}?year=${year}`);
        };

        // Funzione per ottenere i dati dei messaggi per un determinato anno
        const getMessagesData = (year) => {
            return axios.get(`/api/messages/${apartmentId}/${year}`);
        };

        // Funzione per ottenere le etichette (mesi) per un determinato anno
        const getLabelsForYear = (year) => {
            return ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
        };

        // Funzione per generare un colore casuale in formato RGBA
        const getRandomColor = () => {
            return `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.2)`;
        };

        // Funzione per aggiornare il grafico delle visite
        const updateChart = (year) => {
            getVisitsData(year)
                .then(res => {
                    const visitsData = res.data.result; // Dati delle visite
                    const labels = getLabelsForYear(year); // Etichette dei mesi
                    const data = Array(12).fill(0); // Inizializza i dati a zero

                    // Assegna i dati delle visite ai mesi corretti
                    visitsData.forEach(visit => {
                        const monthIndex = visit.month - 1; 
                        data[monthIndex] = visit.total_visits;
                    });

                    // Aggiorna il grafico con i nuovi dati
                    myChart.data.labels = labels;
                    myChart.data.datasets[0].data = data;
                    myChart.update();
                })
                .catch(error => {
                    console.error('Errore nel caricamento dei dati delle visite:', error);
                });
        };

        // Funzione per aggiornare il grafico dei messaggi
        const updateMessageChart = (year) => {
            getMessagesData(year)
                .then(res => {
                    const messageData = res.data.result; // Dati dei messaggi
                    const labels = getLabelsForYear(year); // Etichette dei mesi
                    const data = Array(12).fill(0); // Inizializza i dati a zero

                    // Assegna i dati dei messaggi ai mesi corretti
                    for (const [month, count] of Object.entries(messageData)) {
                        const monthIndex = parseInt(month) - 1;
                        data[monthIndex] = count;
                    }

                    // Aggiorna il grafico con i nuovi dati
                    myMessageChart.data.labels = labels;
                    myMessageChart.data.datasets[0].data = data;
                    myMessageChart.update();
                })
                .catch(error => {
                    console.error('Errore nel caricamento dei dati dei messaggi:', error);
                });
        };

        // Funzione per configurare un nuovo grafico
        const setupChart = (canvasId, label, backgroundColor) => {
            return new Chart(
                document.getElementById(canvasId).getContext('2d'),
                {
                    type: 'bar',
                    data: {
                        labels: getLabelsForYear(defaultYear), // Etichette dei mesi
                        datasets: [{
                            label: label,
                            backgroundColor: backgroundColor,
                            borderColor: 'rgb(255, 99, 132)',
                            borderWidth: 1,
                            hoverBackgroundColor: 'rgba(255, 99, 132, 0.4)',
                            hoverBorderColor: 'rgb(255, 99, 132)',
                            data: Array(12).fill(0), // Dati iniziali a zero
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true // La scala Y parte da zero
                            }
                        }
                    }
                }
            );
        };

        // Crea i grafici delle visite e dei messaggi
        let myChart = setupChart('myChart', 'Statistiche Visualizzazioni', Array(12).fill('').map(() => getRandomColor()));
        let myMessageChart = setupChart('messageChart', 'Statistiche Messaggi', Array(12).fill('').map(() => getRandomColor()));

        // Funzione per gestire il cambio di anno e aggiornare i grafici
        const handleYearChange = () => {
            updateChart(selectedYear);
            updateMessageChart(selectedYear);
            document.getElementById('yearLabel').textContent = selectedYear; // Aggiorna l'etichetta dell'anno
        };

        // Gestisce il clic sul pulsante per l'anno precedente
        document.getElementById('prevYear').addEventListener('click', () => {
            selectedYear = selectedYear === '2024' ? '2023' : '2022'; // Cambia l'anno selezionato
            handleYearChange(); // Aggiorna i grafici
        });

        // Gestisce il clic sul pulsante per l'anno successivo
        document.getElementById('nextYear').addEventListener('click', () => {
            selectedYear = selectedYear === '2022' ? '2023' : '2024'; // Cambia l'anno selezionato
            handleYearChange(); // Aggiorna i grafici
        });

        // Imposta l'etichetta dell'anno inizialmente
        document.getElementById('yearLabel').textContent = defaultYear;
        // Aggiorna i grafici con i dati dell'anno predefinito
        updateChart(defaultYear);
        updateMessageChart(defaultYear);


        // Codice relativo ai pagamenti
        let form = document.getElementById('payment-form');
        let client_token = "{{ $clientToken }}"; // Token per Braintree    
    
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
    
                    let nonceInput = document.createElement('input');
                    nonceInput.name = 'payment_method_nonce';
                    nonceInput.type = 'hidden';
                    nonceInput.value = payload.nonce; // Aggiunge il nonce al form
                    form.appendChild(nonceInput);
    
                    form.submit(); // Invia il form
                });
            });
        });  

        // Gestisce il clic sul pulsante per mostrare/nascondere il box dei pagamenti
        let btn_sponsor = document.getElementById('cta-sponsor');
        btn_sponsor.addEventListener('click', function() {
            document.getElementById('box-payment').classList.toggle('d-none'); // Mostra/nasconde il box
        });

      
        
        
        

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
                    alt="immagine dell'appartamento" style="max-width: 100%; max-height: 400px; object-fit: cover">

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
        <canvas id="messageChart" width="400" height="200" class="w-100"></canvas>
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