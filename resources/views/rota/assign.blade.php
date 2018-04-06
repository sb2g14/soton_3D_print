@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Assign Demonstrators for {{ Carbon\Carbon::parse($date)->format('D, dS \\of M Y') }}
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 well">
                <form method="post" class="form-horizontal" action="/rota/assign/{{$date}}">
                    {{ csrf_field() }}
                    <input type="text" hidden name="date" id="date" value="{{$date}}" />
                    @foreach($sessions as $s)
                        @php
                            $starttime = Carbon\Carbon::parse($s->start_date)->format('G:i');
                            $endtime = Carbon\Carbon::parse($s->end_date)->format('G:i');
                            $icon = 'lock';
                            if($s->public){
                                $icon = 'unlock';
                            }
                        @endphp
                        <div class="form-group">
                            <div class="col-lg-4 control-label">   
                                <span class="fa fa-fw fa-{{$icon}}"></span> 
                                {{$starttime}} -- {{$endtime}}
                            </div>
                            <div class="col-sm-6">
                                @for($d=0;$d<$s->dem_required;$d++)
                                    @php
                                        $x = $s->staff;
                                        if(count($x) > $d){
                                            $x = $x[$d];
                                            $x = array('first_name' => $x->first_name, 'id' => $x->id);
                                        }else{
                                            $x = array('first_name' => '', 'id' => 0);
                                        }
                                        $options = $demonstrators['session_'.$s->id]['dem1'];
                                        if($d > 0){
                                            $options = $demonstrators['session_'.$s->id]['dem2'];
                                        }
                                        //$options = $demonstratorsX;
                                    @endphp
                                    {!! Form::select('dem_'.$s->id.'_'.$d, $options, old($x['first_name'], $x['id']), ['class' => 'form-control','required', 'id' => 'dem_'.$s->id.'_'.$d]) !!}
                                @endfor
                            </div>
                        </div>
                    @endforeach
                    <button type="submit" name="btn_update" value="{{$date}}" id="submit" class="btn btn-lg btn-info">Update</button>
                    <a href="/rota" type="button" class="btn btn-lg btn-primary">See all Sessions</a>
                </form>
            </div>
        </div>
        
    </div>
@endsection
@section('scripts')
    <script src="/js/validate_form.js"></script>
@endsection

