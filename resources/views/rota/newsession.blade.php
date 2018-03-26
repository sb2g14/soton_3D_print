@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Add a new session for {{$date}}
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 well">
                @foreach($events as $e)
                    <a href="/rota/event/update/{{$e->id}}" class="badge badge-{{$e->type}}"> {{$e->name}} </a>
                @endforeach
                @foreach($sessions as $s)
                    @php
                        $starttime = str_replace($date.' ',"",$s->start_date);
                        $endtime = str_replace($date.' ',"",$s->end_date);
                        $icon = 'lock';
                        if($s->public){
                            $icon = 'unlock';
                        }
                    @endphp
                    <div>
                        <form method="post" action="/rota/updatesession">
                            {{ csrf_field() }}
                            <input type="text" hidden name="date" id="date" value="{{$date}}" />
                            <input type="checkbox" name="public_{{$s->id}}" @php if($s->public){echo('checked');} @endphp value="{{$s->public}}" id="public_{{$s->id}}"> <span class="fa fa-fw fa-{{$icon}}"></span> 
                            <input type="text" name="start_time_{{$s->id}}" class="" id="start_time_{{$s->id}}" value="{{$starttime}}" /> -- 
                            <input type="text" name="end_time_{{$s->id}}" class="" id="end_time_{{$s->id}}" value="{{$endtime}}" /> 
                            (<input type="text" name="num_dem_{{$s->id}}" class="" id="num_dem_{{$s->id}}" value="{{$s->dem_required}}"/> demonstrators)
                            <button type="submit" name="btn_update" value="{{$s->id}}" id="submit_{{$s->id}}" class="btn btn-info">Update</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row">

            <div class="col-sm-12 text-left well">
            
                <form method="post" action="/rota/newsession">
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
    </script>
    <script src="/js/validate_form.js"></script>
@endsection

