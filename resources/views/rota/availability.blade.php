@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Declare your availability
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 well">
                <form method="post" action="/rota/availability">
                {{ csrf_field() }}
                @foreach($sessions as $s)
                    <div>
                        <div>{{$s->date()}}: {{$s->start_time()}} -- {{$s->end_time()}}</div>
                        @php
                            $x = $s->availability();
                            $x = $x->where('staff_id',$staffid)->first();
                            if(!$x){
                                $x = "tentative";
                            }else{
                                $x = $x->availability;
                            }
                        @endphp
                        {!! Form::select('av_'.$s->id, $options, old($x, $x), ['class' => 'form-control','required', 'id' => 'av_'.$s->id]) !!}
                            
                        
                    </div>
                @endforeach
                    <button type="submit" name="btn_update" id="submit" class="btn btn-lg btn-info">Update</button>
                    <a href="/rota" type="button" class="btn btn-lg btn-primary">See all Sessions</a>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/validate_form.js"></script>
@endsection

