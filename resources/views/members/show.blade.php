@extends('layouts.layout')

@section('content')
    <h2 style="margin-bottom: 20px; font-weight: 600;">
        {{ $member -> first_name }} {{ $member -> last_name }} <br>
    </h2>

    <div class="container">
        <div class="row">
            <div class="col-xs-2 col-sm-4"></div>

            <div class="col-xs-8 col-sm-4 well text-left">
                <p><span class="glyphicon glyphicon-user"></span> {{$member -> role}}</p>
                @hasanyrole('LeadDemonstrator|Demonstrator|administrator|Coordinator|Technician')
                <p><span class="glyphicon glyphicon-phone"></span> {{$member -> phone}}</p>
                @endhasanyrole
                <p><span class="glyphicon glyphicon-envelope"></span> {{$member -> email}}</p> 
                @if(strtolower(Auth::user()->email) == strtolower($member->email) || Auth::user()->can('staff_manage'))
                    <p><span class="glyphicon glyphicon-th-list"></span> ID: {{$member -> student_id}}</p>
                    <a href="/members/edit/{{$member->id}}">
                        <button type="submit" class="btn btn-info" style="margin: 20px 20px 20px 0px ;">Update Record</button>
                    </a>
                    <a href="/members/delete/{{$member->id}}">
                        <button type="submit" class="btn btn-danger" style="margin: 20px 0px;">Delete Record</button>
                    </a>
                @endif
            </div>
            
            <div class="col-xs-2 col-sm-4"></div>
        </div>
    </div>
@endsection
