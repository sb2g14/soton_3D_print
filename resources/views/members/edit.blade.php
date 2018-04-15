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
                    <div id="first_name_group">
                        <label for="first_name">First name: </label> <br/>
                        <input id="first_name" name="first_name" type="text" class="form-control" value="{{ $member-> first_name}}"/>
                        <span id="first_name_error"></span><br/>
                    </div>
                    <div id="last_name_group">
                        <label for="last_name">Last name: </label><br>
                        <input id="last_name" name="last_name" type="text" class="form-control" value="{{ $member-> last_name}}"/>
                        <span id="last_name_error"></span><br>
                    </div>
                    <div id="student_id_group">
                        <label for="student_id">Student/staff ID: </label><br>
                        <input id="student_id" name="student_id" type="text" class="form-control" value="{{ $member-> student_id}}"/>
                        <span id="student_id_error"></span><br>
                    </div>
                    <div id="email_group">
                        <label for="email">Email: </label> <br>
                        <input id="email" name="email" type="email" class="form-control" value="{{ $member-> email}}"/>
                        <span id="email_error"></span><br>
                    </div>
                    <div id="phone_group">
                        <label for="phone">Phone: </label><br>
                        <input id="phone" name="phone" type="tel" class="form-control" value="{{ $member-> phone}}"/>
                        <span id="phone_error"></span><br>
                    </div>
                    @can('staff_manage')
                    <div class="field-inner">
                        <div class="form-group">
                            {!! Form::label('role', 'Role:' )  !!}
                            {!! Form::select('role',['Demonstrator'=>'Demonstrator', 'Lead Demonstrator'=>'Lead Demonstrator', '3D Hub Manager'=> '3D Hub Manager', 'PR Manager'=> 'PR Manager', 'Technical Manager' => 'Technical Manager', 'IT Manager' => 'IT Manager','IT'=>'IT', 'Coordinator'=> 'Coordinator', 'Co-Coordinator' => 'Co-Coordinator', 'Technician'=>'Technician','New Demonstrator'=>'New Demonstrator', 'Former member'=>'Former member' ], $member->role, ['class' => 'form-control' ]) !!}
                        </div>
                    </div>
                    @endcan
                    @if(Auth::user()->hasAnyRole(['Coordinator','administrator'])) {{--TODO: change to Coordinator only!--}}
                        <div id="cwpdate_group">
                            <label for="cwpdate">Date Casual Workers Permit was checked: </label><br>
                            <input id="cwpdate" name="cwpdate" type="text" class="form-control" value="{{ $member-> CWP_date}}"/>
                            <span id="cwpdate_error"></span><br>
                        </div>
                    @endif
                    @if(Auth::user()->hasAnyRole(['LeadDemonstrator','administrator'])) {{--TODO: change to Lead Demonstrator and IT only!--}}
                        <div id="smtdate_group">
                            <label for="smtdate">Specific module training attended on: </label><br>
                            <input id="smtdate" name="smtdate" type="text" class="form-control" value="{{ $member-> SMT_date}}"/>
                            <span id="smtdate_error"></span><br>
                        </div>
                    @endif
                    @if(Auth::user()->hasAnyRole(['LeadDemonstrator','Technician','administrator'])) {{--TODO: change to Technician, Lead Demonstrator, Coordinator only!--}}
                        <div id="lwidate_group">
                            <label for="lwidate">Workshop Induction attended on: </label><br>
                            <input id="lwidate" name="lwidate" type="text" class="form-control" value="{{ $member-> LWI_date}}"/>
                            <span id="lwidate_error"></span><br>
                        </div>
                    @endif
                    @include('layouts.errors')
                    <button id="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Changes</button>
                    <a type="button" class="btn btn-danger" href="/members/{{$member->id}}">
                        <i class="fa fa-cross"></i> Cancel
                    </a>
                </form>
            </div>

            <div class="col-sm-4"></div>
        </div>
    </div>
@endsection


@section("scripts")
    <script type="text/javascript">
            $(function () {
                $('#cwpdate').datetimepicker({format:'YYYY-MM-DD',showTodayButton:true,showClear:true,showClose:true});
                $('#smtdate').datetimepicker({format:'YYYY-MM-DD',showTodayButton:true,showClear:true,showClose:true});
                $('#lwidate').datetimepicker({format:'YYYY-MM-DD',showTodayButton:true,showClear:true,showClose:true});
            });
    </script>
    <script src="/js/validate_form.js"></script>
@endsection
