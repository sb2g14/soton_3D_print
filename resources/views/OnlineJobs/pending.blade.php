@extends('layouts.layout')

@section('content')
    {{--NAVIGATION--}}
    <div class="container text-center m-b-md">
        <ul class="nav nav-pills nav-justified">
            <li><a href="/OnlineJobs/requests">Requests <span class="badge">{{$counts['requests']}}</span></a></li>
            <li><a href=/OnlineJobs/approved>Approved Jobs <span class="badge">{{$counts['approved']}}</span></a></li>
            <li class="nav-left active"><a href="#">Pending Jobs <span class="badge">{{$counts['pending']}}</span></a></li>
            <li class="nav-right"><a href="/OnlineJobs/prints">Prints</a></li>
            <li><a href="/OnlineJobs/finished">Completed Jobs</a></li>
        </ul>
    </div>
    {{--CONTENT--}}
    <div class="container">
        <table class="table table-sm table-hover table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Job title</th>
                    <th>Requested on</th>
                    <th>Last updated</th>
                    <th>Job controls</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pending_jobs as $job)
                    <tr class="text-center">
                        <td data-th="#">{{ $job->id }}</td>
                        <td data-th="Name">{{$job->customer_name}}</td>
                        <td data-th="Job title">{{$job->job_title}}</td>
                        <td data-th="Requested on">{{ $job->created_at->formatLocalized('%d %b, %H:%M') }}</td>
                        <td data-th="Accepted on">{{ Carbon\Carbon::parse($job->updated_at)->diffForHumans() }}</td>
                        <td data-th="Job controls">
                            <a href="/OnlineJobs/pending/{{$job->id}}" class="btn btn-info">Review Job</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
