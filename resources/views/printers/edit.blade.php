@extends('layouts.layout')
@section('content')
    {{--TITLE--}}
    <div class="title m-b-md">
        Update the printer information
    </div>
    {{--CONTENT--}}
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>

            <div class="col-sm-6 well text-left">
            
                <form method="post" action="/printers/update/{{$printer->id}}">
                    {{--Generate security key --}}
                    {{ csrf_field() }}
                    {{--Hardware Identification Number--}}
                    <div id="serial_group">
                        <label for="serial_no">Serial number: </label> <br/>
                        <input id="serial" name="serial_no" 
                            type="text" class="form-control" 
                            value="{{ $printer->serial_no }}"/>
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
                                        @if (isset($printer->printer_type) && $printer->printer_type==$type->printer_type)
                                            {{"checked"}}
                                        @endif 
                                    />{{$type->printer_type}}<br>
                                @endforeach
                                <input name="printer_type" type="radio" 
                                    value="Other"
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
                                <input name="printer_permission" type="radio" 
                                    value="isWorkshop" <?php if ($printer->isWorkshop) echo "checked";?>>Yes <br>
                                <input name="printer_permission" type="radio" 
                                    value="isOnline" <?php if (!$printer->isWorkshop) echo "checked";?>>No <br>
                            </div> <!-- Class radio -->
                        </div> <!-- /form-group -->
                        <span id="printer_permission_error"></span> <br/>
                    </div>
                    {{--Printer Status--}}
                    @hasrole('administrator')
                        <div id="printer_status_group">
                            <label for="printer_status">Printer status: </label> <br/>
                            <div class="form-group text-left">
                                <div class="radio">
                                    <input name="printer_status" type="radio" 
                                        value="Available" 
                                        @if (isset($printer->printer_status) && $printer->printer_status=="Available") 
                                            {{"checked"}}
                                        @endif 
                                    />Available <br>
                                    <input name="printer_status" type="radio" 
                                        value="Missing" 
                                        @if (isset($printer->printer_status) && $printer->printer_status=="Missing") 
                                            {{"checked"}}
                                        @endif 
                                    />Missing <br>
                                    <input name="printer_status" type="radio" 
                                        value="Broken" 
                                        @if (isset($printer->printer_status) && $printer->printer_status=="Broken") 
                                            {{"checked"}}
                                        @endif 
                                    />Broken <br>
                                    <input name="printer_status" type="radio" 
                                        value="On Loan" 
                                        @if (isset($printer->printer_status) && $printer->printer_status=="On Loan") 
                                            {{"checked"}}
                                        @endif 
                                    />On Loan <br>
                                    <input name="printer_status" type="radio" 
                                        value="Signed out" 
                                        @if (isset($printer->printer_status) && $printer->printer_status=="Signed out") 
                                            {{"checked"}}
                                        @endif 
                                    />Signed out <br>
                                </div> <!-- Class radio -->
                            </div> <!-- /form-group -->
                            <span id="printer_status_error"></span> <br/>
                        </div>
                    @endhasrole
                    @include('layouts.errors')
                    {{--Buttons--}}
                    <div class="col-sm-12 text-center">
                        <button id="submit" type="submit" class="btn btn-lg btn-success">
                            <i class="fa fa-save"></i> Save Changes
                        </button>
                        <a class="btn btn-lg btn-primary" href="/printers/{{$printer->id}}" >View printer details</a>
                    </div>
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
@endsection

@section('scripts')
    {{--<script src="/js/printer_validation.js"></script>--}}
    <script src="/js/validate_form.js"></script>
@endsection
