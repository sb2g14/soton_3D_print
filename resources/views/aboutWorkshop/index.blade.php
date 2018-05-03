@extends('layouts.layout')

@section('content')
    {{--TITLE--}}
    <div class="title m-b-md">
        About the Service
    </div>
    {{--ABSTRACT--}}
    <div class="container well text-left">
        <p>
            This service offers students and staff the opportunity to get into contact with additive manufacturing. We provide open access to a range of fused deposit modelling (FDM) printers in the Design Workshop. For more information, please consult our <a href="/faq">FAQ</a>.
        </p>
        <p>
            We do appreciate when users consider it appropriate to acknowledge the 'support of the 3D Printing Service among the Faculty of Engineering and the Environment design and manufacturing facilities at the University of Southampton', and would be proud to link to any such work from our website. Please also send us photos of your work to be presented in our <a href="/photolibrary">Photo Gallery</a>.
        </p>
        <p>
            For Part III and IV UG student, MSc, researcher and staff projects, the EDMC offers further 3D printing options. 
            Please see the <a href="/faq">FAQ</a> for more information.
        </p>
    </div>
    
    {{--INFORMATION--}}
    <div class="container well">
        <div class="row vdivide">
            <div class="col-sm-6 text-left">
                <h3 class="text-center lead">OPENING HOURS</h3>
                <p>Usually Wednesdays 9:00 &ndash; 18:00, except during University closure.</p>
                <p>Next Scheduled Sessions are:<br/>
                    <table>
                        @foreach($open as $o)
                            <tr>
                            <td>{{ Carbon\Carbon::parse($o[0][0])->format('D, d/m/y') }}:&emsp;</td>
                            {{-- TODO: improve formatting --}}
                            @foreach($o as $s)
                                @if($s != $o[0])
                                </tr><tr><td></td>
                                @endif
                                <td>{{ Carbon\Carbon::parse($s[0])->format('g:i a') }} &ndash; {{ Carbon\Carbon::parse($s[1])->format('g:i a') }}</td>
                            @endforeach
                            </tr>
                        @endforeach
                    </table>
                </p>
                {{--<p>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <div id="opencal"></div>
                            </div>
                        </div>
                    </div>
                    <div id="opentimes"></div>
                </p>--}}
                {!! $chart->html() !!}
                {!! Charts::scripts() !!}
                {!! $chart->script() !!}  
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
    <div class="container well">
        {{phpinfo()}}
    </div>
    {{--MAP--}}
    <section id="canvas1" class="s-map">
        <!--<iframe id="map_canvas1" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4480.157517437024!2d-1.3984993030069568!3d50.93475279559591!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x28ef7c4fb80298da!2sThe+Tizard!5e0!3m2!1sen!2sde!4v1497548468301" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>-->
        <iframe width="100%" height="450" frameborder="0" marginheight="0" marginwidth="0" style="border:0" src="https://maps.southampton.ac.uk/#18/50.93573/-1.39377/nomenu,nowheelzoom,nojump,doors?marker=50.93570779114204%2C-1.3939815759658813"></iframe>
    </section>

@endsection

@section('scripts')
    <script>
        //want to show B13 by default
        //this requires to access the iframe -> not possible
        //$(document).ready( function(){
        //    id = 13;
        //    console.log(id);
        //    obj = parentobject.layer[id];
        //    if(!(obj === null)) { obj.openPopup(); }
        //});
    </script>
    <script type="text/javascript">
        //$(function () {
        //    $('#opencal').datetimepicker({
        //        inline: true, 
        //        format:'DD/MM/YYYY', 
        //        enabledDates: [@foreach($open as $o)'{{Carbon\Carbon::parse($o[0][0])->format("d/m/Y")}}',@endforeach''], 
        //        showTodayButton:true, 
        //        showClear:false, 
        //        showClose:false
        //    });
        //    $("#opencal").on("dp.change", function (e) {
        //        $('#opentimes').html("Hello World");
        //    });
        //});
    </script>
@endsection
