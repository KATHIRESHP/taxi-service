@extends('layouts.admin')

@section('content')
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <a class="card p-5 bg-success shadow-lg text-light" href="{{route('admin.previousDayRide')}}">
            <div class="d-flex justify-content-center fs-1">
                {{$previousDayRideCount}}
            </div>
            <div class="fs-4">
                rides yesturday completed
            </div>
        </a>
    </div>
@endsection
