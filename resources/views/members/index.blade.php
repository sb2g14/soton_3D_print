@extends('layouts.layout')
@section('content')
    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
            {{ $flash }}
        </div>
    @endif

        <div class="text-center m-b-md">
        <div class="title">Our team</div>
            @can('staff_manage')
                <a href="{{ url('/members') }}" type="button" class="btn btn-success">
                    Add new member
                </a>
                <a href="{{ url('/members/former/show') }}" type="button" class="btn btn-primary">
                    View former members
                </a>
            @endcan
        </div>

        <div class="container">
            @php
                $memberlist = [];
                $memberlist[] = array( "body"=>"Coordinators");
                foreach($members as $member){
                    if($member->role == 'Coordinator'){
                        $memberlist[] = $member;
                    }
                }
                foreach($members as $member){
                    if($member->role == 'Co-Coordinator'){
                        $memberlist[] = $member;
                    }
                }
                $memberlist[] = array( "body"=>"Managers");
                foreach($members as $member){
                    if($member->role == 'Technician' || $member->role == 'PR Manager' || $member->role == 'Technical Manager'){
                        $memberlist[] = $member;
                    }
                }
                $memberlist[] = array( "body"=>"Demonstrators");
                foreach($members as $member){
                    if($member->role == 'Lead Demonstrator'){
                        $memberlist[] = $member;
                    }
                }
                foreach($members as $member){
                    if($member->role == 'Demonstrator'){
                        $memberlist[] = $member;
                    }
                }
                $memberlist[] = array( "body"=>"Online Managers");
                foreach($members as $member){
                    if($member->role == '3D Hub Manager'){
                        $memberlist[] = $member;
                    }
                }
                $memberlist[] = array( "body"=>"IT Support");
                foreach($members as $member){
                    if($member->role == 'IT Manager'){
                        $memberlist[] = $member;
                    }
                }
                foreach($members as $member){
                    if($member->role == 'IT' && $member->last_name != "System"){
                        $memberlist[] = $member;
                    }
                }
                $maxindex = sizeof($memberlist);
                $blocksize = (int)(sizeof($memberlist)/4+0.99);
            @endphp
            <div class="row">
                @for($c=0;$c<4;$c++)
                <div class="col-sm-3">
                    <div class="list-group demonstrator">
                        @for($i=(int)($c*$blocksize);$i<min((int)(($c+1)*$blocksize),$maxindex);$i++)
                            @php
                                $member = $memberlist[$i];
                            @endphp
                            @if($member["body"])
                                <span class="list-group-item role-header">{{$member["body"]}}</span>
                            @else
                                <a href="/members/{{$member->id}}" alt="{{$member->role}}" class="list-group-item role-{{str_replace(' ','-',strtolower($member->role))}}">
                                    {{$member->first_name}} {{$member->last_name}}
                                </a>
                            @endif
                        @endfor
                    </div>
                </div>
                @endfor 
            </div>
            {{--
            <div class="row">
                <div class="col-sm-3">
                    <h3>Coordinators</h3>
                    <div class="list-group demonstrator">
                        @foreach($members as $member)
                            @if($member->role == 'Coordinator')
                                <a href="/members/{{$member->id}}" class="list-group-item coordinator">
                                    {{$member->first_name}} {{$member->last_name}}</a>
                            @endif
                        @endforeach
                        @foreach($members as $member)
                            @if($member->role == 'Co-Coordinator')
                                <a href="/members/{{$member->id}}" class="list-group-item coordinator">
                                    {{$member->first_name}} {{$member->last_name}}</a>
                            @endif
                        @endforeach
                    </div>
                    <h3>Managers</h3>
                    <div class="list-group demonstrator">
                        @foreach($members as $member)
                            @if($member->role == 'Technician' || $member->role == 'PR Manager' || $member->role == 'Technical Manager')
                                <a href="/members/{{$member->id}}" class="list-group-item coordinator">
                                    {{$member->first_name}} {{$member->last_name}}</a>

                            @endif
                        @endforeach
                    </div>
                    <h3>Lead Demonstrators</h3>
                    <div class="list-group demonstrator">
                        @foreach($members as $member)
                            @if($member->role == 'Lead Demonstrator')
                                <a href="/members/{{$member->id}}" class="list-group-item demonstrator-lead">
                                    {{$member->first_name}} {{$member->last_name}}</a>

                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-3">
                    <h3>IT Support</h3>
                    <div class="list-group demonstrator">
                        @foreach($members as $member)
                            @if($member->role == 'IT Manager')
                                <a href="/members/{{$member->id}}" class="list-group-item it-manager">
                                    {{$member->first_name}} {{$member->last_name}}</a>

                            @endif
                        @endforeach
                        @foreach($members as $member)
                            @if($member->role == 'IT')
                                <a href="/members/{{$member->id}}" class="list-group-item it-manager">
                                    {{$member->first_name}} {{$member->last_name}}</a>

                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-3">
                    <h3>Online request managers</h3>
                    <div class="list-group demonstrator">
                        @foreach($members as $member)
                            @if($member->role == '3D Hub Manager')
                                <a href="/members/{{$member->id}}" class="list-group-item hub-manager">
                                    {{$member->first_name}} {{$member->last_name}}</a>
                            @endif
                        @endforeach
                    </div>    
                </div>
                <div class="col-sm-3">
                    <h3>Demonstrators</h3>
                    <div class="list-group demonstrator">
                        @foreach($members as $member)
                            @if($member->role == 'Demonstrator' || $member->role == 'New Demonstrator')
                                <a href="/members/{{$member->id}}" class="list-group-item demonstrator-norm">
                                    {{$member->first_name}} {{$member->last_name}}</a>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>--}}
        </div>
@endsection
