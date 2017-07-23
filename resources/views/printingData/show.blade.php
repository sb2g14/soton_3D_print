@extends('layouts.layout')

@section('content')
    <div class="title m-b-md">
        Job details
    </div>
    <div class="container" style=" margin-top: -30px; text-align: center;">
        <ul class="list-inline text-center well">
            <li class="alert alert-warning">
                {{--Print short description and a link--}}
                <h2 class="media-heading">
                        Printer number: <b>{{ $job->printers_id }}</b><br>
                        Requested by: <b>{{$job->student_name}}</b><br>
                        Requester id: <b>{{$job->student_id}}</b><br>
                        Requester emil: <b>{{$job->email}}</b><br>
                        Estimated duration: <b>{{$job->time}}</b><br>
                        Estimated material amount: <b>{{$job->material_amount}} grams</b><br>
                        Estimated price: <b>£{{$job->price}}</b><br>
                        Module Name or Cost Code: <b>{{$job->use_case}}</b><br>
                        Cost Code: <b>{{$job->cost_code}}</b><br>
                        Requested on: <b>{{ $job->created_at->toDayDateTimeString() }}</b>
                </h2>

            </li>
            {{--<li class="btn">--}}
            {{--<div>--}}
                {{--<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#reviewJob">Review</button>--}}
            {{--</div>--}}
            {{--</li>--}}

            <li class="btn">
            <div>
                <a href="/printingData/index" class="btn btn-default">back</a>
            </div>
            </li>

            <div id="reviewJob" class="card">
                <div class="col-md-8 col-md-offset-2" style="margin-top: 30px">
                <div class="panel panel-default">
                    <div class="col well">
                        <h4 style="color:red; font-weight: 600; font-size: large">Please check student input:</h4><br>
                        <form class="form-horizontal" role="form" method="POST" action="/printingData/{{ $job->id }}">

                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('printers_id') ? ' has-error' : '' }}">
                                <label for="printers_id" class="col-md-4 control-label">Printer number:</label>
                                <div class="col-md-6">
                                    <input type="text" id="printers_id" name="printers_id" value="{{ $job->printers_id }}" class="form-control" required>
                                        @if ($errors->has('printers_id'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('printers_id') }}</strong>
                                                </span>
                                        @endif
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
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('time') ? ' has-error' : '' }}">
                                <label for="time" class="col-md-4 control-label">Estimated duration:</label>
                                <div class="col-md-6">
                                    <input type="text" id="time" name="time" value="{{ date("H:i", strtotime($job->time)) }}" class="form-control">
                                        @if ($errors->has('time'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('time') }}</strong>
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
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('use_case') ? ' has-error' : '' }}">
                                <label for="use_case" class="col-md-4 control-label">Project title:</label>
                                <div class="col-md-6">
                                    <input type="text" id="use_case" name="use_case" value="{{ $job->use_case }}" class="form-control">
                                    @if ($errors->has('use_case'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('use_case') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <h4 style="color:red; font-weight: 600; font-size: large">To be filled by demonstrator:</h4><br>

                            {{--<div class="form-group{{ $errors->has('cost_code') ? ' has-error' : '' }}">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="cost_code">Select Project Code:</label>--}}
                                            {{--<select class="form-control" id="cost_code" name="cost_code">--}}
                                                {{--@foreach($cost_codes as $cost_code)--}}
                                                    {{--<option name="cost_code" value="{{ $cost_code->cost_code }}"> {{ $cost_code->shortage }}: {{  $cost_code->description }}--}}
                                                {{--@endforeach--}}
                                                    {{--<option name="cost_code" value="other">Other--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                        {{--<input type="text" id="other_cost_code" name="other_cost_code" placeholder="Please select 'Other' and specify the cost code if project title is not in the list" class="form-control"">--}}
                                {{--@if ($errors->has('cost_code'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('cost_code') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}

                            <div class="form-group">
                                <label for="comments">Add comments:</label><br>
                                <textarea rows="4" cols="50" id="comments" name="comments" placeholder="Please add any comments to this job if relevant" class="form-control"></textarea>
                            </div>

                            {{--<div class="form-group{{ $errors->has('paid') ? ' has-error' : '' }}">--}}
                                {{--<label for="paid">Should the job be financed?</label><br>--}}
                                    {{--<div class="radio">--}}
                                        {{--<label><input type="radio" name="paid" value="Yes"> Yes </label>--}}
                                        {{--<label><input type="radio" name="paid" value="No"> No </label>--}}
                                        {{--@if ($errors->has('paid'))--}}
                                            {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('paid') }}</strong>--}}
                                    {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group{{ $errors->has('purpose') ? ' has-error' : '' }}">--}}
                                {{--<label for="purpose">Is the job to be conducted in workshop or in loan?</label><br>--}}
                                {{--<div class="radio">--}}
                                    {{--<label><input type="radio" name="purpose" value="Use"> Workshop </label>--}}
                                    {{--<label><input type="radio" name="purpose" value="Loan"> Loan </label>--}}
                                    {{--@if ($errors->has('purpose'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('purpose') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Accept</button>
                                <a href="/printingData/delete/{{$job->id}}" class="btn btn-danger">Reject</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            </div>
        </ul>
    </div>



@endsection


