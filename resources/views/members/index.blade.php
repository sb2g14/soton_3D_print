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
                <a href="{{ url('/members') }}" type="button" class="btn btn-lg btn-info">
                    Add new member
                </a>
            @endcan
        </div>

        <div class="container">

            <div class="row">
                <div class="col-sm-3">
                    <h3>Lead Demonstrators</h3>
                    <div class="list-group demonstrator">
                        @foreach($members as $member)
                            @if($member->role == 'Lead Demonstrator')
                                <a href="/members/{{$member->id}}" class="list-group-item demonstrator-lead">
                                    {{$member->first_name}} {{$member->last_name}}</a>
                            @endif
                        @endforeach
                    </div>
                    <h3>Demonstrators</h3>
                    <div class="list-group demonstrator">
                        @foreach($members as $member)
                            @if($member->role == 'Demonstrator' || $member->role == 'unknown')
                                <a href="/members/{{$member->id}}" class="list-group-item demonstrator-norm">
                                    {{$member->first_name}} {{$member->last_name}}</a>

                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-3">
                    <h3>IT Support</h3>
                    <div class="list-group demonstrator">
                        @foreach($members as $member)
                            @if($member->role == 'IT' || $member->role == 'IT Manager')
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
                    <h3>Coordinators</h3>
                    <div class="list-group demonstrator">
                        @foreach($members as $member)
                            @if($member->role == 'Coordinator' || $member->role == 'Co-coordinator')
                                <a href="/members/{{$member->id}}" class="list-group-item coordinator">
                                    {{$member->first_name}} {{$member->last_name}}</a>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
@endsection
