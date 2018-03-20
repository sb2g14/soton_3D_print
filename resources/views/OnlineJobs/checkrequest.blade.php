@extends('layouts.layout')

@section('content')
    {{--<div class="title m-b-md">--}}
        {{--Manage Online Requests--}}
    {{--</div>--}}

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
                        Cost code: @if($job->use_case == 'Cost Code - approved') <b style="color: forestgreen"> {{$job->cost_code}} @elseif($job->use_case == 'Cost Code - unknown')</b> <b style="color: red"> {{$job->cost_code}} @else <b style="color: forestgreen"> {{$job->use_case}} @endif  </b><br>
                        Budget Holder: <b> {{ $job->budget_holder }} </b> <br>
                        Job Title: <b> {{ $job->job_title }} </b><br>
                        Job number: <b>{{$job->id}}</b><br>
                    </p>
                    <a class="btn btn-primary" href="https://dropoff.soton.ac.uk/pickup.php?claimID=
                                                 {{$job->claim_id}}&claimPasscode={{$job->claim_passcode}}
                            &emailAddr=3dprint.soton%40gmail.com">Download .stl files</a>
                </div>
            </div>

            {{--Assign print previews to a requested job--}}
            <div class="col-sm-6 text-left">
                <ul class="list-group lsn">
                    {{--List assigned prints--}}
                    @foreach($job->prints as $print)
                        <li class="alert alert-info text-left">
                            <a type="button" class="close" style="color: red" data-placement="top" data-toggle="popover"
                               data-trigger="hover" data-content="Delete this print-preview"
                                    href="/OnlineJobs/DeletePrintPreview/{{$print->id}}">&times;</a>
                            <p>
                                Preview: <b>{{ $print->id }}</b>
                                Time: <b>{{ $print->time }}</b>
                                Material amount: <b>{{$print->material_amount}}g</b>
                                Price: <b>£{{$print->price}}</b>
                            </p>
                        </li>
                    @endforeach
                </ul>
                <h3>Total job stats</h3>
                {{-- Calculate total print time --}}
                @php
                    $total_minutes = 0;
                    foreach ($job->prints as $print){
                    list($h, $i, $s) = explode(':', $print->time);
                    $minutes = $h*60 + $i;
                    $total_minutes = $total_minutes + $minutes;
                    }
                    $total_time = round($total_minutes/60).':'.sprintf('%02d', $total_minutes%60);
                @endphp
                <p>Total job duration: <b>{{ $total_time }}</b> <br>
                Total material amount: <b>{{ $job->prints->sum('material_amount') }}g</b> <br>
                Total price: <b>£{{ $job->prints->sum('price') }}</b>
                </p>
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
        </div>
        {{--Job control buttons--}}
        <div class="col-sm-12 text-center">
            <span class="text-justify" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="You should specify at least
            one print-preview in each job. Each print-preview is used to calculate printing cost only and is separate
            entity from the actual print.">
                <a class="btn btn-lg btn-info" data-toggle="modal" data-target="#addPrintModal">Add print preview</a>
            </span>

            <a href="/OnlineJobs/index" class="btn btn-lg btn-primary">Back</a>

            <span data-placement="top" data-toggle="popover" data-trigger="hover" data-content="If you think that the requested
            job cannot be printed for some reason, please click on this button and provide an explanation for the customer.">
            <button class="btn btn-lg btn-danger" data-toggle="modal" data-target="#jobReject">Reject a job</button></span>

            @if($job->prints->isEmpty())
                <a href="#" class="btn btn-lg btn-success" data-placement="top" data-toggle="popover" data-trigger="hover"
                   data-content="You cannot approve this job if no print-previews have been created." disabled>Approve job</a>
            @else
            <a href="/OnlineJobs/approveRequest/{{ $job->id }}" class="btn btn-lg btn-success"
               data-placement="top" data-toggle="popover" data-trigger="hover"
               data-content="You may approve this job now. When you do so the total job stats will be sent to a customer for
               approval.">Approve job</a>
            @endif
        </div>
    </div>

    <!-- Modal assign prints-->
    <div id="addPrintModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title text-center">Specify the print details below</h3>
                </div>
                {{--Modal body--}}
                <div class="modal-body text-left">

                    {{--Form to specify material amount and duration of each print--}}
                    <form class="form-horizontal" role="form" method="POST" action="/OnlineJobs/checkrequest/{{ $job->id }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
                            {!! Form::label('hours', 'Printing Time (h:m)', ['class' => 'col-sm-4 control-label'] )  !!}
                            <div class="col-sm-2">
                                {!! Form::select('hours', array('' => 'Hours') + range(0,59),old('hours'), ['class' => 'form-control','required', 'data-help' => 'hours', 'id' => 'hours']) !!}
                                @if ($errors->has('hours'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hours') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-2">
                                {!! Form::select('minutes', array('' => 'Minutes') + range(0,59),old('minutes'), ['class' => 'form-control','required', 'data-help' => 'minutes', 'id' => 'minutes']) !!}
                                @if ($errors->has('minutes'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('minutes') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <span class="help-block" id="time_error"></span>
                        </div>

                        <div class="form-group{{ $errors->has('material_amount') ? ' has-error' : '' }}">
                            <label for="material_amount" class="col-sm-4 control-label">Estimated material amount (grams):</label>
                            <div class="col-sm-6">
                                <input type="text" id="material_amount" name="material_amount" value="{{old('material_amount')}}" class="form-control">
                                @if ($errors->has('material_amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('material_amount') }}</strong>
                                    </span>
                                @endif
                                <span class="help-block" id="material_amount_error"></span>
                            </div>
                        </div>

                        <button id="submit" type="submit" class="btn btn-lg btn-primary">Submit</button>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal add comment to a rejected job-->
    <div id="jobReject" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title text-center">Please explain why this job was rejected</h3>
                </div>
                {{--Modal body--}}
                <div class="modal-body text-left">

                    {{--Form to add a coment to a rejected job--}}
                    <form class="form-horizontal" role="form" method="POST" action="/OnlineJobs/delete/{{ $job->id }}">
                        {{ csrf_field() }}

                        <div class="form-group text-left">
                            <div class="col-md-12">
                                <label for="comments">Add comments for the customer:</label><br>
                                <textarea rows="4" id="message_long" name="comment" placeholder="Please explain why the job was rejected" class="form-control"></textarea>
                                @if ($errors->has('comments'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comments') }}</strong>
                                    </span>
                                @endif
                                <span class="help-block" id="message_long_error"></span>
                            </div>
                        </div>

                        <button id="reject" type="submit" class="btn btn-lg btn-primary">Submit</button>
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
    <script src="/js/validate_form_online_print.js"></script>
    <script src="/js/validate_form_online_job_reject.js"></script>
@endsection


