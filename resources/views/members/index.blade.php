@extends('layouts.layout')
@section('content')
    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
            {{ $flash }}
        </div>
    @endif

        <div class="text-center m-b-md">
        <div class="title">Our team</div>
            
        </div>

        <div class="container">
            @can('staff_manage')
                <a href="{{ url('/members') }}" type="button" class="btn pull-right btn-success">
                    Add new member
                </a>
                <a href="{{ url('/members/former/show') }}" type="button" class="btn pull-left btn-primary">
                    View former members
                </a><br/>
            <hr>
            @endcan
        </div>
        <div class="container">
            {{--@php--}}
                {{--$memberlist = [];--}}
                {{--$memberlist[] = array( "body"=>"Coordinators", "class"=>"role-header");--}}
                {{--foreach($members as $member){--}}
                    {{--if($member->role == 'Coordinator'){--}}
                        {{--$memberlist[] = $member;--}}
                    {{--}--}}
                {{--}--}}
                {{--foreach($members as $member){--}}
                    {{--if($member->role == 'Co-Coordinator'){--}}
                        {{--$memberlist[] = $member;--}}
                    {{--}--}}
                {{--}--}}
                {{--$memberlist[] = array( "body"=>"Managers", "class"=>"role-header-managers");--}}
                {{--foreach($members as $member){--}}
                    {{--if($member->role == 'Technician' || $member->role == 'PR Manager' || $member->role == 'Technical Manager'){--}}
                        {{--$memberlist[] = $member;--}}
                    {{--}--}}
                {{--}--}}
                {{--$memberlist[] = array( "body"=>"Demonstrators", "class"=>"role-header-demonstrator");--}}
                {{--foreach($members as $member){--}}
                    {{--if($member->role == 'Lead Demonstrator'){--}}
                        {{--$memberlist[] = $member;--}}
                    {{--}--}}
                {{--}--}}
                {{--foreach($members as $member){--}}
                    {{--if($member->role == 'Demonstrator'){--}}
                        {{--$memberlist[] = $member;--}}
                    {{--}--}}
                {{--}--}}
                {{--$memberlist[] = array( "body"=>"Online Managers" , "class"=>"role-header-online");--}}
                {{--foreach($members as $member){--}}
                    {{--if($member->role == '3D Hub Manager'){--}}
                        {{--$memberlist[] = $member;--}}
                    {{--}--}}
                {{--}--}}
                {{--$memberlist[] = array( "body"=>"IT Support" , "class"=>"role-header-it");--}}
                {{--foreach($members as $member){--}}
                    {{--if($member->role == 'IT Manager'){--}}
                        {{--$memberlist[] = $member;--}}
                    {{--}--}}
                {{--}--}}
                {{--foreach($members as $member){--}}
                    {{--if($member->role == 'IT' && $member->last_name != "System"){--}}
                        {{--$memberlist[] = $member;--}}
                    {{--}--}}
                {{--}--}}
                {{--$maxindex = sizeof($memberlist);--}}
                {{--$blocksize = (int)(sizeof($memberlist)/4+0.99);--}}
            {{--@endphp--}}
            {{--<div class="row">--}}
                {{--@for($c=0;$c<4;$c++)--}}
                {{--<div class="col-sm-3">--}}
                    {{--<div class="list-group demonstrator">--}}
                        {{--@for($i=(int)($c*$blocksize);$i<min((int)(($c+1)*$blocksize),$maxindex);$i++)--}}
                            {{--@php--}}
                                {{--$member = $memberlist[$i];--}}
                            {{--@endphp--}}
                            {{--@if($member["body"])--}}
                                {{--<span class="list-group-item {{$member['class']}}">{{$member["body"]}}</span>--}}
                            {{--@else--}}
                                {{--<a href="/members/{{$member->id}}" alt="{{$member->role}}" class="list-group-item role-{{str_replace(' ','-',strtolower($member->role))}}">--}}
                                    {{--{{$member->first_name}} {{$member->last_name}}--}}
                                {{--</a>--}}
                            {{--@endif--}}
                        {{--@endfor--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--@endfor--}}
            {{--</div>--}}

            <div class="row">
                <div class="col-sm-3">
                    <div class="list-group demonstrator">
                        <span class="list-group-item role-header">Coordinators</span>
                        @foreach($members as $member)
                            @if($member->role == 'Coordinator' || $member->role == 'Co-Coordinator')
                                <a href="/members/{{$member->id}}" class="list-group-item role-coordinator">
                                    {{$member->first_name}} {{$member->last_name}}</a>
                            @endif
                        @endforeach
                    </div>
                    <div class="list-group demonstrator">
                        <span class="list-group-item role-header-managers">Managers</span>
                        @foreach($members as $member)
                            @if($member->role == 'Technician' || $member->role == 'PR Manager' || $member->role == 'Technical Manager')
                                <a href="/members/{{$member->id}}" class="list-group-item role-coordinator">
                                    {{$member->first_name}} {{$member->last_name}}</a>

                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="list-group demonstrator">
                        <span class="list-group-item role-header-it">IT Support</span>
                        @foreach($members as $member)
                            @if($member->role == 'IT Manager' || $member->role == 'IT' && $member->last_name != "System")
                                <a href="/members/{{$member->id}}" class="list-group-item role-it">
                                    {{$member->first_name}} {{$member->last_name}}</a>

                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="list-group demonstrator">
                        <span class="list-group-item role-header-lead-demonstrators">Lead Demonstrators</span>
                        @foreach($members as $member)
                            @if($member->role == 'Lead Demonstrator')
                                <a href="/members/{{$member->id}}" class="list-group-item role-lead-demonstrator">
                                    {{$member->first_name}} {{$member->last_name}}</a>
                            @endif
                        @endforeach
                    </div>
                    <div class="list-group demonstrator">
                        <span class="list-group-item role-header-online">Online managers</span>
                        @foreach($members as $member)
                            @if($member->role == '3D Hub Manager')
                                <a href="/members/{{$member->id}}" class="list-group-item role-3d-hub-manager">
                                    {{$member->first_name}} {{$member->last_name}}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="list-group demonstrator">
                        <span class="list-group-item role-header-demonstrator">Demonstrators</span>
                        @foreach($members as $member)
                            @if($member->role == 'Demonstrator' || $member->role == 'New Demonstrator')
                                <a href="/members/{{$member->id}}" class="list-group-item role-demonstrator">
                                    {{$member->first_name}} {{$member->last_name}}</a>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
@endsection
