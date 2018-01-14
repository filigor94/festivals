@extends('admin.layouts.admin-master')

@section('content-header')
    <h1>
        Applicants for {{ $festival->title }}
    </h1>
@endsection

@section('content')
    @if(count($applicants))
        <table class="table table-striped table-responsive">
            <thead>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Applied</th>
            </tr>
            </thead>
            <tbody>
            @foreach($applicants as $applicant)
                <tr>
                    <td>{{ $applicant->first_name }}</td>
                    <td>{{ $applicant->last_name }}</td>
                    <td><a href="mailto:{{ $applicant->email }}">{{ $applicant->email }}</a></td>
                    <td>{{ Carbon\Carbon::parse($applicant->created_at)->toDayDateTimeString() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $applicants->links() }}
    @endif
@endsection