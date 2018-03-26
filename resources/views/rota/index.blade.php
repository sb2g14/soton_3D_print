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
                 <form method="post" action="/rota/newsession/make">
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
                    <div class="col-sm-12 text-left well">
                        <div class="row">
                            <div class="col-sm-3 text-left">
                                {{$rota[0]->date()}}<br/>
                                <a href="/rota/newsession/{{$rota[0]->date()}}" type="button" class="btn btn-info">Edit</a>
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
                                                    $icon = 'unlock';
                                                }
                                            @endphp
                                            <tr>
                                                <td><span class="fa fa-fw fa-{{$icon}}"></span> </td>
                                                <td>{{$starttime}} -- {{$endtime}}</td> 
                                                <td>
                                                    @foreach($s->events() as $e)
                                                        <span class="text-justify" data-placement="top" data-toggle="popover"
                                 data-trigger="hover" data-content="{{$e->name}}: {{$e->start_date}} -- {{$e->end_date}}"><a href="/rota/event/update/{{$e->id}}" class="badge badge-{{$e->type}}"> {{$e->name}} </a></span>
                                                    @endforeach
                                                </td>
                                                @if($s->staff()->count()>0)
                                                    <td>
                                                    @php
                                                        $dems = [];
                                                        foreach($s->staff as $dem){
                                                            $dems[] = $dem->first_name.' '.$dem->last_name;
                                                        }
                                                    @endphp
                                                    {{implode(", ",$dems)}}
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
                    <div class="col-sm-12 text-left well col-{{$rota->type}}">
                        <a href="/rota/event/update/{{$rota->id}}">{{$rota->name}}</a>: {{$rota->start_date}} -- {{$rota->end_date}}
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
