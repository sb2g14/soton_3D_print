@extends('layouts.layout')

@section('content')
<div class="title m-b-md">
        Resolve Issue
</div>

<section class="s-welcome">
    <div class="container">
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
                    <h2><b> Message:</b></h2><br>
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
            <hr>
            @endif
        </div>

            {!! Form::open(['url' => '/issues/resolve', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('id',$issue -> id) !!}

            <!-- Body -->
            <div class="form-group">
                    {!! Form::label('body', 'Resolve message', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::textarea('body', $value = null, ['class' => 'form-control', 'placeholder' => 'Please specify the details of the resolved issue', 'id' => 'message']) !!}
                    <td><span class="help-block" id="message_error"></span> </td>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    {!! Form::submit('Submit', ['class' => 'btn btn-lg btn-info pull-right', 'id' => 'submit'] ) !!}
                </div>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
    <script src="/js/update_issue_validation.js"></script>
@endsection