<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">

        <nav class="navbar navbar-expand-md navbar-light shadow-sm bg-white">
            <div class="container">
                
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img id="logo" src="{{asset('storage/bnb_images/BoolBnB.png')}}" alt="Logo" class="d-inline-block align-text-top">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link router line ms-lg-5" href="{{ route('admin.apartments.index') }}">{{ __('Home') }}</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Registrati') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                {{-- <a class="dropdown-item" href="{{ url('dashboard') }}">{{__('Dashboard')}}</a> --}}
                                <a class="dropdown-item" href="{{ url('profile') }}">{{__('Profile')}}</a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        
        <main >
            
            @yield('content')

            
        

        </main>
        
       

    </div>
    <div class="container-fluid shadow-lg bg-white text-center mt-5  py-4 ">
        <h6 class="text-center mb-3 ">
            Progetto finale di gruppo Boolean®, <span style="color: #006769c0;">BoolBnB</span>.
        </h6>
    
        <div id="copyright">
            Copyright© 2024, Boolean®.
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function removeExpiredSponsorships() {
                fetch('/remove-expired-sponsorships')
                    .then(response => response.json())
                    .then(data => {
                        console.log('Expired sponsorships removed:', data);
                    })
                    .catch(error => {
                        console.error('Error removing expired sponsorships:', error);
                    });
            }
    
            // Esegui la funzione subito e poi ogni minuto 
            removeExpiredSponsorships();
            setInterval(removeExpiredSponsorships, 1 * 60 * 1000); // 1 minuto
        });
    </script>
    
    <script src="https://js.braintreegateway.com/web/dropin/1.28.0/js/dropin.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.89.1/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.89.1/js/hosted-fields.min.js"></script>

    
</body>


</html>
