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
                    <div class="list-group">
                        @foreach($members as $member)
                            @if($member->role == 'Lead Demonstrator')
                                <a href="/members/{{$member->id}}" class="list-group-item" style="background-color: #C8E6C9">
                                    {{$member->first_name}} {{$member->last_name}}</a>
                            @endif
                        @endforeach
                    </div>
                    <h3>Demonstrators</h3>
                    <div class="list-group">
                        @foreach($members as $member)
                            @if($member->role == 'Demonstrator' || $member->role == 'unknown')
                                <a href="/members/{{$member->id}}" class="list-group-item" style="background-color: #BBDEFB">
                                    {{$member->first_name}} {{$member->last_name}}</a>

                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-3">
                    <h3>IT Support</h3>
                    <div class="list-group">
                        @foreach($members as $member)
                            @if($member->role == 'IT' || $member->role == 'IT Manager')
                                <a href="/members/{{$member->id}}" class="list-group-item" style="background-color: #C5CAE9">
                                    {{$member->first_name}} {{$member->last_name}}</a>

                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-3">
                    <h3>Online request managers</h3>
                    <div class="list-group">
                        @foreach($members as $member)
                            @if($member->role == '3D Hub Manager')
                                <a href="/members/{{$member->id}}" class="list-group-item" style="background-color: #FFE0B2">
                                    {{$member->first_name}} {{$member->last_name}}</a>
                            @endif
                        @endforeach
                    </div>    
                </div>
                <div class="col-sm-3">
                    <h3>Coordinators</h3>
                    <div class="list-group">
                        @foreach($members as $member)
                            @if($member->role == 'Coordinator' || $member->role == 'Co-coordinator')
                                <a href="/members/{{$member->id}}" class="list-group-item" style="background-color: #FFCDD2">
                                    {{$member->first_name}} {{$member->last_name}}</a>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
           
           <!-- <div class="row">
               <div class="col-xs-2 col-sm-4"></div>
               <div class="col-xs-8 col-sm-4">
                   <div class="list-group">
                       {{--@foreach($members as $member)
           
                           <a href="/members/{{$member->id}}" class="list-group-item">
                               {{$member->first_name}} {{$member->last_name}}: <b>{{ $member->role }}</b><br></a>
                       @endforeach--}}
                   </div>
               </div>
               <div class="col-xs-2 col-sm-4"></div>
           </div> -->
        </div>
@endsection
