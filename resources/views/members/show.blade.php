@extends('layouts.layout')

@section('content')
    <h2 style="margin-bottom: 20px; font-weight: 600;">
        {{ $member -> first_name }} {{ $member -> last_name }}<br/>
    </h2>

    <div class="container">
        <div class="row">
            <div class="col-xs-2 col-sm-1"></div>

            <div class="col-xs-8 col-sm-10 well">
                <div class="row">
                <div class="col-xs-8 col-sm-4 text-left">
                    <p><span class="fa fa-fw fa-user"></span> {{$member -> role}}</p>
                    @hasanyrole('LeadDemonstrator|Demonstrator|administrator|Coordinator|Technician')
                        <p><span class="fa fa-fw fa-phone"></span> {{$member -> phone}}</p>
                    @endhasanyrole
                    <p><span class="fa fa-fw fa-envelope"></span> {{$member -> email}}</p> 
                
                </div>
                
                @if(strtolower(Auth::user()->email) == strtolower($member->email) || Auth::user()->can('staff_manage'))
                <div class="col-xs-8 col-sm-4 text-left">
                    <p><span class="fa fa-fw fa-id-card"></span> ID: {{$member -> student_id}}</p>
                    @if($member->CWP_date)
                        <p><span class="fa fa-fw fa-check-square"></span> Allowed to Work since {{ Carbon\Carbon::parse($member->CWP_date)->format('d/m/Y') }}</p>
                    @else
                        <p><span class="fa fa-fw fa-square"></span> Has not shown the CWP to Andrew Hamilton. </p>
                    @endif
                    @if($member->SMT_date)
                        <p><span class="fa fa-fw fa-check-square"></span> Specific module training attended on {{ Carbon\Carbon::parse($member->SMT_date)->format('d/m/Y') }}</p>
                    @else
                        <p><span class="fa fa-fw fa-square"></span> Has not attended the latest website training. </p>
                    @endif
                    @if($member->LWI_date)
                        <p><span class="fa fa-fw fa-check-square"></span> Workshop induction attended on {{ Carbon\Carbon::parse($member->LWI_date)->format('d/m/Y') }}</p>
                    @else
                        <p><span class="fa fa-fw fa-square"></span> Has not attended the latest workshop induction. </p>
                    @endif  
                </div> 
                @endif
                
                @if(strtolower(Auth::user()->email) == strtolower($member->email) || Auth::user()->can('staff_view_stats'))
                <div class="col-xs-8 col-sm-4 text-left">
                    <p><span class="fa fa-fw fa-bullhorn"></span> Activity in demonstration<br/>
                     Sessions attended: {{$member->experience()}} <br/>
                     (last demonstrated on {{ Carbon\Carbon::parse($member->lastSession())->format('d/m/Y') }})<br/>
                     Prints approved: {{$stats["prints_approved"]}}<br/>
                     Prints completed: {{$stats["prints_completed"]}}</p>
                    <p><span class="fa fa-fw fa-wrench"></span> Activity in maintainance<br/>
                    Issues raised: {{$stats["issues_raised"]}}<br/>
                    Issues solved: {{$stats["issues_closed"]}}</p>
                </div>
                @endif
                </div>
                <div class="col-xs-8 col-sm-12 text-center">
                <hr>
                @if(strtolower(Auth::user()->email) == strtolower($member->email) || Auth::user()->can('staff_manage'))
                    <a href="/members/edit/{{$member->id}}"  class="btn btn-info" style="margin: 20px 0px;">
                        Update Record
                    </a>
                    <a href="/members/delete/{{$member->id}}"  class="btn btn-danger" style="margin: 20px 0px;">
                        Delete Record
                    </a>
                @endif
                <a href="/members/index" class="btn btn-primary" style="margin: 20px 0px;">
                    View All
                </a>
                </div>
            </div>
            
            <div class="col-xs-2 col-sm-1"></div>
        </div>
    </div>
@endsection
