<header class="p-header">
    <div class="ctr">
        <div class="branding">
            <a href="{{ url('/') }}">
                <img class="logo_mob" src="/Images/uos-brand1.png" alt="3Dprinting">
            </a>
        </div>
       @if (Auth::check())
            <ul class="lsn bl-menu" id="my-menu">

                <li class="item">
                    <span>
                        Welcome
			{{--  <br>  {{Auth::user()->name}}! --}}
                        <span class="caret"></span></span>
                    <ul class="dropdown-bl">
                        @isset(Auth::user()->staff)
                        <li><a href="/members/{{Auth::user()->staff->id}}">View record</a></li>
                        @endisset
                        <li><a class="dropdown-item" href="{{ url('/roles') }}">Manage account</a></li>
                    </ul>
                </li>
                <li class="item"><a class="no-dropdown" href="{{ url('/') }}">Home</a></li>
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
                <li class="item">
                    <span>
                        Workshop
                        <span class="caret"></span></span>
                    <ul class="dropdown-bl">
                        <li><a class="dropdown-item" href="{{ url('/aboutWorkshop') }}">About workshop</a></li>
                        <li><a class="dropdown-item" href="{{ url('/orderOnline') }}">Order online</a></li>
                        <li><a class="dropdown-item" href="{{ url('/news') }}">News</a></li>
                        <li><a class="dropdown-item" href={{ url('/printingData/create') }}>Request a job</a></li>
                        <li><a class="dropdown-item" href="{{ url('/loan') }}">Request a loan</a></li>
                        <li><a class="dropdown-item" href="{{ url('/learn') }}">Learn to 3D print</a></li>
                        <li><a class="dropdown-ite"  href="{{ url('/printingData/index') }}">Pending Jobs</a></li>
                        <li><a class="dropdown-ite"  href="{{ url('/photolibrary') }}">Photo Library</a></li>
                    </ul>
                </li>
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
                <li class="item">
                    <span>
                        Staff
                        <span class="caret"></span></span>
                    <ul class="dropdown-bl">
                        <li><a class="dropdown-item" href="{{ url('/members/index') }}">Our team</a></li>
                        <li><a class="dropdown-item" href="{{ url('/documents') }}">For demonstrators</a></li>
                        <li><a class="dropdown-item" href="{{ url('/gettingPaid') }}">Getting paid</a></li>
                    </ul>
                </li>


                @can('receive_online_job_requests')
                    <li class="item"><a class="btn btn-lg no-dropdown" role="button" href={{ url('/OnlineJobs/index') }}>Online Jobs</a></li>
                @elsecan('jobs_manage')
                    <li class="item"><a class="btn btn-lg no-dropdown" role="button" href={{ url('/printingData/index') }}>Pending Jobs</a></li>
                @endcan


                <li class="item"><a class="no-dropdown" href={{ route('auth.logout') }}><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
        @else
            <ul class="lsn bl-menu" id="my-menu">
                <li class="item"><a class="btn btn-lg no-dropdown" role="button" href="{{ url('/printingData/create') }}">Request a job!</a></li>
                <li class="item"><a class="no-dropdown" href="{{ url('/') }}">Home</a></li>
                <li class="item"><a class="no-dropdown" href="{{ url('/aboutWorkshop') }}">About workshop</a></li>
                <li class="item"><a class="no-dropdown" href="{{ url('/orderOnline') }}">Order online</a></li>
                <li class="item"><a class="no-dropdown" href="{{ url('/news') }}">News</a></li>
                <li class="item"><a class="no-dropdown" href="{{ url('/loan') }}">Request a loan</a></li>
                <li class="item"><a class="no-dropdown" href="{{ url('/learn') }}">Learn to 3D print</a></li>
                <li class="item">
                    <span>
                    <span class="glyphicon glyphicon-lock"></span>
                    <span class="caret"></span></span>
                    <ul class="dropdown-bl dropdown-login" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ route('auth.register') }}"><span class="glyphicon glyphicon-user"></span> Register</a></li>
                        <li><a class="dropdown-item" href="{{ route('auth.login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
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
