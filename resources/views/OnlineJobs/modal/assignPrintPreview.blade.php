<!-- Modal assign print Preview-->
<div id="addPrintPreviewModal" class="modal fade" role="dialog">
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
                <form class="form-horizontal" role="form" method="POST" action="/OnlineJobs/requests/{{ $job->id }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
                        {!! Form::label('hours', 'Printing Time (h:m)', ['class' => 'col-sm-4 control-label'] )  !!}
                        <div class="col-sm-2">
                            {!! Form::select('hours', array('' => 'Hours') + range(0,59),old('hours'), 
                                ['class' => 'form-control',
                                 'required', 
                                 'data-help' => 'hours', 
                                 'id' => 'hours']) !!}
                            @if ($errors->has('hours'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('hours') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-sm-2">
                            {!! Form::select('minutes', array('' => 'Minutes') + range(0,59),old('minutes'), 
                                ['class' => 'form-control',
                                 'required', 
                                 'data-help' => 'minutes', 
                                 'id' => 'minutes']) !!}
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

                    <button id="assignPrint" type="submit" class="btn btn-lg btn-primary">Submit</button>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
