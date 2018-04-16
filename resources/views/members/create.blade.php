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
                    <div id="first_name_group">
                        <label for="first_name">First name: </label> <br/>
                        <input id="first_name" name="first_name" type="text" class="form-control" value="{{ old('first_name') }}"/>
                        <span id="first_name_error"></span><br/>
                    </div>
                    <div id="last_name_group">
                        <label for="last_name">Last name: </label><br>
                        <input id="last_name" name="last_name" type="text" class="form-control" value="{{ old('last_name') }}"/>
                        <span id="last_name_error"></span><br>
                    </div>
                    {{--<div id="student_id_group">
                        <label for="student_id">Student/staff ID: </label><br>
                        <input id="student_id" name="student_id" type="text" class="form-control" value=""/>
                        <span id="student_id_error"></span><br>
                    </div>--}} 
                    <div id="email_group">
                        <label for="email">Email: </label> <br>
                        <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}"/>
                        <span id="email_error"></span><br>
                    </div>
                    {{--<div id="phone_group">
                        <label for="phone">Phone: </label><br>
                        <input id="phone" name="phone" type="tel" class="form-control" value=""/>
                        <span id="phone_error"></span><br>
                    </div>--}}
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

