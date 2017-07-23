@extends('layouts.layout')

@section('content')
    <h2 style="margin-bottom: 20px; font-weight: 600;">
        {{ $member -> title }} {{ $member -> first_name }} {{ $member -> last_name }} <br>
    </h2>

    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>

            <div class="col-sm-4 well" style="text-align: left;">
                <p><span class="glyphicon glyphicon-user"></span> {{$member -> role}}</p>
                <p><span class="glyphicon glyphicon-phone"></span> {{$member -> phone}}</p>
                <p><span class="glyphicon glyphicon-envelope"></span> {{$member -> email}}</p> 
            @if(Auth::user()->email == $member->email || Auth::user()->email=='gc3e15@soton.ac.uk')
                    <p><span class="glyphicon glyphicon-th-list"></span> ID: {{$member -> id_number}}</p>
            <a href="/members/edit/{{$member->id}}">
                <button type="submit" class="btn btn-info" style="margin: 20px 20px 20px 0px ;">Update Record</button>
            </a>
            <a href="/members/delete/{{$member->id}}">
                <button type="submit" class="btn btn-danger" style="margin: 20px 0px;">Delete Record</button>
            </a>
            @endif    
            </div>
            
            <div class="col-sm-4"></div>
        </div>
    </div>
    
    {{--{{ Form::button('Hit Me', array('class' => 'btn')) }}--}}
    {{--<button class="btn" type="button">Delete record</button>--}}
@endsection
