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
    <div class="panel-body">
        {!! $chart->html() !!}
        {!! Charts::scripts() !!}
        {!! $chart->script() !!}
    </div>
    <div class="container">
    <div class="alert alert-warning">
        <div class="row vdivide">
            <div class="col-sm-3 text-left">
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
                <p>Total number of prints: <b>{{$printer->prints->count()}}</b></p>
                <p>Of that are successful: <b>{{$printer->prints->where('status','Success')->count()}}</b></p>
            </div>
            <div class="col-sm-3 text-left">
                <p>Printer use statistics</p>
                <p>In use time: <b>{{round($printer->calculateTotalTimeSuccess()/(24*60)).' d '.round($printer->calculateTotalTimeSuccess()%24/60).' h '.sprintf('%02d', $printer->calculateTotalTimeSuccess()%60).' m'}}</b></p>
                <p>On loan time: <b>{{round($printer->calculateTotalTimeOnLoan()/(24*60)).' d '.round($printer->calculateTotalTimeOnLoan()%24/60).' h '.sprintf('%02d', $printer->calculateTotalTimeOnLoan()%60).' m'}}</b></p>
                <p>Time broken: <b> {{round($printer->calculateTotalTimeBroken()/(24*60)).' d '.round($printer->calculateTotalTimeBroken()%24/60).' h '.sprintf('%02d', $printer->calculateTotalTimeBroken()%60).' m' }} </b> </p>
                @php
                $total_time = \Carbon\Carbon::now('Europe/London')->diffInMinutes($printer->created_at);
                $time_idle = $total_time - $printer->calculateTotalTimeBroken();
                @endphp
                <p>Time idle: <b> {{ round($time_idle/(24*60)).' d '.round($time_idle%24/60).' h '.sprintf('%02d', $time_idle%60).' m' }} </b> </p>
                <p>Printer reliability: @if($printer->prints->count() !== 0) <b>{{round($printer->prints->where('status','Success')->count()/$printer->prints->count()*100,2)}}% @else N/A @endif</b></p>
                <p>Printer availability: @if($total_time !== 0) {{ round($time_idle/$total_time*100,2)}}% @else N/A @endif</p>
            </div>
            <div class="col-sm-3 text-left">
                <p>Printer status: <b>{{$printer->printer_status}}</b></p>
                    @php
                        $lastPrint=$printer->prints()->orderBy('updated_at', 'desc')->first();
                        $lastIssue=$printer->fault_data()->where('resolved',1)->orderBy('resolved_at','desc')->first();
//                        $lastIssueUpdate=$printer->fault_data()->where('resolved',0)->first()->FaultUpdates()->orderBy('created_at','desc');
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
            </div>
            <div class="col-sm-3 text-left">
            </div>
        </div>
    </div>
    </div>

<ul>
                      
    @foreach($issues as $issue)

        <li>

            <div class="container well">
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
                                </div>
                            </div>
                        @endforeach
                    </ul>
                @endif

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
        </li>
    @endforeach    
</ul>
@include('layouts.errors')
@endsection
@section('scripts')
@endsection
