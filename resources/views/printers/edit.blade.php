@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Update the printer information
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>

            <div class="col-sm-6 well text-left">
            
                <form method="post" action="/printers/update/{{$printer->id}}">
                    {{--Generate security key --}}
                    {{ csrf_field() }}
                    <label for="body">Serial number: </label> <br>
                    <input id="serial" type="text" name="serial_no" class="form-control" value="{{ $printer->serial_no }}"/><br>
                    <label for="body">Printer type: </label> <br>
                    <!-- Radio list for the printer type -->
                    <div class="form-group text-left">
                        <div class="radio">
                            @foreach($printer_types as $type)
                                <input type="radio" name="printer_type" @if (isset($printer->printer_type)
                                    && $printer->printer_type==$type->printer_type) {{"checked"}} @endif value="{{$type->printer_type}}">{{$type->printer_type}}<br>
                            @endforeach
                            <input type="radio" name="printer_type" id="other" <?php if (isset($printer_type)
                                && $printer->printer_type=="Other") echo "checked";?> value="Other">Other <br>
                                <div id="printer_type_other_group">
                                    <input type="text" id="printer_type_other" name="other_printer_type" class="form-control" placeholder="Please input if other"/><br>
                                    <td><span class="help-block" id="printer_type_other_error"></span> </td>
                                </div>
                        </div> <!-- Class radio -->
                    </div> <!-- /form-group -->
                    @hasrole('administrator')
                    <label for="body">Printer status: </label> <br>
                    <!-- Radio list for the printer status -->
                    <div class="form-group text-left">
                        <div class="radio">
                            <input type="radio" name="printer_status" <?php if (isset($printer->printer_status)
                                && $printer->printer_status=="Available") echo "checked";?> value="Available">Available <br>
                            <input type="radio" name="printer_status" <?php if (isset($printer->printer_status)
                                && $printer->printer_status=="Missing") echo "checked";?> value="Missing">Missing <br>
                            <input type="radio" name="printer_status" <?php if (isset($printer->printer_status)
                                && $printer->printer_status=="Broken") echo "checked";?> value="Broken">Broken <br>
                            <input type="radio" name="printer_status" <?php if (isset($printer->printer_status)
                                && $printer->printer_status=="On Loan") echo "checked";?> value="On Loan">On Loan <br>
                            <input type="radio" name="printer_status" <?php if (isset($printer->printer_status)
                                && $printer->printer_status=="Signed out") echo "checked";?> value="Signed out">Signed out <br>
                        </div> <!-- Class radio -->
                    </div> <!-- /form-group -->
                    @endhasrole
                    @include('layouts.errors')
                    <button id="submit" type="submit" class="btn btn-info">Update</button>
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
