@extends('layouts.layout')
@section('content')
    <style>
        .full-height {
            height: 140vh;
        }
    </style>

    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -100px">
            {{ $flash }}
        </div>
    @endif

    <div class="title m-b-md">
        3D printers     
    </div>

    <div class="container">
        @hasanyrole('LeadDemonstrator|administrator')
        <a href="{{ url('/printers/create') }}">
            <button type="submit" class="btn btn-primary pull-right">Add Printer</button>
        </a>
        @endhasanyrole
        @hasanyrole('LeadDemonstrator|Demonstrator|administrator')
        <a href="/issues/index" class="btn btn-success pull-left" style="margin-right: 20px;" >Manage Issues</a>
        @endhasanyrole
        @hasanyrole('LeadDemonstrator|administrator')
        {!! link_to_route('issues.export',
        'Export Issues to Excel', null,
        ['class' => 'btn btn-info pull-left']) !!}
        @endhasanyrole
        <table class="table">
            <thead>
                <tr style="font-weight: 600;">
                    <th>Printer Number</th>
                    <th>Serial Number</th>
                    <th>Printer Type</th>
                    <th>Status</th>
                    <th>View History</th>
                </tr>
            </thead>
            <tbody>
                @foreach($printers as $printer)
                    <tr style="text-align: left;">
                        <td>{{$printer->id}}</td>
                        <td>{{$printer->serial_no}}</td>
                        <td>{{$printer->printer_type}}</td>
                        @if ($printer->printer_status == 'Available' && $printer->in_use == 0)
                            <td class="success">{{$printer->printer_status}}</td>
                        @elseif($printer->printer_status == 'Available' && $printer->in_use == 1)
                            <td style="background-color:yellowgreen;color:white;">In Use</td>
                        @elseif ($printer->printer_status == 'Missing')
                            <td class="warning">{{$printer->printer_status}}</td>
                        @elseif ($printer->printer_status == 'Broken')
                            <td class="danger">{{$printer->printer_status}}</td>
                         @elseif ($printer->printer_status == 'On Loan')
                            <td class="info">{{$printer->printer_status}}</td>
                         @elseif ($printer->printer_status == 'Signed out')
                            <td class="active">{{$printer->printer_status}}</td>
                        @endif
                        <td><a href="/issues/show/{{$printer->id }}" class="btn btn-info btn-block">Details</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
