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

                    <label for="shortage">Shortage: </label> <br>
                        <input id="shortage" type="text" name="shortage" class="form-control" value="{{ old('shortage') }}"/><br>
                        <td><span class="help-block" id="shortage_error"></span></td>
                    <label for="explanation">Explanation of the shortage:</label><br>
                    <textarea id="explanation" type="text" name="explanation" class="form-control" value="{{ old('explanation') }}">{{ old('explanation') }}</textarea><br>
                        <td><span class="help-block" id="explanation_error"></span></td>
                    <label for="cost_code">Cost code: </label><br>
                        <input id="cost_code" type="text" name="cost_code" class="form-control" value="{{ old('cost_code') }}"/><br>
                        <td><span class="help-block" id="cost_code_error"></span></td>
                    <label for="aproving_member_of_staff">Member of staff approved: </label><br>
                        <input id="staff_name" type="text" name="aproving_member_of_staff" class="form-control" value="{{ old('aproving_member_of_staff') }}"/><br>
                        <td><span class="help-block" id="staff_name_error"></span></td>
                    <label for="expires">Expiry date (yyyy-mm-dd): </label> <br>
                        <input id="expires" type="text" name="expires" class="form-control" value="{{ old('expires') }}"/><br>
                        <td><span class="help-block" id="expires_error"></span></td>
                    <label for="holder">Holder: </label><br>
                        <input id="holder_name" type="text" name="holder" class="form-control" value="{{ old('holder') }}"/><br>
                        <td><span class="help-block" id="holder_name_error"></span></td>
                    <label for="description">Description: </label><br>
                        <input id="description" type="text" name="description" class="form-control" value="{{ old('description') }}"/><br>
                        <td><span class="help-block" id="description_error"></span></td>
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
    <script src="/js/validate_form.js"></script>
@endsection