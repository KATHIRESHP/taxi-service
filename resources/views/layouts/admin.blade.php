@extends('layouts.universal')

@section('layout')
    <header class="header" id="header">
        <div class="header_toggle"><i class='bi bi-three-dots-vertical' id="header-toggle"></i></div>
        @auth('admin')
            <div>{{auth('admin')->user()->name}}</div>
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
                    @guest('admin')
                        @if(Route::has('admin.login'))
                            <a class="nav_link " href="{{route('admin.login')}}">
                                <i class="bi bi-box-arrow-in-down-left"></i>
                                <span class="nav_name">Login</span>
                            </a>
                        @endif
                        @if(Route::has('admin.register'))
                            <a class="nav_link " href="{{route('admin.register')}}">
                                <i class="bi bi-person-add"></i>
                                <span class="nav_name">Register</span>
                            </a>
                        @endif
                    @else
                        @if(Route::has('admin.home'))
                            <a class="nav_link " href="{{route('admin.home')}}">
                                <i class="bi bi-house"></i>
                                <span class="nav_name">Home</span>
                            </a>
                        @endif
                        @if(Route::has('admin.previousDayRide'))
                            <a class="nav_link " href="{{route('admin.previousDayRide')}}">
                                <i class="bi bi-layer-backward"></i>
                                <span class="nav_name">Previous day rides</span>
                            </a>
                        @endif
                        @if(Route::has('admin.driver.index'))
                            <a class="nav_link " href="{{route('admin.driver.index')}}">
                                <i class="bi bi-car-front-fill"></i>
                                <span class="nav_name">Drivers</span>
                            </a>
                        @endif
                    @endguest
                </div>
            </div>
            @auth('admin')
                <form action="{{route('admin.logout')}}" method="POST">
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
    </div>
@endsection
