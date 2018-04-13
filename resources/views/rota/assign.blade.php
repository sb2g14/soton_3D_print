@extends('layouts.layout')
@section('content')
    {{--TITLE--}}
    <div class="title m-b-md">
        Assign Demonstrators for {{ Carbon\Carbon::parse($rota->date)->format('D, dS \\of M Y') }}
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
            <div class="col-sm-12 well"> 
                <form class="form-horizontal" method="post" action="/rota/assign/{{$date}}">
                    {{ csrf_field() }}
                    <input id="date" name="date" type="text" hidden value="{{$date}}" />
                    @foreach($sessions as $s)
                        @php
                            $starttime = Carbon\Carbon::parse($s->start_date)->format('G:i');
                            $endtime = Carbon\Carbon::parse($s->end_date)->format('G:i');
                            $icon = 'lock';
                            if($s->public){
                                $icon = 'globe';
                            }
                        @endphp
                        <div class="form-group">
                            <div class="col-lg-4 control-label">   
                                <span class="fa fa-fw fa-{{$icon}}"></span> 
                                {{$starttime}} &ndash; {{$endtime}}
                            </div>
                            <div class="col-sm-6 input-group">
                                @for($d=0;$d<$s->dem_required;$d++)
                                    @php
                                        /*$x = $s->staff;
                                        if(count($x) > $d){
                                            $x = $x[$d];
                                            $x = array('name' => $x->first_name.' '.$x->last_name, 'id' => $x->id);
                                        }else{
                                            $x = array('name' => '', 'id' => 0);
                                        }*/
                                        $x = $default['session_'.$s->id]['dem_'.$d];
                                        $options = $demonstrators['session_'.$s->id]['dem1'];
                                        if($d > 0){
                                            $options = $demonstrators['session_'.$s->id]['dem2'];
                                        }
                                    @endphp
                                    {!! Form::select('dem_'.$s->id.'_'.$d, $options, old($x['name'], $x['id']), ['class' => 'form-control','required', 'id' => 'dem_'.$s->id.'_'.$d]) !!}
                                @endfor
                            </div>
                        </div>
                    @endforeach
                    <button id="submit" name="btn_update" type="submit" class="btn btn-lg btn-success" value="{{$date}}">
                        <i class="fa fa-save"></i> Save Changes
                    </button>
                    <a type="button" class="btn btn-lg btn-success" href="/rota/email/{{$date}}">
                        <i class="fa fa-envelope"></i> Create E-Mail
                    </a>
                </form>
            </div>
        </div>
        
    </div>
@endsection
@section('scripts')
    <script src="/js/validate_form.js"></script>
@endsection

