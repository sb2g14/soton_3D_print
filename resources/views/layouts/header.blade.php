<header class="p-header">
    <div class="ctr">
        <div class="branding">
            <a href="{{ url('/') }}">
                <img class="logo_mob" src="/Images/uos-brand1.png" alt="3Dprinting">
            </a>
        </div>
       @if (Auth::check())
            <ul class="lsn bl-menu" id="my-menu">

                
                {{--Leading to welcome page--}}
                <li class="item"><a class="no-dropdown" href="{{ url('/') }}">Home</a></li>
                {{--Pages connected with printers--}}
                <li class="item">
                    <span>
                        3D printers
                        <span class="caret"></span></span>
                    <ul class="dropdown-bl">
                        <li><a class="dropdown-item" href="{{ url('/printers/index') }}">View printers</a></li>
                        @can('issues_manage')
                            <li><a class="dropdown-item" href="{{ url('/issues/index') }}">Pending issues</a></li>
                            <li><a class="dropdown-item" href="{{ url('/issues/select') }}">Log an issue</a></li>
                        @endcan
                    </ul>
                </li>
                {{--Manage finance--}}
                @can('manage_cost_codes')
                <li class="item">
                    <span>
                        Finance
                        <span class="caret"></span></span>
                    <ul class="dropdown-bl">
                        <li><a class="dropdown-item" href="{{ url('/costCodes/index') }}">Cost codes</a></li>
                    </ul>
                </li>
                @endcan
                {{--Printing in the workshop and online--}}
                <li class="item">
                    <span>
                        Printing
                        <span class="caret"></span></span>
                    <ul class="dropdown-bl">
                        <li><a class="dropdown-item"  href="{{ url('/printingData/index') }}">Manage Workshop Jobs</a></li>
                        <li><a class="dropdown-item" href="{{ url('/printingData/create') }}">Request to Print in the Workshop</a></li>
                        @can('manage_online_jobs')
                            <li><a class="dropdown-item" href="{{ url('/OnlineJobs/index') }}">Manage Online Jobs</a></li>
                        @endcan
                        <li><a class="dropdown-item"  href="{{ url('/OnlineJobs/create') }}">Order a Print Online</a></li>
                        {{--<li><a class="dropdown-item" href="{{ url('/loan') }}">Request a loan</a></li>--}}
                    </ul>
                </li>
                {{--Managing staff--}}
                <li class="item">
                    <span>
                        Staff
                        <span class="caret"></span></span>
                    <ul class="dropdown-bl">
                        <li><a class="dropdown-item" href="{{ url('/members/index') }}">Our Team</a></li>
                        <li><a class="dropdown-item" href="{{ url('/rota') }}">Rota</a></li>
                        <li><a class="dropdown-item" href="{{ url('/documents') }}">Documents and Info</a></li>
                        <li><a class="dropdown-item" href="{{ url('/gettingPaid') }}">Getting paid</a></li> 
                    </ul>
                </li>
                {{--Other workshop-connected information--}}
                <li class="item">
                    <span>
                        About
                        <span class="caret"></span></span>
                    <ul class="dropdown-bl">
                        <li><a class="dropdown-item" href="{{ url('/aboutWorkshop') }}">About workshop</a></li>
                        <li><a class="dropdown-item" href="{{ url('/news') }}">Workshop History</a></li>
                        <li><a class="dropdown-item" href="{{ url('/learn') }}">Learn to 3D print</a></li>
                        <li><a class="dropdown-item" href="{{ url('/faq') }}">FAQ</a></li>
                        <li><a class="dropdown-item"  href="{{ url('/photolibrary') }}">Photo Library</a></li>
                    </ul>
                </li>

                {{--Each role has separate red button except for Lead Demonstrator and admin--}}
                @hasrole('OnlineJobsManager')
                    <li class="item"><a class="btn btn-danger no-dropdown" role="button" href={{ url('/OnlineJobs/index') }}>Online Jobs</a></li>
                @endhasrole
                {{--Ø--}}
                @hasrole('Coordinator')
                    <li class="item"><a class="btn btn-danger no-dropdown" role="button" href={{ url('/costCodes/index') }}>Cost Codes</a></li>
                @endhasrole
                @hasrole('Demonstrator')
                    <li class="item"><a class="btn btn-danger no-dropdown" role="button" href={{ url('/printingData/index') }}>Pending Jobs</a></li>
                @endhasrole
                @hasrole('LeadDemonstrator')
                    <li class="item"><a class="btn btn-danger no-dropdown" role="button" href={{ url('/rota') }}>Rota</a></li>
                @endhasrole

                <li class="item">
                    <span>
                         {{Auth::user()->name}}
                        <span class="caret"></span></span>
                    <ul class="dropdown-bl dropdown-role">
                        @isset(Auth::user()->staff)
                            <li><a href="/members/{{Auth::user()->staff->id}}">View record</a></li>
                        @endisset
                        <li><a class="dropdown-item" href="{{ url('/roles') }}">Manage account</a></li>
                        @isset(Auth::user()->staff)
                            <li><a class="dropdown-ite"  href="/rota/availability">Update Availability</a></li>
                        @endisset
                        @isset(Auth::user()->staff)
                            <li><a class="dropdown-ite"  href="/myprints">Manage your prints</a></li>
                        @endisset
                        <li><a class="dropdown-item" href={{ route('auth.logout') }}><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    </ul>
                </li>
            </ul>
        @else
           {{--Menu view for unregistered user--}}
            <ul class="lsn bl-menu" id="my-menu">
                
                {{--Welcome page--}}
                <li class="item"><a class="no-dropdown" href="{{ url('/') }}">Home</a></li>
                {{--Request printing in the workshop and online--}}
                <li class="item">
                    <span>
                        Get Started
                        <span class="caret"></span></span>
                    <ul class="dropdown-bl">
                        <li><a class="dropdown-ite" href="{{ url('/printingData/create') }}">Request to Print in the Workshop</a></li>
                        <li><a class="dropdown-ite"  href="{{ url('/OnlineJobs/create') }}">Order a Print Online</a></li>
                        {{--Request a loan--}}
                        {{--<li class="item"><a class="no-dropdown" href="{{ url('/loan') }}">Request a loan</a></li>--}}
                        {{--<li><a class="dropdown-ite"  href="{{ url('/myprints') }}">Manage your requests</a></li>--}}
                    </ul>
                </li>
                
                {{--Page with the information about how to print--}}
                <li class="item"><a class="no-dropdown" href="{{ url('/learn') }}">Learn to 3D print</a></li>
                {{--Other workshop-connected information--}}
                <li class="item">
                    <span>
                        About
                        <span class="caret"></span></span>
                    <ul class="dropdown-bl">
                        <li><a class="dropdown-item" href="{{ url('/aboutWorkshop') }}">About workshop</a></li>
                        <li><a class="dropdown-item" href="{{ url('/members/index') }}">Our Team</a></li>
                        {{--<li><a class="dropdown-item" href="{{ url('/news') }}">Workshop History</a></li>--}}
                        <li><a class="dropdown-item" href="{{ url('/faq') }}">FAQ</a></li>
                        <li><a class="dropdown-ite"  href="{{ url('/photolibrary') }}">Photo Library</a></li>
                    </ul>
                </li>
                {{--Order print in the workshop--}}
                {{--Show this button only on Wednesdays--}}
                @if (Carbon\Carbon::now('Europe/London')->dayOfWeek === 3)
                <li class="item"><a class="btn btn-danger no-dropdown" role="button" href="{{ url('/printingData/create') }}">Request workshop job!</a></li>
                @else
                {{--Order print online--}}
                <li class="item"><a class="btn btn-danger no-dropdown" role="button" href="{{ url('/OnlineJobs/create') }}">Request online job!</a></li>
                @endif


                <li class="item">
                    <span>
                    <span class="glyphicon glyphicon-lock"></span>
                    <span class="caret"></span></span>
                    <ul class="dropdown-bl dropdown-login" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ route('auth.register') }}"><span class="glyphicon glyphicon-user"></span> Register</a></li>
                        <li><a class="dropdown-item" href="{{ route('auth.login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                        {{--<li><a class="dropdown-item" href="https://webauth.pprd.soton.ac.uk/idp/profile/SAML2/Redirect/SSO"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>--}}
                    </ul>
                </li>
            </ul>
        @endif
        
        <div id="toggle-menu" for="hmt" class="hamburger hamburger--slider btn-menu">
            <div class="hamburger-box"> "{{ route('auth.logout') }}">
                <div class="hamburger-inner"></div>
            </div>
        </div>
    </div>
</header>
