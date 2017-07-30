@extends('layouts.layout')
@section('content')
    <style>
        .full-height {
            height: 140vh;
        }
    </style>

    @if ($flash=session('message'))
        <div id="flash_message" class="alert {{ session()->get('alert-class', 'alert-info') }}" role="alert" style="position: relative">
            {{ $flash }}
        </div>
    @endif

    <div class="title m-b-md">
        Issues Printer {{ $id }}
    </div>

    <section class="s-welcome" style="margin-top: -20px">

                    {{--Here we show issues:--}}

            @foreach($issues as $issue)
            <div class="container well" style="margin-top: 20px">
                    <a href="#">
                        <div class="bl-logo logo-issue"></div>
                        <ul class="list-inline text-center">
                            <li><h1>ISSUE {{ $issue-> id }}</h1></li>
                        </ul>
                    </a>
                    <hr>
                <ul class="container" style="margin-top: 20px">
                    <div class="col-sm-6">
                        {{--Print title of an issue--}}
                        <h2><b>{{ $issue->title }}:</b></h2><br>
                        {{--Print name of a user who created an issue--}}
                        <h4 class="media-heading"> {{$issue->users_name_created_issue}}  <small><i>
                                    {{--Print date and time when an issue was created--}}
                                    Created on {{ $issue->created_at->toDayDateTimeString() }}</i></small></h4><br>
                        <h4 class="media-heading"> Printer Status: <b>{{$issue->printer_status}}</b></h4><br>
                        <h4 class="media-heading"> Days out of order: <b>{{floor((strtotime($issue->updated_at) - strtotime($issue->created_at)) / (60 * 60 * 24))}}</b></h4><br>
                    </div>
                    <div class="col-sm-6 item">
                        {{--Print the text of a post--}}
                        <h2><b> Message:</b></h2>
                        @if($issue->resolved == 0)
                            @hasanyrole('LeadDemonstrator|Demonstrator|administrator')
                            <a href="/issues/update/{{$issue->id}}" class="btn btn-lg btn-info pull-right">View/Update or Resolve Issue</a><br>
                            @endhasanyrole
                        @endif
                        <p>{{ $issue->body }}</p>
                    </div>
                </ul>
                @if(!empty(array_filter( (array) $issue->FaultUpdates)))
                    <hr>
                    <a href="#">
                    <ul class="list-inline text-center">
                        <li><h1>ISSUE LOG</h1></li>
                    </ul>
                    </a>
                <hr>
                <ul class="container" style="margin-top: 20px">
                    <div class="col-sm-6">
                        {{--Here we show comments to each issue:--}}
                        @foreach($issue->FaultUpdates as $update)
                            <div class="media">
                                <div class="media-body">
                                    <h2><b>Update:</b></h2><br>
                                    <h4 class="media-heading"> {{$update->users_name}}  <small><i>Updated on {{ $update->created_at->toDayDateTimeString() }}:</i></small></h4><br>
                                    <h4 class="media-heading"> Printer Status: <b>{{$update->printer_status}}</b></h4><br>
                                </div>
                            </div>
                    </div>
                    <div class="col-sm-6">
                        <h2><b>Message:</b></h2><br>
                        <p>{{ $update->body }}</p>
                    </div>
                    @endforeach
                </ul>
                @endif
            <hr>
                @if($issue->resolved == 1)
                <ul class="container" style="margin-top: 20px">
                    <div class="col-sm-6">
                        {{--Here we show issue resolve:--}}
                            <div class="media">
                                <div class="media-body">
                                    <h2><b>Resolved:</b></h2><br>
                                    <h4 class="media-heading"> {{$issue->users_name_resolved_issue}}  <small><i>Resolved on {{ $issue->updated_at->toDayDateTimeString() }}:</i></small></h4><br>
                                </div>
                            </div>
                    </div>
                    <div class="col-sm-6">
                        <h2><b>Message:</b></h2><br>
                        <p>{{ $issue->message_resolved }}</p>
                    </div>
                </ul>
                @endif
        </div>
        @endforeach

                    @include('layouts.errors')
    </section>
@endsection
