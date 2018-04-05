@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Add a new session for {{ Carbon\Carbon::parse($date)->format('D, dS \\of M Y') }}
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 well">
                <!--SHOW EVENTS ON THIS DATE AS BADGES-->
                @foreach($events as $e)
                    <a href="/rota/event/update/{{$e->id}}" class="badge badge-{{$e->type}}"> {{$e->name}} </a>
                @endforeach
                <!--SHOW EXISTING SESSIONS FOR UPDATE-->
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
                        <form method="post" action="/rota/updatesession">
                            {{ csrf_field() }}
                            <input type="text" hidden name="date" id="date" value="{{$date}}" />
                            <input type="checkbox" id="public_{{$s->id}}" name="public_{{$s->id}}" value="{{$s->public}}" alt="if checked, then this session will be shown as public." @php if($s->public){echo('checked');} @endphp  > <span id="public_{{$s->id}}_icn" class="fa fa-fw fa-{{$icon}}"></span> 
                            <input type="text" name="start_time_{{$s->id}}" class="" id="start_time_{{$s->id}}" value="{{$starttime}}" /> -- 
                            <input type="text" name="end_time_{{$s->id}}" class="" id="end_time_{{$s->id}}" value="{{$endtime}}" /> 
                            (<input type="text" name="num_dem_{{$s->id}}" class="" id="num_dem_{{$s->id}}" value="{{$s->dem_required}}"/> demonstrators)
                            <button type="submit" name="btn_update" value="{{$s->id}}" id="submit_{{$s->id}}" class="btn btn-info">Update</button>
                            <a name="btn_delete" href="/rota/session/delete/{{$s->id}}" class="btn btn-danger">Delete</a>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
        <!--SHOW FORM TO ADD A NEW SESSION-->
        <div class="row">

            <div class="col-sm-12 text-left well">
            
                <form method="post" action="/rota/session/new">
                    {{--Generate security key --}}
                    {{ csrf_field() }}
                    <input type="text" hidden name="date" id="date" value="{{$date}}" />
                    <label for="start_time">Start of Session: </label> <br>
                    <input type="text" name="start_time" class="form-control" id="start_time" value="{{$newstarttime}}" />
                    <td><span class="" id="start_time_error"></span> </td> <br>
                    <label for="end_time">End of Session: </label> <br>
                    <input type="text" name="end_time" class="form-control" id="end_time" value="{{$newendtime}}"/>
                    <td><span class="" id="end_time_error"></span> </td> <br>
                    <label for="num_dem">Demonstrators required: </label> <br>
                    <input type="text" name="num_dem" class="form-control" id="num_dem" value="2"/>
                    <td><span class="" id="num_dem_error"></span> </td> <br>
                    <label for="body">Can this session be attended by anyone?</label> <br>
                    <!-- Radio list for the printer status -->
                    <div class="form-group text-left">
                        <div class="radio">
                            <input type="radio" name="session_public" checked value="isPublic">Yes <br>
                            <input type="radio" name="session_public" value="isPrivate">No <br>
                        </div> <!-- Class radio -->
                    </div> <!-- /form-group -->
                    
                    @include('layouts.errors')
                    <button type="submit" id="submit" class="btn btn-lg btn-success">Add Session</button>
                    <a href="/rota" class="btn btn-lg btn-primary">View latest sessions</a>
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
            @foreach($sessions as $s)
                $('#start_time_{{$s->id}}').datetimepicker({format:'HH:mm',showTodayButton:false,showClear:false,showClose:true});
                $('#end_time_{{$s->id}}').datetimepicker({format:'HH:mm',showTodayButton:false,showClear:false,showClose:true});
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

