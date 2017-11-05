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
                <div class="col-sm-3">
                    <div class="list-group demonstrator">
                        @foreach($members as $member)
                                <a href="/members/{{$member->id}}" class="list-group-item it-manager">
                                    {{$member->first_name}} {{$member->last_name}}</a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
@endsection
