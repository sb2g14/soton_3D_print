@extends('layouts.layout')
@section('scripts')
    @if (notify()->ready())
        <script>
            swal({
                title: "{!! notify()->message() !!}",
                text: "{!! notify()->option('text') !!}",
                type: "{{ notify()->type() }}",
                showConfirmButton: true
            });
        </script>
    @endif
@stop
@section('content')
    {{--<div class="title m-b-md">--}}
        {{--How to find us --}}
    {{--</div>--}}
    <div class="container well">
        <div class="col-sm-12 text-center">
            <h3 class="text-center lead">AVAILABLE PRINTERS</h3>
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
                    <td>{{\App\Printers::where('printer_type','UP!')->count()}}</td>
                    <td>ABS or PLA</td>
                    <td>10-100 cm3/h</td>
                    <td>140×140×135mm</td>
                </tr>
                <tr>
                    <td>UP Plus 2</td>
                    <td>{{\App\Printers::where('printer_type','UP Plus 2')->count()}}</td>
                    <td>ABS or PLA</td>
                    <td>10-100 cm3/h</td>
                    <td>140×140×135mm</td>
                </tr>
                <tr>
                    <td>UP BOX</td>
                    <td>{{\App\Printers::where('printer_type','UP BOX')->count()}}</td>
                    <td>ABS or PLA</td>
                    <td></td>
                    <td>255x205x205mm</td>
                </tr>
                <tr>
                    <td>Malyan M200</td>
                    <td>{{\App\Printers::where('printer_type','Malyan M200')->count()}}</td>
                    <td>ABS or PLA</td>
                    <td>180 mm/s</td>
                    <td>120x120x120mm</td>
                </tr>
                <tr>
                    <td>Original Prusa i3 MK3</td>
                    <td>{{\App\Printers::where('printer_type','Original Prusa i3 MK3')->count()}}</td>
                    <td>Any thermoplastic including Nylon and Polycarbonate</td>
                    <td>200+ mm/s</td>
                    <td>250x210x210mm</td>
                </tr>
            </tbody>

        </table>
    </div>

    <div class="container well">
        <div class="row vdivide">
            <div class="col-sm-6 text-left">
                <h3 class="text-center lead">OPEN HOURS</h3>
                <p>Open Access to 3D Printing Service in Design Workshop ​<br>
                Wednesdays  9:00-18:00</p>
            </div>
            <div class="col-sm-6 text-left">
                <h3 class="text-center lead">CONTACTS</h3>
                <table class="contacts">
                    <tr>
                        <td>Location:</td>
                        <td class="col-left"><span class="glyphicon glyphicon-map-marker"></span> University of Southampton, B13/R1055</td>
                    </tr>
                    <tr>
                        <td>Service enquiries:</td>
                    </tr>
                        @foreach($lead_demonstrators as $lead_demonstrator)
                    <tr>
                        <td></td>
                            <td class="col-left">{{ $lead_demonstrator->first_name }} {{ $lead_demonstrator->last_name }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="col-left row-last"><span class="glyphicon glyphicon-envelope"></span> <a href="mailto:{{$lead_demonstrator->email}}">{{  $lead_demonstrator->email }}</a></td>
                    </tr>
                        @endforeach
                    <tr>
                        <td>Faculty contact:</td>
                    @foreach($coordinators as $coordinator)
                        <tr>
                            <td></td>
                            <td class="col-left">{{ $coordinator->first_name }} {{ $coordinator->last_name }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="col-left row-last"><span class="glyphicon glyphicon-envelope"></span> <a href="mailto:{{$coordinator->email}}">{{  $coordinator->email }}</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
                <section id="canvas1" class="s-map">
                    <iframe id="map_canvas1" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4480.157517437024!2d-1.3984993030069568!3d50.93475279559591!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x28ef7c4fb80298da!2sThe+Tizard!5e0!3m2!1sen!2sde!4v1497548468301" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </section>

@endsection
