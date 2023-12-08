$(document).ready(function () {

    console.log("Js linked");
    let isSourceLocationSet = false;
    let isDestinationLocationSet = false;
    let place = [8633089.579710623, 1456402.0692901225]; //8633089.579710623, 1456402.0692901225
    let centerCoordinates = place, currentLocation = [];

    const view = new ol.View();

    const geolocation = new ol.Geolocation({
        trackingOptions: {
            enableHighAccuracy: true,
        },
        projection: view.getProjection(),
    });
    geolocation.setTracking(true);
    geolocation.on("change", function () {
        const coordinates = geolocation.getPosition();
        currentLocation = [coordinates[1], coordinates[0]];
        console.log(place)
    })

    const openSource = () => {
        $('#your-location').fadeToggle(1000);
        $('#current-location').fadeToggle(1000);
        $('#choose-source-location').fadeToggle(1000);
        $('#destination-location').fadeOut(1000);
        $('#choose-destination-location').fadeOut(1000);
    }

    const openDestination = () => {
        $('#your-location').fadeOut(1000);
        $('#current-location').fadeOut(1000);
        $('#choose-source-location').fadeOut(1000);
        $('#choose-destination-location').fadeToggle(1000);
    }

    $('#source').on('click', function () {
        console.log("Source clicked")
        openSource();
        console.log('src toggling')
    })
    $('#destination').on('click', function () {
        openDestination();
        console.log('dest toggling')
    })
    $('#current-location').on('click', function (e) {
        e.preventDefault();
            $('#source_latitude').val(currentLocation[0]);
            $('#source_longitude').val(currentLocation[1]);
            isSourceLocationSet = true;
            console.log($('#source_latitude').val(), $('#source_longitude').val());
        openDestination();
    })
    $("#choose-source-location").on('click', function (e) {
        e.preventDefault();
        console.log(centerCoordinates);
        if (confirm("The green will be your source location")) {
            $('#source_latitude').val(centerCoordinates[1]);
            $('#source_longitude').val(centerCoordinates[0]);
            isSourceLocationSet = true;
            openDestination();
        }
    })
    $("#choose-destination-location").on('click', function (e) {
        e.preventDefault();
        if (confirm("The green will be your destination location")) {
            $('#destination_latitude').val(centerCoordinates[1]);
            $('#destination_longitude').val(centerCoordinates[0]);
            isDestinationLocationSet = true;
            console.log("Dest let long set", centerCoordinates[1], centerCoordinates[0]);
            $("#choose-destination-location").fadeOut();
        }
    })
    $('#form-submit-btn').on('click', function (e) {
        e.preventDefault();
        if (confirm("Please confirm")) {
            if (isSourceLocationSet) {
                if (isDestinationLocationSet) {
                    if ($('#time').val()) {
                        $('#rideForm').submit();
                    } else {
                        alert("choose time of pickup!");
                    }
                } else {
                    alert("choose destination location!");
                }
            } else {
                alert("choose source location!");
            }
        }
    })

    function mapSetUp() {
        const map = new ol.Map({
            view: new ol.View({
                center: place,
                zoom: 8,
            }),
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                }),
            ],
            target: "map",
        });

        // Create a marker at the center of the map
        const centerMarker = new ol.Feature({
            geometry: new ol.geom.Point(place),
        });

        // Marker style
        const markerStyle = new ol.style.Style({
            image: new ol.style.Circle({
                radius: 6,
                fill: new ol.style.Fill({color: 'green'}),
                stroke: new ol.style.Stroke({color: 'white', width: 2}),
            }),
        });

        centerMarker.setStyle(markerStyle);

        const markerLayer = new ol.layer.Vector({
            source: new ol.source.Vector({
                features: [centerMarker],
            }),
        });

        map.addLayer(markerLayer);

        map.getView().on('change:center', function () {
            centerCoordinates = map.getView().getCenter();
            centerMarker.getGeometry().setCoordinates(centerCoordinates);
        });
    }

    mapSetUp();
})
