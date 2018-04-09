@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Add a new event<br/>
    </div>

    <div class="container">
        <div class="row">
            
            <div class="col-sm-3"></div>

            <div class="col-sm-6 text-left well">
                <form method="post" action="/rota/newevent">
                    {{--start_date | end_date | name | type--}}
                    {{--Generate security key --}}
                    {{ csrf_field() }}
                    <div id="event_type_group">
                        <label for="event_type">Type of Event: </label> <br/>
                        {!! Form::select('event_type', $options, old('',''), ['class' => 'form-control','required', 'id' => 'event_type']) !!}
                        <span class="" id="end_date_error"></span> <br/>
                    </div>
                    <div id="event_name_group">
                        <label for="event_name">Event Name: </label> <br/>
                        <input type="text" name="event_name" class="form-control" id="event_name" required value=""/>
                        <span class="" id="event_name_error"></span> <br/>
                    </div>
                    <div id="start_date_group">
                        <label for="start_date">Start of Event: </label> <br/>
                        <input type="datetime" name="start_date" class="form-control" id="start_date" required value="{{Carbon\Carbon::now()->format('d/m/Y 0:00')}}" />
                        <span class="" id="start_date_error"></span> <br/>
                    </div>
                    <div id="end_date_group">
                        <label for="end_date">End of Event: </label> <br/>
                        <input type="datetime" name="end_date" class="form-control" id="end_date" required value="{{Carbon\Carbon::now()->format('d/m/Y 23:59')}}"/>
                        <span class="" id="end_date_error"></span> <br/>
                    </div>
                    @include('layouts.errors')
                    <button type="submit" id="submit" class="btn btn-lg btn-success">Add Event</button>
                    <a href="/rota" class="btn btn-lg btn-primary">View all Events</a>
                </form>
                (Have a look at the <a href="https://www.southampton.ac.uk/uni-life/key-dates.page">University Key-Dates</a>)
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('#start_date').datetimepicker({format:'DD/MM/YYYY HH:mm',showTodayButton:true,showClear:false,showClose:true});
            $('#end_date').datetimepicker({format:'DD/MM/YYYY HH:mm',showTodayButton:true,showClear:false,showClose:true,useCurrent: false});
            $("#start_date").on("dp.change", function (e) {
                $('#end_date').data("DateTimePicker").minDate(e.date);
            });
            $("#end_date").on("dp.change", function (e) {
                $('#start_date').data("DateTimePicker").maxDate(e.date);
            });
        });
    </script>
    <script src="/js/validate_form.js"></script>
@endsection
