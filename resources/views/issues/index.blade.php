@extends('layouts.layout')
@section('content')
    <style>
        .full-height {
            height: 140vh;
        }
    </style>

    @if ($flash=session('message'))
        <div id="flash_message" class="alert {{ session()->get('alert-class', 'alert-info') }}" role="alert" style="position: relative">
            {{ $flash }}
        </div>
    @endif

    <!-- <div class="row">
        <div class="col-lg-12">
            <a href="/issues/select" class="btn btn-lg btn-info pull-left" style="margin-left:10%">Log New Issue</a>
        </div>
    </div> -->

    <div class="text-center m-b-md add-printer-issue">
        <div class="title">Printer Issues</div>
    </div>

    <div class="container">
        <a href="/issues/select" type="button" class="btn pull-right btn-success">
            Raise New
        </a>
        <a href="/printers/index" type="button" class="btn pull-left btn-danger">
            View all printers
        </a>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Printer Number</th>
                    <th>Serial Number</th>
                    <th>Issue Associated Printer Status</th>
                    <th>Created by</th>
                    <th>Created on</th>
                    <th>Days out of Order</th>
                    <th>Title</th>
                    <th style="width: 200px;">Message</th>
                    <th>Modify</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($issues as $issue)
                    <tr class="text-left">
                        <td data-th="ID">{{ $issue->id }}</td>
                        <td data-th="Printer Number"><a href="/issues/show/{{ $issue->printers_id }}"> {{$issue->printers_id}} </a></td>
                        <td data-th="Serial Number">{{$issue->serial_number}}</td>
                        <td data-th="Issue Printer Status">{{ $issue->printer_status }}</td>
                        <td data-th="Created by">{{ $issue->issue_created->first_name}} {{ $issue->issue_created->last_name}}</td>
                        <td data-th="Created on">{{ $issue->created_at->formatLocalized('%d/%m/%Y') }}</td>
                        <td data-th="Days out of Order">{{ \Carbon\Carbon::now('Europe/London')->diffInDays($issue->created_at) }}</td>
                        <td data-th="Title">{{ isset($issue->title) ? $issue->title : "Issue with printer ".$issue->printers_id }}</td>
                        <td data-th="Message">{{ $issue->body }}</td>
                        <td data-th="Modify"><a href="/issues/update/{{$issue->id}}" class="btn btn-info">
                                Update/Resolve</a>
                        </td>
                        <td>@if($issue->created_at->addMinutes(5)->gte(\Carbon\Carbon::now('Europe/London')))
                            <span data-placement="top" data-toggle="popover" data-trigger="hover"
                                  data-content="Delete this issue from the database (this option is available only 5 minutes after creation). The printer status will be changed to Available.">
                                                            <a type="button" id="deleteIssue" href="/issues/delete/{{$issue->id}}"
                                                               class="close" style="color: red">&times;</a>
                                                    </span>
                            @endif</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')

    {{--Load notification--}}
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
@endsection
