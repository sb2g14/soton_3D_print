@extends('layouts.layout')

@section('content')

    {{--NAVIGATION--}}
    <div class="container text-center m-b-md">
        <ul class="nav nav-pills nav-justified">
            <li><a href="/WorkshopJobs/requests">Pending Jobs <span class="badge">{{$counts['pending']}}</span></a></li>
            <li><a href="/WorkshopJobs/approved">Approved Jobs / Printing <span class="badge">{{$counts['approved']}}</span></a></li>
            <li class="active"><a href="#">Completed Jobs</a></li>
        </ul>
    </div>
    
    {{--CONTENT--}}
    <div class="container">
        <table class="table table-sm table-hover table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Printer</th>
                    <th>Job title</th>
                    <th>Name</th>
                    <th>Time</th>
                    <th>Material Amount</th>
                    <th>Price</th>
                    <th>Requested</th>
                    <th>Finished</th>
                    <th>Completed by</th>
                    <th>Status</th>
                    {{--@hasanyrole('LeadDemonstrator|administrator|OnlineJobsManager')--}}
                    <th>Edit</th>
                    {{--@endhasanyrole--}}
                    <th>Restart</th>
                </tr>
            </thead>
            <tbody>
                @foreach($finished_jobs as $job) 
                    @php 
                        list($h, $i, $s) = explode(':', $job->total_duration);
                        $print = $job->prints->first()
                    @endphp
                    @php
                        if($print->status === 'Success'){
                           $printclass = "p-success";
                        }else{
                           $printclass = "p-failed";
                        }
                    @endphp
                    {{--Add number of hours job takes to the time when it was approved--}}
                    {{--Add number of minutes job takes--}}
                    @if (Carbon\Carbon::now('Europe/London')->gte(Carbon\Carbon::parse($job->approved_at)->addHour($h)->addMinutes($i)) || $job->status == 'Failed' || $job->status == 'Success') {{-- TODO: is this still needed? If so, move this check to Controller --}}
                        <tr class="text-left {{$printclass}}">
                            <td data-th="ID">{{ $job->id }}</td>
                            <td data-th="Printer No"><a href="/issues/show/{{ $print->printers_id }}">{{ $print->printers_id }}</a></td>
                            <td data-th="Job title">{{ $job->job_title  }}</td>
                            <td data-th="Name"><a href="mailto:{{$job->customer_email}}?Subject=Job {{ $job->id }} | FEE 3D Printing Service" target="_top">{{$job->customer_name}}</a></td>
                            <td data-th="Time">{{ date("H:i", strtotime($job->total_duration)) }}</td>
                            <td data-th="Material Amount">{{ $job->total_material_amount }} g</td>
                            <td data-th="Price">£{{ $job->total_price }}</td>
                            <td data-th="Requested on">{{ $job->created_at->formatLocalized('%d %b, %H:%M') }}</td>
                            <td data-th="Finished on">{{ Carbon\Carbon::parse($job->finished_at)->formatLocalized('%d %b, %H:%M') }}</td>
                            @if ($job->staff_finished === null)
                                <td data-th="Completed by"></td>
                            @else
                                <td data-th="Completed by">{{ $job->staff_finished->first_name }} {{ $job->staff_finished->last_name }}</td>
                            @endif
                            <td data-th="Status">{{ $job->status }}</td>
                            <td data-th="Edit">
                                {{--@hasanyrole('LeadDemonstrator|administrator|OnlineJobsManager')--}}
                                <a class="btn btn-danger" href="/WorkshopJobs/{{$job->id}}/edit" 
                                   data-toggle="popover" data-trigger="hover" data-placement="top"
                                   data-content="Be very cautious in editing finished jobs as this action will alter the
                                   historic events!">Manage Job</a>
                                {{--@endhasanyrole--}}
                            </td>
                            <td data-th="Restart">
                                @if($job->status == 'Failed')
                                    <a class="btn btn-success" href="/WorkshopJobs/{{$job->id}}/restart">Restart</a>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
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
