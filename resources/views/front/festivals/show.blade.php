<div class="row">
    <div class="col-xs-12">
        <img class="img-responsive" src="{{ $festival->image }}" alt="">
        <h2>
            {{ $festival->title }}
        </h2>
        <hr>
        <p>
            <strong>Appointment:</strong>
            {{ \Carbon\Carbon::parse($festival->start_date)->toDayDateTimeString() . ' - ' . \Carbon\Carbon::parse($festival->end_date)->toDayDateTimeString() }}
        </p>
        <p>
            <strong>Location: </strong>
            {{ $festival->address->country . ', ' . $festival->address->city . ', ' . $festival->address->address }}
        </p>

        <?php
            $coordinates[] = ['', (double)$festival->address->map_lat, (double)$festival->address->map_lng, 0];
        ?>

        {!! Form::hidden('coordinates', json_encode($coordinates), ['id' => 'coordinates']) !!}

        <div id="map-with-locations"></div>
        <hr>
        <p>{{ $festival->description }}</p>
        <hr>
        <div class="checkbox">
            <label class="h4">
                <input type="checkbox" value="on" name="attend" id="attend"> <strong>I will attend</strong>
            </label>
        </div>
        <div id="personalData" style="display: none;">
            {!! Form::open(['route' => ['visitors.store', $festival->id], 'method' => 'post']) !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            {!! Form::label('first_name', 'First name') !!}
                            {!! Form::text('first_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            @if($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            {!! Form::label('last_name', 'Last name') !!}
                            {!! Form::text('last_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            @if($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {!! Form::label('email', 'Email') !!}
                            {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            @if($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <button type="submit" class="festival-details btn btn-primary btn-md pull-right" data-id="{{ $festival->id }}">Apply <span class="glyphicon glyphicon-pencil"></span></button>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script>
    $(function() {
        initMapLocations($('#coordinates').val(), true);
    });

    $('#attend').on('change', function () {
        if ($('#attend').is(':checked')) {
            $('#personalData').css({'display': 'block'});
        } else {
            $('#personalData').css({'display': 'none'});
        }
    })
</script>