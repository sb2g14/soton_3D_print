@extends('layouts.layout')
@section('content')

    <div class="title m-b-md">
        Update the personal information
    </div>

     <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>

            <div class="col-sm-4 well">
                <form method="post" action="/members/edit/{{$member->id}}">

                    {{ csrf_field() }}

                    <label for="body">First name: </label> <br>
                        <input id="first_name" type="text" name="first_name" class="form-control" value="{{ $member-> first_name}}"/><br>
                        <td><span class="help-block" id="first_name_error"></span></td>
                    <label for="body">Last name: </label><br>
                        <input id="last_name" type="text" name="last_name" class="form-control" value="{{ $member-> last_name}}"/><br>
                        <td><span class="help-block" id="last_name_error"></span></td>
                    <label for="body">Student/staff ID: </label><br>
                        <input id="student_id" type="text" name="student_id" class="form-control" value="{{ $member-> student_id}}"/><br>
                    <label for="body">Email: </label> <br>
                        <input id="email" type="email" name="email" class="form-control" value="{{ $member-> email}}"/><br>
                        <td><span class="help-block" id="email_error"></span></td>
                    <label for="body">Phone: </label><br>
                        <input id="phone" type="text" name="phone" class="form-control" value="{{ $member-> phone}}"/><br>
                        <td><span class="help-block" id="phone_error"></span></td>
                    @can('staff_manage')
                    <div class="field-inner">
                        <div class="form-group">
                            {!! Form::label('role', 'Role' )  !!}
                            {!! Form::select('role',['Demonstrator'=>'Demonstrator', 'Lead Demonstrator'=>'Lead Demonstrator', '3D Hub Manager'=> '3D Hub Manager', 'PR Manager'=> 'PR Manager', 'Technical Manager' => 'Technical Manager', 'IT Manager' => 'IT Manager','IT'=>'IT', 'Coordinator'=> 'Coordinator', 'Co-Coordinator' => 'Co-Coordinator', 'Technician'=>'Technician','New Demonstrator'=>'New Demonstrator', 'Former member'=>'Former member' ], $member->role, ['class' => 'form-control' ]) !!}
                        </div>
                    </div>
                    @endcan
                    @include('layouts.errors')
                    <button id="submit" type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>

            <div class="col-sm-4"></div>
        </div>
    </div>
@endsection

@section("scripts")
    {{--<script src="/js/update_personal_validation.js"></script>--}}
    <script src="/js/validate_form.js"></script>
@endsection