@extends('layouts.layout')

@section('content')
    <div class="title m-b-md">
        Manage Online Requests
    </div>

    @php($print = $job->prints->first())

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
                        Module name or cost code:
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
                <h3>Total job stats</h3>
                <p>Total job duration: <b>value</b> <br>
                    Total material amount: <b>value</b> <br>
                    Total price: <b>value</b>
                </p>
                <div>
                    <button class="btn btn-lg btn-info btn-issue" data-toggle="modal" data-target="#addPrintModal">Add a print preview</button>
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
                                        {!! Form::label('hours', 'Printing Time (h:m)', ['class' => 'col-lg-4 control-label'] )  !!}
                                        <div class="col-md-2">
                                            {!! Form::select('hours', range(0,59),old('hours'), ['class' => 'form-control','required', 'data-help' => 'hours', 'id' => 'hours']) !!}
                                            @if ($errors->has('hours'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('hours') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::select('minutes', range(0,59),old('minutes'), ['class' => 'form-control','required', 'data-help' => 'minutes', 'id' => 'minutes']) !!}
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
                                            <input type="text" id="material_amount" name="material_amount" value="{{old('material_amount')}}" class="form-control">
                                            @if ($errors->has('material_amount'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('material_amount') }}</strong>
                                                </span>
                                            @endif
                                                <span class="help-block" id="material_amount_error"></span>
                                        </div>
                                    </div>

                                    <div class="form-group text-left">
                                        <div class="col-md-12">
                                            <label for="comments">Add comments to be seen by a customer (optional):</label><br>
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
                <ul class="list-group lsn">
                    {{--List assigned prints--}}
                    @foreach($job->prints as $print)
                        <li class="text-left well-sm">
                            <p>
                                Time: <b>{{ $print->time }}</b>
                                Material amount: <b>{{$print->material_amount}}</b>
                                Price: <b>{{$print->price}}</b>
                            </p>
                        </li>
                    @endforeach
                </ul>

                {{--Job control buttons--}}
                <div class="col-sm-12 text-left">
                    <a href="/OnlineJobs/approvedRequests" class="btn btn-lg btn-primary">Accept job</a>
                    <a href="/OnlineJobs/delete/{{$job->id}}" class="btn btn-lg btn-danger">Reject job</a>
                    <a href="/OnlineJobs/index" class="btn btn-lg btn-info">Back</a>
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


