@extends('layouts.layout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h2>Login</h2></div>
                    <div class="panel-body">
                        <form id="login" class="form-horizontal" role="form" method="POST" action="{{ url('login') }}">
                            {{ csrf_field() }}

                            {{-- Add a hidden SAML Request field for SAML authentication --}}
                            @if(isset($_GET['SAMLRequest']))
                                <input type="hidden" id="SAMLRequest" name="SAMLRequest" value="{{ $_GET['SAMLRequest'] }}">
                            @endif

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Email</label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus autocomplete="work email">
                                    </div>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                    <td><span class="help-block" id="email_error"></span></td>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('passwords') ? ' has-error' : '' }}">
                                
                                <label for="password" class="col-md-4 control-label">Password</label>
                            
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        <input id="password" type="password" class="form-control" name="password" required>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                    <td><span class="help-block" id="password_error"></span></td>
                                </div>
                            </div>
                            {{--remember me button, use remember_token--}}
                            {{--<div class="form-group">--}}
                                {{--<div class="col-md-6 col-md-offset-4">--}}
                                    {{--<div class="checkbox">--}}
                                        {{--<label>--}}
                                            {{--<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4 text-left">
                                    <button id="login-button" type="submit" class="btn btn-primary">
                                        Login
                                    </button><br>
                                    @include('layouts.errors')
                                    {{--Forgot password button, send email--}}
                                    <a style="padding-left: 0;" class="btn btn-link" href="{{ route('auth.password.reset') }}">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>
                        <h2 style="color:red;">NOTE! The registration and login services are currently available ONLY for workshop staff</h2><br>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
{{--@section('scripts')--}}
    {{--<script src="/js/login_validation.js"></script>--}}
{{--@endsection--}}
