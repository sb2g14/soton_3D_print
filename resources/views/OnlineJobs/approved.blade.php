@extends('layouts.layout')

@section('content')

   
    <div class="container text-center m-b-md">
        {{--<div class="title">Pending Jobs</div>--}}
        <ul class="nav nav-pills nav-justified">
            <li><a href="/OnlineJobs/index">Requests</a></li>
            <li class="active"><a href="#">Approved Jobs</a></li>
            <li><a href="/OnlineJobs/pending">Pending Jobs</a></li>
            <li><a href="/OnlineJobs/prints">Prints</a></li>
            <li><a href="/OnlineJobs/completed">Completed Jobs</a></li>
        </ul>
    </div>

<div class="container">

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Job ID</th>
                <th>Requested by</th>
                <th>Project/Cost Code</th>
                <th>Estimated cost</th>
                <th>Job controls</th>
            </tr>
        </thead>
        <tbody>
            @foreach($approved_jobs as $job)
                <tr class="text-left">
                    <td data-th="Job ID">{{$job->id}}</td>
                    <td data-th="Requested by">{{$job->customer_name}}</td>
                    <td data-th="Project/Cost Code">{{ $job->use_case}}</td>
                    <td data-th="Estimated cost">£{{ $job->total_price }}</td>
                    <td data-th="Job controls"  title="Job controls" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Depending on customer reply you can either start assigning prints by clicking on Customer Approved button or cancel the job by clicking on Customer Reject button. To check the job details please click on Manage button." data-container:"table">
                        <a href="/OnlineJobs/manageApproved/{{$job->id}}" class="btn btn-info">Manage</a>
                        <a href="/OnlineJobs/customerApproved/{{$job->id}}" class="btn btn-success">Customer Approved</a>
                        <a href="/OnlineJobs/customerReject/{{$job->id}}" class="btn btn-danger">Customer Rejected</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- <div class="row">
        <div class="col-xs-12">
            <ul class="list-group lsn">
                @foreach($approved_jobs as $job)
                    <li class="text-center well">
                    {{--Print short description and a link--}}
                        <div class="text-left">Job ID: <b>{{$job->id}}</b></div>
                        <div class="text-left">Requested by: <b>{{$job->customer_name}}</b></div>
                        <div class="text-left">Project/Cost Code: <b>{{ $job->use_case}}</b></div>
                        <div class="text-left">Estimated cost: <b>£{{ $job->total_price }}</b><br></div>

                        <div class="text-center well" style="color: darkred"> Depending on customer reply you can either start assigning prints by
                            clicking on <b style="color: green">Customer Approved</b> button or cancel the job by
                            clicking on <b style="color: red">Customer Reject</b> button.
                            If you would like to check the details of the job please click on <b style="color: blue">Manage</b>.</div>
                        <div class="text-left">
                        <a href="/OnlineJobs/manageApproved/{{$job->id}}" class="btn btn-info">Manage</a>
                        <a href="/OnlineJobs/customerApproved/{{$job->id}}" class="btn btn-success">Customer Approved</a>
                        <a href="/OnlineJobs/customerReject/{{$job->id}}" class="btn btn-danger">Customer Rejected</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div> -->
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
