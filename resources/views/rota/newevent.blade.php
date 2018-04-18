@extends('layouts.layout')
@section('content')
    {{--TITLE--}}
    <div class="title m-b-md">
        Add a new event<br/>
    </div>
    {{--NAVIGATION--}}
    <div class="container">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="pull-left">
                <a type="button" class="btn btn-primary" href="/rota">View latest events</a>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
    {{--CONTENT--}}
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
                        <span id="end_date_error"></span> <br/>
                    </div>
                    <div id="event_name_group">
                        <label for="event_name">Event Name: </label> <br/>
                        <input id="event_name"name="event_name" 
                            type="text" class="form-control" 
                            value="" required/>
                        <span id="event_name_error"></span> <br/>
                    </div>
                    <div id="start_date_group">
                        <label for="start_date">Start of Event: </label> <br/>
                        <input id="start_date" name="start_date" 
                            type="datetime" class="form-control" 
                            value="{{Carbon\Carbon::now()->format('d/m/Y 0:00')}}" required/>
                        <span id="start_date_error"></span> <br/>
                    </div>
                    <div id="end_date_group">
                        <label for="end_date">End of Event: </label> <br/>
                        <input id="end_date" name="end_date" 
                            type="datetime" class="form-control" 
                            value="{{Carbon\Carbon::now()->format('d/m/Y 23:59')}}" required/>
                        <span id="end_date_error"></span> <br/>
                    </div>
                    @include('layouts.errors')
                    <div class="col-sm-12 text-center">
                        <button id="submit" type="submit" class="btn btn-lg btn-success">Add Event</button>
                        {{--<a class="btn btn-lg btn-primary" href="/rota">View all Events</a>--}}
                        <br/>
                        (Have a look at the <a href="https://www.southampton.ac.uk/uni-life/key-dates.page"  target="_blank">University Key-Dates</a>)
                    </div>
                </form>
                
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

