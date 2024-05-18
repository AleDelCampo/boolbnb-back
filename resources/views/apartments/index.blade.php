@extends('layouts.app')

@section('content')
<section>
    <div class="container">
<div class="d-flex justify-content-between my-4">
    <h2 class="fs-4 text-secondary">Appartamenti</h2>
</div>

</div>
</section>

<section>
    <div class="container">
        
        <div class="row justify-content-center py-5">
            <a class="btn my_bg_color fw-bold col-6" href="{{route('admin.apartments.create')}}">Aggiungi un nuovo appartamento</a>
            
        </div>

        <div class="row">
            @forelse ($apartments as $apartment)
            <div class="col-6">
                <div id="tile" class="row p-3 my-3">
                    <div id="img-container" class="col-3 rounded-2">
                        <img  src="{{asset('storage/' . $apartment->image)}}" alt="">
        
                    </div>
                    <div  class="col-8" >
                        <div class="row">
                            <div class="col-6">
                                <div class="fw-bold pt-1 pb-2">
                                    {{$apartment->title}}
                                </div>
                                <div>
                                    {{$apartment->address}}
                                </div>
                            </div>
                            <div class="col-6 d-flex justify-content-end align-items-center">
                                <div>
                                    <a class="btn my_btn" href="{{route('admin.apartments.create')}}" href="{{route('admin.apartments.show', $apartment)}}">Visualilzza</a>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
        
                </div>
    
            </div>
            @empty
            nulla
                {{-- <tr>
                 <td>Nessun Appartamento</td>
                </tr> --}}
            @endforelse

        </div>
                   

        
    </div>
</section>
@endsection