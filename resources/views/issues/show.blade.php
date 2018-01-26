@extends('layouts.layout')
@section('content')
    <style>
        .full-height {
            height: 140vh;
        }
    </style>

    @if ($flash=session('message'))
        <div id="flash_message" class="alert {{ session()->get('alert-class', 'alert-info') }}" role="alert" style="position: relative">
            {{ $flash }}
        </div>
    @endif

    <div class="title m-b-md">
        Summary of Printer {{ $printer->id }}
    </div>
    <div class="container">
        <div class="well">
            <div class="row vdivide">
                <div class="col-sm-6 text-center">
                    {!! $chart->html() !!}
                    {!! Charts::scripts() !!}
                    {!! $chart->script() !!}   
                </div>
                               
                <div class="col-sm-6 text-left">
                    <p>Printer type: <b>{{$printer->printer_type}}</b></p>
                    <p>Printer serial number: <b>{{$printer->serial_no}}</b></p>
                    <p>Date added: <b>{{$printer->created_at->toDayDateTimeString()}}</b></p>
                    @if($printer->updated_at)
                        @if($printer->status === 'Signed out')
                            <p>Date signed out: <b>{{$printer->updated_at->toDayDateTimeString()}}</b></p>
                        @else
                            <p>Last updated: <b>{{$printer->updated_at->toDayDateTimeString()}}</b></p>
                        @endif
                    @endif
                    <!-- <p>Total number of prints: <b>{{$printer->prints->count()}}</b></p>
                    <p>Of that are successful: <b>{{$printer->prints->where('status','Success')->count()}}</b></p>
                    <p>Printer use statistics</p>
                    <p>In use time: <b>{{round($printer->calculateTotalTimeSuccess()/(24*60)).' d '.round($printer->calculateTotalTimeSuccess()%24/60).' h '.sprintf('%02d', $printer->calculateTotalTimeSuccess()%60).' m'}}</b></p>
                    <p>On loan time: <b>{{round($printer->calculateTotalTimeOnLoan()/(24*60)).' d '.round($printer->calculateTotalTimeOnLoan()%24/60).' h '.sprintf('%02d', $printer->calculateTotalTimeOnLoan()%60).' m'}}</b></p>
                    <p>Time broken: <b> {{round($printer->calculateTotalTimeBroken()/(24*60)).' d '.round($printer->calculateTotalTimeBroken()%24/60).' h '.sprintf('%02d', $printer->calculateTotalTimeBroken()%60).' m' }} </b> </p>
                    @php
                    $total_time = \Carbon\Carbon::now('Europe/London')->diffInMinutes($printer->created_at);
                    $time_idle = $total_time - $printer->calculateTotalTimeBroken();
                    @endphp
                    <p>Time idle: <b> {{ round($time_idle/(24*60)).' d '.round($time_idle%24/60).' h '.sprintf('%02d', $time_idle%60).' m' }} </b> </p> -->
                    <p>Printer reliability: @if($printer->prints->count() !== 0) <b>{{round($printer->prints->where('status','Success')->count()/$printer->prints->count()*100,2)}}% @else N/A @endif</b></p>
                    <p>Printer availability: @if($total_time !== 0) <b>{{ round($time_idle/$total_time*100,2)}}% @else N/A @endif</b></p>
                
                    <p>Printer status: <b>{{$printer->printer_status}}</b></p>
                        @php
                            $lastPrint=$printer->prints()->orderBy('updated_at', 'desc')->first();
                            $lastIssue=$printer->fault_data()->where('resolved',1)->orderBy('resolved_at','desc')->first();
                            $lastIssueUpdate = \App\FaultData::orderBy('fault_updates.updated_at','desc')
                            ->crossJoin('fault_updates', 'fault_datas.id', '=', 'fault_updates.fault_data_id')
                            ->where('fault_datas.printers_id', $printer->id)
                            ->select('fault_updates.*')
                           ->first();

                            $nullDate = \Carbon\Carbon::create(1990, 1, 1, 0);
                            if(!$lastPrint)
                            {
                                $tstmp1 = $nullDate;
                            } else {
                                $tstmp1 = $lastPrint->updated_at;
                            }
                            if(!$lastIssue)
                            {
                                $tstmp2 = $nullDate;
                            } else {
                                $tstmp2 = \Carbon\Carbon::parse($lastIssue->resolved_at);
                            }
                            if(!$lastIssueUpdate)
                            {
                                $tstmp3 = $nullDate;
                            } else {
                                $tstmp3 = $lastIssueUpdate->updated_at;
                            }
                            // Compare maximums of pairs of timestamps
                            $max=$tstmp1->max($tstmp2)->max($tstmp3);
                        @endphp
                        <p>Last staff updated:
                        @if($max === $nullDate)
                            <b>N/A</b>
                        @else
                            <b>
                            @if($tstmp1 === $max)
                                {{$lastPrint->staff_started->first_name}} {{$lastPrint->staff_started->last_name}}
                            @elseif($tstmp2 === $max)
                                {{ $lastIssue->issue_resolved->first_name }} {{ $lastIssue->issue_resolved->last_name }}
                            @elseif($tstmp3 === $max)
                                {{ $lastIssueUpdate->users_name }}
                            @endif
                            </b>
                        @endif
                        </p>
                    <p>Last used by:
                        @php
                            $lastPrint=$printer->prints()->orderBy('updated_at', 'desc')->first();
                            $lastJob=$lastPrint->jobs()->first();
                            if($lastJob->requested_online == 0){
                                $lastUser = $lastJob->customer_name;
                                $lastUserEmail = $lastJob->customer_email;
                            } else {
                                $lastUser = $lastPrint->staff_started->first_name.' '.$lastPrint->staff_started->last_name;
                                $lastUserEmail = $lastPrint->staff_started->email;
                            }
                        @endphp
                        <a href="mailto:{{$lastUserEmail}}">{{$lastUser}}</a>
                    </p>
                    <p>@if($printer->status !== 'Broken' && $printer->status !== 'Missing' && $printer->status !== 'Signed out')
                            Previous issue:
                        @else
                           Current issue:
                        @endif
                            <b>{{$printer->fault_data()->orderBy('updated_at','desc')->first()->body}}</b>
                    </p>
                    <!-- <p>Days out of Order</p> -->
                    <a href="/printers/index" class="btn btn-lg btn-info">Back to all printers</a>
                </div>
            </div>
        </div>
    </div>
                      

