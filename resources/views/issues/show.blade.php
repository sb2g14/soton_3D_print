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
            <div class="col-sm-3 text-left">
                <p>Printer type: <b>{{$printer->printer_type}}</b></p>
                <p>Printer serial number: <b>{{$printer->serial_no}}</b></p>
                <p>Date added: <b>{{$printer->created_at}}</b></p>
                @if($printer->status === 'Signed out')
                    <p>Date signed out: <b>{{$printer->updated_at->toDayDateTimeString()}}</b></p>
                @else
                    <p>Last updated: <b>{{$printer->updated_at->toDayDateTimeString()}}</b></p>
                @endif
                <p>Total number of prints: <b>{{$printer->prints->count()}}</b></p>
                <p>Of that are successful: <b>{{$printer->prints->where('status','Success')->count()}}</b></p>
            </div>
            <div class="col-sm-3 text-left">
                <p>Printer use statistics</p>
                <p>In use time: <b>{{$printer->calculateTotalTimeSuccess()}}</b></p>
                <p>On loan time: <b>{{$printer->calculateTotalTimeOnLoan()}}</b></p>
                <p>Time broken: </p>
                <p>Time idle: </p>
                <p>Printer reliability: <b>{{round($printer->prints->where('status','Success')->count()/$printer->prints->count()*100,2)}}%</b></p>
                <p>Printer availability: idle time/total time</p>
            </div>
            <div class="col-sm-3 text-left">
                <p>Printer status: <b>{{$printer->printer_status}}</b></p>
                <p>Last updated by:
                    @php
                        $lastPrint=$printer->prints()->orderBy('updated_at', 'desc')->first();
                        $lastIssue=$printer->fault_data()->orderBy('updated_at','desc')->first();
                        //$lastIssueUpdate=$printer->fault_data()->fault_updates()->orderBy('updated_at','desc')->first();
                        $lastIssueUpdate = \App\FaultData::orderBy('fault_updates.updated_at','desc')
                        ->crossJoin('fault_updates', 'fault_datas.id', '=', 'fault_updates.fault_data_id')
                        ->where('fault_datas.printers_id', $printer->id)
                        ->select('fault_updates.updated_at', 'fault_updates.users_id')
                        ->first();

                        $nullDate = \Carbon\Carbon::create(1990, 1, 1, 0);
                        if(!$lastPrint)
                        {
                            $lastPrint = ['updated_at'=>$nullDate, 'print_finished_by'=>64];
                        } else {
                            $lastPrint = $lastPrint->toArray();
                        }
                        if(!$lastIssue)
                        {
                            $lastIssue = ['updated_at'=>$nullDate, 'user_name_resolved_issue'=>'System',
                            'user_name_created_issue'=>'System'];
                        } else {
                            $lastIssue = $lastIssue->toArray();
                        }
                        if(!$lastIssueUpdate)
                        {
                            $lastIssueUpdate = ['updated_at'=>$nullDate, 'users_id'=>64];
                        } else {
                            $lastIssueUpdate = $lastIssueUpdate->toArray();
                        }
                        // Compare maximums of pairs of timestamps
                        $tstmp1 = new \Carbon\Carbon($lastPrint['updated_at']);
                        $tstmp2 = new \Carbon\Carbon($lastIssue['updated_at']);
                        $tstmp3 = new \Carbon\Carbon($lastIssueUpdate['updated_at']);
                        $max=$tstmp1->max($tstmp2)->max($tstmp3);
                    @endphp
                    {{$max}}
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
                        {{$printer->fault_data()->orderBy('updated_at','desc')->first()->body}}
                </p>
            </div>
            <div class="col-sm-3 text-left">
                <p>Days out of Order</p>
                <p style="color:red;"><b></b></p>
            </div>
        </div>
    </div>
    </div>

