@extends('layouts.layout')

@section('content')
    {{--NAVIGATION--}}
    <div class="container text-center m-b-md">
        <ul class="nav nav-pills nav-justified">
            <li class="active"><a href="#">Requests <span class="badge">{{$counts['requests']}}</span></a></li>
            <li><a href="/OnlineJobs/approved">Approved Jobs <span class="badge">{{$counts['approved']}}</span></a></li>
            <li class="nav-left"><a href="/OnlineJobs/pending">Pending Jobs <span class="badge">{{$counts['pending']}}</span></a></li>
            <li class="nav-right"><a href="/OnlineJobs/prints">Prints</a></li>
            <li><a href="/OnlineJobs/finished">Completed Jobs</a></li>
        </ul>
    </div>
    {{--CONTENT--}}
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Requested by</th>
                    <th>Job Title</th>
                    <th>Project/Cost Code</th>
                    <th>Requested on</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                    <tr class="text-left">
                        <td data-th="Job ID">{{$job->id}}</td>
                        <td data-th="Requested by">{{$job->customer_name}}</td>
                        <td data-th="Job Title">{{ $job->job_title }}</td>
                        <td data-th="Project/Cost Code">{{ $job->use_case}}</td>
                        <td data-th="Requested on">{{ $job->created_at->formatLocalized('%d %b, %H:%M') }}</td>
                        <td><a href="/OnlineJobs/request/{{$job->id}}" class="btn btn-info">Manage</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
