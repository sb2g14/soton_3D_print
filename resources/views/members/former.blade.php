@extends('layouts.layout')
@section('content')
    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
            {{ $flash }}
        </div>
    @endif

        <div class="text-center m-b-md">
        <div class="title">Former Members</div>
        </div>

        <div class="container">
            @can('staff_manage')
                <a href="{{ url('/members') }}" type="button" class="btn pull-right btn-success">
                    Add new member
                </a>
                <a href="{{ url('/members/index') }}" type="button" class="btn pull-left btn-primary">
                    View current members
                </a><br/>
            <hr>
            @endcan
        </div>
        <div class="container">
            @php
                $memberlist = [];
                foreach($members as $member){
                    $memberlist[] = $member;
                }
                $maxindex = sizeof($memberlist);
                $blocksize = (int)($maxindex/4+0.99);
            @endphp
            <div class="row">
                @for($c=0;$c<4;$c++)
                <div class="col-sm-3">
                    <div class="list-group demonstrator">
                        @for($i=(int)($c*$blocksize);$i<min((int)(($c+1)*$blocksize),$maxindex);$i++)
                            @php
                                $member = $memberlist[$i];
                            @endphp
                            <a href="/members/{{$member->id}}" alt="{{$member->role}}" class="list-group-item role-{{str_replace(' ','-',strtolower($member->role))}}">
                                {{$member->first_name}} {{$member->last_name}}
                            </a>
                        @endfor
                    </div>
                </div>
                @endfor 
            </div>
        </div>
@endsection
