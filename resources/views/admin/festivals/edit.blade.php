{!! Form::model($festival, ['route' => ['admin.festivals.store', $festival->id], 'method' => 'put', 'files' => true, 'id' => 'editFestival']) !!}
    <div class="modal-body" id="festivalBody" style="overflow: auto;">
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

                            <?php
                                $daterange = \Carbon\Carbon::parse($festival->start_date)->format('m/d/Y H:i A') . ' - ' . \Carbon\Carbon::parse($festival->end_date)->format('m/d/Y H:i A');
                            ?>

                            {!! Form::text('daterange', $daterange, ['class' => 'form-control pull-right', 'id' => 'reservationtime']) !!}
                        </div>
                        <!-- /.input group -->

                        @if($errors->has('daterange'))
                            <span class="help-block">
                                <strong>{{ $errors->first('daterange') }}</strong>
                            </span>
                        @endif
                    </div>
                    <!-- /.form group -->

                    <div class="row">
                        <div class="col-xs-12">
                            <img src="{{ $festival->image }}" class="img-responsive" style="object-fit: contain; max-height: 300px;">
                        </div>
                    </div>

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
                        {!! Form::text('country', $festival->address->country, ['class' => 'form-control']) !!}
                        @if($errors->has('country'))
                            <span class="help-block">
                                <strong>{{ $errors->first('country') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                        {!! Form::label('city', 'City') !!}
                        {!! Form::text('city', $festival->address->city, ['class' => 'form-control']) !!}
                        @if($errors->has('city'))
                            <span class="help-block">
                                <strong>{{ $errors->first('city') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        {!! Form::label('address', 'Address') !!}
                        {!! Form::text('address', $festival->address->address, ['class' => 'form-control']) !!}
                        @if($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>

                    <?php
                        $coordinates[] = ['', (double)$festival->address->map_lat, (double)$festival->address->map_lng, 0];
                    ?>

                    {!! Form::hidden('coordinates', json_encode($coordinates), ['id' => 'coordinates']) !!}
                    {!! Form::hidden('map_lat', $festival->address->map_lat, ['id' => 'map_lat']) !!}
                    {!! Form::hidden('map_lng', $festival->address->map_lng, ['id' => 'map_lng']) !!}

                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        <div id="map-with-locations"></div>
                        @if($errors->has('map_lat') || $errors->has('map_lng'))
                            <span class="help-block">
                                <strong>{{ $errors->first('map_lat') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12" style="display: none;">
            <div id="errors" class="alert fresh-color alert-danger">

            </div>
        </div>
    </div>
    <div class="modal-footer">
        {!! Form::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
        {!! Form::submit('Save changes', ['class' => 'btn btn-primary']) !!}
    </div>
{!! Form::close() !!}

<script type="text/javascript">
    var url;

    $(function() {
        $('input[name="daterange"]').daterangepicker({
            timePicker: true,
            timePickerIncrement: 5,
            locale: {
                format: 'MM/DD/YYYY h:mm A'
            }
        });

        initMapLocations($('#coordinates').val());
    });

    $('#editFestival').on('submit', function (e) {
        e.preventDefault();

        var createProblemFormData = new FormData(this);

        url = '/admin/festivals/{{  $festival->id }}';

        $.ajax({
            type: "POST",
            data: createProblemFormData,
            url: url,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#festivals-list').html(data);
                $('#festival').modal('hide');
            },
            error: function (xhr, status, error) {
                //console.log("error " + xhr + "\n" + status + "\n" + error);
                var errors = xhr.responseJSON['errors'];
                var message = '<ul>';
                $.each( errors , function( key, value ) {
                    message += '<li>' + value + '</li>';
                });
                message += '</ul>';
                $('#errors').html(message);
                $('#errors').parent().css({'display': 'block'});
            }
        });
    })
</script>