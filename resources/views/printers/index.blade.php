
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
            @can('issues_manage')
                <a href="/issues/index" class="btn btn-primary pull-left" style="margin-right: 8px;" >Manage Issues</a>
            @endcan
            {{--@hasanyrole('LeadDemonstrator|administrator')--}}
                {{--{!! link_to_route('issues.export',--}}
                {{--'Export to Excel', null,--}}
                {{--['class' => 'btn btn-info pull-left']) !!}--}}
            {{--@endhasanyrole--}}
            @can('printers_manage')
                <a href="{{ url('/printers/create') }}" class="btn btn-success pull-right">Add Printer</a>
            @endcan
        </div>
        
            
        <table class="table">
            <thead>
                <tr>
                    <th>Printer Number</th>
                    <th>Serial Number</th>
                    <th>Printer Type</th>
                    <th>Status</th>
                    @can('issues_manage')
                        <th>View History</th>
                        @hasanyrole('administrator')
                            <th>Update Record</th>
                        @endhasanyrole
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach($printers as $printer)
                    @php
                        $printerstatus = $printer->printer_status;
                        if($printer->printer_status == 'Available' && $printer->in_use == 1){
                            $printerstatus = 'In Use';
                        }
                        $printerclass = strtolower($printerstatus);
                        $printerclass = str_replace(" ","-",$printerclass);
                    @endphp
                    <tr class="text-left {{$printerclass}}">
                        <td data-th="Printer Number">{{$printer->id}}</td>
                        <td data-th="Serial Number">{{$printer->serial_no}}</td>
                        <td data-th="Printer Type">{{$printer->printer_type}}</td>
                        <td data-th="Status">{{$printerstatus}}</td>
                        @can('issues_manage')
                            <td data-th="View History"><a href="/issues/show/{{$printer->id }}" class="btn btn-primary">Details</a></td>
                            @hasanyrole('administrator')
                                <td data-th="Update Record"><a href="/printers/update/{{$printer->id }}" class="btn btn-info">Update</a></td>
                            @endhasanyrole
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
