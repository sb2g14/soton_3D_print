@extends('layouts.layout')

@section('content')
    <div class="title m-b-md">
        About the Service
    </div>
    <div class="container well text-left">
        <p>
            This service offers students and staff the opportunity to get into contact with additive manufacturing. We provide open access to a range of fused deposit modelling (FDM) printers in the Design Workshop. For more information, please consult our <a href="faq">FAQ</a>.
        </p>
        <p>
            We do appreciate when users consider it appropriate to acknowledge the 'support of the 3D Printing Service among the Faculty of Engineering and the Environment design and manufacturing facilities at the University of Southampton', and would be proud to link to any such work from our website. Please also send us photos of your work to be presented in our <a href="photolibrary">Photo Gallery</a>.
        </p>
        <p>
            For Part III and IV UG student, MSc, researcher and staff projects with a sub-project cost (‘budget’) code,
            the EDMC offers further 3D printing options, for example binder jet powder printing (ABS) and Direct Metal
            Laser Sintering (typically stainless steel). Please have a look at the
            <a href="https://www.southampton.ac.uk/autonomous-systems/about/ecdm-workshop.page">
                EDMC manufacturing methods</a>. Relevant details can be found on the page of the
            <a href="https://groupsite.soton.ac.uk/Academic/FEE-Engineering-Design-and-Manufacturing-Centre/Pages/Home.aspx">
                FEE Engineering Design and Manufacturing Centre</a>, in particular the
            <a href="https://groupsite.soton.ac.uk/Academic/FEE-Engineering-Design-and-Manufacturing-Centre/_layouts/WordViewer.aspx?id=/Academic/FEE-Engineering-Design-and-Manufacturing-Centre/Documents/FEE-Workshop-Facilities-available-for-Student%2BResearcher%2BStaff-Use.docx">
                'FEE Workshop Facilities available for Student Researcher Staff Use' file</a> in the Documents folder.
        </p>
    </div>
    

    <div class="container well">
        <div class="row vdivide">
            <div class="col-sm-6 text-left">
                <h3 class="text-center lead">OPEN HOURS</h3>
                <p>Wednesdays 9:00-18:00, except during University closure.</p>
                
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
@endsection
