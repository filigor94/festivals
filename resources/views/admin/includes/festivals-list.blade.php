@if(count($festivals))
    <table class="table table-striped table-responsive">
        <thead>
        <tr>
            <th></th>
            <th>Title</th>
            <th>Begins</th>
            <th>Ends</th>
            <th>Applicants</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach($festivals as $festival)
                <tr>
                    <td><img src="{{ $festival->image }}"></td>
                    <td>{{ $festival->title }}</td>
                    <td>{{ Carbon\Carbon::parse($festival->start_date)->toDayDateTimeString() }}</td>
                    <td>{{ Carbon\Carbon::parse($festival->end_date)->toDayDateTimeString() }}</td>
                    <td><a href="{{ route('admin.festivals.applicants', ['festival' => $festival->id]) }}">View</a></td>
                    <td>
                        <button type="button" class="edit-festival btn btn-primary btn-xs" data-id="{{ $festival->id }}" onclick="editFestival($(this))">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                        </button>

                        {!! Form::open(['route' => ['admin.festivals.destroy', $festival->id], 'method' => 'delete', 'style' => 'display: inline-block']) !!}
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
@endif