@extends('layouts.layout')
@section('content')
    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
            {{ $flash }}
        </div>
    @endif
    {{--TITLE--}}
    <div class="text-center m-b-md">
        <div class="title">Latest Sessions</div>    
    </div>
    {{--NAVIGATION--}}
    <div class="container">
        <div class="pull-right">
            <span class="text-justify" data-placement="top" data-toggle="popover"
                data-trigger="hover" data-content="Indicate when you are available, so you can be assigned for a session.">
                <a type="button" class="btn btn-info" href="/rota/availability">Indicate Availability</a>
            </span>
        </div>
        @can('staff_manage')
            <div class="col-lg-2 pull-right">
                <span class="text-justify" data-placement="top" data-toggle="popover"
                    data-trigger="hover" data-content="Add special university dates or workshop events here.">
                    <a type="button" class="btn btn-success" href="/rota/event/new">Add Event</a>
                </span>
            </div>
             <div class="col-lg-4 pull-right">{{--<div style="position: relative;">--}}
                 <form method="post" action="/rota/session/find">
                    {{ csrf_field() }}
                    <span class="text-justify" data-placement="top" data-toggle="popover"
                        data-trigger="hover" data-content="Add or edit sessions for this date.">
                        <div class="input-group">
                            <input id="newdate" name="newdate" type="text" class="form-control" value="{{now()}}" required />
                            <div class="input-group-btn">  
                                <button type="submit" class="btn btn-success" style="position: relative;">
                                    Add new session
                                </button> 
                            </div>
                        </div>
                    </span>
                 </form>
            @endcan
             <hr>
        </div>
    </div>
    {{--CONTENT--}}
    <div class="container">
        <div class="row">
            @foreach($items as $rota)
                @if($rota->sessions)
<!-- DISPLAY ROTA -->
                <div class="col-sm-12 text-left well">
                    <div class="row">
                        <!-- SHOW DATE -->
                        <div class="col-sm-3 text-left">
                            {{ Carbon\Carbon::parse($rota->date)->format('D, d/m/Y') }} <br/>
                            @can('staff_manage')
                                <div class="btn-group btn-group-sm">
                                    <span class="btn-group text-justify" data-placement="top" data-toggle="popover"
                                        data-trigger="hover" data-content="Edit the sessions for this date.">
                                        <a type="button" class="btn btn-info" 
                                            href="/rota/session/{{$rota->date}}">
                                            <i class="fa fa-calendar"></i> Edit
                                        </a>
                                    </span>
                                    <span class="btn-group text-justify" data-placement="top" data-toggle="popover"
                                        data-trigger="hover" data-content="Edit who is going to demonstrate on this day.">
                                        <a type="button" class="btn btn-info" 
                                            href="/rota/assign/{{$rota->date}}">
                                            <i class="fa fa-user-plus "></i> Assign
                                        </a>
                                    </span>
                                    <span class="btn-group text-justify" data-placement="top" data-toggle="popover"
                                        data-trigger="hover" data-content="Email the rota to all demonstrators.">
                                        <a type="button" class="btn btn-info" 
                                            href="/rota/email/{{$rota->date}}">
                                            <i class="fa fa-envelope "></i> Email
                                        </a>
                                    </span>
                                </div>
                            @endcan
                        </div>
                        <!-- SHOW SESSIONS -->
                        <div class="col-sm-9 text-left">
                            <ul class="list-group">
                                @foreach($rota->sessions as $s)
                                    @php
                                        $icon = 'lock';
                                        $icondesc = 'private session';
                                        if($s->public){
                                            $icon = 'globe';
                                            $icondesc = 'normal, public session';
                                        }
                                    @endphp
                                    <li class="list-group-item">
                                        <div class="row">
                                            <!-- PUBLIC OR PRIVATE -->
                                            <div class="col-sm-1">
                                                <span class="text-justify" data-placement="top" data-toggle="popover"
                                                    data-trigger="hover" data-content="{{$icondesc}}">
                                                    <span class="fa fa-fw fa-{{$icon}}"></span>
                                                </span>
                                            </div>
                                            <!-- SESSION TIME -->
                                            <div class="col-sm-2">{{$s->timeString()}}</div> 
                                            <!-- EVENT BADGES -->
                                            <div class="col-sm-3">
                                                @foreach($s->events() as $e)
                                                    <span class="text-justify" data-placement="top" data-toggle="popover"
                                                        data-trigger="hover" data-content="{{$e->name}}: {{$e->dateString()}}">
                                                        <a class="badge badge-{{$e->type}}"
                                                            @can('staff_manage') href="/rota/event/update/{{$e->id}}" @endcan>
                                                            {{$e->name}}
                                                        </a>
                                                    </span>
                                                @endforeach
                                            </div>
                                            <!-- DEMONSTRATORS -->
                                            <div class="col-sm-6 text-left">
                                                @if($s->staff()->count()>0)
                                                    @php
                                                        $dems = [];
                                                        foreach($s->staff as $dem){
                                                            if($dem->id == $user->id){
                                                                $dems[] = '<span class="text-danger">'.$dem->name().'</span>';
                                                            }else{
                                                                $dems[] = $dem->name();
                                                            }
                                                        }
                                                    @endphp
                                                    {!!implode(", ",$dems)!!}
                                                @else
                                                    ({{$s->dem_required}} demonstrators)
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @else
<!--DISPLAY EVENT-->
                <div class="col-sm-12 text-left well col-{{$rota->type}}">
                    <a @can('staff_manage') href="/rota/event/update/{{$rota->id}}" @endcan>{{$rota->name}}</a>:
                    {{$rota->dateString()}}
                </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        //create date-time-picker
        $(function () {
            $('#newdate').datetimepicker({format:'YYYY-MM-DD', disabledDates: [{!!$closures!!}], showTodayButton:true, showClear:false, showClose:true}); 
        });
    </script>
    <script>
        //display tooltips
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
