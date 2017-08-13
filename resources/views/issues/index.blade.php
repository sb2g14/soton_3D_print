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
        <a href="/issues/select" type="button" class="btn btn-lg btn-info">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </a>
    </div>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Printer Number</th>
                    <th>Serial Number</th>
                    <th>Printer Status</th>
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
                        <td data-th="Printer Number">{{$issue->printers_id}}</td>
                        <td data-th="Serial Number">{{$issue->serial_number}}</td>
                        <td data-th="Printer Status">{{ $issue->printer_status }}</td>
                        <td data-th="Created by">{{ $issue->users_name_created_issue}}</td>
                        <td data-th="Created on">{{ isset($issue->Date)  ? $issue->Date : $issue->created_at->toDayDateTimeString() }}</td>
                        <td data-th="Days out of Order">{{ isset($issue->Date) ? $issue->days_out_of_order : floor((strtotime($issue->updated_at) - strtotime($issue->created_at)) / (60 * 60 * 24)) }}</td>
                        <td data-th="Title">{{ isset($issue->title) ? $issue->title : "Issue with printer ".$issue->printers_id }}</td>
                        <td data-th="Message">{{ $issue->body }}</td>
                        <td data-th="Modify"><a href="/issues/update/{{$issue->id}}" class="btn btn-info">Update/Resolve</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
