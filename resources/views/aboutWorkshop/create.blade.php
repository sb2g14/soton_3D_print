@extends('layouts.layout')
@section('content')

    <div class="title m-b-md">
        Add a new member     
    </div>

     <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>

            <div class="col-sm-4 well">
                <form method="post" action="/aboutWorkshop">

                    {{ csrf_field() }}

                    {{--<label for="body">Title: </label> <br>--}}
                        {{--<input type="text" name="title" class="form-control" /><br>--}}
                    <label for="body">First name: </label> <br>
                        <input type="text" name="first_name" class="form-control" /><br>
                    <label for="body">Last name: </label><br>
                        <input type="text" name="last_name" class="form-control"/><br>
                    <label for="body">Email: </label> <br>
                        <input type="email" name="email" class="form-control"/><br>
                    <label for="body">Phone: </label><br>
                        <input type="text" name="phone" class="form-control"/><br>
                    <label for="body">Role: </label><br>
                    <!-- Radio list for the member role -->
                    <div class="form-group" style="text-align: left;">
                        <div class="radio" style="margin: 10%; margin-top: -2px">
                            <input type="radio" name="role" <?php if (isset($role)
                                && $role=="Demonstrator") echo "checked";?> value="Demonstrator">Demonstrator <br>
                            <input type="radio" name="role" <?php if (isset($role)
                                && $role=="Lead Demonstrator") echo "checked";?> value="Lead Demonstrator">Lead Demonstrator <br>
                            <input type="radio" name="role" <?php if (isset($role)
                                && $role=="3D Hub Manager") echo "checked";?> value="3D Hub Manager">3D Hub Manager <br>
                            <input type="radio" name="role" <?php if (isset($role)
                                && $role=="PR Manager") echo "checked";?> value="PR Manager">PR Manager <br>
                            <input type="radio" name="role" <?php if (isset($role)
                                && $role=="Technical Manager") echo "checked";?> value="Technical Manager">Technical Manager <br>
                            <input type="radio" name="role" <?php if (isset($role)
                                && $role=="IT Manager") echo "checked";?> value="IT Manager">IT Manager <br>
                            <input type="radio" name="role" <?php if (isset($role)
                                && $role=="IT") echo "checked";?> value="IT">IT <br>
                            <input type="radio" name="role" <?php if (isset($role)
                                && $role=="Co-Coordinator") echo "checked";?> value="Co-Coordinator">Co-Coordinator <br>
                        </div> <!-- Class radio -->
                    </div> <!-- /form-group -->
                    <!--This button submits the update action-->
                    @include('layouts.errors')
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>

            <div class="col-sm-4"></div>
        </div>
    </div>
@endsection
