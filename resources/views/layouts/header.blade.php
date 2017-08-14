<header class="p-header">
    <div class="ctr">
        <div class="branding">
            <a href="{{ url('/') }}">
                <img class="logo_mob" src="/Images/uos-brand1.png" alt="3Dprinting">
            </a>
        </div>
       @if (Auth::check())
            <ul class="lsn bl-menu" id="my-menu">

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="navbarDropdownMenuLink"  aria-haspopup="true" aria-expanded="false">
                        Welcome {{Auth::user()->name}}!
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        @isset(Auth::user()->staff)
                        <li><a class="dropdown-item" href="/members/{{Auth::user()->staff->id}}">View Record</a></li>
                        @endisset
                        <li><a class="dropdown-item" href="{{ url('/roles') }}">Manage Account</a></li>
                    </ul>
                </li>
                <li class="home"><a class="no-dropdown" href="{{ url('/') }}">Home</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="navbarDropdownMenuLink"  aria-haspopup="true" aria-expanded="false">
                        Workshop
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ url('/aboutWorkshop') }}">About workshop</a></li>
                        <li><a class="dropdown-item" href="{{ url('/orderOnline') }}">Order online</a></li>
                        <li><a class="dropdown-item" href="{{ url('/news') }}">News</a></li>
                        <li><a class="dropdown-item" href={{ url('/printingData/create') }}>Request a job</a></li>
                        <li><a class="dropdown-item" href="{{ url('/loan') }}">Request a loan</a></li>
                        <li><a class="dropdown-item" href="{{ url('/learn') }}">Learn to 3D print</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="navbarDropdownMenuLink"  aria-haspopup="true" aria-expanded="false">
                        3D printers
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ url('/printers/index') }}">View printers</a></li>
                        @hasanyrole('LeadDemonstrator|Demonstrator|administrator')
                        <li><a class="dropdown-item" href="{{ url('/issues/index') }}">Pending issues</a></li>
                        <li><a class="dropdown-item" href="{{ url('/issues/select') }}">Log an issue</a></li>
                        @endhasanyrole
                    </ul>
                </li>
                <li><a class="no-dropdown" href="{{ url('/members/index') }}">Staff</a></li>
                @hasanyrole('LeadDemonstrator|Demonstrator|NewDemonstrator|administrator')
                <li><a class="btn btn-lg no-dropdown" role="button" href={{ url('/printingData/index') }}>Pending Jobs</a></li>
                @endhasanyrole
                <li><a class="no-dropdown" href={{ route('auth.logout') }}><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            @else
                <ul class="lsn bl-menu" id="my-menu">
                    <li><a class="btn btn-lg no-dropdown" role="button" href="{{ url('/printingData/create') }}">Request a job!</a></li>
                    <li class="home"><a class="no-dropdown" href="{{ url('/') }}">Home</a></li>
                    <li><a class="no-dropdown" href="{{ url('/aboutWorkshop') }}">About workshop</a></li>
                    <li><a class="no-dropdown" href="{{ url('/orderOnline') }}">Order online</a></li>
                    <li><a class="no-dropdown" href="{{ url('/news') }}">News</a></li>
                    <li><a class="no-dropdown" href="{{ url('/loan') }}">Request a loan</a></li>
                    <li><a class="no-dropdown" href="{{ url('/learn') }}">Learn to 3D print</a></li>
                    {{--<li><a href="{{ route('auth.register') }}"><span class="glyphicon glyphicon-user"></span> Register</a></li>--}}
                    {{--<li><a href="{{ route('auth.login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>--}}
                    <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="navbarDropdownMenuLink"  aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-lock"></span>
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-login" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ route('auth.register') }}"><span class="glyphicon glyphicon-user"></span> Register</a></li>
                        <li><a class="dropdown-item" href="{{ route('auth.login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    </ul>
                    </li>
            @endif
        </ul>
        <div id="toggle-menu" for="hmt" class="hamburger hamburger--slider btn-menu">
            <div class="hamburger-box""{{ route('auth.logout') }}">
                <div class="hamburger-inner"></div>
            </div>
        </div>
    </div>
</header>
