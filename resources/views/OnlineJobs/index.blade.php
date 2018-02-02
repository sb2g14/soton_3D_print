@extends('layouts.layout')

@section('content')
    <div class="container text-center m-b-md">
        {{--<div class="title">Pending Jobs</div>--}}
        <ul class="nav nav-pills nav-justified">
            <li class="active"><a href="#">Requests</a></li>
            <li><a href="/OnlineJobs/approved">Approved Jobs</a></li>
            <li><a href="/OnlineJobs/pending">Pending Jobs</a></li>
            <li><a href="/OnlineJobs/prints">Prints</a></li>
            <li><a href="/OnlineJobs/completed">Completed Jobs</a></li>
        </ul>
    </div>
    
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Requested by</th>
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
                        <td data-th="Project/Cost Code">{{ $job->use_case}}</td>
                        <td data-th="Requested on">{{ $job->created_at->formatLocalized('%d %b, %H:%m') }}</td>
                        <td><a href="/OnlineJobs/checkrequest/{{$job->id}}" class="btn btn-info">Manage</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{--<!-- <div class="row">--}}
            {{--<div class="col-xs-12">--}}
                {{--<ul class="list-group lsn">--}}
                    {{--@foreach($jobs as $job)--}}
                        {{--<li class="text-left well">--}}
                        {{--Print short description and a link--}}
                            {{--<p>--}}
                                {{--Job ID: <b>{{$job->id}}</b><br>--}}
                                {{--Requested by: <b>{{$job->customer_name}}</b><br>--}}
                                {{--Requester id: <b>{{$job->customer_id}}</b>--}}
                                {{--Project/Cost Code: <b>{{ $job->use_case}}</b><br>--}}
                                {{--Requested on: <b>{{ $job->created_at->toDayDateTimeString() }}</b><br>--}}
                            {{--</p>--}}
                            {{--<a href="/OnlineJobs/checkrequest/{{$job->id}}" class="btn btn-info">Manage</a>--}}
                        {{--</li>--}}
                    {{--@endforeach--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</div> -->--}}
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
