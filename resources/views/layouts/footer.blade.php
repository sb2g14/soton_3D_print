
<footer>
    @php $version = config('app'); $version = $version['version']; @endphp 
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <p class="text-justify">FEE 3D Printing Service at the University of Southampton IT platform for managing online and in-premises print requests. Designed and maintained by a team of university students.</p>
                <hr>
                <div class="copyright">
                        
                        <span style="font-weight: 500;">&copy; 2017-{{date("Y")}}</span>
                        <a href="{{ url('/') }}">FEE 3D Printing Service</a> and <a href="{{ url('https://www.southampton.ac.uk/') }}" target="_blank">University of Southampton</a> - 
                        <span style="font-weight: 200;"> version {{$version}}</span>
                </div>
            </div>
            @php
                $itteam = App\staff::orderBy('last_name')->where('role','IT')
                    ->where('id','!=','7')->where('id','!=','1')->where('id','!=','2')->where('last_name','!=','System')
                    ->get();
                $itmanager = App\staff::orderBy('last_name')->where('role','IT Manager')
                    ->where('id','!=','7')->where('id','!=','1')->where('id','!=','2')->where('last_name','!=','System')
                    ->get();
                $itsupport = App\staff::where('role','IT Manager')->first();
                $studentlead = App\staff::where('role','Lead Demonstrator')->first();
                $facultylead = App\staff::where('role','Coordinator')->first();
            @endphp
            <div class="col-sm-4 text-left support">
                <div class="row">
                    <div class="col-xs-6 team">
                        <b>Developer team: </b><br>
                        <div class="developers">
                            Svitlana Braichenko <br>
                            Illya Khromov <br>
                            Andrii Iakovliev <br>
                            Lasse Wollatz
                        </div>
                        {{--<b>Maintained by:</b><br>
                        <div class="developers">
                            @foreach($itteam as $staff)
                                {{$staff->name()}} <br>
                            @endforeach
                            @foreach($itmanager as $staff)
                                {{$staff->name()}} <br>
                            @endforeach
                        </div>--}}
                    </div>
                    <div class="col-xs-6 team">
                        <b>Contact us: </b><br>
                        <div class="developers">
                            Student Lead: <a href="mailto:{{$studentlead->email}}?Subject=3D%20Printing%20Service" target="_blank">{{$studentlead->name()}}</a> <br>
                            Faculty Lead: <a href="mailto:{{$facultylead->email}}?Subject=3D%20Printing%20Service" target="_blank">{{$facultylead->name()}}</a> <br>
                            IT Support: <a href="mailto:{{$itsupport->email}}?Subject=3D%20Printing%20Service" target="_blank">{{$itsupport->name()}}</a> <br>
                        </div><br>
                        <a href="/aboutWorkshop">Find us on campus</a><br>
                    </div>
                </div>
                
            </div>
            <div class="col-xs-12 col-sm-4 text-center"> 
                <div class="row">
                        Find out more
                </div>
                <div class="social-media"> 
                    <div class="row">
                        <div class="col-xs-3"></div>
                        <div class="col-xs-1">
                            <a href="https://www.facebook.com/EDMC-and-Design-Workshops-University-of-Southampton-1569152903360637/" target="_blank"><i class="fa fa-facebook-f"></i></a>
                        </div>
                        <div class="col-xs-1">
                            <a href="https://www.youtube.com/channel/UCYrrokbBniAgVg_On7BSD3A" target="_blank"><i class="fa fa-youtube-play"></i></a>
                        </div>
                        <div class="col-xs-1">
                            <a href="https://www.southampton.ac.uk" target="_blank"><img src="/Images/icons/S.gif" style="height:30px;"/></a>
                        </div>
                        <div class="col-xs-2">
                            <a href={{ url('/faq') }} target="_blank">FAQ</a>
                        </div>
                        <div class="col-xs-2"></div>
                    </div>
                </div>
                
                
                
            </div>
        </div>
    </div>
</footer>

{{-- Cookie banner --}}
<style>
    #cookie_banner {
        background-color:rgba(0, 0, 0, 0.6);
        color: white;
    }
    #cookie_banner_body {
        background-color: #002e3b;
        background-color:rgba(0, 0, 0, 0.6); 
        color: white;
    }
    #cookie_banner_body a{
        text-decoration: underline;
        color: white;
    }
    #cookie_banner.affix {
        bottom: 0px;
    }
</style>
@if(!( isset($_COOKIE['complianceCookie']) && $_COOKIE['complianceCookie'] === "true" ))
<div id="cookie_banner" class="container-fluid col-lg-12" data-spy="affix" data-offset-bottom="0">
    <div id="cookie_banner_body" class="row">
        <div class="col-lg-11">
            <br/>
            <b><a href="https://www.southampton.ac.uk/about/governance/policies/cookies.page">We use cookies because we need them to handle sessions and check if you clicked the cross on this alert before.</a> We currently have set {{count($_COOKIE)}} cookies. If you continue without changing your settings, we will assume that you are happy to receive cookies on the 3D Printing Service website.  </b><br/>
            <br/>
        </div>
        <div class="col-lg-1">
            <button id="cookie_banner_button" type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    </div>
</div>
@endif

