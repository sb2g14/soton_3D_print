@extends('layouts.layout')

@section('content')
<div class="title m-b-md">
        Update Issue
</div>

<div class="container well">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
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
                            <h5 class="media-heading">Update: {{$issue->users_name_created_issue}}<small><i>
                            {{--Print date and time when an issue was updated--}}
                            Updated on {{ $update->created_at->toDayDateTimeString() }}:</i></small></h5><br>
                            <p>Printer Status: <b>{{$update->printer_status}}</b><br>
                                Description: <b>{{ $update->body }}</b>
                            </p>
                        </li>
                    @endforeach
                </ul>
            @endif
            <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#{{ $update->id }}">Update</button>
            <a href="/issues/index" class="btn btn-danger">Go back</a>
                    
            <div id="{{ $update->id }}" class="card collapse">

                {!! Form::open(['url' => '/issues/update', 'method' => 'POST', 'class' => 'text-left']) !!}
                    {!! Form::hidden('id',$issue -> id) !!}
                    {{-- <div class="field-inner"> --}}
                        <div class="form-group">
                            {!! Form::label('select', 'Select New Status', ['class' => 'control-label'] )  !!}
                            {!!  Form::select('select',['Broken'=>'Broken', 'Missing'=>'Missing', 'Signed out'=> 'Signed out'], null, ['class' => 'form-control' ]) !!}
                        </div>
                  <!--   </div> -->
                    <!-- Body -->
                    <div class="form-group">
                            {!! Form::label('body', 'Description', ['class' => 'control-label']) !!}
                            {!! Form::textarea('body', $value = $update->body, ['class' => 'form-control', 'placeholder' => 'Please specify the log details', 'id' => 'message']) !!}
                            <div class="help-block" id="message_error"></div>
                    </div>
                    <!-- Submit Button -->
                    {!! Form::submit('Submit', ['class' => 'btn', 'id' => 'submit'] ) !!}
                    
                {!! Form::close() !!}        
            </div>
        </div>
        <div class="col-sm-4"></div>
    </div>
    
    

</div>


       
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

            {!! Form::open(['url' => '/issues/update', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('id',$issue -> id) !!}
            <div class="field-inner">
                <div class="form-group">
                    {!! Form::label('select', 'Select New Status', ['class' => 'col-lg-2 control-label'] )  !!}
                     <div class="col-lg-10">
                    {!!  Form::select('select',['Broken'=>'Broken', 'Missing'=>'Missing', 'Signed out'=> 'Signed out'], null, ['class' => 'form-control' ]) !!}
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="form-group">
                    {!! Form::label('body', 'Message', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::textarea('body', $value = $issue->body, ['class' => 'form-control', 'placeholder' => 'Please specify the log details', 'id' => 'message']) !!}
                    <td><span class="help-block" id="message_error"></span> </td>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    {!! Form::submit('Submit', ['class' => 'btn btn-lg pull-right', 'id' => 'submit'] ) !!}
                </div>
            </div>

    </div>
</section>
@endsection
@section('scripts')
    <script src="/js/update_issue_validation.js"></script>
@endsection