@extends('layouts.layout')

@section('content')

    {{--Show the error message--}}
    @if ($flash=session('message'))
        <div id="flash_message" class="alert {{ session()->get('alert-class', 'alert-info') }}" role="alert">
            {{ $flash }}
        </div>
    @endif

 {{--Defining variables for restart a job prefil of forms--}}
    @if(isset($data))
        @php
            $print = $data->prints->first();
            $printers_id = $print->printers_id;
            $student_name = $data->customer_name;
            $email = $data->customer_email;
            $student_id = $data->customer_id;
            list($hours, $minutes, $s) = explode(':', $data->total_duration);
            $material_amount = $data->total_material_amount;
            $use_case = $data->use_case;
        @endphp
    @else
        @php
            $printers_id = '';
            $student_name = '';
            $email = '';
            $student_id = '';
            $hours = '';
            $minutes = '';
            $material_amount = '';
            $use_case = '';
        @endphp
    @endif

<div class="container well s-request-form">
    <div class="row vdivide">
        <div class="col-sm-6">
            <h1 class="text-center lead">REQUEST A JOB</h1>
            <form id="requestForm" class="form-horizontal" method="POST" action="/printingData">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('printers_id') ? ' has-error' : '' }}">
                   {{--This is a Printer Number dropdown--}}
                    <div class="form-group">
                        {!! Form::label('printers_id', 'Printer Number', ['class' => 'col-lg-4 control-label'] )  !!}
                        <div class="col-md-6">
                            {!! Form::select('printers_id', array('' => 'Select Available Printer') + $available_printers,  old('printers_id', $printers_id), ['class' => 'form-control','required', 'data-help' => 'printers_id', 'id' => 'printers_id']) !!}
                            @if ($errors->has('printers_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('printers_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{--Student Name field--}}
                <div class="form-group{{ $errors->has('student_name') ? ' has-error' : '' }}">
                    <label for="student_name" class="col-sm-4 control-label">Name</label>

                    <div class="col-sm-8">
                        <input id="student_name" data-help="" type="text" class="form-control" name="student_name" value="{{ old('student_name', isset($member)  ? $member->first_name.' '.$member->last_name : $student_name) }}" placeholder="Please input your First and Last name" required>
                        @if ($errors->has('student_name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('student_name') }}</strong>
                        </span>
                        @endif
                        <span class="help-block" id="student_name_error"></span>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">Email</label>

                    <div class="col-md-6">
                        <input id="email" data-help="email" type="email" class="form-control" name="email" value="{{ old('email', isset($member)  ? $member->email : $email) }}" placeholder="Please input soton email" required><br>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                        <span class="help-block" id="email_error"></span>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('student_id') ? ' has-error' : '' }}">
                    <label for="student_id" class="col-sm-4 control-label">Student/Staff ID</label>
                    <div class="col-sm-8">
                        <input id="student_id" data-help="student_id" type="text" class="form-control" name="student_id" value="{{ old('student_id', isset($member)  ? $member->student_id : $student_id) }}" placeholder="Please input your university ID number" required>
                        @if ($errors->has('student_id'))
                            <span class="help-block">
                            <strong>{{ $errors->first('student_id') }}</strong>
                        </span>
                        @endif
                        <span class="help-block" id="student_id_error"></span>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
                    {!! Form::label('hours', 'Printing Time', ['class' => 'col-lg-4 control-label'] )  !!}
                    <div class="col-md-4">
                        {!! Form::select('hours',array('' => 'Hours')+ range(0,59), old('hours', $hours), ['class' => 'form-control','required', 'data-help' => 'hours', 'id' => 'hours']) !!}
                        @if ($errors->has('hours'))
                            <span class="help-block">
                            <strong>{{ $errors->first('hours') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-4">
                        {!! Form::select('minutes',array('' => 'Minutes')+ range(0,59), old('minutes', $minutes), ['class' => 'form-control','required', 'data-help' => 'minutes', 'id' => 'minutes']) !!}
                        @if ($errors->has('minutes'))
                            <span class="help-block">
                            <strong>{{ $errors->first('minutes') }}</strong>
                        </span>
                        @endif
                   </div>
                </div>

                <div class="form-group{{ $errors->has('material_amount') ? ' has-error' : '' }}">
                    <label for="material_amount" class="col-sm-4 control-label">Material Amount (grams) </label>
                    <div class="col-sm-8">
                        <input id="material_amount" data-help="material_amount" type="text" class="form-control" name="material_amount" value="{{ old('material_amount', $material_amount) }}" placeholder="Please specify the amount of material requested" required>
                        @if ($errors->has('material_amount'))
                            <span class="help-block">
                            <strong>{{ $errors->first('material_amount') }}</strong>
                        </span>
                        @endif
                        <span class="help-block" id="material_amount_error"></span>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('use_case') ? ' has-error' : '' }}">
                    <label for="use_case" class="col-sm-4 control-label">Module Name (Project) or Cost Code</label>
                    <div class="col-sm-8">
                        <input id="use_case" data-help="use_case" type="text" class="form-control" name="use_case" value="{{ old('use_case', isset($member)  ? "Demonstrator" : $use_case) }}" placeholder="A 9 digit cost code or module name are allowed" required>
                        @if ($errors->has('use_case'))
                            <span class="help-block">
                            <strong>{{ $errors->first('use_case') }}</strong>
                        </span>
                        @endif
                        <span class="help-block" id="use_case_error"></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8 text-left">
                        <button id="submit" type="submit" class="btn">Submit</button>
                        <a href="/" class="btn btn-danger">Go back</a>
                        <a href="{{  url('https://www.3dhubs.com/service/254134') }}" target="_blank" class="btn btn-info">Order online</a>
                    </div>
                </div>
                
            </form>
        </div>
        <div class="col-sm-6 instructions">
            <div class="hint text-left is-active before-filling" data-hint="general">
                <h3 class="text-center lead">How to request a 3D print</h3>
                <p>Submit the Request form to the left providing all the necessary details.</p>
                <p>After the form is submitted it is redirected to the demonstrator for approval.</p>
                <p>Please do not start printing until the demonstrator checks all the details and approves the request.</p>
                <p>If your job was approved but something went wrong with the print itself ask the demonstrator to
                    cancel the job. Therefore, you will be charged only for the printing time spent before cancelling
                    the job and not for the whole job.</p>
            </div>
            
            <div class="hint text-left" data-hint="printer_id">
                <h3 class="text-center lead">If the chosen printer is unavailable</h3>
                <p>If the printer you have selected is not on the list of available printers this means that it is
                    either broken or scheduled to use for other print. In either case please contact the demonstrator
                    for further information.</p>
            </div>
            <div class="hint text-left" data-hint="email">
                <h3 class="text-center lead">Why do we need your email?</h3>
                <p>Your university email may be used to contact you regarding the prints you have just requested or the
                    prints did previously.</p>
            </div>
            <div class="hint text-left" data-hint="student_id">
                <h3 class="text-center lead">How to find out my student/staff ID?</h3>
                <p>Student ID is typically 9 digits long. Staff ID is typically 8 digits long. Do not forget to input
                    the whole ID number. It is schematically displayed in the picture below. </p>
                <div class="text-center">
                    <img src="/Images/studentID.svg" width="300" alt="studentID">
                </div>
            </div>
            <div class="hint text-left" data-hint="hours">
                <h3 class="text-center lead">Printing time</h3>
                <p>Please input the printing time that is provided by the software in hours and minutes. Note,
                    that 59 hours and 59 minutes is currently the maximum available printing time.</p>
            </div>
            <div class="hint text-left" data-hint="minutes">
                <h3 class="text-center lead">Printing time</h3>
                <p>Please input the printing time that is provided by the software in hours and minutes. Note,
                    that 59 hours and 59 minutes is currently the maximum available printing time.</p>
            </div>
            <div class="hint text-left" data-hint="material_amount">
                <h3 class="text-center lead">Estimated price</h3>
                <p>Based on the print duration and the material amount we
                    estimate the cost of your print to be £  <span id="price" style="color: red;"></span></p>
            </div>
            <div class="hint text-left" data-hint="use_case">
                <h3 class="text-center lead">Module name or Cost Code</h3>
                <p>If you are a student and your print is part of a project, please input the short abbreviation of your
                    module name or course. Note that course or module abbreviations must be in capital letters. The
                    system will recognise most of the standard modules that are registered with the workshop.</p>
                <p>If your abbreviation was not recognised, please contact the demonstrator.</p>
                <p>If you are a PhD student, postdoc or an academic, please input the Cost Code that will be charged for
                    the current print. If in doubt or if you have any questions, please contact the demonstrator.</p>
            </div>
            <div class="hint text-left after-filling" data-hint="final">
                <h3 class="text-center lead">The estimated cost of the print</h3>
                <p>The cost of your print is £ <span id="price-final" style="color: red;"></span></p>
                <p>The price was calculated based on the print duration and the amount of material used.</p>
                <p>After you press Submit button, the request will be sent to the demonstrator for approval. At this
                    stage, the cost may change if the amount of material or the duration of print are altered by the
                    demonstrator.</p>
                <p>Please, do not start printing until notified that your job was approved. You will get a notification
                    when the job will be approved or rejected by a demonstrator.</p>
                <p>You may cancel your job if it is unsuccessful. In this case, you will be charged only for the
                    printing time spent before cancellation. To do that contact the demonstrator.</p>
            </div>            
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="/js/request_job_validation.js"></script>
@endsection