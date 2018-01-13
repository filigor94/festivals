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
    {!! Form::open(['route' => 'festivals.store', 'method' => 'post', 'files' => true]) !!}
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Event</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        {!! Form::label('title', 'Title') !!}
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}
                        @if($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <!-- Date and time range -->
                    <div class="form-group{{ $errors->has('daterange') ? ' has-error' : '' }}">
                        {!! Form::label('reservationtime', 'Duration range') !!}

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            {!! Form::text('daterange', null, ['class' => 'form-control pull-right', 'id' => 'reservationtime']) !!}
                        </div>
                        <!-- /.input group -->

                        @if($errors->has('daterange'))
                            <span class="help-block">
                                <strong>{{ $errors->first('daterange') }}</strong>
                            </span>
                        @endif
                    </div>
                    <!-- /.form group -->

                    <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                        {!! Form::label('image', 'Featured image') !!}
                        {!! Form::file('image', ['accept' => 'image/*']) !!}

                        <p class="help-block">Allowed types: jpg, png, bmp, gif</p>
                        @if($errors->has('image'))
                            <span class="help-block">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        {!! Form::label('description', 'Description') !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
                        @if($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Address</h3>
                </div>
                <div class="box-body">
                    <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                        {!! Form::label('country', 'Country') !!}
                        {!! Form::text('country', null, ['class' => 'form-control']) !!}
                        @if($errors->has('country'))
                            <span class="help-block">
                                <strong>{{ $errors->first('country') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                        {!! Form::label('city', 'City') !!}
                        {!! Form::text('city', null, ['class' => 'form-control']) !!}
                        @if($errors->has('city'))
                            <span class="help-block">
                                <strong>{{ $errors->first('city') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        {!! Form::label('address', 'Address') !!}
                        {!! Form::text('address', null, ['class' => 'form-control']) !!}
                        @if($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>

                    {!! Form::hidden('map_lat', null, ['id' => 'map_lat']) !!}
                    {!! Form::hidden('map_lng', null, ['id' => 'map_lng']) !!}

                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        <div id="map"></div>
                        @if($errors->has('map_lat') || $errors->has('map_lng'))
                            <span class="help-block">
                                <strong>{{ $errors->first('map_lat') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
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
                timePickerIncrement: 5,
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