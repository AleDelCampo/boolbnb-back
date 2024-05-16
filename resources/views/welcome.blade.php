@extends('layouts.app')
@section('content')
<body  class="bg-home">
    <div class="jumbotron p-4 rounded-3">
        <div class="container py-5 bg-cnt">
    
            <h1>BoolBnB</h1>
    
            <div>
                Benvenuto sulla nostra piattaforma!!
            </div>
    
            <a class="btn btn-primary mt-4" href="{{route('dashboard')}}">Vai alla DashBoard</a>
    
        </div>
    </div>
</body>

@endsection