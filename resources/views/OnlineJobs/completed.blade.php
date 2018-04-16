@extends('layouts.layout')

@section('content')
    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
            {{ $flash }}
        </div>
    @endif

 <div class="container text-center m-b-md">
     <ul class="nav nav-pills nav-justified">
         <li><a href="/OnlineJobs/index">Requests <span class="badge">{{$counts['requests']}}</span></a></li>
         <li><a href=/OnlineJobs/approved>Approved Jobs <span class="badge">{{$counts['approved']}}</span></a></li>
         <li class="nav-left"><a href="/OnlineJobs/pending">Pending Jobs <span class="badge">{{$counts['pending']}}</span></a></li>
         <li class="nav-right"><a href="/OnlineJobs/prints">Prints</a></li>
         <li class="active"><a href="#">Completed Jobs</a></li>
    </ul>
</div>
    <!-- <div class="text-center m-b-md">
        <div class="title">Printing Jobs History</div>
        <a href="/printingData/index" class="btn btn-lg btn-danger">Show pending jobs</a>
        <a href="/printingData/approved" type="button" class="btn btn-lg btn-success" style="display: inline-block;">Show currently approved jobs</a>
        
    </div> -->

    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    {{--<th>Printer No</th>--}}
                    <th>Name</th>
                    {{--<th>Payment Category</th>--}}
                    {{--<th>Time</th>--}}
                    {{--<th>Material Amount</th>--}}
                    <th>Price</th>
                    <th>Created</th>
                    <th>Finished</th>
                    <th>Approved by</th>
                    <th>Job Title</th>
                    <th>Status</th>
                    {{--@hasanyrole('LeadDemonstrator|administrator|OnlineJobsManager')--}}
                    {{--<th>Edit</th>--}}
                    {{--@endhasanyrole--}}
                    {{--<th>Restart</th>--}}
                </tr>
            </thead>
            <tbody>
                @foreach($completed_jobs as $job)
                    @php
                        if($job->status === 'Success'){
                           $jobclass = "p-success";
                        }else{
                           $jobclass = "p-failed";
                        }
                    @endphp
                    <tr class="text-left {{$jobclass}}">
                        <td data-th="ID">{{ $job->id }}</td>
                        {{--<td data-th="Printer Numbers">{{ $print->printers_id }}</td>--}}
                        <td data-th="Name">{{$job->customer_name}}</td>
                        {{--<td data-th="Payment Category">{{$job->payment_category}}</td>--}}
                        {{--<td data-th="Time">{{ date("H:i", strtotime($job->total_duration)) }}</td>--}}
                        {{--<td data-th="Material Amount">{{ $job->total_material_amount }} g</td>--}}
                        <td data-th="Price">£{{ $job->total_price }}</td>
                        <td data-th="Created on">{{ $job->created_at->formatLocalized('%d %b, %H:%M') }}</td>
                        <td data-th="Last updated on">{{ Carbon\Carbon::parse($job->updated_at)->formatLocalized('%d %b, %H:%M') }}</td>
                        <td data-th="Approved by">{{ $job->staff_approved->first_name }} {{ $job->staff_approved->last_name }}</td>
                        <td data-th="Job Title">{{ $job->job_title }}</td>
                        <td data-th="Status">{{ $job->status }}</td>
                        {{--@if ($job->status === 'Success')
                            <td data-th="Status" class="success">{{ $job->status }}</td>
                        @elseif ($job->status === 'Failed')
                            <td data-th="Status" class="danger">{{ $job->status }}</td>
                        @else
                            <td data-th="Status" class="info">{{ $job->status }}</td>
                        @endif--}}
                        <td data-th="Edit">
                            {{--@hasanyrole('LeadDemonstrator|administrator|OnlineJobsManager')--}}
                            {{--<a href="/printingData/edit/{{$job->id}}" class="btn btn-danger">Review Job</a>--}}
                            {{--@endhasanyrole--}}
                        {{--</td>--}}
                        {{--<td data-th="Restart">--}}
                            {{--@if($job->status == 'Failed')--}}
                            {{--<a href="/printingData/restart/{{$job->id}}" class="btn btn-primary">Restart</a>--}}
                            {{--@endif--}}
                        {{--</td>--}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
