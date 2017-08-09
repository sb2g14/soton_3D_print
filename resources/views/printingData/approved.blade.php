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
                <th>Use Case</th>
            </tr>
            </thead>
            <tbody>
            @foreach($approved_jobs as $job)
                {{--Separate hours from minutes and seconds in printing time--}}
                @php( list($h, $i, $s) = explode(':', $job->time) )
                {{--Add number of hours job takes to the time when it was approved--}}
                {{--Add number of minutes job takes--}}
                {{--Plus 15 minutes--}}
                {{--If time for job finish plus 15 minutes didn't pass we show approved job--}}
                @if ($job->updated_at->addHour($h)->addMinutes($i)->addMinutes(15)->gte(Carbon\Carbon::now('Europe/London')))
                <tr class="text-left">
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
                    <td><a href="/printingData/abort/{{$job->id}}" class="btn btn-danger">Job Failed</a><br><br>
                        <a href="/printingData/success/{{$job->id}}" class="btn btn-success">Job Successful</a></td>
                </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
