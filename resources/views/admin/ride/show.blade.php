@extends('layouts.admin')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center vh-100 gap-4">
        <div class="card p-5 col-8 col-md-6 col-lg-4 col-xl-3">
            <div class="card-title">
                View the map the location details
            </div>
            <div class="card-body">
                <div>
                    Ride status: <span
                        class="badge {{($ride->status == "pending" ? "bg-danger" : "bg-success")}}">{{$ride->status}}</span>
                    <br><span>Distance: {{$ride->distance}} (approx)</span>
                </div>
                <div>
                    Fare: <span class="fs-3 badge bg-success">₹ {{$ride->payment->amount}}</span>
                </div>
            </div>
        </div>
        <div class="h-50 w-75">
            <div class="d-flex justify-content-between">
                <span class="badge bg-danger">Red is destination</span>
                <span class="badge bg-primary">Driver location</span>
                <span class="badge bg-success">Green is source</span>
            </div>
            <div id="map" class="h-100 w-100 bg-secondary" title="scroll if map is not visible"></div>
        </div>
    </div>
    <script type="text/javascript">
        var ride = {!! json_encode($ride) !!};
    </script>
    <script type="text/javascript" src="{{asset('asset/js/user/ShowRide.js')}}"></script>
@endsection
