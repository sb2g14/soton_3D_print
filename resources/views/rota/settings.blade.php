@extends('layouts.layout')
@section('content')
    {{--TITLE--}}
    <div class="title m-b-md">
        Update Rota Settings
    </div>
    {{--NAVIGATION--}}
    <div class="container">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="pull-left">
                <a type="button" class="btn btn-primary" href="/rota">View latest rotas</a>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
    {{--CONTENT--}}
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>

            <div class="col-sm-6 text-left well">
                
                <form method="post" action="/rota/settings">
                    {{--start_date | end_date | name | type--}}
                    {{--Generate security key --}}
                    {{ csrf_field() }}
                    <div id="check_rota_assign_group">
                        <label for="check_rota_assign" class="">Only allow demonstrators to get assigned if they...</label><br/>
                        @foreach($settingsAssignCheck as $s)
                            <input id="check_rota_assign_{{$s->key}}" name="setting_{{$s->id}}" 
                                type="checkbox" 
                                @php if($s->value()){echo('checked');} @endphp /> 
                            @php
                                $description = "";
                                switch($s->key){
                                    case "RotaCheckCWP":
                                        $description = "...have shown their Casual Working Permit to the Coordinator;";
                                        break;
                                    case "RotaCheckSMT":
                                        $description = "...have attended the specific module training;";
                                        break;
                                    case "RotaCheckLWI":
                                        $description = "...have completed the workshop induction;";
                                        break;
                                }
                            @endphp
                            <span class="">{{$description}}</span><br/>
                        @endforeach
                        <span id="check_rota_assign_error"></span> <br/>
                    </div>
                    @include('layouts.errors')
                    <div class="col-sm-12 text-center">
                        <button type="submit" id="submit" class="btn btn-lg btn-success">
                            <i class="fa fa-save"></i> Save Changes
                        </button>
                        {{--<a href="/rota" class="btn btn-lg btn-primary">View all Sessions</a>--}}
                    </div>
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/validate_form.js"></script>
@endsection

