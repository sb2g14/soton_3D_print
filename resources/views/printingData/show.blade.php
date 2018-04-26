@extends('layouts.layout')

@section('content')
    <div class="title m-b-md">
        Job details
    </div>

    @php($print = $job->prints->first())

    <div class="container well">
        <div class="row vdivide">
            <div class="col-sm-6 text-left job-details">
                <div class="alert alert-info text-left">
                    <p>
                        Printer number: <a href="/issues/show/{{ $print->printers_id }}"><b>{{ $print->printers_id }}</b></a><br>
                        Printer serial number: <b>{{ $print->printer->serial_no }}</b><br>
                        Requested on: <b>{{ $job->created_at->toDayDateTimeString() }}</b><br>
                        Requested by: <b>{{$job->customer_name}}</b><br>
                        Requester id: <b>{{$job->customer_id}}</b><br>
                        Requester email: <b>{{$job->customer_email}}</b><br>
                        Payment category: <b>{{$job->payment_category}}</b><br>
                        Total estimated duration: <b>{{$job->total_duration}}</b><br>
                        Total estimated material amount: <b>{{$job->total_material_amount}} grams</b><br>
                        Total estimated price: <b>£{{$job->total_price}}</b><br>
                        {{--Module name or cost code: @if($job->use_case == 'Cost Code - approved') <b style="color: forestgreen"> @elseif($job->use_case == 'Cost Code - unknown') <b style="color: red"> @endif {{$job->use_case}} </b><br>--}}
                        Cost code: @if($job->use_case == 'Cost Code - approved') <b style="color: forestgreen"> {{$job->cost_code}} @elseif($job->use_case == 'Cost Code - unknown')</b> <b style="color: red"> {{$job->cost_code}} @else <b style="color: forestgreen"> {{$job->use_case}} @endif  </b><br>
                        Budget Holder: <b> {{ $job->budget_holder }} </b><br>
                        Job Title: {{ $job->job_title }} <br>
                        Job number: <b>{{$job->id}}</b><br>
                    </p>
                </div>

            </div>
            <div class="col-sm-6">
                <div id="reviewJob" class="text-center card">
                    <h4>Please check student input:</h4><br>
                    <form class="form-horizontal" role="form" method="POST" action="/WorkshopJobs/{{ $job->id }}">

                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->has('printers_id') ? ' has-error' : '' }}">
                            {{--This is a Printer Number dropdown--}}
                            <div class="form-group">
                                {!! Form::label('printers_id', 'Printer Number', ['class' => 'col-lg-4 control-label'] )  !!}
                                <div class="col-md-6">
                                    {!! Form::select('printers_id', $available_printers,  $print->printers_id, ['class' => 'form-control','required', 'data-help' => 'printers_id', 'id' => 'printers_id']) !!}
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
                                <input id="student_name" name="student_name" 
                                    type="text" class="form-control" 
                                    value="{{ $job->customer_name }}"/>
                                @if ($errors->has('student_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('student_name') }}</strong>
                                    </span>
                                @endif
                                <span id="student_name_error"></span>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('student_id') ? ' has-error' : '' }}">
                            <label for="student_id" class="col-md-4 control-label">Requester id:</label>
                            <div class="col-md-6">
                                <input id="student_id" name="student_id" 
                                    type="text" class="form-control" 
                                    value="{{ $job->customer_id }}" >
                                @if ($errors->has('student_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('student_id') }}</strong>
                                    </span>
                                @endif
                                <span id="student_id_error"></span>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Requester email:</label>
                            <div class="col-md-6">
                                <input id="email" name="email" 
                                    type="text" class="form-control" 
                                    value="{{ $job->customer_email }}" />
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <span class="" id="email_error"></span>
                            </div>
                        </div>

                       {{--Get numbers of hours and minutes from the requested time--}}
                        @php( list($h, $i, $s) = explode(':', $job->total_duration) )

                        <div id="time" class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
                            {!! Form::label('hours', 'Printing Time (h:m)', ['class' => 'col-lg-4 control-label'] )  !!}
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
                                <input id="material_amount" name="material_amount" 
                                    type="text" class="form-control" 
                                    value="{{ $job->total_material_amount }}" />
                                    @if ($errors->has('material_amount'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('material_amount') }}</strong>
                                        </span>
                                    @endif
                                <span class="" id="material_amount_error"></span>
                            </div>
                        </div>

                        <div class="form-group text-left">
                            <div class="col-md-12">
                                <label for="comments">Add comments (optional):</label><br>
                                <textarea id="comment" name="comments" 
                                    rows="4" class="form-control" 
                                    placeholder="Please add any comments to this job if relevant" ></textarea> 
                                <span id="comment_error"></span>
                            </div>
                        </div>

                        <div class="col-sm-12 text-left">
                                <button id="submit" type="submit" class="btn btn-lg btn-success">Accept</button>
                                <a class="btn btn-lg btn-danger" href="/WorkshopJobs/{{$job->id}}/delete">Reject</a>
                                <a class="btn btn-lg btn-primary" href="/WorkshopJobs/index">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if (notify()->ready())
        <script>
            swal({
                title: "{!! notify()->message() !!}",
                text: "{!! notify()->option('text') !!}",
                type: "{{ notify()->type() }}",
                showConfirmButton: true
            });
        </script>
    @endif
    <script src="/js/validate_form.js"></script>
@endsection


