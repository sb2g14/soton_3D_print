@extends('layouts.layout')

@section('content')
    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
            {{ $flash }}
        </div>
    @endif

 <div class="container text-center m-b-md">
     <ul class="nav nav-pills nav-justified">
         <li><a href="/OnlineJobs/index">Requests</a></li>
         <li><a href=/OnlineJobs/approved>Approved Jobs</a></li>
         <li class="connected"><a href="/OnlineJobs/pending">Pending Jobs</a></li>
         <li class="active"><a href="#">Prints</a></li>
         <li><a href="/OnlineJobs/completed">Completed Jobs</a></li>
    </ul>
</div>

    <h3>
        Prints Running
    </h3>

    <div class="container">
        <table class="table table-sm table-hover table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Printer No</th>
                    <th>Printed by</th>
                    <th>Job IDs: Titles</th>
                    <th>Started on</th>
                    <th>Time Remain</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
            {{--Define prints associated with jobs in progress--}}
                    @foreach($prints as $print)
                         {{--Calculate time of print finish --}}
                        @php list($h, $i, $s) = explode(':', $print->time);
                        $time_finish = $print->created_at->addHour($h)->addMinutes($i);
                        @endphp
                        <tr class="text-left">
                            <td data-th="ID">{{ $print->id }}</td>
                            <td data-th="Printer No"><a href="/issues/show/{{$print->printers_id}}">{{ $print->printers_id }}</a></td>
                            <td data-th="Printed by">{{$print->staff_started->first_name}} {{$print->staff_started->last_name}}</td>
                            <td data-th="Job IDs: Titles">@foreach($print->jobs as $job) {{ $job->id }}: {{ $job->job_title }} <br> @endforeach</td>
                            <td data-th="Started on">{{ $print->created_at->formatLocalized('%d %b, %H:%m') }}</td>
                            <td data-th="Time Remain">@if ($time_finish->gte(Carbon\Carbon::now('Europe/London'))) {{ $time_finish->diffInHours(Carbon\Carbon::now('Europe/London')) }}:{{ sprintf('%02d', $time_finish->diffInMinutes(Carbon\Carbon::now('Europe/London'))%60) }} @else  completed @endif </td>
                            <td data-th="Manage">
                                <a href="/OnlineJobs/printSuccessful/{{ $print->id }}" class="btn btn-success">Print Successful</a>
                                <a href="/OnlineJobs/printFailed/{{ $print->id }}" class="btn btn-danger">Print Failed</a>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    <hr>

    <h3>
        Completed Prints of Pending Jobs
    </h3>

    <div class="container">
        <table class="table table-sm table-hover table-responsive">
            <thead>
            <tr>
                <th>#</th>
                <th>Printer No</th>
                <th>Job IDs: Titles</th>
                <th>Started by</th>
                <th>Started on</th>
                <th>Finished by</th>
                <th>Status</th>
                <th>Manage</th>
            </tr>
            </thead>
            <tbody>
                @foreach($prints_of_jobs_in_progress as $print)
                    {{--@foreach($job->prints as $print)--}}
                        @if($print->status == 'Success' || $print->status == 'Failed')
                            <tr class="text-left">
                                <td data-th="ID">{{ $print->id }}</td>
                                <td data-th="Printer No"><a href="/issues/show/{{$print->printers_id}}">{{ $print->printers_id }}</a></td>
                                <td data-th="Job IDs: Titles">@foreach($print->jobs as $job) {{ $job->id }} {{ $job->job_title }} <br> @endforeach</td>
                                <td data-th="Started by">{{$print->staff_started->first_name}} {{$print->staff_started->last_name}}</td>
                                <td data-th="Started on">{{ $print->created_at->formatLocalized('%d %b, %H:%m') }}</td>
                                <td data-th="Finished by">{{$print->staff_finished->first_name}} {{$print->staff_finished->last_name}}</td>
                                @if ($print->status === 'Success')
                                    <td data-th="Status" class="success">{{ $print->status }}</td>
                                @elseif ($print->status === 'Failed')
                                    <td data-th="Status" class="danger">{{ $print->status }}</td>
                                @else
                                    <td data-th="Status" class="info">{{ $print->status }}</td>
                                @endif
                                <td data-th="Manage">
                                </td>
                            </tr>
                        @endif
                    @endforeach
                {{--@endforeach--}}
            </tbody>
        </table>
    </div>

@endsection
