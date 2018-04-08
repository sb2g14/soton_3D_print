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
            <a href="/rota/availability" type="button" class="btn btn-info pull-left">Indicate Availability</a>
            @can('staff_manage')
                 <div class="pull-right"><a href="/rota/event/new" type="button" class="btn btn-success">Add Event</a></div>
                 {{--<div class="pull-right">&nbsp;</div>--}}
                 <div class="col-lg-4 pull-right">{{--<div style="position: relative;">--}}
                     <form method="post" action="/rota/session/find">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" name="newdate" class="form-control" id="newdate" value="{{now()}}" required />
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-success" style="position: relative;">Add new session</button>
                            </div>
                        </div>
                     </form>
                @endcan
                 <hr>
            </div>
        </div>
        <div class="container">
            <div class="row">
                @foreach($items as $rota)
                    @if($rota['sessions'])
<!-- DISPLAY ROTA -->
                    <div class="col-sm-12 text-left well">
                        <div class="row">
                            <!-- SHOW DATE -->
                            <div class="col-sm-3 text-left">
                                {{ Carbon\Carbon::parse($rota['date'])->format('D, d/m/Y') }} <br/>
                                @can('staff_manage')
                                    <a href="/rota/session/{{$rota['date']}}" type="button" class="btn btn-info">Edit</a>
                                    <a href="/rota/assign/{{$rota['date']}}" type="button" class="btn btn-success">Assign Demonstrators</a>
                                @endcan
                            </div>
                            <!-- SHOW SESSIONS -->
                            <div class="col-sm-9 text-left">
                                <table class="table table-hover">
                                    <tbody>
                                        @foreach($rota['sessions'] as $s)
                                            @php
                                                $starttime = $s->start_time();
                                                $endtime = $s->end_time();
                                                $icon = 'lock';
                                                if($s->public){
                                                    $icon = 'globe';
                                                }
                                            @endphp
                                            <tr>
                                                <!-- PUBLIC OR PRIVATE -->
                                                <td><span class="fa fa-fw fa-{{$icon}}"></span> </td>
                                                <!-- SESSION TIME -->
                                                <td>{{$starttime}} &ndash; {{$endtime}}</td> 
                                                <!-- EVENT BADGES -->
                                                <td>
                                                    @foreach($s->events() as $e)
                                                        <span class="text-justify" data-placement="top" data-toggle="popover"
                                 data-trigger="hover" data-content="{{$e->name}}: {{ Carbon\Carbon::parse($e->start_date)->format('d/m/Y') }} &ndash; {{ Carbon\Carbon::parse($e->end_date)->format('d/m/Y') }}"><a @can('staff_manage') href="/rota/event/update/{{$e->id}}" @endcan class="badge badge-{{$e->type}}"> {{$e->name}} </a></span>
                                                    @endforeach
                                                </td>
                                                <!-- DEMONSTRATORS -->
                                                @if($s->staff()->count()>0)
                                                    <td>
                                                    @php
                                                        $dems = [];
                                                        foreach($s->staff as $dem){
                                                            if($dem->id == $user->id){
                                                                $dems[] = '<span class="text-danger">'.$dem->first_name.' '.$dem->last_name.'</span>';
                                                            }else{
                                                                $dems[] = $dem->first_name.' '.$dem->last_name;
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
                        {{ Carbon\Carbon::parse($rota->start_date)->format('d/m/Y') }}
                        @if($rota->start_date != $rota->end_date)
                            &ndash; {{ Carbon\Carbon::parse($rota->end_date)->format('d/m/Y') }}
                        @endif
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('#newdate').datetimepicker({format:'YYYY-MM-DD', disabledDates: [{!!$closures!!}], showTodayButton:true, showClear:false, showClose:true}); 
        });
    </script>
@endsection
