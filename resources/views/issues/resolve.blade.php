@extends('layouts.layout')

@section('content')
<div class="title m-b-md">
        Resolve an issue
</div>

<div class="container well">
    <div class="row">
        <div class="col-sm-6">
            <div class="alert alert-info text-left">
                {{--Print title of an issue--}}
                <h3 class="text-center">{{ $issue->title }}</h3><br>
                {{--Print name of a user who created an issue--}}
                <h5 class="media-heading"> {{$issue->users_name_created_issue}}<small><i>
                {{--Print date and time when an issue was created--}}
                Created on {{ $issue->created_at->toDayDateTimeString() }}</i></small></h5><br>
                <p>Printer Status: <b>{{$issue->printer_status}}</b><br>
                    Days out of order: <b>{{floor((strtotime($issue->updated_at) - strtotime($issue->created_at)) / (60 * 60 * 24))}}</b><br>
                    {{--Print the text of a post--}}
                    Description: <b>{{ $issue->body }}</b>
                </p>
            </div>

            @if(!empty(array_filter( (array) $issue->FaultUpdates)))
                <h3 class="text-center lead">ISSUE LOG</h3>
                <ul class="list-group text-left">
                    {{--Here we show updates to each issue:--}}
                    @foreach($issue->FaultUpdates as $update)
                        <li class="list-group-item">
                            <h5 class="media-body">Update: {{$update->users_name}}  <small><i>
                                        Updated on {{ $update->created_at->toDayDateTimeString() }}:</i></small></h5><br>
                                <p> Printer Status: <b>{{$update->printer_status}}</b><br>
                                    Closing message: <b>{{ $update->body }}</b></p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="col-sm-6">
            {!! Form::open(['url' => '/issues/resolve', 'method' => 'POST', 'class' => 'text-left']) !!}
                {!! Form::hidden('id',$issue -> id) !!}
                    <div class="form-group">
                        {!! Form::label('body', 'Resolve message', ['class' => 'control-label']) !!}
                        {!! Form::textarea('body', $value = null, ['class' => 'form-control', 'placeholder' => 'Please specify the details of the resolved issue', 'id' => 'message']) !!}
                        <div class="text-danger" id="message_error"></div>
                    </div>
                        {!! Form::submit('Submit', ['class' => 'btn-success', 'id' => 'submit'] ) !!}
                         <a href="/issues" class="btn btn-danger">Go back</a>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="/js/validate_form.js"></script>
@endsection