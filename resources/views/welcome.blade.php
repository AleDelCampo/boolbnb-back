@extends('layouts.app')
@section('content')
<body  class="bg-home">
    

    <div class=" welcome  container d-flex align-items-center shadow-lg py-5 my-5   rounded">

        <div class="row justify-content-end " id="card-wrapper">

            <div class="row justify-content-end col-lg-8 col-md-10 col-10 login" id="logo-wrapper">
                <div class="col-12 g-0 mb-3" id="img-wrapper">
                    <img class="img-fluid" id="logo-welcome-home" src="{{asset('storage/bnb_images/BoolBnB.png')}}" alt="">
                </div>
                <div class="col-12 text-end">
                    Accedi per gestire tutte le informazioni e le sponsorizzazioni dei tuoi appartamenti.
                </div>
                <div class="col-6 my-auto text-center  " id="btn-home">
                    <a class="btn my_btn mt-4" href="{{route('admin.apartments.index')}}">Accedi</a>
                </div>
            </div>
        </div>

    </div>


</body>

@endsection