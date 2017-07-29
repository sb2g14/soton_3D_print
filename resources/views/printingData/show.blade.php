@extends('layouts.layout')

@section('content')
    <div class="title m-b-md">
        Job details
    </div>

    <div class="container well">
        <div class="row vdivide">
            <div class="col-sm-6 text-left">
                <div class="alert alert-info text-left">
                    <p>
                        Printer number: <b>{{ $job->printers_id }}</b><br>
                        Printer serial number: <b>{{ $job->serial_no }}</b><br>
                        Requested on: <b>{{ $job->created_at->toDayDateTimeString() }}</b>
                        Requested by: <b>{{$job->student_name}}</b><br>
                        Requester id: <b>{{$job->student_id}}</b><br>
                        Requester email: <b>{{$job->email}}</b><br>
                        Payment category: <b>{{$job->payment_category}}</b><br>
                        Estimated duration: <b>{{$job->time}}</b><br>
                        Estimated material amount: <b>{{$job->material_amount}} grams</b><br>
                        Estimated price: <b>£{{$job->price}}</b><br>
                        Module name or cost code: <b>{{$job->use_case}}</b><br>
                        Cost code: <b>{{$job->cost_code}}</b><br>
                        Comment: <b>{{$job->comment}}</b><br>
                        Job number: <b>{{$job->id}}</b><br>
                    </p>
                </div>
               
            </div>
            <div class="col-sm-6">
                <div id="reviewJob" class="text-center card">
                    <h4 style="color:red; font-weight: 600; font-size: large">Please check student input:</h4><br>
                    <form class="form-horizontal" role="form" method="POST" action="/printingData/{{ $job->id }}">

                        {{ csrf_field() }}

                        {{--<div class="form-group{{ $errors->has('printers_id') ? ' has-error' : '' }}">--}}
                            {{--<label for="printers_id" class="col-md-4 control-label">Printer number:</label>--}}
                            {{--<div class="col-md-6">--}}
                                {{--<input type="text" id="printers_id" name="printers_id" value="{{ $job->printers_id }}" class="form-control" required>--}}
                                    {{--@if ($errors->has('printers_id'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('printers_id') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                    {{--<span class="help-block" id="printers_id_error"></span>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="form-group {{ $errors->has('printers_id') ? ' has-error' : '' }}">
                            {{--This is a Printer Number dropdown--}}
                            <div class="form-group">
                                {!! Form::label('printers_id', 'Printer Number', ['class' => 'col-lg-4 control-label'] )  !!}
                                <div class="col-md-6">
                                    {!! Form::select('printers_id', $available_printers,  $job->printers_id, ['class' => 'form-control','required', 'data-help' => 'printers_id', 'id' => 'printers_id']) !!}
                                    @if ($errors->has('printers_id'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('printers_id') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('student_name') ? ' has-error' : '' }}">
                            <label for="student_name" class="col-md-4 control-label">Requested by:</label>
                            <div class="col-md-6">
                                <input type="text" id="student_name" name="student_name" value="{{ $job->student_name }}" class="form-control">
                                    @if ($errors->has('student_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('student_name') }}</strong>
                                        </span>
                                    @endif
                                     <span class="help-block" id="student_name_error"></span>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('student_id') ? ' has-error' : '' }}">
                            <label for="student_id" class="col-md-4 control-label">Requester id:</label>
                            <div class="col-md-6">
                                <input type="text" id="student_id" name="student_id" value="{{ $job->student_id }}" class="form-control">
                                    @if ($errors->has('student_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('student_id') }}</strong>
                                    </span>
                                    @endif
                                <span class="help-block" id="student_id_error"></span>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Requester email:</label>
                            <div class="col-md-6">
                                <input type="text" id="email" name="email" value="{{ $job->email }}" class="form-control">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <span class="help-block" id="email_error"></span>
                            </div>
                        </div>

                        {{--<div class="form-group{{ $errors->has('time') ? ' has-error' : '' }}">--}}
                            {{--<label for="time" class="col-md-4 control-label">Estimated duration:</label>--}}
                            {{--<div class="col-md-6">--}}
                                {{--<input type="text" id="time" name="time" value="{{ date("H:i", strtotime($job->time)) }}" class="form-control">--}}
                                    {{--@if ($errors->has('time'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('time') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                    {{--<span class="help-block" id="time_error"></span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                       {{--Get numbers of hours and minutes from the requested time--}}
                        @php( list($h, $i, $s) = explode(':', $job->time) )

                        <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
                            {!! Form::label('hours', 'Printing Time', ['class' => 'col-lg-4 control-label'] )  !!}
                            <div class="col-md-2">
                                {!! Form::select('hours', range(0,59), $h, ['class' => 'form-control','required', 'data-help' => 'hours', 'id' => 'hours']) !!}
                                @if ($errors->has('hours'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('hours') }}</strong>
                        </span>
                                @endif
                            </div>
                            <div class="col-md-2">
                                {!! Form::select('minutes', range(0,59), $i, ['class' => 'form-control','required', 'data-help' => 'minutes', 'id' => 'minutes']) !!}
                                @if ($errors->has('minutes'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('minutes') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('material_amount') ? ' has-error' : '' }}">
                            <label for="material_amount" class="col-md-4 control-label">Estimated material amount (grams):</label>
                            <div class="col-md-6">
                                <input type="text" id="material_amount" name="material_amount" value="{{ $job->material_amount }}" class="form-control">
                                    @if ($errors->has('material_amount'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('material_amount') }}</strong>
                                        </span>
                                    @endif
                                <span class="help-block" id="material_amount_error"></span>
                            </div>
                        </div>

                        {{--<div class="form-group{{ $errors->has('use_case') ? ' has-error' : '' }}">--}}
                            {{--<label for="use_case" class="col-md-4 control-label">Project title:</label>--}}
                            {{--<div class="col-md-6">--}}
                                {{--<input type="text" id="use_case" name="use_case" value="{{ $job->use_case }}" class="form-control">--}}
                                    {{--@if ($errors->has('use_case'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('use_case') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                    {{--<span class="help-block" id="use_case_error"></span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <!-- <hr>
                        <h4 style="color:red; font-weight: 600; font-size: large">To be filled by demonstrator:</h4><br> -->

                        <div class="form-group text-left">
                            <label for="comments">Add comments (optional):</label><br>
                            <textarea rows="4" id="message" name="comments" placeholder="Please add any comments to this job if relevant" class="form-control"></textarea>
                            <span class="help-block" id="message_error"></span>
                        </div>

                        <div class="col-sm-12 text-left">
                                <button id="submit" type="submit" class="btn btn-lg">Accept</button>
                                <a href="/printingData/delete/{{$job->id}}" class="btn btn-lg btn-danger">Reject</a>
                                <a href="/printingData/index" class="btn btn-lg btn-info">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/approve_job_validation.js"></script>
@endsection


