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
                    <input type="text" name="id" class="form-control" id="number" value="{{old('id')}}" /><br>
                    <td><span class="help-block" id="number_error"></span> </td>
                    <label for="serial_no">Serial number: </label> <br>
                    <input type="text" name="serial_no" class="form-control" id="serial" value="{{old('serial_no')}}"/><br>
                    <td><span class="help-block" id="serial_error"></span> </td>
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
                            <input type="text" name="other_printer_type" class="form-control" id="other" placeholder="Please input if other"/><br>
                            <td><span class="help-block" id="other_error"></span> </td>
                        </div> <!-- Class radio -->
                    </div> <!-- /form-group -->
                    @include('layouts.errors')
                    <button type="submit" id="submit" class="btn btn-lg btn-primary">Register new 3D printer</button>
                    
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/new_printer_validation.js"></script>
@endsection

