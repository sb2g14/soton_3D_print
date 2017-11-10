@extends('layouts.layout')

@section('content')
    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
            {{ $flash }}
        </div>
    @endif

 <div class="container text-center m-b-md">
     <ul class="nav nav-pills nav-justified">
        <li><a href="/printingData/index">Pending Jobs</a></li>
        <li><a href="/printingData/approved">Approved Jobs / Printing</a></li>
        <li class="active"><a href="#">Completed Jobs</a></li>
    </ul>
</div>
    <!-- <div class="text-center m-b-md">
        <div class="title">Printing Jobs History</div>
        <a href="/printingData/index" class="btn btn-lg btn-danger">Show pending jobs</a>
        <a href="/printingData/approved" type="button" class="btn btn-lg btn-success" style="display: inline-block;">Show currently approved jobs</a>
        
    </div> -->

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Printer No</th>
                    <th>Name</th>
                    {{--<th>Payment Category</th>--}}
                    <th>Time</th>
                    <th>Material Amount</th>
                    <th>Price</th>
                    <th>Created</th>
                    <th>Approved</th>
                    <th>Approved by</th>
                    <th>Project Name</th>
                    <th>Status</th>
                    {{--@hasanyrole('LeadDemonstrator|administrator|OnlineJobsManager')--}}
                    <th>Edit</th>
                    {{--@endhasanyrole--}}
                    <th>Restart</th>
                </tr>
            </thead>
            <tbody>
                @foreach($finished_jobs as $job)
                    @php list($h, $i, $s) = explode(':', $job->total_duration);
                    $print = $job->prints->first()
                    @endphp
                    {{--Add number of hours job takes to the time when it was approved--}}
                    {{--Add number of minutes job takes--}}
                    @if (Carbon\Carbon::now('Europe/London')->gte($job->approved_at->addHour($h)->addMinutes($i)))
                    <tr class="text-left">
                        <td data-th="ID">{{ $job->id }}</td>
                        <td data-th="Printer No">{{ $print->printers_id }}</td>
                        <td data-th="Name">{{$job->customer_name}}</td>
                        {{--<td data-th="Payment Category">{{$job->payment_category}}</td>--}}
                        <td data-th="Time">{{ date("H:i", strtotime($job->total_duration)) }}</td>
                        <td data-th="Material Amount">{{ $job->total_material_amount }} g</td>
                        <td data-th="Price">£{{ $job->total_price }}</td>
                        <td data-th="Created on">{{ $job->created_at->toDateTimeString() }}</td>
                        <td data-th="Approved on">{{ $job->approved_at->toDateTimeString() }}</td>
                        <td data-th="Approved by">{{ $job->staff_approved->first_name }} {{ $job->staff_approved->last_name }}</td>
                        <td data-th="Project Name">{{ $job->use_case  }}</td>
                        <td data-th="Status">{{ $job->status }}</td>
                        <td data-th="Edit">
                            {{--@hasanyrole('LeadDemonstrator|administrator|OnlineJobsManager')--}}
                            <a href="/printingData/edit/{{$job->id}}" class="btn btn-danger">Review Job</a>
                            {{--@endhasanyrole--}}
                        </td>
                        <td data-th="Restart">
                            @if($job->status == 'Failed')
                            <a href="/printingData/restart/{{$job->id}}" class="btn btn-primary">Restart</a>
                            @endif
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
