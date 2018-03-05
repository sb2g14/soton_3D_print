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
        <table class="table table-responsive table-sm">
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
                <tr>
                    <td>UP!</td>
                    <td>{{\App\Printers::where('printer_type','UP!')->where('printer_status','!=','Signed out')->count()}}</td>
                    <td>ABS or PLA</td>
                    <td>10-100 cm3/h</td>
                    <td>140×140×135mm</td>
                </tr>
                <tr>
                    <td>UP Plus 2</td>
                    <td>{{\App\Printers::where('printer_type','UP Plus 2')->where('printer_status','!=','Signed out')->count()}}</td>
                    <td>ABS or PLA</td>
                    <td>10-100 cm3/h</td>
                    <td>140×140×135mm</td>
                </tr>
            </tbody>

        </table>
        <div class="col-sm-12 text-center">
            <h3 class="text-center lead">AVAILABLE PRINTERS FOR ORDERING ONLINE</h3>
            <p>If the order can not be printed in the workshop, here is the list of printers available for online requests:</p>
            <table class="table table-responsive table-sm">
                <thead>
                    <tr>
                        <td>UP BOX</td>
                        <td>{{\App\Printers::where('printer_type','UP BOX')->where('printer_status','!=','Signed out')->count()}}</td>
                        <td>ABS or PLA</td>
                        <td></td>
                        <td>255x205x205mm</td>
                    </tr>
                    <tr>
                        <td>Malyan M200</td>
                        <td>{{\App\Printers::where('printer_type','Malyan M200')->where('printer_status','!=','Signed out')->count()}}</td>
                        <td>ABS or PLA</td>
                        <td>180 mm/s</td>
                        <td>120x120x120mm</td>
                    </tr>
                    <tr>
                        <td>Original Prusa i3 MK3</td>
                        <td>{{\App\Printers::where('printer_type','Prusa i3 MK3')->where('printer_status','!=','Signed out')->count()}}</td>
                        <td>Any thermoplastic including Nylon and Polycarbonate</td>
                        <td>200+ mm/s</td>
                        <td>250x210x210mm</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
