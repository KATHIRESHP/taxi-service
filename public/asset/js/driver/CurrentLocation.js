$(document).ready(function () {
    // var latitude, longitude;
    // const success = (position) => {
    //     latitude = position.coords.latitude;
    //     longitude = position.coords.longitude;
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     console.log(latitude, longitude);
    //     const formData = new FormData();
    //     formData.append('latitude', latitude);
    //     formData.append('longitude', longitude);
    //     $.ajax({
    //         type: "POST",
    //         url: "/driver/updatelocation",
    //         data: formData,
    //         dataType: "json",
    //         contentType: false,
    //         processData: false,
    //         success: function (response) {
    //             console.log("Ajax success", response);
    //         },
    //         error: function (error) {
    //             console.log("Ajax Error: ", error);
    //         }
    //     })
    // }
    // const error = (e) => {
    //     if (e.message === "User denied Geolocation") {
    //         alert("You should allow location access!");
    //     } else {
    //         alert("Error in getting location");
    //     }
    // }
    // navigator.geolocation.getCurrentPosition(success, error);
    // setInterval(() => {
    //     navigator.geolocation.getCurrentPosition(success, error);
    // }, 30000);

    const view = new ol.View();

    const geolocation = new ol.Geolocation({
        trackingOptions: {
            enableHighAccuracy: true,
        },
        projection: view.getProjection(),
    });
    geolocation.setTracking(true);
    geolocation.on("change:position", function () {
        const coordinates = geolocation.getPosition();
        // console.log(coordinates, "Driver current location");
        const formData = new FormData();
        formData.append('latitude', coordinates[1]);
        formData.append('longitude', coordinates[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/driver/updatelocation",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                console.log("Ajax success", response);
            },
            error: function (error) {
                console.log("Ajax Error: ", error);
            }
        })
    })

});
