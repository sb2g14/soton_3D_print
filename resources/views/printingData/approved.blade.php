@extends('layouts.layout')

@section('content')

<div class="container text-center m-b-md">
    <ul class="nav nav-pills nav-justified">
        <li><a href="/printingData/index">Pending Jobs</a></li>
        <li class="active"><a href="#">Approved Jobs / Printing</a></li>
        <li><a href="/printingData/finished">Completed Jobs</a></li>
    </ul>
</div>

    <!-- <div class="text-center m-b-md">
        <div class="title">Currently Approved Jobs</div>
        <a href="/printingData/index" class="btn btn-lg btn-danger">Show pending jobs</a>
    </div> -->

    <div class="container">
        <table class="table table-sm table-hover table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Printer</th>
                    <th>Name</th>
                    <th>Job title</th>
                    <th>Remaining time</th>
                    <th>Price</th>
                    <th>Approved on</th>
                    <th>Approved by</th>
                    <th>Module/Cost Code</th>
                </tr>
            </thead>
            <tbody>
                @foreach($approved_jobs as $job)
                    {{--Separate hours from minutes and seconds in printing time--}}
                    @php list($h, $i, $s) = explode(':', $job->total_duration);
                    $print = $job->prints->first()
                    @endphp
                    {{--Calculate time of print finish --}}
                    @php list($h, $i, $s) = explode(':', $print->time);
                        $time_finish = $print->created_at->addHour($h)->addMinutes($i);
                    @endphp
                    {{--Add number of hours job takes to the time when it was approved--}}
                    {{--Add number of minutes job takes--}}
                    @if (Carbon\Carbon::parse($job->approved_at)->addHour($h)->addMinutes($i)->gte(Carbon\Carbon::now('Europe/London')))
                    <tr class="text-left">
                        <td data-th="ID">{{ $job->id }}</td>
                        <td data-th="Printer No"><a href="/issues/show/{{ $print->printers_id }}">{{ $print->printers_id }}</a></td>
                        <td data-th="Name"><a href="mailto:{{$job->customer_email}}?Subject=Soton3Dprint Job {{ $job->id }}" target="_top">{{$job->customer_name}}</a></td>
                        <td data-th="Job title">{{$job->job_title}}</td>
                        <td data-th="Remaining time">@if ($time_finish->gte(Carbon\Carbon::now('Europe/London'))) {{ $time_finish->diffInHours(Carbon\Carbon::now('Europe/London')) }}:{{ sprintf('%02d', $time_finish->diffInMinutes(Carbon\Carbon::now('Europe/London'))%60) }} @else  completed @endif</td>
                        <td data-th="Price">£{{ $job->total_price }}</td>
                        <td data-th="Approved on">{{ Carbon\Carbon::parse($job->approved_at)->formatLocalized('%d %b, %H:%M') }}</td>
                        <td data-th="Approved by">{{ $job->staff_approved->first_name }} {{ $job->staff_approved->last_name }}</td>
                        <td data-th="Module/Cost Code"> @if($job->use_case == 'Cost Code - approved') <b style="color: forestgreen"> {{$job->cost_code}} @elseif($job->use_case == 'Cost Code - unknown')</b> <b style="color: red"> {{$job->cost_code}} @else <b style="color: forestgreen"> {{$job->use_case}} @endif </b> </td>
                        <td><a href="/printingData/abort/{{$job->id}}" class="btn btn-danger">Job Failed</a><br><br>
                            <a href="/printingData/success/{{$job->id}}" class="btn btn-success">Job Successful</a></td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <!-- <a href="/printingData/finished" class="btn btn-lg"> Show jobs history</a> -->
    </div>

@endsection

@section('scripts')
    <script src="/js/approve_job_validation.js"></script>
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
