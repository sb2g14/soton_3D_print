@extends('layouts.layout')

@section('content')
    {{--SESSION MESSAGE--}}
    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
            {{ $flash }}
        </div>
    @endif
    {{--NAVIGATION--}}
    <div class="container text-center m-b-md">
        <ul class="nav nav-pills nav-justified">
            <li><a href="/OnlineJobs/requests">Requests <span class="badge">{{$counts['requests']}}</span></a></li>
            <li><a href=/OnlineJobs/approved>Approved Jobs <span class="badge">{{$counts['approved']}}</span></a></li>
            <li class="nav-left"><a href="/OnlineJobs/pending">Pending Jobs <span class="badge">{{$counts['pending']}}</span></a></li>
            <li class="nav-right"><a href="/OnlineJobs/prints">Prints</a></li>
            <li class="active"><a href="#">Completed Jobs</a></li>
        </ul>
    </div>
    {{--CONTENT--}}
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Job Title</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Created</th>
                    <th>Finished</th>
                    <th>Approved by</th>
                    <th>Status</th>
                    <th>Job controls</th>
                </tr>
            </thead>
            <tbody>
                @foreach($completed_jobs as $job)
                    @php
                        if($job->status === 'Success'){
                           $jobclass = "p-success";
                        }else{
                           $jobclass = "p-failed";
                        }
                    @endphp
                    <tr class="text-left {{$jobclass}}">
                        <td data-th="ID">{{ $job->id }}</td>
                        <td data-th="Job Title">{{ $job->job_title }}</td>
                        <td data-th="Name">{{$job->customer_name}}</td>
                        <td data-th="Price">£{{ $job->total_price }}</td>
                        <td data-th="Created on">{{ $job->created_at->formatLocalized('%d %b, %H:%M') }}</td>
                        <td data-th="Last updated on">{{ $job->finished_at()->formatLocalized('%d %b, %H:%M') }}</td>
                        <td data-th="Approved by">{{ $job->staff_approved->name() }}</td>
                        <td data-th="Status">{{ $job->status }}</td>
                        <td data-th="Job controls">
                            <a href="/OnlineJobs/{{$job->id}}" class="btn btn-info">Review Job</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
