@extends('layouts.layout')

@section('content')

    {{--@if ($flash=session('message'))--}}
    {{--<div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">--}}
        {{--{{ $flash }}--}}
    {{--</div>--}}
    {{--@endif--}}

   
    <div class="container text-center m-b-md">
        {{--<div class="title">Pending Jobs</div>--}}
        <ul class="nav nav-pills nav-justified">
            <li><a href="/OnlineJobs/index">Requests</a></li>
            <li><a href=/OnlineJobs/approved>Approved Jobs</a></li>
            <li class="active"><a href="#">Pending Jobs</a></li>
            <li><a href="/printingData/approved">Prints</a></li>
            <li><a href="/printingData/finished">Completed Jobs</a></li>
        </ul>
    </div>
    
    <div class="container">

        <div class="row">
            <div class="col-xs-12">
                <ul class="list-group lsn">
                    @foreach($pending_jobs as $job)
                        <li class="text-left well">
                        {{--Print short description and a link--}}
                            <p>
                                Job ID: <b>{{$job->id}}</b><br>
                                Requested by: <b>{{$job->customer_name}}</b><br>
                                {{--Requester id: <b>{{$job->customer_id}}</b>--}}
                                Project/Cost Code: <b>{{ $job->use_case}}</b><br>
                                Requested on: <b>{{ $job->created_at->toDayDateTimeString() }}</b><br>
                                Approved on: <b>{{ Carbon\Carbon::parse($job->approved_at)->toDayDateTimeString() }}</b><br>
                                Estimated cost: <b>£{{ $job->total_price }}</b><br>
                            </p>
                            <a href="/OnlineJobs/manageApproved/{{$job->id}}" class="btn btn-info">Manage</a>
                            <a href="/OnlineJobs/customerApproved/{{$job->id}}" class="btn btn-success">Customer Accepted</a>
                            <a href="/OnlineJobs/delete/{{$job->id}}" class="btn btn-danger">Customer Rejected</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
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
