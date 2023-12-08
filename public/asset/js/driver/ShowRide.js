$(document).ready(function () {
    console.log(ride);
    let source = [ride.source_longitude, ride.source_latitude];
    let destination = [ride.destination_longitude, ride.destination_latitude];
    console.log(source);
    console.log(destination);
    let place = [0, 0], driverCoordinates;

    function currentLocation() {
        return new Promise(resolve => {
            const view = new ol.View();

            const geolocation = new ol.Geolocation({
                trackingOptions: {
                    enableHighAccuracy: true,
                },
                projection: view.getProjection(),
            });
            geolocation.setTracking(true);
            geolocation.on("change:position", function () {
                driverCoordinates = geolocation.getPosition();
                console.log(driverCoordinates);
                if(driverCoordinates) {
                    resolve(driverCoordinates);
                }
            })
        })
    }
    async function mapSetUp() {
        console.log("Promise requested");
        await currentLocation();
        console.log("Promise received");
        const map = new ol.Map({
            view: new ol.View({
                center: source,
                zoom: 5,
            }),
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                }),
            ],
            target: "map",
        });


        // Create a marker at the center of the map
        const sourceMarker = new ol.Feature({
            geometry: new ol.geom.Point(source),
        });
        const destinationMarker = new ol.Feature({
            geometry: new ol.geom.Point(destination),
        });
        const currentLocationMarker = new ol.Feature({
            geometry: new ol.geom.Point(driverCoordinates),
        });

        // Marker style
        const sourceMarkerStyle = new ol.style.Style({
            image: new ol.style.Circle({
                radius: 6,
                fill: new ol.style.Fill({color: 'green'}),
                stroke: new ol.style.Stroke({color: 'white', width: 2}),
            }),
        });
        const destinationMarkerStyle = new ol.style.Style({
            image: new ol.style.Circle({
                radius: 6,
                fill: new ol.style.Fill({color: 'red'}),
                stroke: new ol.style.Stroke({color: 'white', width: 2}),
            }),
        });
        const currentLocationMarkerStyle = new ol.style.Style({
            image: new ol.style.Circle({
                radius: 6,
                fill: new ol.style.Fill({color: 'blue'}),
                stroke: new ol.style.Stroke({color: 'white', width: 2}),
            }),
        });

        sourceMarker.setStyle(sourceMarkerStyle);
        destinationMarker.setStyle(destinationMarkerStyle);
        currentLocationMarker.setStyle(currentLocationMarkerStyle);

        // Marker layer
        const markerLayer = new ol.layer.Vector({
            source: new ol.source.Vector({
                features: [sourceMarker, destinationMarker, currentLocationMarker],
            }),
        });

        map.addLayer(markerLayer);
    }

    mapSetUp();
});
