@extends('layouts.layout')
@section('content')
    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
            {{ $flash }}
        </div>
    @endif

        <div class="text-center m-b-md">
            <div class="title">Latest Sessions</div>    
        </div>

        <div class="container">
            <div class="pull-right">
                <span class="text-justify" data-placement="top" data-toggle="popover"
                    data-trigger="hover" data-content="Indicate when you are available, so you can be assigned for a session.">
                    <a href="/rota/availability" type="button" class="btn btn-success">Indicate Availability</a>
                </span>
            </div>
            @can('staff_manage')
                <div class="col-lg-2 pull-right">
                    <span class="text-justify" data-placement="top" data-toggle="popover"
                        data-trigger="hover" data-content="Add special university dates or workshop events here.">
                        <a href="/rota/event/new" type="button" class="btn btn-success">Add Event</a>
                    </span>
                </div>
                 <div class="col-lg-4 pull-right">{{--<div style="position: relative;">--}}
                     <form method="post" action="/rota/session/find">
                        {{ csrf_field() }}
                        <span class="text-justify" data-placement="top" data-toggle="popover"
                            data-trigger="hover" data-content="Add or edit sessions for this date.">
                        <div class="input-group">
                            <input type="text" name="newdate" class="form-control" id="newdate" value="{{now()}}" required />
                            <div class="input-group-btn">  
                                <button type="submit" class="btn btn-success" style="position: relative;">Add new session</button> 
                            </div>
                        </div>
                        </span>
                     </form>
                @endcan
                 <hr>
            </div>
        </div>
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
                                    <div class="btn-group-vertical btn-group-sm">
                                        <a href="/rota/session/{{$rota->date}}" type="button" class="btn btn-info" 
                                            data-toggle="tooltip" data-placement="right" title="Edit the sessions for this date.">
                                            <i class="fa fa-calendar"></i> Edit
                                        </a>
                                        <a href="/rota/assign/{{$rota->date}}" type="button" class="btn btn-info" 
                                            data-toggle="tooltip" data-placement="right" title="Edit who is going to demonstrate on this day.">
                                            <i class="fa fa-user-plus "></i> Assign
                                        </a>
                                    </div>
                                @endcan
                            </div>
                            <!-- SHOW SESSIONS -->
                            <div class="col-sm-9 text-left">
                                <table class="table table-hover">
                                    <tbody>
                                        @foreach($rota->sessions as $s)
                                            @php
                                                $icon = 'lock';
                                                $icondesc = 'private session';
                                                if($s->public){
                                                    $icon = 'globe';
                                                    $icondesc = 'normal, public session';
                                                }
                                            @endphp
                                            <tr>
                                                <!-- PUBLIC OR PRIVATE -->
                                                <td><span class="text-justify" data-placement="top" data-toggle="popover"
                                                        data-trigger="hover" data-content="{{$icondesc}}">
                                                    <span class="fa fa-fw fa-{{$icon}}"></span>
                                                </span></td>
                                                <!-- SESSION TIME -->
                                                <td>{{$s->timeString()}}</td> 
                                                <!-- EVENT BADGES -->
                                                <td>
                                                    @foreach($s->events() as $e)
                                                        <span class="text-justify" data-placement="top" data-toggle="popover"
                                                            data-trigger="hover" data-content="{{$e->name}}: {{$e->dateString()}}">
                                                            <a @can('staff_manage') href="/rota/event/update/{{$e->id}}" @endcan class="badge badge-{{$e->type}}"> {{$e->name}} </a>
                                                        </span>
                                                    @endforeach
                                                </td>
                                                <!-- DEMONSTRATORS -->
                                                @if($s->staff()->count()>0)
                                                    <td>
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
                                                    </td>
                                                @else
                                                    <td>({{$s->dem_required}} demonstrators)</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
    @if (notify()->ready())
        <script>
            //display notification
            swal({
                title: "{!! notify()->message() !!}",
                text: "{!! notify()->option('text') !!}",
                type: "{{ notify()->type() }}",
                showConfirmButton: true
            });
        </script>
    @endif
@endsection
