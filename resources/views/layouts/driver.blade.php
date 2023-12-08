@extends('layouts.universal')

@section('layout')
    <header class="header" id="header">
        <div class="header_toggle"><i class='bi bi-three-dots-vertical' id="header-toggle"></i></div>
        @auth('driver')
            <div>{{auth('driver')->user()->name}}</div>
        @endauth
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="/driver/home" class="nav_logo">
                    <i class="bi bi-threads text-light"></i>
                    <span class="nav_logo-name">K Taxi</span>
                </a>
                <div class="nav_list">
                    @guest('driver')
                        @if(Route::has('driver.login'))
                            <a class="nav_link " href="{{route('driver.login')}}">
                                <i class="bi bi-box-arrow-in-down-left"></i>
                                <span class="nav_name">Login</span>
                            </a>
                        @endif
                        @if(Route::has('driver.register'))
                            <a class="nav_link " href="{{route('driver.register')}}">
                                <i class="bi bi-person-add"></i>
                                <span class="nav_name">Register</span>
                            </a>
                        @endif
                    @else
                        <script src="{{asset('asset/js/driver/CurrentLocation.js')}}"></script>
                        @if(Route::has('driver.ride.requests'))
                            <a class="nav_link " href="{{route('driver.ride.requests')}}">
                                <i class="bi bi-filter-left"></i>
                                <span class="nav_name">Requests</span>
                            </a>
                        @endif
                        @if(Route::has('driver.ride.currentride') && auth()->user()->status == "inride")
                            <a class="nav_link " href="{{route('driver.ride.currentride')}}">
                                <i class="bi bi-paperclip"></i>
                                <span class="nav_name">Current ride</span>
                            </a>
                        @endif
                    @endguest
                </div>
            </div>
            @auth('driver')
                <form action="{{route('driver.logout')}}" method="POST">
                    @csrf
                    <button type="submit" class="nav_link btn">
                        <i class='bi bi-box-arrow-left'></i>
                        <span class="nav_name">SignOut</span>
                    </button>
                </form>
            @else
                @if(Route::has('landpage'))
                    <a class="nav_link " href="{{route('landpage')}}">
                        <i class="bi bi-arrow-left"></i>
                        <span class="nav_name">Back</span>
                    </a>
                @endif
            @endauth
        </nav>
    </div>
    <div class="height-100 bg-light ">
        @if(session()->has('message'))
            <div class="alert alert-success col-4 d-flex justify-content-between mt-5" role="alert">
                {{session()->get('message')}}
                <button class="btn-close" data-bs-dismiss="alert" type="button"></button>
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger col-4 d-flex justify-content-between mt-5" role="alert">
                {{session()->get('error')}}
                <button class="btn-close" data-bs-dismiss="alert" type="button"></button>
            </div>
        @endif
        <div style="height: 80px; width: 100%"></div>
        @yield('content')
        @auth()
            <div style="position:absolute; bottom: 5%; right: 5%;">
                <div class="flex flex-column">
                    <form action="{{route('driver.checkin')}}" method="POST" style=" display: {{auth()->user()->status == "away" ? "block" : "none"}}">
                        @csrf
                        @method("PUT")
                        <button id="checkin" type="submit" class=" btn btn-outline-success" style="border-radius: 50px;">Checkin</button>
                    </form>
                    <form action="{{route('driver.checkout')}}" method="POST" style="display: {{auth()->user()->status == "available" ? "block" : "none"}}">
                        @csrf
                        @method("PUT")
                        <button id="checkout" class=" btn btn-outline-danger" style="border-radius: 50px;">Checkout</button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
@endsection
