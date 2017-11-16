@extends('layouts.layout')

@section('content')
    @if ($flash=session('message'))
    <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -100px">
        {{ $flash }}
    </div>
    @endif

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
        <table class="table">
            <thead>
                <tr>
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
                    <th>Project Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($approved_jobs as $job)
                    {{--Separate hours from minutes and seconds in printing time--}}
                    @php list($h, $i, $s) = explode(':', $job->total_duration);
                    $print = $job->prints->first()
                    @endphp
                    {{--Add number of hours job takes to the time when it was approved--}}
                    {{--Add number of minutes job takes--}}
                    @if (Carbon\Carbon::parse($job->approved_at)->addHour($h)->addMinutes($i)->gte(Carbon\Carbon::now('Europe/London')))
                    <tr class="text-left">
                        <td data-th="ID">{{ $job->id }}</td>
                        <td data-th="Printer No">{{ $print->printers_id }}</td>
                        <td data-th="Name">{{$job->customer_name}}</td>
                        <td data-th="Email">{{$job->customer_email}}</td>
                        <td data-th="Payment Category">{{$job->payment_category}}</td>
                        <td data-th="Time">{{ date("H:i", strtotime($job->total_duration)) }}</td>
                        <td data-th="Material Amount">{{ $job->total_material_amount }} g</td>
                        <td data-th="Price">£{{ $job->total_price }}</td>
                        <td data-th="Created on">{{ $job->created_at->toDayDateTimeString() }}</td>
                        <td data-th="Approved on">{{ Carbon\Carbon::parse($job->approved_at)->toDayDateTimeString() }}</td>
                        <td data-th="Approved by">{{ $job->staff_approved->first_name }} {{ $job->staff_approved->last_name }}</td>
                        <td data-th="Project Name">{{ $job->use_case  }}</td>
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
