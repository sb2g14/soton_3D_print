@extends('layouts.layout')

@section('content')
    
    <div class="title m-b-md">
        Statistics
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 well">
                        @php 
                            $chart_height = 300; 
                            $chart_box_height = $chart_height+150; 
                        @endphp
                        <div style="display: inline-block; overflow: none; width:48%;height:{{$chart_box_height}}; float=left;">
                            <iframe id="DC_printer_availability" src="{{ route('chart', ['name' => 'printer_status', 'height' => $chart_height, 'color' => 'coral']) }}" height="{{$chart_box_height}}" width="100%" style="width:100%; border:none;"></iframe>
                        </div>
                        <div style="display: inline-block; overflow: none; width:48%;height:{{$chart_box_height}}px; float=left;">
                            <iframe id="DC_workshop_usage" src="{{ route('chart', ['name' => 'workshop_usage', 'height' => $chart_height, 'color' => 'coral']) }}" height="{{$chart_box_height}}" width="100%" style="width:100%; border:none;"></iframe>
                        </div>
                        

                        <div style="display: inline-block; overflow: none; width:32%;height:{{$chart_box_height}}; float=left;">
                            <iframe id="DC_prints_per_month" src="{{ route('chart', ['name' => 'printspmpy', 'height' => $chart_height, 'color' => 'prussian']) }}" height="{{$chart_box_height}}" width="100%" style="width:100%; border:none; overflow: none;"></iframe>
                        </div>
                        <div style="display: inline-block; overflow: none; width:32%;height:{{$chart_box_height}}; float=left;">
                            <iframe id="DC_prints_peryear" src="{{ route('chart', ['name' => 'printspy', 'height' => $chart_height, 'color' => 'prussian']) }}" height="{{$chart_box_height}}" width="100%" style="width:100%; border:none; overflow: none;"></iframe>
                        </div>

                        <div style="display: inline-block; overflow: none; width:32%;height:{{$chart_box_height}}; float=left;">
                            <iframe id="DC_users_peryear" src="{{ route('chart', ['name' => 'userspy', 'height' => $chart_height, 'color' => 'prussian']) }}" height="{{$chart_box_height}}" width="100%" style="width:100%; border:none; overflow: none;"></iframe>
                        </div>
                        <div style="display: inline-block; overflow: none; width:96%;height:{{$chart_box_height}}; float=left;">
                            <iframe id="DC_printertype_reliability" src="{{ route('chart', ['name' => 'printertype_reliability', 'color' => 'shamrock', 'height' => $chart_height]) }}" height="{{$chart_box_height}}" width="100%" style="width:100%; border:none;"></iframe>
                        </div>
                        
                    </div>


        </div>
    </div>
@endsection
