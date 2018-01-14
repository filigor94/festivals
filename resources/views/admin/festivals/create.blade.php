@extends('admin.layouts.admin-master')

@section('content-header')
    <h1>
        Create Festival
    </h1>
@endsection

@section('content')
    {!! Form::open(['route' => 'admin.festivals.store', 'method' => 'post', 'files' => true]) !!}
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

        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-footer">
                    <a href="{{ route('admin.festivals.index') }}" class="btn btn-danger">Cancel</a>
                    {!! Form::submit('Create', ['class' => 'btn btn-primary pull-right']) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                timePicker: true,
                timePickerIncrement: 5,
                locale: {
                    format: 'MM/DD/YYYY h:mm A'
                }
            });
        });

        $(window).on('load', function () {
            initMap();
        })
    </script>
@endsection