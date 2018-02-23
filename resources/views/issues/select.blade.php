@extends('layouts.layout')

@section('content')
    <div class="title m-b-md">
        Log New Issue
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                {!! Form::open(['url' => '/issues/select', 'method' => 'POST', 'class' => 'form-inline']) !!}
                    <div class="form-group">
                        {!! Form::label('select', 'Select Printer', ['class' => 'control-label'] )  !!}
                        {!!  Form::select('select',$printers,'1',['class' => ' form-control' ]) !!}
                    </div>
                    <!-- If redirection is from post view save the welcome post  -->
                    @if(isset($title))
                     {!!  Form::hidden('title',$title) !!}
                    @endif
                    @if(isset($body))
                        {!!  Form::hidden('body',$body) !!}
                    @endif
                    {!! Form::submit('Submit', ['class' => 'btn btn-info'] ) !!}
                    <a href="/issues/index" class="btn btn-danger">Go to issues list</a>
                {!! Form::close() !!}
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
@endsection
