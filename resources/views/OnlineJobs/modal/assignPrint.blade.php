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
                <form class="form-horizontal" role="form" method="POST" action="/OnlineJobs/pending/{{$job->id}}">
                    {{ csrf_field() }}

                    {{--Select a printer--}}
                    <div class="form-group {{ $errors->has('printers_id') ? ' has-error' : '' }}">
                        {{--This is a Printer Number dropdown--}}
                        {!! Form::label('printers_id', 'Printer Number', ['class' => 'col-sm-4 control-label'] )  !!}
                        <div class="col-sm-4">
                            {!! Form::select('printers_id', array('' => 'Select Available Printer') + $available_printers,  old('printers_id'), 
                                ['class' => 'form-control',
                                 'required', 
                                 'data-help' => 'printers_id', 
                                 'id' => 'printers_id']
                                ) !!}
                            @if ($errors->has('printers_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('printers_id') }}</strong>
                                </span>
                            @endif
                        </div>
                        <span class="" id="printers_id_error"></span>
                    </div>

                    <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
                        {!! Form::label('hours', 'Printing Time (h:m)', ['class' => 'col-sm-4 control-label'] )  !!}
                        <div class="col-sm-2">
                            {!! Form::select('hours', array('' => 'Hours') + range(0,59),old('hours'), 
                                ['class' => 'form-control','required', 'data-help' => 'hours', 'id' => 'hours']) !!}
                            @if ($errors->has('hours'))
                                <span class="help-block">
                                                <strong>{{ $errors->first('hours') }}</strong>
                                            </span>
                            @endif
                        </div>
                        <div class="col-sm-2">
                            {!! Form::select('minutes', array('' => 'Minutes') + range(0,59),old('minutes'), 
                                ['class' => 'form-control','required', 'data-help' => 'minutes', 'id' => 'minutes']) !!}
                            @if ($errors->has('minutes'))
                                <span class="help-block">
                                                <strong>{{ $errors->first('minutes') }}</strong>
                                            </span>
                            @endif
                        </div>
                        <span class="" id="time_error"></span>
                    </div>

                    <div class="form-group{{ $errors->has('material_amount') ? ' has-error' : '' }}">
                        <label for="material_amount" class="col-sm-4 control-label">Estimated material amount (grams):</label>
                        <div class="col-sm-4">
                            <input type="text" id="material_amount" name="material_amount" value="{{old('material_amount')}}" class="form-control">
                        </div>
                        @if ($errors->has('material_amount'))
                            <div class="col-sm-4 help-block">
                                <strong>{{ $errors->first('material_amount') }}</strong>
                            </div>
                        @endif
                        <span class="" id="material_amount_error"></span>
                    </div>

                    <!-- Select Multiple Jobs to be assigned to the print -->
                    <div class="form-group">
                        {!! Form::label('multipleselect[]', 'Select one or many pending jobs', ['class' => 'col-sm-4 control-label'] )  !!}
                        <div class="col-sm-4">
                            {!!  Form::select('multipleselect[]', $jobs_in_progress, $selected = $job->id, 
                                ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'jobs_id']) !!}
                            @if ($errors->has('multipleselect'))
                                <span class="help-block">
                                                <strong>{{ $errors->first('multipleselect') }}</strong>
                                            </span>
                            @endif
                            <span class="" id="multipleselect"></span>
                        </div>
                    </div>
                    {{--Add comment to the print--}}
                    <div class="form-group text-left">
                        <div class="col-sm-12">
                            <label for="comments">Add comments to the print:</label><br>
                            <textarea id="comment" name="comments" 
                                rows="4" class="form-control" 
                                placeholder="Please add any comments to this job if relevant"></textarea>
                            @if ($errors->has('comments'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('comments') }}</strong>
                                </span>
                            @endif
                            <span class="" id="comment_error"></span>
                        </div>
                    </div>

                    <button id="assignPrint" type="submit" class="btn btn-lg btn-success">Submit</button>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
