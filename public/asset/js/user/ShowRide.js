$(document).ready(function () {
    console.log(ride);
    let source = [ride.source_longitude, ride.source_latitude];
    let destination = [ride.destination_longitude, ride.destination_latitude];

    function mapSetUp() {
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

        sourceMarker.setStyle(sourceMarkerStyle);
        destinationMarker.setStyle(destinationMarkerStyle);
        let markLayer;
        if (ride.driver) {
            let driverLocation = [ride.driver.longitude, ride.driver.latitude];
            const driverLocationMarker = new ol.Feature({
                geometry: new ol.geom.Point(driverLocation),
            });

            const driverLocationMarkerStyle = new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 6,
                    fill: new ol.style.Fill({color: 'blue'}),
                    stroke: new ol.style.Stroke({color: 'white', width: 2}),
                }),
            });
            driverLocationMarker.setStyle(driverLocationMarkerStyle);
            markerLayer = new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: [sourceMarker, destinationMarker, driverLocationMarker],
                }),
            });
        } else {
            markerLayer = new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: [sourceMarker, destinationMarker],
                }),
            });
        }
        map.addLayer(markerLayer);
    }

    mapSetUp();
});
