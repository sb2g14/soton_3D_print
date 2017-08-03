@extends('layouts.layout')

@section('content')
    @if ($flash=session('message'))
    <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -100px">
        {{ $flash }}
    </div>
    @endif

    <div class="text-center m-b-md">
        <div class="title">Approved Jobs</div>
        <a href="/printingData/index" class="btn btn-lg btn-info">Show pending jobs</a>
    </div>

    <div class="container">
        <table class="table">
            <thead>
            <tr style="font-weight: 600;">
                <th>ID</th>
                <th>Printer No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Payment Category</th>
                <th>Time</th>
                <th>Material Amount</th>
                <th>Price</th>
                <th>Created on</th>
                <th>Approved on</th>
                <th>Approved by</th>
                <th>Use Case</th>
            </tr>
            </thead>
            <tbody>
            @foreach($approved_jobs as $job)
                {{--Separate hours from minutes and seconds in printing time--}}
                @php( list($h, $i, $s) = explode(':', $job->time) )
                @endphp
                {{--Add number of hours job takes to the time when it was approved--}}
                {{--Add number of minutes job takes--}}
                {{--Plus 15 minutes--}}
                {{--If time for job finish plus 15 minutes didn't pass we show approved job--}}
                @if ($job->updated_at->addHour($h)->addMinutes($i)->addMinutes(15)->gte(Carbon\Carbon::now('Europe/London')))
                <tr style="text-align: left;">
                    <td>{{ $job->id }}</td>
                    <td>{{ $job->printers_id }}</td>
                    <td>{{$job->student_name}}</td>
                    <td>{{$job->email}}</td>
                    <td>{{$job->payment_category}}</td>
                    <td>{{ date("H:i", strtotime($job->time)) }}</td>
                    <td>{{ $job->material_amount }} g</td>
                    <td>£{{ $job->price }}</td>
                    <td>{{ $job->created_at->toDayDateTimeString() }}</td>
                    <td>{{ $job->updated_at->toDayDateTimeString() }}</td>
                    <td>{{ $job->user->name }}</td>
                    <td>{{ $job->use_case  }}</td>
                    <td><a href="/printingData/abort/{{$job->id}}" class="btn btn-danger">Job Failed</a></td>
                    <td><a href="/printingData/success/{{$job->id}}" class="btn btn-success">Job Successful</a></td>
                </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>

    {{--<ul class="container" style=" margin-top: -30px; text-align: center;">--}}
        {{--<div class="panel-body">--}}
            {{--<ul class="list-group">--}}
            {{--@foreach($approved_jobs as $job)--}}
                {{--Show job only after 15 minutes after it finishes--}}
                {{--@if($job->created_at)--}}
                    {{--<ul class="list-inline text-center well">--}}
                        {{--<li>--}}
                            {{--<h2 class="media-heading">--}}
                                {{--{{ $job->printers_id }} {{$job->student_name}} {{ date("H:i", strtotime($job->time)) }}--}}
                                {{--{{ $job->material_amount }} {{ $job->use_case }} {{ $job->created_at->toDayDateTimeString() }}--}}
                            {{--</h2>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<div>--}}
                                {{--<a href="/printingData/abort/{{$job->id}}" class="btn btn-danger">Job Failed</a>--}}
                                {{--<a href="/printingData/success/{{$job->id}}" class="btn btn-success">Job Successful</a>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--@endif--}}
            {{--@endforeach--}}
        {{--</ul>--}}
        {{--</div>--}}
    {{--</ul>--}}



@endsection
