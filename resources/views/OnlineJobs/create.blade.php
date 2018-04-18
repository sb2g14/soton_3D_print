@extends('layouts.layout')

@section('content')

    {{--Show the error message--}}
    @if ($flash=session('message'))
        <div id="flash_message" class="alert {{ session()->get('alert-class', 'alert-info') }}" role="alert">
            {{ $flash }}
        </div>
    @endif

<div class="container well s-request-form">
    <div class="row vdivide">
        <div class="col-sm-6">
            <h1 class="text-center lead">ONLINE JOB REQUEST FORM</h1>
            <form id="requestForm" class="form-horizontal" method="POST" action="/onlineJobs">
                {{ csrf_field() }}

                {{--Customer Name field--}}
                <div class="form-group{{ $errors->has('customer_name') ? ' has-error' : '' }}">
                    <label for="customer_name" class="col-sm-4 control-label">Full Name</label>

                    <div class="col-sm-8">
                        <input id="customer_name" name="customer_name" 
                            type="text" class="form-control" 
                            value="{{ old('customer_name') }}" required autocomplete="name"
                            placeholder="Please input your First and Last name" data-help="" />
                        @if ($errors->has('customer_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('customer_name') }}</strong>
                            </span>
                        @endif
                        <span class="" id="customer_name_error"></span>
                    </div>
                </div>

                {{--Customer email field--}}
                <div class="form-group{{ $errors->has('customer_email') ? ' has-error' : '' }}">
                    <label for="customer_email" class="col-sm-4 control-label">Email</label>

                    <div class="col-sm-8">
                        <input id="customer_email" name="customer_email" 
                            type="text" class="form-control" 
                            value="{{ old('customer_email') }}" required autocomplete="work email"
                            placeholder="Please input soton email" data-help="customer_email" />
                        @if ($errors->has('customer_email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('customer_email') }}</strong>
                            </span>
                        @endif
                        <span class="" id="customer_email_error"></span>
                    </div>
                </div>

                {{--Customer ID field--}}
                <div class="form-group{{ $errors->has('customer_id') ? ' has-error' : '' }}">
                    <label for="customer_id" class="col-sm-4 control-label">Student/Staff ID</label>

                    <div class="col-sm-8">
                        <input id="customer_id" name="customer_id"  
                            type="text" class="form-control" 
                            value="{{ old('customer_id') }}" required autocomplete="work id"
                            placeholder="Please input your university ID number" data-help="customer_id" />
                        @if ($errors->has('customer_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('customer_id') }}</strong>
                            </span>
                        @endif
                        <span class="" id="customer_id_error"></span>
                    </div>
                </div>

                {{--Cost code field--}}
                <div class="form-group{{ $errors->has('use_case') ? ' has-error' : '' }}">
                    <label for="use_case" class="col-sm-4 control-label">Project Code or Cost Code</label>

                    <div class="col-sm-8">
                        <input id="use_case" name="use_case" 
                            type="text" class="form-control"
                            value="{{ old('use_case') }}" required autocomplete="off"
                            placeholder="A 9 digit cost code or module name" data-help="use_case" />

                        @if ($errors->has('use_case'))
                            <span class="help-block">
                                <strong>{{ $errors->first('use_case') }}</strong>
                            </span>
                        @endif
                        <span class="" id="use_case_error"></span>
                    </div>
                </div>

                {{--Budget Holder--}}
                <div id="budget_holder_group" class="form-group{{ $errors->has('budget_holder') ? ' has-error' : '' }}">
                    <label for="budget_holder" class="col-sm-4 control-label">Budget Holder</label>

                    <div class="col-sm-8">
                        <input id="budget_holder" name="budget_holder"  
                            type="text" class="form-control"
                            value="{{ old('budget_holder') }}" autocomplete="off"
                            placeholder="Provide the name of the budget holder of the cost code" data-help="budget_holder" />
                        @if ($errors->has('budget_holder'))
                            <span class="help-block">
                                <strong>{{ $errors->first('budget_holder') }}</strong>
                            </span>
                        @endif
                        <span class="" id="budget_holder_error"></span>
                    </div>
                </div>

                {{--Dropoff claim id--}}
                <div class="form-group{{ $errors->has('claim_id') ? ' has-error' : '' }}">
                    <label for="claim_id" class="col-sm-4 control-label">Drop-off file id</label>

                    <div class="col-sm-8">
                        <input id="claim_id" name="claim_id"  
                            type="text" class="form-control"
                            value="{{ old('claim_id') }}" required autocomplete="off"
                            placeholder="Claim ID" data-help="claim_id"/>

                        @if ($errors->has('claim_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('claim_id') }}</strong>
                            </span>
                        @endif
                        <span class="" id="claim_id_error"></span>
                    </div>
                </div>

                {{--Dropoff claim passcode--}}
                <div class="form-group{{ $errors->has('claim_passcode') ? ' has-error' : '' }}">
                    <label for="claim_passcode" class="col-sm-4 control-label">Drop-off file passcode</label>

                    <div class="col-sm-8">
                        <input id="claim_passcode" name="claim_passcode"  
                            type="text" class="form-control"
                            value="{{ old('claim_passcode') }}" required autocomplete="off" 
                            placeholder="Claim Passcode" data-help="claim_passcode" />

                        @if ($errors->has('claim_passcode'))
                            <span class="help-block">
                                <strong>{{ $errors->first('claim_passcode') }}</strong>
                            </span>
                        @endif
                        <span class="" id="claim_passcode_error"></span>
                    </div>
                </div>

                {{--Job title--}}
                <div class="form-group{{ $errors->has('job_title') ? ' has-error' : '' }}">
                    <label for="job_title" class="col-sm-4 control-label">Job title</label>

                    <div class="col-sm-8">
                        <input id="job_title" name="job_title"  
                            type="text" class="form-control"
                            value="{{ old('job_title') }}" required autocomplete="off" 
                            placeholder="Provide a meaningful name for your request" data-help="job_title" />
                        @if ($errors->has('job_title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('job_title') }}</strong>
                            </span>
                        @endif
                        <span class="" id="job_title_error"></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8 text-left">
                        <button id="submit" type="submit" class="btn btn-success">Submit</button>
                        <a class="btn btn-danger" href="/" >Cancel</a>
                        {{--<a class="btn btn-primary" href="/printingData/create" >Request a Workshop Print</a>--}}
                    </div>
                </div>
                
            </form>
        </div>
        <div class="col-sm-6 instructions">
            <div class="hint text-left is-active before-filling" data-hint="general">
                <h4 class="text-justify" style="color: red" >
                    Online 3D printing is primarily intended for print jobs that cannot be undertaken by students in the workshop.
                    If you are unable to complete a job using the open-access printers in the workshop and have been referred to
                    the online service, then you can follow the instructions below to submit your job.
                </h4>
                <h3 class="text-center lead">How to request a print using online service</h3>
                <p>Submit the Request form to the left providing all the necessary details. Click on each field of the
                form and read the detailed guidance on how to fill it.</p>
                <p>After the form is submitted it is redirected to the online job manager for initial check.</p>
                <p>After the check is complete you will receive an email from the manager with the estimated duration and
                    cost of your print.</p>
                <p>If you are happy with the estimated figures please reply to the manager confirming your order.</p>
            </div>

            <div class="hint text-left" data-hint="customer_email">
                <h3 class="text-center lead">Please provide your university email address</h3>
                <p>We need your University of Southampton email address in order to be able to communicate with you
                concerning your job request. After finishing this form you will be contacted by the online jobs manager
                    with the estimated cost and duration of your print.</p>
            </div>
            <div class="hint text-left" data-hint="customer_id">
                <h3 class="text-center lead">How to find out my student/staff ID?</h3>
                <p>Student ID is typically 9 digits long. Staff ID is typically 8 digits long. Do not forget to input
                    the whole ID number. It is schematically displayed in the picture below. </p>
                <div class="text-center">
                    <img src="/Images/studentID.svg" width="300" alt="studentID">
                </div>
            </div>
            <div class="hint text-left" data-hint="use_case">
                <h3 class="text-center lead">Project Code or Cost Code</h3>
                <p>If you are a student and your print is part of a project, please input the short abbreviation of your
                    module name or course. Note that course or module abbreviations must be in capital letters. The
                    system will recognise most of the standard modules that are registered with the workshop.</p>
                <p>If you are a PhD student, postdoc or an academic, please input the Cost Code that will be charged for
                    the current print. If in doubt or if you have any questions, please contact the demonstrator.</p>
                <p>If your abbreviation or cost code was not recognised, please contact our IT manager via email:
                    @foreach($it as $member)
                        <a href="mailto:{{ $member->email }}?Subject=Online job request issue" target="_top">
                            {{ $member->name() }}
                        </a>
                    @endforeach
                    .<br></p>
            </div>
            <div class="hint text-left" data-hint="claim_id">
                <h3 class="text-center lead">Drop-off claim id</h3>
                <p>To submit your 3D print request online you need to provide the drawing of your model in <b>.stl</b> format.</p>
                <p>We currently receive files uploaded via university drop-off service that can be accessed via the
                button below.</p>
                <p>On the drop-off website you need to <b>Login</b>, click <b>Drop-off</b> add
                    <b>Online Manager, 3dprint.soton@gmail.com</b> as your recipient and upload your files. 
                </p>
                <div>
                    <img class="align" src="/Images/icons/drop_off_manual.svg">
                </div>
                <div class="text-center text-bold">
                    <a href="{{ url('https://dropoff.soton.ac.uk') }}" target="_blank">In order to proceed to drop-off click here </a>
                </div>
            </div>
            <div class="hint text-left" data-hint="claim_passcode">
                <h3 class="text-center lead">Drop-off claim passcode</h3>
                <p>Copy and paste the drop-off passcode for file you have uploaded</p>
            </div>
            <div class="hint text-left" data-hint="budget_holder">
                <h3 class="text-center lead">Budget Holder</h3>
                <p>Please provide the name of the budget holder of the university cost code you entered.</p>
                <p>If you are unsure who is your the budget holder please ask Finance Office.</p>
            </div>
            <div class="hint text-left" data-hint="job_title">
                <h3 class="text-center lead">Job Title</h3>
                <p>Please provide a title for your print. This will appear to the module coordinator/ cost code budget holder as the cost of the print is claimed.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="/js/validate_form.js"></script>
@endsection
