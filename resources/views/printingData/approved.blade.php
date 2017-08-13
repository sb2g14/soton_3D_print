@extends('layouts.layout')

@section('content')
    @if ($flash=session('message'))
    <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -100px">
        {{ $flash }}
    </div>
    @endif

    <div class="text-center m-b-md">
        <div class="title">Currently Approved Jobs</div>
        <a href="/printingData/index" class="btn btn-lg btn-danger">Show pending jobs</a>
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
                        <td data-th="ID">{{ $job->id }}</td>
                        <td data-th="Printer No">{{ $job->printers_id }}</td>
                        <td data-th="Name">{{$job->student_name}}</td>
                        <td data-th="Email">{{$job->email}}</td>
                        <td data-th="Payment Category">{{$job->payment_category}}</td>
                        <td data-th="Time">{{ date("H:i", strtotime($job->time)) }}</td>
                        <td data-th="Material Amount">{{ $job->material_amount }} g</td>
                        <td data-th="Price">£{{ $job->price }}</td>
                        <td data-th="Created on">{{ $job->created_at->toDayDateTimeString() }}</td>
                        <td data-th="Aproved on">{{ $job->updated_at->toDayDateTimeString() }}</td>
                        <td data-th="Aproved by">{{ $job->user->name }}</td>
                        <td data-th="Use Case">{{ $job->use_case  }}</td>
                        <td><a href="/printingData/abort/{{$job->id}}" class="btn btn-danger">Job Failed</a><br><br>
                            <a href="/printingData/success/{{$job->id}}" class="btn btn-success">Job Successful</a></td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <a href="/printingData/finished" class="btn btn-lg"> Show jobs history</a>
    </div>

@endsection
