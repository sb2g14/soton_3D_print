@extends('layouts.layout')

@section('content')
   
    <div class="container text-center m-b-md">
        {{--<div class="title">Pending Jobs</div>--}}
        <ul class="nav nav-pills nav-justified">
            <li><a href="/OnlineJobs/index">Requests</a></li>
            <li><a href=/OnlineJobs/approved>Approved Jobs</a></li>
            <li class="active"><a href="#">Pending Jobs</a></li>
            <li><a href="/OnlineJobs/prints">Prints</a></li>
            <li><a href="/OnlineJobs/completed">Completed Jobs</a></li>
        </ul>
    </div>
    
    <div class="container">
        <table class="table table-sm table-hover table-responsive">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Project</th>
                <th>Requested on</th>
                <th>Accepted</th>
                <th>Job controls</th>
            </tr>
            </thead>
            <tbody>
                @foreach($pending_jobs as $job)
                    <tr class="text-center">
                        <td>{{ $job->id }}</td>
                        <td data-th="Name">{{$job->customer_name}}</td>
                        <td data-th="Project name">{{$job->use_case}}</td>
                        <td data-th="Requested on">{{ $job->created_at->toDateTimeString() }}</td>
                        <td data-th="Accepted on">{{ Carbon\Carbon::parse($job->approved_at)->diffForHumans() }}</td>
                        <td>
                            <a href="/OnlineJobs/managePendingJob/{{$job->id}}" class="btn btn-info">Review Job</a>
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
