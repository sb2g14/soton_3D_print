@extends('layouts.layout')

@section('content')
    {{--NAVIGATION--}}
    <div class="container text-center m-b-md">
        <ul class="nav nav-pills nav-justified">
            <li><a href="/OnlineJobs/requests">Requests <span class="badge">{{$counts['requests']}}</span></a></li>
            <li class="active"><a href="#">Approved Jobs <span class="badge">{{$counts['approved']}}</span></a></li>
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
                    <th>Estimated cost</th>
                    <th>Job controls</th>
                </tr>
            </thead>
            <tbody>
                @foreach($approved_jobs as $job)
                    <tr class="text-left">
                        <td data-th="Job ID">{{$job->id}}</td>
                        <td data-th="Requested by">{{$job->customer_name}}</td>
                        <td data-th="Job Title">{{ $job->job_title}}</td>
                        <td data-th="Estimated cost">£{{ $job->total_price }}</td>
                        <td data-th="Job controls"  title="Job controls" 
                            data-toggle="popover" data-trigger="hover" data-placement="top" 
                            data-content="Depending on customer reply you can either start assigning prints by clicking on 
                                Customer Approved button or cancel the job by clicking on Customer Reject button. To check 
                                the job details please click on Manage button.">
                            <a class="btn btn-info" href="/OnlineJobs/{{$job->id}}">Manage</a>
                            {{--<a class="btn btn-success" href="/OnlineJobs/approved/{{$job->id}}/accept">Customer Accepted</a>
                            <a class="btn btn-danger" href="/OnlineJobs/approved/{{$job->id}}/reject">Customer Rejected</a>--}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