<ul class="lsn container">
    @php
        $printdata = $printer->prints()->select('created_at AS StartDate', 'updated_at AS EndDate','purpose AS Type','status AS Description', 'id as EntryID');
        $issuedata = $printer->fault_data()->select('created_at AS StartDate', 'resolved_at AS EndDate', 'printer_status AS Type', 'body AS Description', 'id as EntryID');
        $historydata = $printdata->unionAll($issuedata)->orderBy('StartDate', 'DESC')->get();
    @endphp
    @php
        $lastEntry = null;
        $entryCounter = 1;
    @endphp
    @foreach($historydata as $entry)
        @if($lastEntry)
            @if($entry->Type === 'Use' && $entry->Type === $lastEntry->Type && $entry->Description === $lastEntry->Description)
                @php
                    $entryCounter += 1;
                    //combine them
                    $lastEntry->StartDate = $entry->StartDate
                @endphp
            @else

                @php
                    //print last entry
                    $outStartDate = new \Carbon\Carbon($lastEntry->StartDate);
                    if(!$lastEntry->EndDate){
                        $outEndDate = null;
                    } else {
                        $outEndDate = new \Carbon\Carbon($lastEntry->EndDate);
                    }
                    $outDescription = $lastEntry->Description;
                    $outType = $lastEntry->Type;
                    $outClass = '';
                    if($lastEntry->Type == 'Use'){
                        $outType = $entryCounter.' Prints';
                        if($lastEntry->Description === 'Success'){
                            $outClass = 'alert alert-success';
                        }else{
                            $outClass = 'alert alert-warning';
                        }
                    }
                    if($lastEntry->Type === 'Loan'){
                            $outClass = 'alert alert-info';
                    }
                    if($lastEntry->Type === 'Broken'){
                            $outClass = 'alert alert-danger';
                    }
                    if($lastEntry->Type === 'Missing'){
                            $outClass = 'alert alert-danger';
                    }

                    $entryCounter = 1;
                @endphp
                <li>
                    <div class="{{$outClass}}">
                        {{$outStartDate->format('d/m/Y')}} -
                        @if($outEndDate)
                            {{$outEndDate->format('d/m/Y')}}
                        @else
                            Now
                        @endif
                            {{$outType}}: {{$outDescription}}
                        @if($outType === 'Broken' || $outType === 'Missing')
                            @can('issues_manage')
                                <div class="col-sm-4">
                                    @if(!$outEndDate)
                                        <a href="/issues/update/{{$lastEntry->EntryID}}" class="btn btn-info">View/Update or Resolve</a>
                                    @endif
                                </div>
                            @endcan
                        @endif
                    </div>
                </li>
                @php
                    $lastEntry = $entry;
                @endphp
            @endif
        @else
            @php
                $lastEntry = $entry;
            @endphp

        @endif
    @endforeach

    @if($lastEntry)
        @php
            //print very last entry
            $outStartDate = new \Carbon\Carbon($lastEntry->StartDate);
            $outEndDate = new \Carbon\Carbon($lastEntry->EndDate);
            $outDescription = $lastEntry->Description;
            $outType = $lastEntry->Type;
            $outClass = '';
            if($lastEntry->Type == 'Use'){
                $outType = $entryCounter.' Prints';
                if($lastEntry->Description === 'Success'){
                    $outClass = 'alert alert-success';
                }else{
                    $outClass = 'alert alert-warning';
                }
            }
            if($lastEntry->Type === 'Loan'){
                    $outClass = 'alert alert-info';
            }
            if($lastEntry->Type === 'Broken'){
                    $outClass = 'alert alert-danger';
            }
            if($lastEntry->Type === 'Missing'){
                    $outClass = 'alert alert-danger';
            }
        @endphp
        <li>
            <div class="{{$outClass}}">
                {{$outStartDate->format('d/m/Y')}} -
                @if($outEndDate)
                    {{$outEndDate->format('d/m/Y')}}
                @else
                    Now
                @endif
                {{$outType}}: {{$outDescription}}
                @if($outType === 'Broken' || $outType === 'Missing')
                    @can('issues_manage')
                        <div class="col-sm-4">
                            @if(!$outEndDate)
                                <a href="/issues/update/{{$lastEntry->EntryID}}" class="btn btn-info">View/Update or Resolve</a>
                            @endif
                        </div>
                    @endcan
                @endif
            </div>
        </li>
    @endif

    {{--@foreach($issues as $issue)

        <li>
            
                <div class="alert alert-warning">
                    <div class="row">
                        <div class="col-sm-12 text-left"><h3><b>{{ isset($issue->title) ? $issue->title : 'Issue with printer '.$issue->printers_id }}:</b></h3></div>
                    </div>
                    <div class="row vdivide">
                        <div class="col-sm-3 text-left">
                            <p>Created by</p>
                            <p><b>{{$issue->issue_created->first_name}} {{$issue->issue_created->last_name}}</b></p>
                        </div>
                        <div class="col-sm-3 text-left">
                            <p>Created on</p>
                            <p>{{ $issue->created_at->toDayDateTimeString()}}</p>
                        </div>
                        <div class="col-sm-3 text-left">
                            <p>Printer Status</p>
                            <p style="color:red;"><b>{{$issue->printer_status}}</b></p>
                        </div>
                        <div class="col-sm-3 text-left">
                            <p>Days out of Order</p>
                            <p style="color:red;"><b>@if($issue->resolved == 0) {{\Carbon\Carbon::now('Europe/London')->diffInDays($issue->created_at)}} @else {{  Carbon\Carbon::parse($issue->resolved_at)->diffInDays($issue->created_at)}} @endif</b></p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-8 text-left">
                        <p style="font-size: 18px;"><b>Description:</b></p>
                        <p style="font-size: 18px;">{{ $issue->body }}</p>
                    </div>
                    @can('issues_manage')
                        <div class="col-sm-4">
                            @if($issue->resolved == 0)
                                <a href="/issues/update/{{$issue->id}}" class="btn btn-lg btn-info">View/Update or Resolve</a>
                            @endif
                        </div>
                    @endcan
                </div>

                @if(!empty(array_filter( (array) $issue->FaultUpdates)))

                    <hr>
                    <div class="text-left">
                        <h3>ISSUE LOG:</h3>
                    </div>

                    <ul>

                        @foreach($issue->FaultUpdates as $update)

                            <div class="alert alert-info">
                                <div class="row">
                                    <div class="col-sm-12 text-left"><h3><b>Issue update</b></h3></div>
                                </div>
                                <div class="row vdivide ">
                                    <div class="col-sm-4 text-left">
                                        <p>Created by</p>
                                        <p><b>{{$update->staff->first_name}} {{$update->staff->last_name}}</b></p>
                                    </div>
                                    <div class="col-sm-4 text-left">
                                        <p>Created on</p>
                                        <p>{{ $update->created_at->toDayDateTimeString() }}</p>
                                    </div>
                                    <div class="col-sm-4 text-left">
                                        <p>Printer Status</p>
                                        <p style="color:red;"><b>{{$update->printer_status}}</b></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-8 text-left">
                                        <p style="font-size: 18px;"><b>Description</b></p>
                                        <p style="font-size: 18px;">{{ $update->body }}</p>
                                    </div>
                                    @if($issue->resolved == 1)


                                        <div class="alert alert-success">
                                            <div class="row">
                                                <div class="col-sm-12 text-left"><h3><b>Issue resolved</b></h3></div>
                                            </div>
                                            <div class="row vdivide">
                                                <div class="col-sm-4 text-left">
                                                    <p>Created by</p>
                                                    <p><b>{{$issue->issue_resolved->first_name}} {{$issue->issue_resolved->last_name}}</b></p>
                                                </div>
                                                <div class="col-sm-4 text-left">
                                                    <p>Resolved on</p>
                                                    <p>{{ Carbon\Carbon::parse($issue->resolved_at)->toDayDateTimeString() }}</p>
                                                </div>
                                                <div class="col-sm-4 text-left">
                                                    <p>Printer Status</p>
                                                    <p><b>Available</b></p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-8 text-left">
                                                    <p style="font-size: 18px;"><b>Resolve message:</b></p>
                                                    <p style="font-size: 18px;">{{ $issue->message_resolved }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                    </ul>
            </div>    
        </li>
    @endforeach--}}
</ul>
@include('layouts.errors')
@endsection
@section('scripts')
@endsection
