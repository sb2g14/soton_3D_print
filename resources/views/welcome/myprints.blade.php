@extends('layouts.layout')

@section('content')
    

    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-sm-12 well">
                <h1>
                    {{ $email }}
                </h1>
                <a href="/" class="btn btn-primary  pull-left" style="margin: 20px 0px;">
                        Go Home
                </a>
                <a href="/WorkshopJobs/create"  class="btn btn-success  pull-right" style="margin: 20px 20px;">
                        Print in the Workshop
                </a>
                <a href="/OnlineJobs/create"  class="btn btn-success  pull-right" style="margin: 20px 0px;">
                        Order Online
                </a>
            </div>
            <div class="col-xs-8 col-sm-12 well">
                <h2 style="margin-bottom: 20px; font-weight: 600;">Active Jobs</h2>
                <hr>
                <table class="table table-hover">
                    <thead>
                        <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Job Title</th>
                    <th>Date Created</th>
                    {{--<th>Time</th>
                    <th>Material Amount</th>--}}
                    <th>Price</th>
                    <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                @foreach($activejobs as $job)
                    @php
                        $thestatus = "ERROR";
                        $thestatusIcon = "question-circle";
                        $thetype = "";
                        $thetypeIcon = "question-circle";
                        $jobclass = "";
                        if($job->requested_online == 1){
                            $thetype = "online order";
                            $thetypeIcon = "globe";
                            $jobclass = "p-failed";
                            
                            if($job->status === 'Waiting'){
                                $thestatus = 'Being Checked...';
                                $thestatusIcon = "clock-o";
                            }else if($job->status === 'Approved'){
                                $thestatus = 'Waiting for your approval...';
                                $thestatusIcon = "exclamation-triangle";
                            }else if($job->status === 'In Progress'){
                                $thestatus = 'Job is being printed...';
                                $thestatusIcon = "check";
                            }else{
                                $thestatus = 'Stuck in our online workflow';
                                $thestatusIcon = "exclamation-triangle";
                            }
                            
                        }else{
                            
                            $thetype = "workshop print";
                            $thetypeIcon = "building";
                            $jobclass = "p-success";
                            if($job->status === 'Waiting'){
                                $thestatus = 'Being checked - Please wait!';
                                $thestatusIcon = "clock-o";
                            }else if($job->status === 'Approved'){
                                $thestatus = 'Please start printing!';
                                $thestatusIcon = "check";
                            }else{
                                $thestatus = 'Stuck in our workshop workflow';
                                $thestatusIcon = "exclamation-triangle";
                            }
                        }
                    @endphp
                    <tr class="text-left">
                        <td data-th="ID">{{ $job->id }}</td>
                        <td data-th="Type"><span class="fa fa-{{$thetypeIcon}}"></span> {{ $thetype }}</td>
                        <td data-th="Job Title">{{ $job->job_title }}</td>
                        <td data-th="Created on">{{ $job->created_at->formatLocalized('%d %b, %H:%M') }}</td>
                        @if($job->status === 'Waiting' && $job->requested_online == 1)
                            {{--<td data-th="Time">tbc</td>
                            <td data-th="Material Amount">tbc</td>--}}
                            <td data-th="Price">tbc</td>
                        @else
                            {{--<td data-th="Time">{{ $job->total_duration }}</td>
                            <td data-th="Material Amount">{{ $job->total_material_amount }} g</td>--}}
                            <td data-th="Price">£{{ $job->total_price }}</td>
                        @endif
                        @if($thetype === "online order" && $job->status === 'Approved')
                            <td data-th="Status"><span class="fa fa-{{$thestatusIcon}}"></span> <a href="/OnlineJobs/approved/{{$job->id}}">{{ $thestatus }} </a></td>
                        @else
                            <td data-th="Status"><span class="fa fa-{{$thestatusIcon}}"></span> {{ $thestatus }}</td>
                        @endif
                    </tr>
                @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-xs-8 col-sm-12 well">
                <h2 style="margin-bottom: 20px; font-weight: 600;">Old Jobs</h2>
                <hr>
                <table class="table table-hover">
                    <thead>
                        <tr>
                    <th>ID</th>
                    <th>Job Title</th>
                    <th>Date Created</th>
                    {{--<th>Time</th>
                    <th>Material Amount</th>--}}
                    <th>Price</th>
                    <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                @foreach($completedjobs as $job)
                    @php
                        if($job->status === 'Success'){
                           $jobclass = "p-success";
                        }else{
                           $jobclass = "p-failed";
                        }
                    @endphp
                    <tr class="text-left {{$jobclass}}">
                        <td data-th="ID">{{ $job->id }}</td>
                        <td data-th="Job Title">{{ $job->job_title }}</td>
                        <td data-th="Created on">{{ $job->created_at->formatLocalized('%d %b, %H:%M') }}</td>
                        {{--<td data-th="Time">{{ $job->total_duration }}</td>
                        <td data-th="Material Amount">{{ $job->total_material_amount }} g</td>--}}
                        <td data-th="Price">£{{ $job->total_price }}</td>
                        <td data-th="Status">{{ $job->status }}</td>
                    </tr>
                @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
