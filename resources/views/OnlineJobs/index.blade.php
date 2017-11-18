@extends('layouts.layout')

@section('content')
    {{--Load notification of an approved job--}}
    @if (notify()->ready())
        <script>
            swal({
                title: "{!! notify()->message() !!}",
                text: "{!! notify()->option('text') !!}",
                type: "{{ notify()->type() }}",
                showConfirmButton: true
            });
        </script>
    @endif

    {{--@if ($flash=session('message'))--}}
    {{--<div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">--}}
        {{--{{ $flash }}--}}
    {{--</div>--}}
    {{--@endif--}}

   
    <div class="container text-center m-b-md">
        {{--<div class="title">Pending Jobs</div>--}}
        <ul class="nav nav-pills nav-justified">
            <li class="active"><a href="#">Pending Requests</a></li>
            <li><a href="/printingData/approved">Pending Jobs</a></li>
            <li><a href="/printingData/approved">Assign Prints</a></li>
            <li><a href="/printingData/finished">Completed Jobs/Prints</a></li>
        </ul>


        @hasanyrole('LeadDemonstrator|administrator')
        {!! link_to_route('printingData.export',
        'Export Jobs to Excel', null,
        ['class' => 'btn btn-lg btn-primary']) !!}
        @endhasanyrole
    </div>
    
    {{--<div class="container">--}}
        {{----}}
        {{--<div class="row">--}}
            {{--<div class="col-xs-12">--}}
                {{--<ul class="list-group lsn">--}}
                    {{--@foreach($jobs as $job)--}}

                        {{--<li class="text-left well">--}}
                        {{--Print short description and a link--}}
                            {{--<p>--}}
                                {{--Requested by: <b>{{$job->customer_name}}</b><br>--}}
                                {{--Requested on: <b>{{ $job->created_at->toDayDateTimeString() }}</b><br>--}}
                                {{--Job is printed on <br>--}}
                                {{--@foreach($job->prints as $print)--}}
                                    {{--Printer number: <b>{{ $print->printers_id }}</b><br>--}}
                                {{--@endforeach--}}
                            {{--</p>--}}
                            {{--<a href="/printingData/show/{{$job->id}}" class="btn btn-info">Manage</a>--}}
                        {{--</li>--}}
                    {{--@endforeach--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@endsection
