@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Frequently Asked Questions
    </div>
    <div class="container well text-left">
        <div style="text-align: center">
            <p> Coming soon... But we already added a bit of information that might be helpful :-)</p>
        </div>
    </div>
    <div class="container well">
        <div class="col-sm-12 text-center">
            <h3 class="text-center lead">AVAILABLE PRINTERS FOR PRINTING IN THE WORKSHOP</h3>
            <p>Currently the workshop provides access to the following types of printers:</p>
        </div>
        <table class="table table-responsive table-hover table-sm">
            <thead>
                <tr>
                    <th>Printer model</th>
                    <th>Number available</th>
                    <th>Printing material</th>
                    <th>Print speed</th>
                    <th>Print size</th>
                </tr>
            </thead>
            <tbody>
                @foreach($workshop_printers as $printer)
                    <tr>
                        <td>{{$printer['name']}}</td>
                        <td>{{$printer['count']}}</td>
                        <td>{{$printer['material']}}</td>
                        <td>{{$printer['speed']}}</td>
                        <td>{{$printer['size']}}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>
        <div class="col-sm-12 text-center">
            <h3 class="text-center lead">AVAILABLE PRINTERS FOR ORDERING ONLINE</h3>
            <p>If the order can not be printed in the workshop, here is the list of printers available for online requests:</p>
            <table class="table table-responsive table-hover table-sm">
                <thead>
                    <tr>
                        <th>Printer model</th>
                        <th>Number available</th>
                        <th>Printing material</th>
                        <th>Print speed</th>
                        <th>Print size</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($online_printers as $printer)
                    <tr>
                        <td>{{$printer['name']}}</td>
                        <td>{{$printer['count']}}</td>
                        <td>{{$printer['material']}}</td>
                        <td>{{$printer['speed']}}</td>
                        <td>{{$printer['size']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
