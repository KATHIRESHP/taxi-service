@extends('layouts.driver')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center vh-100 gap-4">
        <div class="card p-5 col-8 col-md-6 col-lg-4 col-xl-3">
            <div class="card-title">
                View the map the location details
            </div>
            <div class="card-body">
               <div>
                   Ride status: <span class="badge {{($ride->status == "ongoing" ? "bg-danger" : "bg-success")}}">{{$ride->status}}</span>
                   <br><span>Distance: {{$ride->distance}} (approx)</span>
               </div>
                <div>
                    @if($ride->status == 'pending')
                       <a href="{{route('driver.ride.requests')}}" class="btn btn-link fs-5"> << back</a>
                    @endif
                   @if($ride->status == 'ongoing')
                        <form action="{{route('driver.ride.pickup', $ride->id)}}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-success" type="submit">Customer PickUp</button>
                        </form>
                   @endif
                   @if($ride->status == 'picked')
                        <form action="{{route('driver.ride.complete', $ride->id)}}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-success" type="submit">Complete Ride</button>
                        </form>
                   @endif
                   @if($ride->status == 'payment')
                        Total Fare: <span class="badge bg-success fs-5">₹{{$ride->payment->amount}}</span>
                   @endif
                </div>
            </div>
        </div>
        <div class="h-75 w-75">
            <div class="d-flex justify-content-between">
                <span class="badge bg-danger">Red is destination</span>
                <span class="badge bg-primary">Blue is your location</span>
                <span class="badge bg-success">Green is source</span>
            </div>
            <div id="map" class="h-100 w-100 bg-secondary" title="scroll if map is not visible"></div>
        </div>
    </div>
    <script type="text/javascript">
        var ride = {!! json_encode($ride) !!};
    </script>
    <script type="text/javascript" src="{{asset('asset/js/driver/ShowRide.js')}}"></script>
@endsection
