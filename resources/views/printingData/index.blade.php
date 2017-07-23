@extends('layouts.layout')

@section('content')
    @if ($flash=session('message'))
    <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
        {{ $flash }}
    </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <a href="/printingData/approved" class="btn btn-lg btn-info pull-left" style="position: relative; margin-left: 10%">Show approved jobs</a>
        </div>
    </div>

    <div class="title m-b-md">
        Pending Jobs
    </div>

    <ul class="container" style=" margin-top: -30px; text-align: center;">
        <div class="panel-body">
        <ul class="list-group">
            @foreach($jobs as $job)

                    <ul class="list-inline text-center well">
                    {{--Print short description and a link--}}
                        <li>
                            <h2 class="media-heading">
                                Printer number: <b>{{ $job->printers_id }}</b><br>
                                Requested by: <b>{{$job->student_name}}</b><br>
                                Requested on: <b>{{ $job->created_at->toDayDateTimeString() }}</b>
                            </h2>
                        </li>

                        <li>
                            <div>
                                <a href="/printingData/{{$job->id}}" class="btn btn-info">Manage</a>
                            </div>
                        </li>
                    </ul>
            @endforeach
        </ul>
            <hr>
        </div>
    </ul>
@endsection
