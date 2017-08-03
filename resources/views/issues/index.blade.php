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

    <div class="text-center m-b-md">
        <div class="title" style="display: inline-block; vertical-align: middle;">Printer Issues</div>
        <a href="/issues/select" type="button" class="btn btn-lg btn-info" style="display: inline-block;">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </a>
    </div>

    <div class="container">
        <table class="table">
            <thead>
                <tr style="font-weight: 600;">
                    <th style="vertical-align: top;">ID</th>
                    <th style="vertical-align: top;">Printer Number</th>
                    <th style="vertical-align: top;">Serial Number</th>
                    <th style="vertical-align: top;">Printer Status</th>
                    <th style="vertical-align: top;">Created by</th>
                    <th style="vertical-align: top;">Created on</th>
                    <th style="vertical-align: top;">Days out of Order</th>
                    <th style="vertical-align: top;">Title</th>
                    <th style="vertical-align: top;">Message</th>
                    <th style="vertical-align: top;">Modify</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($issues as $issue)
                    <tr style="text-align: left;">
                        <td>{{ $issue->id }}</td>
                        <td>{{$issue->printers_id}}</td>
                        <td>{{$issue->serial_number}}</td>
                        <td>{{ $issue->printer_status }}</td>
                        <td>{{ $issue->users_name_created_issue}}</td>
                        <td>{{ isset($issue->Date)  ? $issue->Date : $issue->created_at->toDayDateTimeString() }}</td>
                        <td>{{ floor((time() - strtotime($issue->created_at)) / (60 * 60 * 24)) }}</td>
                        <td>{{ isset($issue->title) ? $issue->title : "Issue with printer ".$issue->printers_id }}</td>
                        <td>{{ $issue->body }}</td>
                        <td><a href="/issues/update/{{$issue->id}}" class="btn btn-info">Update/Resolve</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
