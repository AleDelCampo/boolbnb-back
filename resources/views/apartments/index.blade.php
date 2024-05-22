@extends('layouts.app')

@section('content')


<section>
    <div class="row m-0 ">

        <div class="col-2">
            <div id="lateral-nav" class="row p-5">
                <div class="col 12">

                    <div class="row align-items-center">
                        <div class="col-4">
                            <div id="img-user">
                                <img src="https://static.vecteezy.com/system/resources/thumbnails/005/129/844/small_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg"
                                    alt="">

                            </div>
                        </div>
                        <div class="col-8 fw-bold ">
                            <h3>
                                {{ Auth::user()->name }}

                            </h3>
                        </div>

                    </div>
                    <div id="nav-list" class="row mt-5 ">

                        {{-- <div class="col-12 py-2 ">
                            <a class="btn my_bg_color my_btn fw-bold w-100 "
                                href="{{ url('dashboard') }}">{{__('Dashboard')}}</a>
                        </div> --}}
                        <div class="col-12 py-2">
                            <a class="btn my_bg_color fw-bold w-100" href="{{ url('profile')}}">{{__('Profilo')}}</a>
                        </div>
                        <div class="col-12 py-2">
                            <a class="btn my_bg_color fw-bold w-100" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"> {{ __('Logout') }}</a>
                        </div>



                    </div>
                </div>
            </div>



        </div>


        <div class="col-8 flex-grow-1 ">

            <div class="container">
                <h2 class="fs-4 text-secondary py-4">Appartamenti</h2>

                <div class="row justify-content-center py-5">
                    <a class="btn my_bg_color fw-bold col-6" href="{{route('admin.apartments.create')}}">Aggiungi un nuovo appartamento</a>
                </div>

                <div class="row p-0">
                    @forelse ($apartments as $apartment)
                    <div class="col-6">
                        <div id="tile" class="row p-3 my-3 ">
                            <div id="img-container" class="col-4 rounded-2">
                                <img src="{{asset('storage/' . $apartment->image)}}" alt="">

                            </div>
                            <div class="col-8">
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
                                            <a class="btn my_btn"
                                                href="{{route('admin.apartments.show', $apartment)}}">Visualizza</a>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    @empty
                    <div class="text-center">
                        Nessun appartamento disponibile
                        <hr>
                    </div>


                    @endforelse

                </div>

            </div>


        </div>

    </div>


</section>
@endsection