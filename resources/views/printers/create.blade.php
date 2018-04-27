@extends('layouts.layout')
@section('content')
    {{--TITLE--}}
    <div class="title m-b-md">
        Register a new printer
    </div>
    {{--CONTENT--}}
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>

            <div class="col-sm-6 well text-left">
            
                <form method="post" action="/printers">
                    {{--Generate security key --}}
                    {{ csrf_field() }}
                    {{--Printer Number--}}
                    <div id="number_group">
                        <label for="id">Printer number: </label> <br/>
                        <input id="number" name="id" 
                            type="text" class="form-control" 
                            value="{{old('id')}}" required/>
                        <span id="number_error"></span> <br/>
                    </div>
                    {{--Hardware Identification Number--}}
                    <div id="serial_group">
                        <label for="serial_no">Serial number: </label> <br/>
                        <input id="serial" name="serial_no" 
                            type="text" class="form-control" 
                            value="{{old('serial_no')}}"/>
                        <span id="serial_error"></span> <br/>
                    </div>
                    {{--Printer Type--}}
                    <div id="printer_type_group">
                        <label for="printer_type">Printer type: </label> <br/>
                        <div class="form-group text-left">
                            <div class="radio">
                                @foreach($printer_types as $type)
                                    <input name="printer_type" type="radio" 
                                        value="{{$type->printer_type}}"
                                        @if (isset($printer_type) && $printer_type==$type->printer_type) {{"checked"}} @endif 
                                    />{{$type->printer_type}}<br>
                                @endforeach
                                <input name="printer_type" type="radio" 
                                    value="Other" 
                                    @if (isset($printer_type) && $printer_type=="Other") {{"checked"}} @endif 
                                />Other <br>
                                <div id="printer_type_other_group">
                                    <input id="printer_type_other" name="other_printer_type" 
                                        type="text" class="form-control" 
                                        placeholder="Please input if other"/>
                                    <span id="printer_type_other_error"></span><br/>
                                </div>
                            </div> <!-- /Class radio -->
                        </div> <!-- /form-group -->
                        <span id="printer_type_error"></span> <br/>
                    </div>
                    {{--Printer Usage Permission--}}
                    <div id="printer_permission_group">
                        <label for="printer_permission">Can this Printer be used by students?: </label> <br/>
                        <div class="form-group text-left">
                            <div class="radio">
                                <input type="radio" name="printer_permission" value="isWorkshop">Yes <br>
                                <input type="radio" name="printer_permission" checked value="isOnline">No <br>
                            </div>
                        </div>
                        <span id="printer_permission_error"></span> <br/>
                    </div>
                    @include('layouts.errors')
                    {{--Buttons--}}
                    <div class="col-sm-12 text-center">
                        <button type="submit" id="submit" class="btn btn-lg btn-success">Register new 3D printer</button>
                        <a href="/printers" class="btn btn-lg btn-primary">View all printers</a>
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

