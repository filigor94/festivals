@extends('admin.layouts.admin-master')

@section('content-header')
    <h1>
        Festivals
        <a href="{{ route('admin.festivals.create') }}" class="btn btn-success btn-xs">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add new
        </a>
    </h1>
@endsection

@section('content')
    <div id="festivals-list">
        @include('admin.includes.festivals-list')
    </div>

    <!-- Festivals Modal -->
    <div class="modal fade bs-example-modal-lg" id="festival" tabindex="-1" role="dialog" aria-labelledby="festivalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="festivalLabel">Update festival</h4>
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

        function editFestival(obj) {
            $('#festivalBody').html('<img src="http://rpg.drivethrustuff.com/shared_images/ajax-loader.gif"/>');
            url = '/admin/festivals/' + obj.attr('data-id') + '/edit';

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
        }
    </script>
@endsection