@extends('front.layouts.master')

@section('content')
    @if(count($festivals))
        <div class="col-md-8 col-md-offset-2">
            @foreach($festivals as $festival)
                <img class="img-responsive" src="{{ $festival->image }}" alt="">
                <h2>
                    <a href="#">{{ $festival->title }}</a>
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
                <button type="button" class="festival-details btn btn-primary btn-md" data-id="{{ $festival->id }}">Read More <span class="glyphicon glyphicon-chevron-right"></span></button>
                <hr>
            @endforeach

            {{ $festivals->links() }}
        </div>
    @endif

    <!-- Modal -->
    <div class="modal fade bs-example-modal-lg" id="festivalModal" tabindex="-1" role="dialog" aria-labelledby="festivalModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="festivalModalLabel">Festival details</h4>
                </div>
                <div class="modal-body" id="festivalBody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var url;

        $('.festival-details').on('click', function () {
            $('#festivalBody').html('<img src="http://rpg.drivethrustuff.com/shared_images/ajax-loader.gif"/>');
            url = '/festivals/' + $(this).attr('data-id');

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

            $('#festivalModal').modal('show');
        })
    </script>
@endsection