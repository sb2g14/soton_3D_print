@extends('layouts.layout')

@section('content')
    @if ($flash=session('message'))
    <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
        {{ $flash }}
    </div>
    @endif

   
    <div class="text-center m-b-md">
        <div class="title">Pending Jobs</div>
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
