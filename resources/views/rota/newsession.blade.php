@extends('layouts.layout')
@section('content')
    {{--TITLE--}}
    <div class="title m-b-md">
        Edit rota for {{ Carbon\Carbon::parse($date)->format('D, dS \\of M Y') }}
    </div>
    {{--NAVIGATION--}}
    <div class="container">
        <div class="pull-left">
            <a type="button" class="btn btn-primary" href="/rota">View latest sessions</a>
        </div>
    </div>
    {{--CONTENT--}}
    <div class="container">
        <div class="row">
            <div class="col-sm-12"> 
                <!--SHOW EVENTS ON THIS DATE AS BADGES-->
                @foreach($events as $e)
                    <a class="badge badge-{{$e->type}}" href="/rota/event/update/{{$e->id}}"> {{$e->name}} </a>
                @endforeach
                <br/>
            </div>
            @if(count($sessions)>0)
                <div class="col-sm-12 well">
                    <!--SHOW EXISTING SESSIONS FOR UPDATE-->
                    Sessions this day:<br/>
                    @foreach($sessions as $s)
                        @php
                            $starttime = str_replace($date.' ',"",$s->start_date);
                            $endtime = str_replace($date.' ',"",$s->end_date);
                            $icon = 'lock';
                            if($s->public){
                                $icon = 'globe';
                            }
                        @endphp
                        <div>
                            <form method="post" action="/rota/updatesession" class="form-inline">
                                {{ csrf_field() }}
                                <input type="date" hidden name="date" id="date" value="{{$date}}" />
                                <div class="row">
                                    <div class="col-sm-2 form-group">
                                        <label for="public_{{$s->id}}" class="sr-only">Public Session</label>
                                        <input id="public_{{$s->id}}" name="public_{{$s->id}}" 
                                            type="checkbox" 
                                            value="{{$s->public}}" @php if($s->public){echo('checked');} @endphp 
                                            alt="if checked, then this session will be shown as public." /> 
                                        <span class=""><i id="public_{{$s->id}}_icn" class="fa fa-fw fa-{{$icon}}"></i></span>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <div class="col-sm-5">
                                            <label for="start_time_{{$s->id}}" class="sr-only">Start of Session</label>
                                            <input id="start_time_{{$s->id}}" name="start_time_{{$s->id}}" 
                                                type="time" class="form-control input-sm" 
                                                value="{{$starttime}}" /> 
                                        </div> 
                                        <div class="col-sm-1">
                                            &ndash;
                                        </div>
                                        <div class="col-sm-5">
                                            <label for="end_time_{{$s->id}}" class="sr-only">End of Session</label>
                                            <input id="end_time_{{$s->id}}" name="end_time_{{$s->id}}" 
                                                type="time" class="form-control input-sm" 
                                                value="{{$endtime}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <span class="text-justify" data-placement="top" data-toggle="popover"
                                            data-trigger="hover" data-content="Number of demonstrators required for this session">
                                            <label for="num_dem_{{$s->id}}" class="sr-only">Number of Demonstrators</label>
                                            <div class="input-group">  
                                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                                <input id="num_dem_{{$s->id}}" name="num_dem_{{$s->id}}" 
                                                    type="number" class="form-control input-sm col-sm-2"
                                                    value="{{$s->dem_required}}" /> 
                                            </div>
                                        </span>
                                    </div>
                                    <div class="col-sm-2 btn-group">
                                        <button id="submit_{{$s->id}}" name="btn_update" 
                                            type="submit" class="btn btn-success" 
                                            value="{{$s->id}}">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                        <a name="btn_delete" class="btn btn-danger" 
                                            href="/rota/session/delete/{{$s->id}}">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div><br/>
                    @endforeach
                </div>
            @endif
        </div>
        <!--SHOW FORM TO ADD A NEW SESSION-->
        <div class="row">

            <div class="col-sm-12 text-left well">
            
                <form method="post" action="/rota/session/new">
                    {{--Generate security key --}}
                    {{ csrf_field() }}
                    <input id="date" name="date" type="text" value="{{$date}}" hidden />
                    <div id="start_time_group">
                        <label for="start_time">Start of Session: </label> <br/>
                        <input id="start_time" name="start_time" 
                            type="time" class="form-control" 
                            value="{{$newstarttime}}" required>
                        <span class="" id="start_time_error"></span> <br/>
                    </div>
                    <div id="end_time_group">
                        <label for="end_time">End of Session: </label> <br/>
                        <input id="end_time" name="end_time" 
                            type="time" class="form-control" 
                            value="{{$newendtime}}" required="true"/>
                        <span class="" id="end_time_error"></span><br/>
                    </div>
                    <div id="num_dem_group">
                        <label for="number_of_demonstrators">Demonstrators required: </label> <br/>
                        <input id="num_dem" name="number_of_demonstrators" 
                            type="number" class="form-control" 
                            value="2"/>
                        <span class="" id="num_dem_error"></span><br/>
                    </div>
                    <div id="session_public_group">
                        <label for="body">Can this session be attended by any student, or is it a private session (e.g. for training first years)?</label> <br>
                        <div class="form-group text-left">
                            <div class="radio">
                                <input name="session_public" type="radio" value="isPublic" checked />
                                <i class="fa fa-fw fa-globe"></i> Yes (show this session as an opening time for customers)<br/>
                                <input name="session_public" type="radio" value="isPrivate" />
                                <i class="fa fa-fw fa-lock"></i> No (this session is only visible to staff)<br/>
                            </div> <!-- Class radio -->
                        </div> <!-- /form-group -->
                    </div>
                    @include('layouts.errors')
                    <div class="col-sm-12 text-center">
                        <button id="submit" type="submit" class="btn btn-lg btn-success">Add Session</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('#start_time').datetimepicker({format:'HH:mm',showTodayButton:false,showClear:false,showClose:true});
            $('#end_time').datetimepicker({format:'HH:mm',showTodayButton:false,showClear:false,showClose:true});
            $("#start_time").on("dp.change", function (e) {
                $('#end_time').data("DateTimePicker").minDate(e.date);
            });
            $("#end_time").on("dp.change", function (e) {
                $('#start_time').data("DateTimePicker").maxDate(e.date);
            });
            @foreach($sessions as $s)
                $('#start_time_{{$s->id}}').datetimepicker({format:'HH:mm',showTodayButton:false,showClear:false,showClose:true});
                $('#end_time_{{$s->id}}').datetimepicker({format:'HH:mm',showTodayButton:false,showClear:false,showClose:true});
                $("#start_time_{{$s->id}}").on("dp.change", function (e) {
                    $('#end_time_{{$s->id}}').data("DateTimePicker").minDate(e.date);
                });
                $("#end_time_{{$s->id}}").on("dp.change", function (e) {
                    $('#start_time_{{$s->id}}').data("DateTimePicker").maxDate(e.date);
                });
            @endforeach
        });
        $("input").change(function() {
            $id = $(this).attr('id');
            $spanid = "#".concat($id.concat("_icn"));
            $id = "#".concat($id);
            console.log($spanid);
            if($($id).is(":checked")){
                $($spanid).removeClass("fa-lock");
                $($spanid).addClass("fa-globe");
            }else{
                $($spanid).removeClass("fa-unlock");
                $($spanid).removeClass("fa-globe");
                $($spanid).addClass("fa-lock");
            }
        });
    </script>
    <script src="/js/validate_form.js"></script>
@endsection

