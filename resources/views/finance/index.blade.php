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
            <a href="{{ url('/costCodes') }}" type="button" class="btn btn-primary pull-left">
                Cost Codes
            </a>
        </div>
        <div class="col-lg-2 pull-left">
            <a href="{{ url('/statistics') }}" type="button" class="btn btn-primary pull-left">
                <i class="fa fa-bar-chart"></i> Statistics
            </a>
        </div>
        <div class="col-lg-2 pull-left">
            <a href="{{ url('/finance/jobs') }}" type="button" class="btn btn-primary pull-left">
                <i class="fa fa-clock-o"></i> Past Jobs
            </a>
        </div>
        <div class="pull-right">
            <a href="/finance/settings" type="button" class="btn btn-info pull-left">
                <i class="fa fa-cog"></i> Settings
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
                            //$demohour = 15.08; //cost to employ a demonstrator for 1h
                            //$inWorkshopJobs = $WorkshopJobs->sum('Price');
                            //$inOnlineJobs = $OnlineJobs->sum('Price');
                        @endphp
                        <tbody id="tableJobs">
                            @foreach($finance[0] as $label => $money)
                                <tr class="text-left">
                                    <td data-th="Label">{{$label}}</td>
                                    @if($money > 0)
                                        <td data-th="Money In" class="text-right">&pound;{{ number_format($money,2) }}</td>
                                        <td data-th="Money Out" class="text-right"> </td>
                                        @php
                                            $moneyin += $money;
                                        @endphp
                                    @elseif($money < 0)
                                        <td data-th="Money In" class="text-right"></td>
                                        <td data-th="Money Out" class="text-right">&pound;{{ number_format($money,2) }}</td>
                                        @php
                                            $moneyout += $money;
                                        @endphp
                                    @else
                                        <td data-th="Money In" class="text-right"></td>
                                        <td data-th="Money Out" class="text-right"></td>
                                    @endif
                                </tr>
                                
                            @endforeach
                            <tr class="text-left">
                                <td data-th="Label">TOTAL</td>
                                <td data-th="Money In" class="text-right">&pound;{{ number_format($moneyin,2) }}</td>
                                <td data-th="Money Out" class="text-right">&pound;{{ number_format($moneyout,2) }}</td>
                                <td data-th="Total" class="text-right"> =&pound;{{ number_format($moneyin + $moneyout,2) }}</td>
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
                        @endphp
                        <tbody id="tableJobs">
                            @foreach($finance[1] as $label => $money)
                                <tr class="text-left">
                                    <td data-th="Label">{{$label}}</td>
                                    @if($money > 0)
                                        <td data-th="Money In" class="text-right">&pound;{{ number_format($money,2) }}</td>
                                        <td data-th="Money Out" class="text-right"> </td>
                                        @php
                                            $moneyin += $money;
                                        @endphp
                                    @elseif($money < 0)
                                        <td data-th="Money In" class="text-right"></td>
                                        <td data-th="Money Out" class="text-right">&pound;{{ number_format($money,2) }}</td>
                                        @php
                                            $moneyout += $money;
                                        @endphp
                                    @else
                                        <td data-th="Money In" class="text-right"></td>
                                        <td data-th="Money Out" class="text-right"></td>
                                    @endif
                                </tr>
                                
                            @endforeach
                            <tr class="text-left">
                                <td data-th="Label">TOTAL</td>
                                <td data-th="Money In" class="text-right">&pound;{{ number_format($moneyin,2) }}</td>
                                <td data-th="Money Out" class="text-right">&pound;{{ number_format($moneyout,2) }}</td>
                                <td data-th="Total" class="text-right"> =&pound;{{ number_format($moneyin + $moneyout,2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-left">
                    * These numbers do not include money spend on IT, Printers, and Demonstrators management tasks. Several figures are estiamtes only<br/>
                    ** Numbers are estimated based on the number of sessions and the number of demonstrators assigned to them and does not include preperation time, training, or non-demonstrating related duties.<br/>
                    *** Numbers are a rough estimate based on the number of online orders and prints done for these.<br/>
                    **** Material cost is estimated assuming 20% waste material per print, ignoring failed prints.
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@endsection
