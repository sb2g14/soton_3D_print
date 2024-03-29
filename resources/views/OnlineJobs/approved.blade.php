@extends('layouts.layout')

@section('content')

   
    <div class="container text-center m-b-md">
        <ul class="nav nav-pills nav-justified">
            <li><a href="/OnlineJobs/index">Requests <span class="badge">{{$counts['requests']}}</span></a></li>
            <li class="active"><a href="#">Approved Jobs <span class="badge">{{$counts['approved']}}</span></a></li>
            <li class="nav-left"><a href="/OnlineJobs/pending">Pending Jobs <span class="badge">{{$counts['pending']}}</span></a></li>
            <li class="nav-right"><a href="/OnlineJobs/prints">Prints</a></li>
            <li><a href="/OnlineJobs/completed">Completed Jobs</a></li>
        </ul>
    </div>

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
                    <td data-th="Job controls"  title="Job controls" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Depending on customer reply you can either start assigning prints by clicking on Customer Approved button or cancel the job by clicking on Customer Reject button. To check the job details please click on Manage button.">
                        <a href="/OnlineJobs/manageApproved/{{$job->id}}" class="btn btn-info">Manage</a>
                        <a href="/OnlineJobs/customerApproved/{{$job->id}}" class="btn btn-success">Customer Accepted</a>
                        <a href="/OnlineJobs/customerReject/{{$job->id}}" class="btn btn-danger">Customer Rejected</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
    {{--Load notification of an approved job--}}
    @if (notify()->ready())
        <script>
            swal({
                title: "{!! notify()->message() !!}",
                text: "{!! notify()->option('text') !!}",
                type: "{{ notify()->type() }}",
                showConfirmButton: true
            });
        </script>
    @endif
@endsection
