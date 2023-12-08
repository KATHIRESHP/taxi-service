@extends('layouts.universal')

@section('layout')
    <header class="header" id="header" style="background-color: transparent">
        <div class="header_toggle"><i class='bi bi-three-dots-vertical' id="header-toggle"></i></div>
        @auth()
            <div>{{auth()->user()->name}}</div>
        @endauth
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="/user/home" class="nav_logo">
                    <i class="bi bi-threads text-light"></i>
                    <span class="nav_logo-name">K Taxi</span>
                </a>
                <div class="nav_list">
                    @guest()
                        @if(Route::has('user.login'))
                            <a class="nav_link " href="{{route('user.login')}}">
                                <i class="bi bi-box-arrow-in-down-left"></i>
                                <span class="nav_name">Login</span>
                            </a>
                        @endif
                        @if(Route::has('user.register'))
                            <a class="nav_link " href="{{route('user.register')}}">
                                <i class="bi bi-person-add"></i>
                                <span class="nav_name">Register</span>
                            </a>
                        @endif
                    @else
                        @if(Route::has('user.ride.create'))
                            <a class="nav_link " href="{{route('user.ride.create')}}">
                                <i class="bi bi-bicycle"></i>
                                <span class="nav_name">Ride</span>
                            </a>
                        @endif
                        @if(Route::has('user.ride.rides'))
                            <a class="nav_link " href="{{route('user.ride.rides')}}">
                                <i class="bi bi-filter-right"></i>
                                <span class="nav_name">My rides</span>
                            </a>
                        @endif
                    @endguest
                </div>
            </div>
            @auth()
                <form action="{{route('user.logout')}}" method="POST">
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
    <!--Container Main start-->
    <div class="height-100 bg-light">
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
        @yield('content')
    </div>
    <!--Container Main end-->
@endsection
