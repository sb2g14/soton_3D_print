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
                <div class="col-xs-2 col-sm-4"></div>
                <div class="col-xs-8 col-sm-4">
                    <div class="list-group">
                        {{--<a href="/members/create" class="list-group-item"> Add member <br></a>--}}
                        @foreach($members as $member)
                            <a href="/members/{{$member->id}}" class="list-group-item">
                                {{$member->first_name}} {{$member->last_name}}: <b>{{ $member->role }}</b><br></a>
                        @endforeach
                    </div>
                </div>
                <div class="col-xs-2 col-sm-4"></div>
            </div>
        </div>
@endsection
