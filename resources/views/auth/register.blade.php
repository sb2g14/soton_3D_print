@extends('layouts.layout')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h2>Register</h2></div>
                    <div class="panel-body">
                        <form id = "register" class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required><br>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                    <td><span class="help-block" id="name_error"></span></td>

                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('id_number') ? ' has-error' : '' }}">
                                <label for="id_number" class="col-md-4 control-label">Student/staff ID</label>

                                <div class="col-md-6">
                                    <input id="student_id" type="text" class="form-control" name="id_number" value="{{ old('id_number') }}" required><br>

                                    @if ($errors->has('id_number'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('id_number') }}</strong>
                                    </span>
                                    @endif
                                    <td><span class="help-block" id="student_id_error"></span> </td>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required><br>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                    <td><span class="help-block" id="email_error"></span></td>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required><br>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                    <td><span class="help-block" id="password_error"></span></td>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required><br>
                                    <td><span class="help-block" id="password_confirm_error"></span></td>
                                </div>
                            </div>
                            @include('layouts.errors')

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button id="register-button" type="submit" class="btn ">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                        <h3 style="color:red;">NOTE! The registration and login services are currently available ONLY for workshop staff</h3><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/register_validation.js"></script>
@endsection
