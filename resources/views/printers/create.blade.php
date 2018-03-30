@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Register a new printer
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>

            <div class="col-sm-6 text-left well">
            
                <form method="post" action="/printers">
                    {{--Generate security key --}}
                    {{ csrf_field() }}
                    <label for="id">Printer number: </label> <br>
                    <input type="text" name="id" class="form-control" id="number" value="{{old('id')}}" />
                    <td><span class="" id="number_error"></span> </td> <br>
                    <label for="serial_no">Serial number: </label> <br>
                    <input type="text" name="serial_no" class="form-control" id="serial" value="{{old('serial_no')}}"/>
                    <td><span class="" id="serial_error"></span> </td> <br>
                    <label for="body">Can this Printer be used by students?: </label> <br>
                    <!-- Radio list for the printer status -->
                    <div class="form-group text-left">
                        <div class="radio">
                            <input type="radio" name="printer_permission" value="isWorkshop">Yes <br>
                            <input type="radio" name="printer_permission" checked value="isOnline">No <br>
                        </div> <!-- Class radio -->
                    </div> <!-- /form-group -->
                    <label for="body">Printer type: </label> <br>
                    <!-- Radio list for the printer type -->
                    <div class="form-group text-left">
                        <div class="radio">
                            @foreach($printer_types as $type)
                                <input type="radio" name="printer_type" @if (isset($printer_type)
                                    && $printer_type==$type->printer_type) {{"checked"}} @endif value="{{$type->printer_type}}">{{$type->printer_type}}<br>
                            @endforeach
                            <input type="radio" name="printer_type" <?php if (isset($printer_type)
                                && $printer_type=="Other") echo "checked";?> value="Other">Other <br>
                            <div id="printer_type_other_group">
                                <input type="text" id="printer_type_other" name="other_printer_type" class="form-control" placeholder="Please input if other"/><br>
                                <td><span class="help-block" id="printer_type_other_error"></span> </td>
                            </div>
                        </div> <!-- Class radio -->
                    </div> <!-- /form-group -->
                    @include('layouts.errors')
                    <button type="submit" id="submit" class="btn btn-lg btn-success">Register new 3D printer</button>
                    <a href="/printers/index" class="btn btn-lg btn-primary">View all printers</a>
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/validate_form.js"></script>
@endsection

