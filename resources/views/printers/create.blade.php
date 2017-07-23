@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Register a new printer
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>

            <div class="col-sm-4 text-left well">
            
                <form method="post" action="/printers">
                    {{--Generate security key --}}
                    {{ csrf_field() }}
                    <label for="body">Printer number: </label> <br>
                    <input type="text" name="id" class="form-control" id="number" /><br>
                    <td><span class="help-block" id="number_error"></span> </td>
                    <label for="body">Serial number: </label> <br>
                    <input type="text" name="serial_no" class="form-control" id="serial"/><br>
                    <td><span class="help-block" id="serial_error"></span> </td>
                    <label for="body">Printer type: </label> <br>

                    <!-- Radio list for the printer type -->
                    <div class="form-group" style="text-align: left;">
                        <div class="radio" style="margin: 10%; margin-top: -2px">
                            <input type="radio" name="printer_type" <?php if (isset($printer_type)
                                && $printer_type=="UP!") echo "checked";?> value="UP!">UP! <br>
                            <input type="radio" name="printer_type" <?php if (isset($printer_type)
                                && $printer_type=="UP Plus 2") echo "checked";?> value="UP Plus 2">UP Plus 2 <br>
                            <input type="radio" name="printer_type" <?php if (isset($printer_type)
                                && $printer_type=="UP BOX") echo "checked";?> value="UP BOX">UP BOX <br>
                            <input type="radio" name="printer_type" <?php if (isset($printer_type)
                                && $printer_type=="Other") echo "checked";?> value="Other">Other <br>
                            <input type="text" name="other_printer_type" class="form-control" id="other" placeholder="Please input if other"/><br>
                            <td><span class="help-block" id="other_error"></span> </td>
                        </div> <!-- Class radio -->
                    </div> <!-- /form-group -->

                    <label for="body">Printer status: </label> <br>
                    <!-- Radio list for the printer status -->
                    <div class="form-group" style="text-align: left;">
                        <div class="radio" style="margin: 10%; margin-top: -2px">
                            <input type="radio" name="printer_status" <?php if (isset($printer_status)
                                && $printer_status=="Available") echo "checked";?> value="Available">Available <br>
                            <input type="radio" name="printer_status" <?php if (isset($printer_status)
                                && $printer_status=="Missing") echo "checked";?> value="Missing">Missing <br>
                            <input type="radio" name="printer_status" <?php if (isset($printer_status)
                                && $printer_status=="Broken") echo "checked";?> value="Broken">Broken <br>
                            <input type="radio" name="printer_status" <?php if (isset($printer_status)
                                && $printer_status=="On Loan") echo "checked";?> value="On Loan">On Loan <br>
                            <input type="radio" name="printer_status" <?php if (isset($printer_status)
                                && $printer_status=="Signed out") echo "checked";?> value="Signed out">Signed out <br>
                        </div> <!-- Class radio -->
                    </div> <!-- /form-group -->
                    @include('layouts.errors')
                    <button type="submit" id="submit" class="btn btn-lg">Register new 3D printer</button>
                    
                </form>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/new_printer_validation.js"></script>
@endsection