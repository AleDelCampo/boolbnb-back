@extends('layouts.app')
@section('content')
<body  class="bg-home">

    <div class="container d-flex align-items-center ">

        <div class="row mt-5">
            <div class="col-6">
                <img class="img-fluid" src="{{asset('storage/bnb_images/BoolBnB.png')}}" alt="">
            </div>
            <div class="col-6 my-auto text-center  ">
                <a class="btn my_btn mt-4" href="{{route('admin.apartments.index')}}">Accedi</a>


            </div>
        </div>

    </div>


</body>

@endsection