@extends('layouts.layout')

@section('content')
<div class="title m-b-md">
        Update an issue
</div>

<div class="container well">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="alert alert-info text-left">
                {{--Print title of an issue--}}
                <h3 class="text-center">{{ isset($issue->title) ? $issue->title : 'Issue with printer '.$issue->printers_id }}</h3><br>
                {{--Print name of a user who created an issue--}}
                <h5 class="media-heading"> {{ $issue->issue_created->first_name }} {{ $issue->issue_created->last_name }}<small><i>
                {{--Print date and time when an issue was created--}}
                Created on {{ $issue->created_at->toDayDateTimeString() }}</i></small></h5><br>
                <p>Printer Number: <b>{{$issue->printers_id}}</b><br>
                    Printer Status: <b>{{$issue->printer_status}}</b><br>
                    Days out of order: <b>{{ \Carbon\Carbon::now('Europe/London')->diffInDays($issue->created_at) }}</b><br>
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
                            {{--Print date and time when an issue was updated--}}
                            @if($update->created_at->addMinutes(5)->gte(\Carbon\Carbon::now('Europe/London')))
                            <span data-placement="top" data-toggle="popover" data-trigger="hover"
                                  data-content="Delete this update from the database (this option is available only 5 minutes after creation). This will change the status of the printer to the previous one.">
                                <a type="button" id="deleteUpdate" href="/issues/delete_update/{{$update->id}}" class="close" style="color: red">&times;</a>
                            </span>
                            @endif
                            <small><i>{{ $update->staff->first_name }} {{ $update->staff->last_name }} updated on {{ $update->created_at->toDayDateTimeString() }}:</i></small></h5><br>
                            <p>Printer Status: <b>{{$update->printer_status}}</b><br>
                                Description: <b>{{ $update->body }}</b>
                            </p>
                        </li>
                    @endforeach
                </ul>
            @endif
            @if($issue->resolved === 0)
            <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#update">Update</button>
            <button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#resolve">Resolve</button>
            @endif
            <a id="buttons" href="/issues/index" class="btn btn-primary">See all issues</a>


            <div id="update" class="card collapse">
                {!! Form::open(['url' => '/issues/update', 'method' => 'POST', 'class' => 'text-left']) !!}
                    {!! Form::hidden('id',$issue -> id) !!}
                        <div class="form-group">
                            {!! Form::label('select', 'Select New Status', ['class' => 'control-label'] )  !!}
                            {!! Form::select('select',['Broken'=>'Broken', 'Missing'=>'Missing', 'Signed out'=> 'Signed out'], null, ['class' => 'form-control' ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('body', 'Description', ['class' => 'control-label']) !!}
                            {!! Form::textarea('body', $value = null, ['class' => 'form-control', 'placeholder' => 'Please specify the log details', 'id' => 'message']) !!}
                            <div class="help-block" id="message_error"></div>
                        </div>
                    <!-- Submit Button -->
                    {!! Form::submit('Submit', ['class' => 'btn btn-success', 'id' => 'submit'] ) !!}
                {!! Form::close() !!}        
            </div>
            <div id="resolve" class="card collapse">
                {!! Form::open(['url' => '/issues/resolve', 'method' => 'POST', 'class' => 'text-left']) !!}
                {!! Form::hidden('id',$issue -> id) !!}
                <div class="form-group">
                    {!! Form::label('body', 'Resolve message', ['class' => 'control-label']) !!}
                    {!! Form::textarea('body', $value = null, ['class' => 'form-control', 'placeholder' => 'Please specify the details of the resolved issue', 'id' => 'message_resolve']) !!}
                    <div class="help-block" id="message_resolve_error"></div>
                </div>
                {!! Form::submit('Submit', ['class' => 'btn btn-success', 'id' => 'btn-resolve'] ) !!}
                <a href="/issues/index" class="btn btn-danger">Go back</a>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="/js/validate_form.js"></script>
    <script src="/js/validate_form_issue_resolve.js"></script>
@endsection
