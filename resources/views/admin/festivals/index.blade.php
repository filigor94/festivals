@extends('admin.layouts.admin-master')

@section('content-header')
    <h1>
        Festivals
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol>
@endsection

@section('content')
    <table class="table table-striped table-responsive">
        <thead>
        <tr>
            <th></th>
            <th>Title</th>
            <th>Begins</th>
            <th>Ends</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach($festivals as $festival)
                <tr>
                    <td><img src="{{ $festival->image }}" class="img-responsive" style="width: 100px;"></td>
                    <td>{{ $festival->title }}</td>
                    <td>{{ $festival->start_date }}</td>
                    <td>{{ $festival->end_date }}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-xs">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                        </button>

                        {!! Form::open(['route' => ['festivals.destroy', $festival->id], 'method' => 'delete', 'style' => 'display: inline-block']) !!}
                            <button type="submit" class="btn btn-danger btn-xs">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
                            </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $festivals->links() }}
@endsection