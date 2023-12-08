@extends('layouts.user')

@section('content')
    <div style="width: 100%; height: 100%"
         class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-2 mt-5">
        <form class="d-flex flex-column gap-4 p-4 rounded border border-1 border-black col-8 col-sm-6 col-md-4 col-lg-3"
              action="{{route('user.ride.store')}}"
              id="rideForm"
              method="POST">
            @csrf
            <span>Choose the ride</span>
            <span id="source" class="btn btn-primary">Source</span>
            <input type="hidden" class="form-control" name="source_latitude" value="" id="source_latitude"
                   placeholder="Source" readonly>
            <input type="hidden" class="form-control" name="source_longitude" value="" id="source_longitude"
                   placeholder="Source" readonly>
            <div class="form-outline" id="your-location" style="display: none">
                <select id="location" name="location" class="form-control" value="{{old('location')}}">
                    <option value="Coimbatore">Coimbatore</option>
                    <option value="Tiruppur">Tiruppur</option>
                    <option value="Karur">Karur</option>
                </select>
                @error('location')
                <div class="text-danger">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
            <button id="current-location" class="btn btn-success" style="display: none;">Current location
            </button>
            <button id="choose-source-location" class="btn btn-success" style="display: none;">Choose source location
            </button>
            @error('source_longitude')
            <p class="text-danger">{{$message}}</p>
            @enderror
            <span id="destination" class="btn btn-primary ">Destination</span>
            <input type="hidden" class="form-control" name="destination_latitude" value="" id="destination_latitude"
                   placeholder="Source" readonly>
            <input type="hidden" class="form-control" name="destination_longitude" value="" id="destination_longitude"
                   placeholder="Source" readonly>
            <button id="choose-destination-location" class="btn btn-success" style="display: none;">Choose destination
                location
            </button>
            @error('destination_longitude')
            <p class="text-danger">{{$message}}</p>
            @enderror
            <input type="time" class="form-control" name="time" value="" id="time" placeholder="Pickup time">
            @error('time')
            <p class="text-danger">{{$message}}</p>
            @enderror
            <button type="submit" class="btn btn-outline-success" id="form-submit-btn">Book</button>
        </form>
        <div class="map h-75 w-75" id="map">Green will always point to the center, Kindly adjust the map to point,</div>
    </div>
    <script type="module" src="{{asset('asset/js/user/CreateRide.js')}}"></script>
@endsection
