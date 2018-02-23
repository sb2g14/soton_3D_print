@extends('layouts.layout')

@section('content')
<div class="title m-b-md">
    Log New Issue
</div>

<div class="container well">
    <div class="row vdivide">
        <div class="col-sm-6 text-left">
            {!! Form::open(['url' => '/issues/create', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'LogIssueForm']) !!}
            {!! Form::hidden('id',$selectedPrinter -> id) !!}
            <div class="field-inner">
                <div class="form-group">
                    {!! Form::label('select', 'Select New Status', ['class' => 'col-sm-4 control-label'] )  !!}
                    <div class="col-sm-8">
                        {!!  Form::select('select',['Broken'=>'Broken', 'Missing'=>'Missing', 'Signed out'=> 'Signed out'], null, ['class' => 'form-control' ]) !!}
                    </div>
                </div>
            </div>
            <!-- Title -->
            <div class="form-group">
                {!! Form::label('title', 'Issue', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('title', $value = $title, ['class' => 'form-control', 'placeholder' => 'Please specify the title of the issue', 'id' => 'issue']) !!}
                    <td><span class="help-block" id="issue_error"></span> </td>
                </div>
            </div>
            <!-- Body -->
            <div class="form-group">
                {!! Form::label('body', 'Message', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::textarea('body', $value = $body, ['class' => 'form-control', 'placeholder' => 'Please specify the log details', 'id' => 'message']) !!}
                    <td><span class="help-block" id="message_error"></span> </td>
                </div>
            </div>
            <!-- Submit button-->
            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-4">
                    {!! Form::submit('Submit', ['class' => 'btn btn-success', 'id' => 'submit'] ) !!}
                    {{--Go back button--}}
                    <a href="/issues/select" class="btn btn-danger">Go back</a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 text-left">
            <ul class="list-inline text-left col-sm-offset-4">
                <li>
                    <div class="media-heading">
                    Printer Number: <b>{{ $selectedPrinter -> id }}</b> <br>
                    Serial Number: <b>{{ $selectedPrinter -> serial_no }}</b> <br>
                    Printer Type: <b>{{ $selectedPrinter -> printer_type }}</b> <br>
                    Printer Status: <b>{{ $selectedPrinter -> printer_status }}</b> <br>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="/js/validate_form.js"></script>
@endsection