<ul class="container">
    @php
        $printdata = $printer->prints()->select('created_at AS StartDate', 'updated_at AS EndDate','purpose AS Type','status AS Description');
        $issuedata = $printer->fault_data()->select('created_at AS StartDate', 'resolved_at AS EndDate', 'printer_status AS Type', 'body AS Description');
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

                                $entryCounter = 1;
                            @endphp
                            <li>
                                <div class="{{$outClass}}">
                                    {{$outStartDate->format('d/m/Y')}}-{{$outEndDate->format('d/m/Y')}} {{$outType}}: {{$outDescription}}
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
    @php
        if($lastEntry){
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

        }
    @endphp
    {{--@foreach($issues as $issue)--}}

        {{--<li>--}}

            {{--<div class="container well">--}}
                {{--<div class="alert alert-warning">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-sm-12 text-left"><h3><b>{{ isset($issue->title) ? $issue->title : 'Issue with printer '.$issue->printers_id }}:</b></h3></div>--}}
                    {{--</div>--}}
                    {{--<div class="row vdivide">--}}
                        {{--<div class="col-sm-3 text-left">--}}
                            {{--<p>Created by</p>--}}
                            {{--<p><b>{{$issue->users_name_created_issue}}</b></p>--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-3 text-left">--}}
                            {{--<p>Created on</p>--}}
                            {{--<p>{{ isset($issue->Date)  ? $issue->Date : $issue->created_at->toDayDateTimeString()}}</p>--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-3 text-left">--}}
                            {{--<p>Printer Status</p>    --}}
                            {{--<p style="color:red;"><b>{{$issue->printer_status}}</b></p>--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-3 text-left">--}}
                            {{--<p>Days out of Order</p>--}}
                            {{--<p style="color:red;"><b>{{ isset($issue->Date) ? $issue->days_out_of_order : \Carbon\Carbon::now('Europe/London')->diffInDays($issue->created_at) }}</b></p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<hr>--}}
                {{--<div class="row">--}}
                    {{--<div class="col-sm-8 text-left">--}}
                        {{--<p style="font-size: 18px;"><b>Description:</b></p>--}}
                        {{--<p style="font-size: 18px;">{{ $issue->body }}</p>--}}
                    {{--</div>--}}
                        {{--@can('issues_manage')--}}
                        {{--<div class="col-sm-4">--}}
                            {{--@if($issue->resolved == 0)--}}
                            {{--<a href="/issues/update/{{$issue->id}}" class="btn btn-lg btn-info">View/Update or Resolve</a>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                        {{--@endcan--}}
                {{--</div>--}}

                {{--@if(!empty(array_filter( (array) $issue->FaultUpdates)))--}}

                    {{--<hr>--}}
                    {{--<div class="text-left">--}}
                        {{--<h3>ISSUE LOG:</h3>--}}
                    {{--</div>--}}

                    {{--<ul> --}}

                        {{--@foreach($issue->FaultUpdates as $update)--}}
                    {{----}}
                            {{--<div class="alert alert-info">--}}
                                {{--<div class="row">--}}
                                    {{--<div class="col-sm-12 text-left"><h3><b>Issue update</b></h3></div>--}}
                                {{--</div>--}}
                                {{--<div class="row vdivide ">--}}
                                    {{--<div class="col-sm-4 text-left">--}}
                                        {{--<p>Created by</p>--}}
                                        {{--<p><b>{{$update->users_name}}</b></p>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-sm-4 text-left">--}}
                                        {{--<p>Created on</p>--}}
                                        {{--<p>{{ $update->created_at->toDayDateTimeString() }}</p>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-sm-4 text-left">--}}
                                        {{--<p>Printer Status</p>    --}}
                                        {{--<p style="color:red;"><b>{{$update->printer_status}}</b></p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<hr>--}}
                                {{--<div class="row">--}}
                                    {{--<div class="col-sm-8 text-left">--}}
                                        {{--<p style="font-size: 18px;"><b>Description</b></p>--}}
                                        {{--<p style="font-size: 18px;">{{ $update->body }}</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                    {{--</ul>--}}
                {{--@endif--}}

                {{--@if($issue->resolved == 1)--}}
                    {{----}}

                    {{--<div class="alert alert-success">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-sm-12 text-left"><h3><b>Issue resolved</b></h3></div>--}}
                        {{--</div>--}}
                        {{--<div class="row vdivide">--}}
                            {{--<div class="col-sm-4 text-left">--}}
                                {{--<p>Created by</p>--}}
                                {{--<p><b>{{$issue->users_name_resolved_issue}}</b></p>--}}
                            {{--</div>--}}
                            {{--<div class="col-sm-4 text-left">--}}
                                {{--<p>Resolved on</p>--}}
                                {{--<p>{{ isset($issue->Repair_Date) ? $issue->Repair_Date : $issue->updated_at->toDayDateTimeString() }}</p>--}}
                            {{--</div>--}}
                            {{--<div class="col-sm-4 text-left">--}}
                                {{--<p>Printer Status</p>    --}}
                                {{--<p><b>Available</b></p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<hr>--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-sm-8 text-left">--}}
                                {{--<p style="font-size: 18px;"><b>Resolve message:</b></p>--}}
                                {{--<p style="font-size: 18px;">{{ $issue->message_resolved }}</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--@endif--}}
            {{--</div>--}}
        {{--</li>--}}
    {{--@endforeach    --}}
</ul>
@include('layouts.errors')
@endsection
