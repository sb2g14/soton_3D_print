@extends('layouts.layout')

@section('content')
    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
            {{ $flash }}
        </div>
    @endif

    <div class="text-center m-b-md">
        <div class="title">Finance Overview</div> 
    </div>

    <div class="container">
        <div class="col-lg-2 pull-left">
            <a href="{{ url('/costCodes/index') }}" type="button" class="btn btn-primary pull-left">
                Cost Codes
            </a>
        </div>
        <div class="col-lg-2 pull-left">
            <a href="{{ url('/statistics') }}" type="button" class="btn btn-primary pull-left">
                Statistics
            </a>
        </div>
        <div class="col-lg-2 pull-left">
            <a href="{{ url('/finance/jobs') }}" type="button" class="btn btn-primary pull-left">
                Past Jobs
            </a>
        </div>
        <hr>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                @php 
                    $chart_height = 300; 
                    $chart_box_height = $chart_height+150; 
                @endphp
                <div class="well" style="display: inline-block; overflow: none; width:100%;height:{{$chart_box_height}}; float=left;">
                    <iframe id="DC_prints_peryear" src="{{ route('chart', ['name' => 'printspy', 'height' => $chart_height, 'color' => 'prussian']) }}" height="{{$chart_box_height}}" width="100%" style="width:100%; border:none; overflow: none;"></iframe>
                </div>
                <div class="well" style="display: inline-block; overflow: none; width:100%;height:{{$chart_box_height}}; float=left;">
                    <iframe id="DC_printertype_reliability" src="{{ route('chart', ['name' => 'printertype_reliability', 'color' => 'shamrock', 'height' => $chart_height]) }}" height="{{$chart_box_height}}" width="100%" style="width:100%; border:none;"></iframe>
                </div>
                <div class="text-left well">
                    <b>People who haven't shown their CWP yet:</b><br/>
                    {{ $nocwp }}<br/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="well">
                    <b>Money Flow This Year</b>*
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Label</th>
                                <th class="text-right">Money In</th>
                                <th class="text-right">Money Out</th>
                            </tr>
                        </thead>
                        @php
                            $moneyin = 0;
                            $moneyout = 0;
                            $demohour = 15.08; //cost to employ a demonstrator for 1h
                            $inWorkshopJobs = $WorkshopJobs->sum('Price');
                            $inOnlineJobs = $OnlineJobs->sum('Price');
                        @endphp
                        <tbody id="tableJobs">
                            <tr class="text-left">
                                <td data-th="Label">Workshop Jobs</td>
                                <td data-th="Money In" class="text-right">&pound;{{ number_format($inWorkshopJobs,2) }}</td>
                                <td data-th="Money Out" class="text-right"> </td>
                            </tr>
                            @php
                                $moneyin += $inWorkshopJobs;
                            @endphp
                            <tr class="text-left">
                                <td data-th="Label">Online Jobs</td>
                                <td data-th="Money In" class="text-right">&pound;{{ number_format($inOnlineJobs,2) }}</td>
                                <td data-th="Money Out" class="text-right"> </td>
                            </tr>
                            @php
                                $moneyin += $inOnlineJobs;
                            @endphp
                            @foreach($demonstrators as $demonstrator) 
                                <tr class="text-left">
                                    <td data-th="Label">{{ $demonstrator->role }} Payment</td>
                                    <td data-th="Money In" class="text-right"> </td>
                                    <td data-th="Money Out" class="text-right">- &pound;{{ number_format(($demonstrator->Sessions)*$demohour,2) }}</td>
                                </tr>
                                @php
                                    $moneyout += ($demonstrator->Sessions)*$demohour;
                                @endphp
                            @endforeach
                            <tr class="text-left">
                                <td data-th="Label">TOTAL</td>
                                <td data-th="Money In" class="text-right">&pound;{{ number_format($moneyin,2) }}</td>
                                <td data-th="Money Out" class="text-right">- &pound;{{ number_format($moneyout,2) }}</td>
                                <td data-th="Total" class="text-right"> =&pound;{{ number_format($moneyin - $moneyout,2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="well">
                    <b>Money Flow Last Year</b>*
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Label</th>
                                <th class="text-right">Money In</th>
                                <th class="text-right">Money Out</th>
                            </tr>
                        </thead>
                        @php
                            $moneyin = 0;
                            $moneyout = 0;
                            $demohour = 15.08; //cost to employ a demonstrator for 1h
                            $inWorkshopJobs = $WorkshopJobsPrev->sum('Price');
                            $inOnlineJobs = $OnlineJobsPrev->sum('Price');
                        @endphp
                        <tbody id="tableJobs">
                            <tr class="text-left">
                                <td data-th="Label">Workshop Jobs</td>
                                <td data-th="Money In" class="text-right">&pound;{{ number_format($inWorkshopJobs,2) }}</td>
                                <td data-th="Money Out" class="text-right"> </td>
                            </tr>
                            @php
                                $moneyin += $inWorkshopJobs;
                            @endphp
                            <tr class="text-left">
                                <td data-th="Label">Online Jobs</td>
                                <td data-th="Money In" class="text-right">&pound;{{ number_format($inOnlineJobs,2) }}</td>
                                <td data-th="Money Out" class="text-right"> </td>
                            </tr>
                            @php
                                $moneyin += $inOnlineJobs;
                            @endphp
                            @foreach($demonstratorsPrev as $demonstrator) 
                                <tr class="text-left">
                                    <td data-th="Label">{{ $demonstrator->role }} Payment</td>
                                    <td data-th="Money In" class="text-right"> </td>
                                    <td data-th="Money Out" class="text-right">- &pound;{{ number_format(($demonstrator->Sessions)*$demohour,2) }}</td>
                                </tr>
                                @php
                                    $moneyout += ($demonstrator->Sessions)*$demohour;
                                @endphp
                            @endforeach
                            <tr class="text-left">
                                <td data-th="Label">TOTAL</td>
                                <td data-th="Money In" class="text-right">&pound;{{ number_format($moneyin,2) }}</td>
                                <td data-th="Money Out" class="text-right">- &pound;{{ number_format($moneyout,2) }}</td>
                                <td data-th="Total" class="text-right"> =&pound;{{ number_format($moneyin - $moneyout,2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-left">
                    * These numbers do not include money spend on Online Demonstrators, IT, Printers, and Filament. Money spend on demonstrators is an estimate based on the number of sessions assigned online and does not include preperation time, training, or non-demonstrating related duties.
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@endsection
