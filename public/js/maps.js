var marker;
var createProblemLat;
var createProblemLng;

function initMap() {
    marker = false;
    var subotica = {lat: 46.101196, lng: 19.665872};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: subotica
    });

    map.addListener("click", function (event) {
        var latitude = createProblemLat = event.latLng.lat();
        var longitude = createProblemLng = event.latLng.lng();

        $('#map_lat').val(latitude);
        $('#map_lng').val(longitude);

        console.log( latitude + ', ' + longitude );
        placeMarkerAndPanTo(event.latLng, map);

        geocodeLatLng(geocoder, map, infowindow);
    }); //end addListener

    var geocoder = new google.maps.Geocoder;
    var infowindow = new google.maps.InfoWindow;
}

function initMapLocations(data, disabled_click) {
    marker = true;
    var beaches = JSON.parse(data);
    var location = {lat: beaches[0][1], lng: beaches[0][2]};
    var map = new google.maps.Map(document.getElementById('map-with-locations'), {
        zoom: 13,
        center: location
    });

    if (!disabled_click) {
        map.addListener("click", function (event) {
            var latitude = createProblemLat = event.latLng.lat();
            var longitude = createProblemLng = event.latLng.lng();

            $('#map_lat').val(latitude);
            $('#map_lng').val(longitude);

            console.log( latitude + ', ' + longitude );
            placeMarkerAndPanTo(event.latLng, map);

            geocodeLatLng(geocoder, map, infowindow);
        }); //end addListener

        var geocoder = new google.maps.Geocoder;
        var infowindow = new google.maps.InfoWindow;
    }

    setMarkers(map, beaches);
}

function setMarkers(map, beaches) {
    // Marker sizes are expressed as a Size of X,Y where the origin of the image
    // (0,0) is located in the top left of the image.

    // Origins, anchor positions and coordinates of the marker increase in the X
    // direction to the right and in the Y direction down.

    // Shapes define the clickable region of the icon. The type defines an HTML
    // <area> element 'poly' which traces out a polygon as a series of X,Y points.
    // The final coordinate closes the poly by connecting to the first coordinate.
    var shape = {
        coords: [1, 1, 1, 20, 18, 20, 18, 1],
        type: 'poly'
    };
    for (var i = 0; i < beaches.length; i++) {
        var beach = beaches[i];
        marker = new google.maps.Marker({
            position: {lat: beach[1], lng: beach[2]},
            map: map,
            shape: shape,
            title: beach[0],
            zIndex: beach[3]
        });
    }
}

function geocodeLatLng(geocoder, map, infowindow) {
    var input = createProblemLat + ',' + createProblemLng;
    var latlngStr = input.split(',', 2);
    var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
    geocoder.geocode({'location': latlng}, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
                createProblemLatLngFormattedAddress = results[0].formatted_address;
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
            } else {
                window.alert('No results found');
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
}

function placeMarkerAndPanTo(latLng, map) {
    if (!marker) {
        marker = new google.maps.Marker({
            position: latLng,
            map: map
        });
        map.panTo(latLng);
    } else {
        marker.setPosition(latLng);
    }
}