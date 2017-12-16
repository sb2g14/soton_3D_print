@extends('layouts.layout')

@section('content')
    <div class="title m-b-md">
        Review job {{ $job->id }}
    </div>

    <div class="container well">
        <div class="row vdivide">

            {{--Review the request information and download the .stl files--}}
            <div class="col-sm-6 text-left job-details">
                <div class="alert alert-info text-left">
                    <p>
                        Requested on: <b>{{ $job->created_at->toDayDateTimeString() }}</b><br>
                        Requested by: <b>{{$job->customer_name}}</b><br>
                        Requester id: <b>{{$job->customer_id}}</b><br>
                        Requester email: <b>{{$job->customer_email}}</b><br>
                        Payment category: <b>{{$job->payment_category}}</b><br>
                        Project name:
                        @if($job->use_case == 'Cost Code - approved')
                            <b style="color: forestgreen">
                                @elseif($job->use_case == 'Cost Code - unknown')
                                    <b style="color: red">
                                        @endif {{$job->use_case}}
                                    </b><br>
                                    Cost code:
                                    @if($job->use_case == 'Cost Code - approved')
                                        <b style="color: forestgreen">
                                            @elseif($job->use_case == 'Cost Code - unknown')
                                                <b style="color: red">
                                                    @endif {{$job->cost_code}}
                                                </b><br>
                                                Job number: <b>{{$job->id}}</b><br>
                    </p>
                    <a class="btn btn-danger" href="https://dropoff.soton.ac.uk/pickup.php?claimID=
                                                 {{$job->claim_id}}&claimPasscode={{$job->claim_passcode}}
                            &emailAddr=3DPrintFEE%40soton.ac.uk">Download .stl files</a>
                </div>
            </div>

            {{--Assign prints to a requested job--}}
            <div class="col-sm-6 text-left">

                <!-- Modal assign prints-->
                <div id="addPrintModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title text-center">Create New Print</h3>
                            </div>
                            {{--Modal body--}}
                            <div class="modal-body text-left">

                                {{--Form to specify material amount and duration of each print--}}
                                <form class="form-horizontal" role="form" method="POST" action="/OnlineJobs/managePendingJob/{{$job->id}}">
                                    {{ csrf_field() }}

                                    {{--Select a printer--}}
                                    <div class="form-group {{ $errors->has('printers_id') ? ' has-error' : '' }}">
                                        {{--This is a Printer Number dropdown--}}
                                        <div class="col-lg-4">
                                            {!! Form::label('printers_id', 'Printer Number', ['class' => 'col-lg-4 control-label'] )  !!}
                                            <div class="col-md-6">
                                                {!! Form::select('printers_id', array('' => 'Select Available Printer') + $available_printers,  old('printers_id'), ['class' => 'form-control','required', 'data-help' => 'printers_id', 'id' => 'printers_id']) !!}
                                                @if ($errors->has('printers_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('printers_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
                                        {!! Form::label('hours', 'Printing Time (h:m)', ['class' => 'col-lg-4 control-label'] )  !!}
                                        <div class="col-md-4">
                                            {!! Form::select('hours', array('' => 'Hours') + range(0,59),old('hours'), ['class' => 'form-control','required', 'data-help' => 'hours', 'id' => 'hours']) !!}
                                            @if ($errors->has('hours'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('hours') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            {!! Form::select('minutes', array('' => 'Minutes') + range(0,59),old('minutes'), ['class' => 'form-control','required', 'data-help' => 'minutes', 'id' => 'minutes']) !!}
                                            @if ($errors->has('minutes'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('minutes') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('material_amount') ? ' has-error' : '' }}">
                                        <label for="material_amount" class="col-md-4 control-label">Estimated material amount (grams):</label>
                                        <div class="col-lg-2">
                                            <input type="text" id="material_amount" name="material_amount" value="{{old('material_amount')}}" class="form-control">
                                            @if ($errors->has('material_amount'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('material_amount') }}</strong>
                                                </span>
                                            @endif
                                            <span class="help-block" id="material_amount_error"></span>
                                        </div>
                                    </div>

                                    <!-- Select Multiple Jobs to be assigned to the print -->
                                    <div class="form-group">
                                        {!! Form::label('multipleselect[]', 'Select one or many pending jobs', ['class' => 'col-lg-2 control-label'] )  !!}
                                        <div class="col-lg-10">
                                            {!!  Form::select('multipleselect[]', $jobs_in_progress, $selected = $job->id, ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'jobs_id']) !!}
                                            @if ($errors->has('multipleselect'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('multipleselect') }}</strong>
                                                </span>
                                            @endif
                                            <span class="help-block" id="multipleselect"></span>
                                        </div>
                                    </div>

                                    <div class="form-group text-left">
                                        <div class="col-md-12">
                                            <label for="comments">Add comments to the print:</label><br>
                                            <textarea rows="4" id="message" name="comments" placeholder="Please add any comments to this job if relevant" class="form-control"></textarea>
                                            @if ($errors->has('comments'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('comments') }}</strong>
                                                </span>
                                            @endif
                                            <span class="help-block" id="message_error"></span>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 text-left">
                                        <button id="submit" type="submit" class="btn btn-lg btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                    {{--List assigned prints--}}
                    @foreach($job->prints as $print)
                    @php list($h, $i, $s) = explode(':', $print->time);
                        $time_finish = $print->created_at->addHour($h)->addMinutes($i);
                    @endphp
                        <div class="alert alert-warning">
                            <p>
                                Print: <b>{{ $print->id }}</b> on Printer <b> {{ $print->printers_id }} </b> started <b> {{ $print->created_at->diffForHumans() }}</b> by <b>{{ $print->staff_started->first_name }} {{ $print->staff_started->last_name }}</b>
                                Material amount: <b>{{$print->material_amount}}g</b>
                                Total Time: <b>{{ $print->time }}</b>
                                Time Remain: <b>@if (Carbon\Carbon::now('Europe/London')->gte($time_finish) || $print->status == 'Success' || $print->status == 'Failed')  completed  @else {{ $time_finish->diffInHours(Carbon\Carbon::now('Europe/London')) }}:{{ sprintf('%02d', $time_finish->diffInMinutes(Carbon\Carbon::now('Europe/London'))%60)}} @endif</b>
                                Status: <b> {{ $print->status }} </b>
                            </p>
                        </div>
                    @endforeach
                {{--<h3>Total job stats</h3>--}}
                {{-- Calculate total print time --}}
                {{--@php--}}
                    {{--$total_minutes = 0;--}}
                    {{--foreach ($job->prints as $print){--}}
                    {{--list($h, $i, $s) = explode(':', $print->time);--}}
                    {{--$minutes = $h*60 + $i;--}}
                    {{--$total_minutes = $total_minutes + $minutes;--}}
                    {{--}--}}
                    {{--$total_time = round($total_minutes/60).':'.sprintf('%02d', $total_minutes%60);--}}
                {{--@endphp--}}
                {{--<p>Total job duration: <b>{{ $total_time }}</b> <br>--}}
                    {{--Total material amount: <b>{{ $job->prints->sum('material_amount') }}g</b> <br>--}}
                    {{--Total price: <b>£{{ $job->prints->sum('price') }}</b>--}}
                {{--</p>--}}
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input. Please return to fix them.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            {{--Job control buttons--}}
            <div class="col-sm-12 text-center">
                <button class="btn btn-lg btn-warning btn-issue" data-toggle="modal" data-target="#addPrintModal">Assign Prints</button>
                <a href="/OnlineJobs/pending" class="btn btn-lg btn-info">Back</a>
                <button class="btn btn-lg btn-danger" data-toggle="modal" data-target="#jobReject">Job Failed</button>

                @if($query_in_progress == null & $query_success !== null)
                    <a href="/OnlineJobs/jobSuccess/{{$job->id}}" class="btn btn-lg btn-success">Job Completed</a>
                @else
                    <a href="#" class="btn btn-lg btn-success" disabled>Job Completed</a>
                @endif

            </div>
        </div>
    </div>

    <!-- Modal add comment to a failed job-->
    <div id="jobReject" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title text-center">Please explain why this job has failed</h3>
                </div>
                {{--Modal body--}}
                <div class="modal-body text-left">

                    {{--Form to add a coment to a rejected job--}}
                    <form class="form-horizontal" role="form" method="POST" action="/OnlineJobs/jobFailed/{{ $job->id }}">
                        {{ csrf_field() }}

                        <div class="form-group text-left">
                            <div class="col-md-12">
                                <label for="comments">Add comments for the customer:</label><br>
                                <textarea rows="4" id="message" name="comment" placeholder="Please explain why the job has failed" class="form-control"></textarea>
                                @if ($errors->has('comments'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comments') }}</strong>
                                    </span>
                                @endif
                                <span class="help-block" id="message_error"></span>
                            </div>
                        </div>

                        <div class="col-sm-12 text-left">
                            <button id="submit" type="submit" class="btn btn-lg btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    <script src="/js/print_preview_validation.js"></script>
@endsection

