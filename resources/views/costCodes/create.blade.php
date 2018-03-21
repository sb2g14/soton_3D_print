@extends('layouts.layout')
@section('content')

    <div class="title m-b-md">
        Create the cost code
    </div>

     <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>

            <div class="col-sm-4 well">
                <form method="post" action="/costCodes/create">

                    {{ csrf_field() }}

                    <label for="shortage">Shortage: </label><br>
                        <input id="shortage" type="text" name="shortage" class="form-control" value="{{ old('shortage') }}"/>
                        <td><span class="" id="shortage_error"></span></td><br>
                    <label for="explanation">Explanation of the shortage:</label><br>
                        <textarea id="explanation" type="text" name="explanation" class="form-control" value="{{ old('explanation') }}">{{ old('explanation') }}</textarea>
                        <td><span class="" id="explanation_error"></span></td><br>
                    <label for="cost_code">Cost code: </label><br>
                        <input id="cost_code" type="text" name="cost_code" class="form-control" value="{{ old('cost_code') }}"/>
                        <td><span class="" id="cost_code_error"></span></td><br>
                    <label for="aproving_member_of_staff">Member of staff approved: </label><br>
                        <input id="staff_name" type="text" name="aproving_member_of_staff" class="form-control" value="{{ old('aproving_member_of_staff') }}"/>
                        <td><span class="" id="staff_name_error"></span></td><br>
                    <label for="expires">Expiry date (yyyy-mm-dd): </label> <br>
                        <input id="expires" type="text" name="expires" class="form-control" value="{{ old('expires') }}"/>
                        <td><span class="" id="expires_error"></span></td><br>
                    <label for="holder">Holder: </label><br>
                        <input id="holder_name" type="text" name="holder" class="form-control" value="{{ old('holder') }}"/>
                        <td><span class="" id="holder_name_error"></span></td><br>
                    <label for="description">Description: </label><br>
                        <input id="description" type="text" name="description" class="form-control" value="{{ old('description') }}"/>
                        <td><span class="" id="description_error"></span></td><br>
                    @include('layouts.errors')
                    <button id="submit" type="submit" class="btn btn-success">Add</button>
                    <a href="/costCodes/index" class="btn btn-danger">Go back</a>
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
