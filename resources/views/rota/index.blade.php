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
            <div>
            <a href="/rota/availability" type="button" class="btn btn-success pull-left">Indicate Availability</a>
            @can('staff_manage')
                 <a href="/rota/newevent" type="button" class="btn btn-success pull-right">Add Event</a>
                 <div class="pull-right">
                 <form method="post" action="/rota/session/find">
                    {{ csrf_field() }}
                    <div style="position: relative;"><input type="text" name="newdate" class="" id="newdate" value="{{now()}}" /></div>
                    <button type="submit" class="btn btn-success" style="position: relative;">Add new session</button>
                 </form>
                 </div>
            @endcan
            <hr>
            </div>
        </div>
        <div class="container">
            <div class="row">
                @foreach($items as $rota)
                    @if($rota[0])
<!-- DISPLAY ROTA -->
                    <div class="col-sm-12 text-left well">
                        <div class="row">
                            <div class="col-sm-3 text-left">
                                {{ Carbon\Carbon::parse($rota[0]->date())->format('D, d/m/Y') }} <br/>
                                <a href="/rota/session/{{$rota[0]->date()}}" type="button" class="btn btn-info">Edit</a>
                                <a href="/rota/assign/{{$rota[0]->date()}}" type="button" class="btn btn-success">Assign Demonstrators</a>
                            </div>
                            <div class="col-sm-9 text-left">
                                <table class="table table-hover">
                                    <tbody>
                                        @foreach($rota as $s)
                                            @php
                                                $starttime = $s->start_time();
                                                $endtime = $s->end_time();
                                                $icon = 'lock';
                                                if($s->public){
                                                    $icon = 'globe';
                                                }
                                            @endphp
                                            <tr>
                                                <td><span class="fa fa-fw fa-{{$icon}}"></span> </td>
                                                <td>{{$starttime}} -- {{$endtime}}</td> 
                                                <td>
                                                    @foreach($s->events() as $e)
                                                        <span class="text-justify" data-placement="top" data-toggle="popover"
                                 data-trigger="hover" data-content="{{$e->name}}: {{ Carbon\Carbon::parse($e->start_date)->format('d/m/Y') }} -- {{ Carbon\Carbon::parse($e->end_date)->format('d/m/Y') }}"><a href="/rota/event/update/{{$e->id}}" class="badge badge-{{$e->type}}"> {{$e->name}} </a></span>
                                                    @endforeach
                                                </td>
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
                        <a href="/rota/event/update/{{$rota->id}}">{{$rota->name}}</a>: {{ Carbon\Carbon::parse($rota->start_date)->format('d/m/Y') }} -- {{ Carbon\Carbon::parse($rota->end_date)->format('d/m/Y') }}
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
