@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Update the printer information
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>

            <div class="col-sm-4 well text-left">
            
                <form method="post" action="/printers/update/{{$printer->id}}">
                    {{--Generate security key --}}
                    {{ csrf_field() }}
                    {{--<label for="body">Printer number: </label> <br>--}}
                    {{--<input type="text" name="id" class="form-control" value="{{ $printer->id }}" /><br>--}}
                    <label for="body">Serial number: </label> <br>
                    <input type="text" name="serial_no" class="form-control" value="{{ $printer->serial_no }}"/><br>
                    <label for="body">Printer type: </label> <br>
                    {{--<input type="text" name="printer_type" class="form-control"/><br>--}}
                    <!-- Radio list for the printer type -->
                    <div class="form-group text-left">
                        <div class="radio">
                            <input type="radio" name="printer_type" <?php if (isset($printer->printer_type)
                                && $printer->printer_type=="UP!") echo "checked";?> value="UP!">UP! <br>
                            <input type="radio" name="printer_type" <?php if (isset($printer->printer_type)
                                && $printer->printer_type=="UP Plus 2") echo "checked";?> value="UP Plus 2">UP Plus 2 <br>
                            <input type="radio" name="printer_type" <?php if (isset($printer->printer_type)
                                && $printer->printer_type=="UP BOX") echo "checked";?> value="UP BOX">UP BOX <br>
                            <input type="radio" name="printer_type" <?php if (isset($printer_type)
                                && $printer->printer_type=="Other") echo "checked";?> value="Other">Other <br>
                            <input type="text" name="other_printer_type" class="form-control" placeholder="Please input if other"/><br>
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
@endsection
