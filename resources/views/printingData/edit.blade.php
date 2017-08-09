@extends('layouts.layout')

@section('content')
    <div class="title m-b-md">
        Job details
    </div>

    <div class="container well">
        <div class="row vdivide">
            <div class="col-sm-6 text-left job-details">
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
                        Module name or cost code: @if($job->use_case == 'Cost Code - approved') <b style="color: forestgreen"> @else <b style="color: red"> @endif {{$job->use_case}} </b><br>
                        Cost code: @if($job->use_case == 'Cost Code - approved') <b style="color: forestgreen"> @else <b style="color: red"> @endif {{$job->cost_code}} </b><br>
                        Comment: <b>{{$job->comment}}</b><br>
                        Job number: <b>{{$job->id}}</b><br>
                        Successful: <b>{{$job->successful}}</b>
                    </p>
                </div>
               
            </div>
            <div class="col-sm-6">
                <div id="reviewJob" class="text-center card">
                    <h4>Please check student input:</h4><br>
                    <form class="form-horizontal" role="form" method="POST" action="/printingData/edit/{{ $job->id }}">

                        {{ csrf_field() }}
                    {{--Edit the printing time --}}
                        @php( list($h, $i, $s) = explode(':', $job->time) )

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
                                <input type="text" id="material_amount" name="material_amount" value="{{ $job->material_amount }}" class="form-control">
                                    @if ($errors->has('material_amount'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('material_amount') }}</strong>
                                        </span>
                                    @endif
                                <span class="help-block" id="material_amount_error"></span>
                            </div>
                        </div>

                            <div class="form-group text-left">
                                <div class="radio">
                                    <input type="radio" name="successful" <?php if (isset($job->successful)
                                        && $job->successful=="Yes") echo "checked";?> value="Yes">Yes <br>
                                    <input type="radio" name="successful" <?php if (isset($job->successful)
                                        && $job->successful=="No") echo "checked";?> value="No">No <br>
                                </div> <!-- Class radio -->
                            </div> <!-- /form-group -->

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


