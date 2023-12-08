@extends('layouts.driver')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <form action="{{route('driver.update', $driver->id)}}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="mb-4 fs-4">Update any time</div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="name">Name</label>
                                <input id="name" name="name" class="form-control" value="{{$driver->name}}"/>
                                @error('name')
                                <div class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="email">Email address</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{$driver->email}}"/>
                                @error('email')
                                <div class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="location">Location</label>
                                <select id="location" name="location" class="form-control" value="{{$driver->location}}">
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
                            <div class="form-outline mb-4">
                                <label class="form-label" for="phone">Phone</label>
                                <input type="number" id="phone" name="phone" class="form-control" value="{{$driver->phone}}"/>
                                @error('phone')
                                <div class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-block mb-4">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="map" style="height: 500px; width: 100%">Your current location</div>
    </div>
    <script type="module">

        const view = new ol.View({
            center: [0, 0],
            zoom: 2,
        });

        const map = new ol.Map({
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM(),
                }),
            ],
            target: 'map',
            view: view,
        });

        const geolocation = new ol.Geolocation({
            trackingOptions: {
                enableHighAccuracy: true,
            },
            projection: view.getProjection(),
        });
        geolocation.setTracking(true);

        const accuracyFeature = new ol.Feature();
        geolocation.on('change:accuracyGeometry', function () {
            accuracyFeature.setGeometry(geolocation.getAccuracyGeometry());
        });

        const positionFeature = new ol.Feature();
        positionFeature.setStyle(
            new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 6,
                    fill: new ol.style.Fill({
                        color: '#3399CC',
                    }),
                    stroke: new ol.style.Stroke({
                        color: '#fff',
                        width: 2,
                    }),
                }),
            })
        );

        geolocation.on('change:position', function () {
            const coordinates = geolocation.getPosition();
            positionFeature.setGeometry(coordinates ? new ol.geom.Point(coordinates) : null);
        });

        new ol.layer.Vector({
            map: map,
            source: new ol.source.Vector({
                features: [accuracyFeature, positionFeature],
            }),
        });

    </script>
@endsection
