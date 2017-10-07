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
        <div>
            @hasanyrole('LeadDemonstrator|Demonstrator|administrator')
                <a href="/issues/index" class="btn btn-primary pull-left" style="margin-right: 8px;" >Manage Issues</a>
            @endhasanyrole
            @hasanyrole('LeadDemonstrator|administrator')
                {!! link_to_route('issues.export',
                'Export to Excel', null,
                ['class' => 'btn btn-info pull-left']) !!}
            @endhasanyrole
            @hasanyrole('LeadDemonstrator|administrator')
                <a href="{{ url('/printers/create') }}" class="btn btn-success pull-right">Add Printer</a>
            @endhasanyrole
        </div>
        
            
        <table class="table">
            <thead>
                <tr>
                    <th>Printer Number</th>
                    <th>Serial Number</th>
                    <th>Printer Type</th>
                    <th>Status</th>
                    @hasanyrole('LeadDemonstrator|Demonstrator|administrator')
                        <th>View History</th>
                        @hasanyrole('administrator')
                            <th>Update Record</th>
                        @endhasanyrole
                    @endhasanyrole
                </tr>
            </thead>
            <tbody>
                @foreach($printers as $printer)
                    <tr class="text-left">
                        <td data-th="Printer Number">{{$printer->id}}</td>
                        <td data-th="Serial Number">{{$printer->serial_no}}</td>
                        <td data-th="Printer Type">{{$printer->printer_type}}</td>
                        @if ($printer->printer_status == 'Available' && $printer->in_use == 0)
                            <td data-th="Status" class="success">{{$printer->printer_status}}</td>
                            @elseif($printer->printer_status == 'Available' && $printer->in_use == 1)
                                <td data-th="Status" style="background-color:yellowgreen;color:white;">In Use</td>
                            @elseif ($printer->printer_status == 'Missing')
                                <td data-th="Status" class="warning">{{$printer->printer_status}}</td>
                            @elseif ($printer->printer_status == 'Broken')
                                <td data-th="Status" class="danger">{{$printer->printer_status}}</td>
                            @elseif ($printer->printer_status == 'On Loan')
                                <td data-th="Status" class="info">{{$printer->printer_status}}</td>
                            @elseif ($printer->printer_status == 'Signed out')
                                <td data-th="Status" class="active">{{$printer->printer_status}}</td>
                        @endif
                        @hasanyrole('LeadDemonstrator|Demonstrator|administrator')
                            <td data-th="View History"><a href="/issues/show/{{$printer->id }}" class="btn btn-info">Details</a></td>
                            @hasanyrole('administrator')
                                <td data-th="Update Record"><a href="/printers/update/{{$printer->id }}" class="btn btn-primary">Update</a></td>
                            @endhasanyrole
                        @endhasanyrole
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
