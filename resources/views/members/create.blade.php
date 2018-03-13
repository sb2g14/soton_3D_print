@extends('layouts.layout')
@section('content')

    <div class="title m-b-md">
        Add a new member     
    </div>

     <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>

            <div class="col-sm-4 well">
                <form method="post" action="/members">

                    {{ csrf_field() }}

                    <label for="first_name">First name: </label> <br>
                        <input id="first_name" type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" /><br>
                    <label for="last_name">Last name: </label><br>
                        <input id="last_name" type="text" name="last_name" class="form-control" value="{{ old('last_name') }}"/><br>
                    {{--<label for="body">Student/staff ID: </label><br>--}}
                        {{--<input type="text" name="student_id" class="form-control"/><br>--}}
                    <label for="email">Email: </label> <br>
                        <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}"/><br>
                    {{--<label for="phone">Phone: </label><br>--}}
                        {{--<input type="text" name="phone" class="form-control"/><br>--}}
                    <div class="field-inner">
                        <div class="form-group">
                            {!! Form::label('role', 'Role' )  !!}
                            {!! Form::select('role',['Demonstrator'=>'Demonstrator', 'Lead Demonstrator'=>'Lead Demonstrator', '3D Hub Manager'=> '3D Hub Manager', 'PR Manager'=> 'PR Manager', 'Technical Manager' => 'Technical Manager', 'IT Manager' => 'IT Manager','IT'=>'IT', 'Coordinator'=> 'Coordinator', 'Co-Coordinator' => 'Co-Coordinator', 'Technician'=>'Technician','New Demonstrator'=>'New Demonstrator' ], 'New Demonstrator', ['class' => 'form-control' ]) !!}
                        </div>
                    </div> <!-- /form-group -->
                    <!--This button submits the update action-->
                    @include('layouts.errors')
                    <button id="submit" type="submit" class="btn btn-success">Add</button>
                </form>
            </div>

            <div class="col-sm-4"></div>
        </div>
    </div>
@endsection
@section("scripts")
    <script src="/js/validate_form.js"></script>
@endsection

