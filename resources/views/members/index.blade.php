@extends('layouts.layout')
@section('content')
    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -100px">
            {{ $flash }}
        </div>
    @endif
    {{--<div class="title m-b-md">--}}
        {{--About us--}}
    {{--</div>--}}

    {{--<div class="container">--}}

        {{--<div> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, consequuntur aliquid libero, deleniti inventore expedita excepturi maiores qui quos! Odio ratione, ipsam ipsa a commodi expedita error ea officiis maxime? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum dicta ex aliquid illum vero, aut sed fugit quae dignissimos a veritatis iste maiores reiciendis, dolores voluptas saepe dolorem consequatur tenetur.--}}
        {{--</div>--}}
    {{--</div>--}}

        <div class="title m-b-md">
            Our team
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <div class="list-group">
                        @foreach($members as $member)
                            <a href="/members/{{$member->id}}" class="list-group-item">
                                {{$member->first_name}} {{$member->last_name}}<br></a>
                        @endforeach
                    </div>
                    @if(Auth::user()->email=='gc3e15@soton.ac.uk')
                    <a href="{{ url('/aboutWorkshop/create') }}">
                        <button type="submit" class="btn btn-primary" style="margin-bottom: 20px;">Add Member</button>
                    </a>
                    @endif
                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
@endsection
