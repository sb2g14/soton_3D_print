@extends('layouts.layout')

@section('content')
    @if ($flash=session('message'))
    <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
        {{ $flash }}
    </div>
    @endif

   
    <div class=" container text-center m-b-md">
        <div class="title">Pending Jobs</div>
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#home">Pending Jobs</a></li>
            <li><a data-toggle="tab" href="#menu1">Approved Jobs / Printing</a></li>
            <li><a data-toggle="tab" href="#menu2">Completed Jobs</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
              <h3>HOME</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div id="menu1" class="tab-pane fade">
              <h3>Menu 1</h3>
              <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
            <div id="menu2" class="tab-pane fade">
              <h3>Menu 2</h3>
              <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
            </div>
        </div>
        <a href="/printingData/approved" type="button" class="btn btn-lg btn-success" style="display: inline-block;">Show currently approved jobs</a>

        @hasanyrole('LeadDemonstrator|administrator')
        {!! link_to_route('printingData.export',
        'Export Jobs to Excel', null,
        ['class' => 'btn btn-lg btn-primary']) !!}
        @endhasanyrole
    </div>
    
    <div class="container">
        
        <div class="row">
            <div class="col-xs-2 col-sm-4"></div>
            <div class="col-xs-8 col-sm-4">
                <ul class="list-group lsn">
                    @foreach($jobs as $job)

                        <li class="text-left well">
                        {{--Print short description and a link--}}
                            <p>
                                Printer number: <b>{{ $job->printers_id }}</b><br>
                                Requested by: <b>{{$job->student_name}}</b><br>
                                Requested on: <b>{{ $job->created_at->toDayDateTimeString() }}</b>
                            </p>
                            <a href="/printingData/show/{{$job->id}}" class="btn btn-info">Manage</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-xs-2 col-sm-4"></div>
        </div>
    </div>
@endsection
