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
         <li><a href="/OnlineJobs/pending">Pending Jobs</a></li>
         <li class="active"><a href="#">Prints</a></li>
         <li><a href="/OnlineJobs/completed">Completed Jobs</a></li>
    </ul>
</div>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Printer No</th>
                    <th>Printed by</th>
                    <th>Job IDs</th>
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
                         @if ($time_finish->gte(Carbon\Carbon::now('Europe/London')))
                        <tr class="text-left">
                            <td data-th="ID">{{ $print->id }}</td>
                            <td data-th="Printer No">{{ $print->printers_id }}</td>
                            <td data-th="Printed by">{{$print->staff_started->first_name}} {{$print->staff_started->last_name}}</td>
                            <td data-th="Job IDs">@foreach($print->jobs as $job) {{ $job->id }} @endforeach</td>
                            <td data-th="Started on">{{ $print->created_at->toDateTimeString() }}</td>
                            <td data-th="Time Remain">{{ $time_finish->diffInHours(Carbon\Carbon::now('Europe/London')) }}:{{ sprintf('%02d', $time_finish->diffInMinutes(Carbon\Carbon::now('Europe/London'))%60) }}</td>
                            <td data-th="Manage">
                                <a href="#" class="btn btn-success">Print successful</a>
                                <a href="#" class="btn btn-danger">Print failed</a>
                            </td>
                        </tr>
                        @endif
                    @endforeach
            <hr>
                {{--@foreach($jobs_in_progress as $job)--}}
                {{--@endforeach--}}
            </tbody>
        </table>
    </div>

@endsection
