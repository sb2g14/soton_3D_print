<header class="p-header">
    <div class="ctr">
        <div class="branding">
            <a href="{{ url('/') }}">
                <img class="logo_mob" src="/Images/uos-brand1.png" alt="3Dprinting">
            </a>
        </div>
        @php
            $workshopIsOpen = App\Http\Controllers\Traits\WorkshopTrait::isOpen();
        @endphp
        @if (Auth::check() && !Auth::user()->isCustomer())
            <ul class="lsn bl-menu" id="my-menu">

                
                {{--Leading to welcome page--}}
                <li class="item"><a class="no-dropdown" href="{{ url('/') }}">Home</a></li>
                {{--Pages connected with printers--}}
                <li class="item">
                    <span>
                        3D printers
                        <span class="caret"></span></span>
                    <ul class="dropdown-bl">
                        <li><a class="dropdown-item" href="{{ url('/printers') }}">View printers</a></li>
                        @can('issues_manage')
                            <li><a class="dropdown-item" href="{{ url('/issues') }}">Pending issues</a></li>
                            <li><a class="dropdown-item" href="{{ url('/issues/select') }}">Log an issue</a></li>
                        @endcan
                    </ul>
                </li>
                {{--Manage finance--}}
                @can('manage_cost_codes')
                <li class="item">
                    <span>
                        Finance
                        <span class="caret"></span>
                    </span>
                    <ul class="dropdown-bl">
                        <li><a class="dropdown-item" href="{{ url('/finance') }}">Overview</a></li>
                        <li><a class="dropdown-item" href="{{ url('/finance/jobs') }}">Review Jobs</a></li>
                        <li><a class="dropdown-item" href="{{ url('/costCodes') }}">Cost codes</a></li>
                    </ul>
                </li>
                @endcan
                {{--Printing in the workshop and online--}}
                <li class="item">
                    <span>
                        Printing
                        <span class="caret"></span></span>
                    <ul class="dropdown-bl">
                        <li><a class="dropdown-item"  href="{{ url('/WorkshopJobs/requests') }}">Manage Workshop Jobs</a></li>
                        <li>
                            <a class="dropdown-item" 
                                href="{{ url('/WorkshopJobs/create') }}">Request to Print in the Workshop</a>
                        </li>
                        @can('manage_online_jobs')
                            <li><a class="dropdown-item" href="{{ url('/OnlineJobs/requests') }}">Manage Online Jobs</a></li>
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
                        <li><a class="dropdown-item" href="{{ url('/about') }}">About the Service</a></li>
                        <li><a class="dropdown-item" href="{{ url('/history') }}">Service History</a></li>
                        <li><a class="dropdown-item" href="{{ url('/learn') }}">Learn to 3D print</a></li>
                        <li><a class="dropdown-item" href="{{ url('/faq') }}">FAQ</a></li>
                        <li><a class="dropdown-item"  href="{{ url('/gallery') }}">Photo Gallery</a></li>
                    </ul>
                </li>

                {{--Each role has separate red button except for admin--}} 
                @hasrole('Coordinator')
                    {{--Manage Finance--}}
                    <li class="item">
                        <a class="btn btn-danger no-dropdown" role="button" href={{ url('/finance') }}>Review Finance</a>
                    </li>
                @endhasrole 
                @hasrole('LeadDemonstrator')
                    @if ($workshopIsOpen)
                        {{--Manage Workshop Jobs--}}
                        <li class="item">
                            <a class="btn btn-danger no-dropdown" role="button" 
                                href="{{ url('/WorkshopJobs/requests') }}">Pending Jobs</a>
                        </li>
                    @else
                        {{--Manage Rota--}}
                        <li class="item">
                            <a class="btn btn-danger no-dropdown" role="button" 
                                href="{{ url('/rota') }}">Rota</a>
                        </li>
                    @endif
                @endhasrole
                @hasrole('Demonstrator') 
                    @if ($workshopIsOpen)
                        {{--Manage Workshop Jobs--}}
                        <li class="item">
                            <a class="btn btn-danger no-dropdown" role="button" 
                                href="{{ url('/WorkshopJobs/requests') }}">Pending Jobs</a>
                        </li>
                    @else
                        {{--Manage Availability--}}
                        <li class="item">
                            <a class="btn btn-danger no-dropdown" role="button" 
                                href="{{ url('/rota/availability') }}">Indicate Availability</a>
                        </li>
                    @endif
                @endhasrole
                @hasrole('OnlineJobsManager')
                    {{--Manage Online Jobs--}}
                    <li class="item">
                        <a class="btn btn-danger no-dropdown" role="button" href={{ url('/OnlineJobs/requests') }}>Online Jobs</a>
                    </li>
                @endhasrole

                <li class="item">
                    <span>
                         {{Auth::user()->name()}}
                        <span class="caret"></span>
                    </span>
                    <ul class="dropdown-bl dropdown-role">
                        @isset(Auth::user()->staff)
                            <li>
                                <a href="/members/{{Auth::user()->staff->id}}">
                                    View record
                                </a>
                            </li>
                        @endisset
                        @can('users_manage')
                            <li>
                                <a class="dropdown-item" href="{{ url('/roles') }}">
                                    Manage Permissions
                                </a>
                            </li>
                        @endcan
                        @isset(Auth::user()->staff)
                            <li>
                                <a class="dropdown-ite" href="/rota/availability">
                                    Update Availability
                                </a>
                            </li>
                        @endisset
                        <li>
                            <a class="dropdown-ite" href="/myprints">
                                Manage your prints
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" 
                                href="{{ route('auth.logout') }}">
                                <span class="fa fa-fw fa-sign-out"></span> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        @else
           {{--Menu view for customer--}}
            <ul class="lsn bl-menu" id="my-menu">
                
                {{--Welcome page--}}
                <li class="item"><a class="no-dropdown" href="{{ url('/') }}">Home</a></li>
                {{--Request printing in the workshop and online--}}
                @if (Auth::check())
                    <li class="item">
                        <span>
                            Get Started
                            <span class="caret"></span>
                        </span>
                        <ul class="dropdown-bl">
                            <li><a class="dropdown-ite" href="{{ url('/WorkshopJobs/create') }}">Request to Print in the Workshop</a></li>
                            <li><a class="dropdown-ite"  href="{{ url('/OnlineJobs/create') }}">Order a Print Online</a></li>
                            {{--Request a loan--}}
                            {{--<li class="item"><a class="no-dropdown" href="{{ url('/loan') }}">Request a loan</a></li>--}}
                            {{--<li><a class="dropdown-ite"  href="{{ url('/myprints') }}">Manage your requests</a></li>--}}
                        </ul>
                    </li>
                @endif
                {{--Page with the information about how to print--}}
                <li class="item"><a class="no-dropdown" href="{{ url('/learn') }}">Learn to 3D print</a></li>
                {{--Other workshop-connected information--}}
                <li class="item">
                    <span>
                        About
                        <span class="caret"></span></span>
                    <ul class="dropdown-bl">
                        <li><a class="dropdown-item" href="{{ url('/about') }}">About the Service</a></li>
                        <li><a class="dropdown-item" href="{{ url('/members/index') }}">Our Team</a></li>
                        {{--<li><a class="dropdown-item" href="{{ url('/history') }}">Service History</a></li>--}}
                        <li><a class="dropdown-item" href="{{ url('/faq') }}">FAQ</a></li>
                        <li><a class="dropdown-ite"  href="{{ url('/gallery') }}">Photo Gallery</a></li>
                    </ul>
                </li>
                
                @if(Auth::check())
                    {{--Show this button only when workshop is open--}}
                    @if ($workshopIsOpen)
                        {{--Order print in the workshop--}}
                        <li class="item">
                            <a class="btn btn-danger no-dropdown" role="button" 
                                href="{{ url('/WorkshopJobs/create') }}">Request workshop job!</a>
                        </li>
                    @else
                        {{--Order print online--}}
                        <li class="item">
                            <a class="btn btn-danger no-dropdown" role="button" 
                                href="{{ url('/OnlineJobs/create') }}">Request online job!</a>
                        </li>
                    @endif
                @else
                    {{--Log In--}}
                    <li class="item">
                        <a class="btn btn-danger no-dropdown" role="button" href="{{ route('auth.login') }}">Login</a>
                    </li>
                @endif 

                @if(!Auth::check())
                    {{--<li class="item">
                        <span>
                        <span class="fa fa-lock"></span>
                        <span class="caret"></span></span>
                        <ul class="dropdown-bl dropdown-login" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('auth.register') }}"><span class="fa fa-fw fa-user-plus"></span> Register</a></li>
                            <li><a class="dropdown-item" href="{{ route('auth.login') }}"><span class="fa fa-fw fa-sign-in"></span> Login</a></li>
                        </ul>
                    </li>--}}
                @else
                    <li class="item">
                        <span>
                             {{Auth::user()->name()}}
                            <span class="caret"></span>
                        </span>
                        <ul class="dropdown-bl dropdown-login"> {{--dropdown-role--}}
                            <li><a class="dropdown-ite"  href="/myprints">Manage your prints</a></li>
                            <li><a class="dropdown-item" href={{ route('auth.logout') }}><span class="fa fa-sign-out"></span> Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        @endif
        
        <div id="toggle-menu" for="hmt" class="hamburger hamburger--slider btn-menu">
            <div class="hamburger-box"> {{--"{{ route('auth.logout') }}">--}}
                <div class="hamburger-inner"></div>
            </div>
        </div>
    </div>
</header>
