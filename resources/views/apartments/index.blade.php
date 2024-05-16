@extends('layouts.app')

@section('content')
<section>
    <div class="container">
<div class="d-flex justify-content-between my-4">
    <h2 class="fs-4 text-secondary">Appartamenti</h2>
    <a class="btn btn-primary" href="{{route('admin.apartments.create')}}">Aggiungi</a>
</div>
    
    </div>
</section>

<section>
    <div class="container">

        <table class="table my-4">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Descrizione</th>
                <th scope="col"></th>
                {{-- <th scope="col"></th> --}}
              </tr>
            </thead>

            <tbody>
              <tr>
               @forelse ($apartments as $apartment)
                   <tr>
                    <th scope="row">{{$apartment->id}}</th>
                    <td>
                        <a href="{{route('admin.apartments.show', $apartment)}}">{{$apartment->title}}</a></td>
                    <td>{{$apartment->description}}</td>
                    <td>
                        <a href="{{route('admin.apartments.edit', $apartment)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                    </td>
                   </tr>
               @empty
                   <tr>
                    <td>Nessun Appartamento</td>
                   </tr>
               @endforelse
            </tbody>
          </table>
    </div>
</section>
@endsection