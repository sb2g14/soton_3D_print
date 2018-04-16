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
                        @if($printer->printer_status === 'Signed out')
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
                            $lastPrint=$printer->prints()->orderBy('updated_at', 'desc')->where('status','!=', 'Waiting')->first();
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
                            if($lastPrint){
                                $lastJob=$lastPrint->jobs()->first();
                                if($lastJob->requested_online == 0){
                                    $lastUser = $lastJob->customer_name;
                                    $lastUserEmail = $lastJob->customer_email;
                                } else {
                                    $lastUser = $lastPrint->staff_started->first_name.' '.$lastPrint->staff_started->last_name;
                                    $lastUserEmail = $lastPrint->staff_started->email;
                                }
                            }else{
                                $lastUser = "--";
                                $lastUserEmail = "";
                            }
                        @endphp
                        <a href="mailto:{{$lastUserEmail}}">{{$lastUser}}</a>
                    </p>
                    <p>@if($printer->printer_status !== 'Broken' && $printer->printer_status !== 'Missing' && $printer->printer_status !== 'Signed out')
                            There are no issues with this printer.
                       @elseif($printer->printer_status === 'Signed out')
                            The printer is signed out from the workshop.
                        @else
                           Current issue:
                            <b>{{$printer->fault_data()->orderBy('updated_at','desc')->first()->body}}</b>
                        @endif

                    </p>
                    <!-- <p>Days out of Order</p> -->
                    <a href="/printers/update/{{$printer->id}}" class="btn btn-info">Update Record</a>
                    <a href="/printers/index" class="btn btn-primary">View all printers</a>
                </div>
            </div>
        </div>
    </div>
                      

<ul class="lsn container printer-details">
    {{-- Printer signed out --}}
    @if($printer->printer_status === 'Signed out')
    <li class="item">
        <div class="row well">
            <div class="col-lg-4 text-left">{{$printer->updated_at->format('d/m/Y')}}:</div>
            <div class="col-lg-4 text-justify">Printer signed out from the workshop</div>
        </div>
    </li>
    @endif
    {{-- Prints, Loans and Issues --}}
    @foreach($historyEntries as $entry)
        <li class="item">
            <div class=" row {{$entry['Class']}}">
                <div class="col-sm-4 text-left">
                    {{$entry['StartDate']->format('d/m/Y')}} -
                    @if($entry['EndDate'])
                        {{$entry['EndDate']->format('d/m/Y')}}
                    @else
                        Now
                    @endif
                </div>
                <div class="col-sm-4 text-justify">{{$entry['Type']}}: {{$entry['Description']}}</div>
                @if($entry['Type'] === 'Broken' || $entry['Type'] === 'Missing')
                    @can('issues_manage')
                        <div class="col-sm-4">
                            @if(!$entry['EndDate'])
                                <a href="/issues/update/{{$entry['EntryID']}}" class="btn btn-info">View/Update or Resolve</a>
                            @else
                                <a href="/issues/update/{{$entry['EntryID']}}">View details...</a>
                            @endif
                        </div>
                    @endcan
                @endif
                @if($entry['Type'] === '1 Prints' && $entry['Description'] !== 'Success' && $entry['Description'] !== 'Failed')
                        <div class="col-sm-4">
                            @if(!$entry['EndDate'])
                                <a href="/print/{{$entry['EntryID']}}" class="btn btn-info">View</a>
                            @else
                                <a href="/print/{{$entry['EntryID']}}">View details...</a>
                            @endif
                        </div>
                @endif
            </div>
        </li>
    @endforeach
    {{-- Printer created --}}
    <li class="item">
        <div class="row well">
            <div class="col-sm-4 text-left">{{$printer->created_at->format('d/m/Y')}}:</div>
            <div class="col-sm-4 text-justify">Printer registered with the workshop</div>
        </div>
    </li>
</ul>
@include('layouts.errors')
@endsection
@section('scripts')
@endsection
