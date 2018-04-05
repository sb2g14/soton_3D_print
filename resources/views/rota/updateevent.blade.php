@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Update Event
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>

            <div class="col-sm-6 text-left well">
            
                <form method="post" action="/rota/event/update/{{$event->id}}">
                    {{--start_date | end_date | name | type--}}
                    {{--Generate security key --}}
                    {{ csrf_field() }}
                    <label for="event_type">Type of Event: </label> <br>
                    {!! Form::select('event_type', $options, $event->type, ['class' => 'form-control','required', 'id' => 'event_type']) !!}
                    <td><span class="" id="end_date_error"></span> </td> <br>
                    <label for="event_name">Event Name: </label> <br>
                    <input type="text" name="event_name" class="form-control" id="event_name" value="{{$event->name}}"/>
                    <td><span class="" id="event_name_error"></span> </td> <br>
                    <label for="start_date">Start of Event: </label> <br>
                    <input type="text" name="start_date" class="form-control" id="start_date" value="{{$event->start_date}}" />
                    <td><span class="" id="start_date_error"></span> </td> <br>
                    <label for="end_date">End of Event: </label> <br>
                    <input type="text" name="end_date" class="form-control" id="end_date" value="{{$event->end_date}}"/>
                    <td><span class="" id="end_date_error"></span> </td> <br>
                    @include('layouts.errors')
                    <button type="submit" id="submit" class="btn btn-lg btn-success">Update Event</button>
                    <a href="/rota" class="btn btn-lg btn-primary">View all Sessions</a>
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('#start_date').datetimepicker({format:'YYYY-MM-DD HH:mm',showTodayButton:true,showClear:false,showClose:true});
            $('#end_date').datetimepicker({format:'YYYY-MM-DD HH:mm',showTodayButton:true,showClear:false,showClose:true});
        });
    </script>
    <script src="/js/validate_form.js"></script>
@endsection

