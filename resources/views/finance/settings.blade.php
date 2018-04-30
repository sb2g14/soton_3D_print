@extends('layouts.layout')
@section('content')
    {{--TITLE--}}
    <div class="title m-b-md">
        Update Finance Settings
    </div>
    {{--NAVIGATION--}}
    <div class="container">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="pull-left">
                <a type="button" class="btn btn-primary" href="/finance">Finance Overview</a>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
    {{--CONTENT--}}
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>

            <div class="col-sm-6 text-left well">
                
                <form method="post" action="/finance/settings">
                    {{--Generate security key --}}
                    {{ csrf_field() }}
                    <div id="check_rota_assign_group" class="form-group">
                        <label for="check_rota_assign" class="">Set Prices for Prints</label><br/>
                        @foreach($settingsPrices as $s)
                            <div class="input-group">
                                <div class="input-group-addon">&pound;</div>
                                <input id="price_{{$s->id}}" name="setting_{{$s->id}}" 
                                    class="form-control" 
                                    value="{{$s->value()}}"/> 
                                @php
                                    $description = "";
                                    switch($s->key){
                                        case "PriceMaterial":
                                            $description = "/100g material";
                                            break;
                                        case "PriceTime":
                                            $description = "/h printing time";
                                            break;
                                    }
                                @endphp
                                <div class="input-group-addon">{{$description}}</div>
                            </div><br/>
                        @endforeach
                        <span id="check_rota_assign_error"></span> <br/>
                    </div>
                    @include('layouts.errors')
                    <div class="col-sm-12 text-center">
                        <button type="submit" id="submit" class="btn btn-lg btn-success">
                            <i class="fa fa-save"></i> Save Changes
                        </button>
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

