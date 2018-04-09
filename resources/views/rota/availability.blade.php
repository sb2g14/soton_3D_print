@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Declare your availability
    </div>

    <div class="container">
        <div class="row">
            <form method="post" action="/rota/availability">
                {{ csrf_field() }}
                @foreach($rotas as $r)
                    <div class="col-sm-12 well">
                        <div class="row">
                            <div class="col-sm-4 control-label">
                                {{ Carbon\Carbon::parse($r['date'])->format('D, d/m/Y') }}: 
                            </div>
                            <div class="col-sm-8">
                                @foreach($r['sessions'] as $s)
                                    <span class="text-justify" data-placement="top" data-toggle="popover"
                                            data-trigger="hover" data-content="Choose Available, if you want to be selected for this session. If you choose tentative, you will only be selected, in case no one else suits that shift.">
                                    <div class="input-group">
                                        <div class="input-group-addon">{{$s->start_time()}} &ndash; {{$s->end_time()}}</div>
                                        @php
                                            $x = $s->availability();
                                            $x = $x->where('staff_id',$staffid)->first();
                                            if(!$x){
                                                $x = "tentative";
                                            }else{
                                                $x = $x->status;
                                            }
                                        @endphp   
                                            {!! Form::select('av_'.$s->id, $options, old($x, $x), ['class' => 'form-control','required', 'id' => 'av_'.$s->id, 'type' => 'text']) !!}    
                                    </div>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
                <button type="submit" name="btn_update" id="submit" class="btn btn-lg btn-info">Update</button>
                <a href="/rota" type="button" class="btn btn-lg btn-primary">See all Sessions</a>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/validate_form.js"></script>
@endsection

