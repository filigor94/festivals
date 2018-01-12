@extends('admin.layouts.admin-master')

@section('styles')
    <style>
        #map {
            height: 400px;
        }
    </style>
@endsection

@section('content-header')
    <h1>
        Create Festival
        <small>Optional description</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('festivals.store') }}" method="post" enctype="multipart/form-data" role="form">
        {{ csrf_field() }}

        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Event</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
                    </div>

                    <!-- Date and time range -->
                    <div class="form-group">
                        <label>Duration range:</label>

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <input type="text" name="daterange" class="form-control pull-right" id="reservationtime">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                    <div class="form-group">
                        <label for="exampleInputFile">Featured image</label>
                        <input type="file" id="image" name="image">

                        <p class="help-block">Allowed types: jpg, png, bmp, gif</p>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Address</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" name="country" class="form-control" id="country" placeholder="Enter country">
                    </div>

                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" class="form-control" id="city" placeholder="Enter city">
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" id="address" placeholder="Enter street">
                    </div>

                    <input type="hidden" name="map_lat" id="map_lat">
                    <input type="hidden" name="map_lng" id="map_lng">

                    <div class="row">
                        <div class="col-xs-12">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbKh3KgPDE67rPkoO67_V_SJdt5wsvJjw&callback=initMap"
            type="text/javascript"></script>

    <script type="text/javascript">
        var marker;
        var createProblemLat;
        var createProblemLng;

        $(function() {
            $('input[name="daterange"]').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY h:mm A'
                }
            });
        });

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

        function setMarkers(map) {
            // Adds markers to the map.

            var beaches = JSON.parse($('#latest_problems').val());

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
                var marker2 = new google.maps.Marker({
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
    </script>
@endsection