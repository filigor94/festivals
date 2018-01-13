@extends('admin.layouts.admin-master')

@section('content-header')
    <h1>
        Festivals
        <a href="{{ route('festivals.create') }}" class="btn btn-success btn-xs">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add new
        </a>
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
                    <td><img src="{{ $festival->image }}" class="img-responsive"></td>
                    <td>{{ $festival->title }}</td>
                    <td>{{ $festival->start_date }}</td>
                    <td>{{ $festival->end_date }}</td>
                    <td>
                        <button type="button" class="edit-festival btn btn-primary btn-xs" data-id="{{ $festival->id }}">
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

    <!-- Festivals Modal -->
    <div class="modal fade bs-example-modal-lg" id="festival" tabindex="-1" role="dialog" aria-labelledby="festivalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="festivalLabel">Modal title</h4>
                </div>
                <div id="festivalBody">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var url;

        $('.edit-festival').on('click', function () {
            url = '/admin/festivals/' + $(this).attr('data-id') + '/edit';

            $.ajax({
                type: "GET",
                url: url,
                async: true,
                cache: false,
                success: function (data) {
                    $('#festivalBody').html(data);
                },
                error: function (xhr, status, error) {
                    console.log("error " + xhr + "\n" + status + "\n" + error);
                }
            });

            $('#festival').modal('show');
        });
    </script>
@endsection