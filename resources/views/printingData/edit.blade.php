@extends('layouts.layout')

@section('content')
    <div class="title m-b-md">
        Job details
    </div>

    @php $print = $job->prints->first()
    @endphp

    <div class="container well">
        <div class="row vdivide">
            <div class="col-sm-6 text-left job-details">
                <div class="alert alert-info text-left">
                    <p>
                        Printer number: <b>{{ $print->printers_id }}</b><br>
                        Printer serial number: <b>{{ $print->printer->serial_no }}</b><br>
                        Requested on: <b>{{ $job->created_at->toDayDateTimeString() }}</b><br>
                        Requested by: <b>{{$job->customer_name}}</b><br>
                        Requester id: <b>{{$job->customer_id}}</b><br>
                        Requester email: <b>{{$job->customer_email}}</b><br>
                        Payment category: <b>{{$job->payment_category}}</b><br>
                        Estimated duration: <b>{{$job->total_duration}}</b><br>
                        Estimated material amount: <b>{{$job->total_material_amount}} grams</b><br>
                        Estimated price: <b>£{{$job->total_price}}</b><br>
                        Cost code: @if($job->use_case == 'Cost Code - approved') <b style="color: forestgreen"> {{$job->cost_code}} @elseif($job->use_case == 'Cost Code - unknown')</b> <b style="color: red"> {{$job->cost_code}} @else <b style="color: forestgreen"> {{$job->use_case}} @endif </b><br>
                        Comment: <b>{{$job->job_approved_comment}}</b><br>
                        Job number: <b>{{$job->id}}</b><br>
                        Job title: <b>{{$job->job_title}}</b>
                        Status: <b>{{$job->status}}</b>
                    </p>
                </div>
               
            </div>
            <div class="col-sm-6">
                <div id="reviewJob" class="text-center card">
                    <h4>Please update the following information:</h4><br>
                    <form class="form-horizontal" role="form" method="POST" action="/printingData/edit/{{ $job->id }}">

                        {{ csrf_field() }}
                    {{--Edit the printing time --}}
                        @php list($h, $i, $s) = explode(':', $job->total_duration)
                        @endphp

                        <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
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
                                <input type="text" id="material_amount" name="material_amount" value="{{ $job->total_material_amount }}" class="form-control">
                                    @if ($errors->has('material_amount'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('material_amount') }}</strong>
                                        </span>
                                    @endif
                                <span class="help-block" id="material_amount_error"></span>
                            </div>
                        </div>

                            <label for="successful" class="col-md-4 control-label">Was the job successful?</label>
                            <div class="form-group text-left">
                                <div class="radio">
                                    <label class="radio-inline"><input type="radio" name="successful" <?php if (isset($job->status)
                                            && $job->status=="Success") echo "checked";?> value="Success">Yes </label>
                                    <label class="radio-inline"><input type="radio" name="successful" <?php if (isset($job->status)
                                            && $job->status=="Failed") echo "checked";?> value="Failed">No </label><br>
                                </div> <!-- Class radio -->
                            </div> <!-- /form-group -->

                        <div class="col-sm-12 text-left">
                                <button id="submit" type="submit" class="btn btn-success">Save</button>
                                {{--<a href="/printingData/delete/{{$job->id}}" class="btn btn-lg btn-danger">Reject</a>--}}
                                <a href="/printingData/finished" class="btn btn-danger">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/validate_form.js"></script>
@endsection


