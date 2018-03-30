@extends('layouts.layout')
@section('content')

    <div class="title m-b-md">
        Update the cost code
    </div>

     <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>

            <div class="col-sm-4 well">
                <form method="post" action="/costCodes/update/{{$cost_code->id}}">

                    {{ csrf_field() }}

                    <label for="shortage">Shortage: </label> <br>
                        <input id="shortage" type="text" name="shortage" class="form-control" value="{{ $cost_code-> shortage }}"/>
                        <td><span class="" id="shortage_error"></span></td><br>
                    <label for="explanation">Explanation of the shortage:</label><br>
                        <textarea id="explanation" name="explanation" class="form-control" >{{ $cost_code->explanation }}</textarea>
                        <td><span class="" id="explanation_error"></span></td><br>
                    <label for="cost_code">Cost code: </label><br>
                        <input id="cost_code" type="text" name="cost_code" class="form-control" value="{{ $cost_code-> cost_code }}"/>
                        <td><span class="" id="cost_code_error"></span></td><br>
                    <label for="aproving_member_of_staff">Member of staff approved: </label><br>
                        <input id="staff_name" type="text" name="aproving_member_of_staff" class="form-control" value="{{ $cost_code-> aproving_member_of_staff }}"/>
                        <td><span class="" id="staff_name_error"></span></td><br>
                    <label for="expires">Expiry date (yyyy-mm-dd): </label> <br>
                        <input id="expires" type="text" name="expires" class="form-control" value="{{ $cost_code-> expires}}"/>
                        <td><span class="" id="expires_error"></span></td><br>
                    <label for="holder">Holder: </label><br>
                        <input id="holder_name" type="text" name="holder" class="form-control" value="{{ $cost_code-> holder}}"/>
                        <td><span class="" id="holder_name_error"></span></td><br>
                    <label for="description">Description: </label><br>
                        <input id="description" type="text" name="description" class="form-control" value="{{ $cost_code-> description}}"/>
                        <td><span class="" id="description_error"></span></td><br>
                    @include('layouts.errors')
                    <button id="submit" type="submit" class="btn btn-success">Update</button>
                    <a href="/costCodes/delete/{{  $cost_code->id }}" class="btn btn-danger">Delete</a>
                </form>
            </div>

            <div class="col-sm-4"></div>
        </div>
    </div>
@endsection

@section("scripts")
    <script type="text/javascript">
        $(function () {
            $('#expires').datetimepicker({format:'YYYY-MM-DD',showTodayButton:true,showClear:false,showClose:true});
        });
    </script>
    <script src="/js/validate_form.js"></script>
@endsection
