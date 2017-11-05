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

            <div class="row">
                <div class="col-xs-2 col-sm-4"></div>
                <div class="col-xs-8 col-sm-4">
                    <div class="list-group">
                            @foreach($members as $member)
                            <a href="/members/{{$member->id}}" class="list-group-item">
                                {{$member->first_name}} {{$member->last_name}} </a>
                            @endforeach
                    </div>
                </div>
                <div class="col-xs-2 col-sm-4"></div>

            </div>
        </div>
@endsection
