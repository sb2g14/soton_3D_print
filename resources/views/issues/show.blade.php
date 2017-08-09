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

    <div class="title m-b-md">
        Performance history of Printer {{ $id }}
    </div>

<ul>
                      
    @foreach($issues as $issue)

        <li>

            <div class="container well">
                <div class="alert alert-warning">
                    <div class="row">
                        <div class="col-sm-12 text-left"><h3><b>{{ isset($issue->title) ? $issue->title : 'Issue with printer '.$issue->printers_id }}:</b></h3></div>
                    </div>
                    <div class="row vdivide">
                        <div class="col-sm-3 text-left">
                            <p>Created by</p>
                            <p><b>{{$issue->users_name_created_issue}}</b></p>
                        </div>
                        <div class="col-sm-3 text-left">
                            <p>Created on</p>
                            <p>{{ isset($issue->Date)  ? $issue->Date : $issue->created_at->toDayDateTimeString()}}</p>
                        </div>
                        <div class="col-sm-3 text-left">
                            <p>Printer Status</p>    
                            <p style="color:red;"><b>{{$issue->printer_status}}</b></p>
                        </div>
                        <div class="col-sm-3 text-left">
                            <p>Days out of Order</p>
                            <p style="color:red;"><b>{{ isset($issue->Date) ? $issue->days_out_of_order : floor((strtotime($issue->updated_at) - strtotime($issue->created_at)) / (60 * 60 * 24))}}</b></p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-8 text-left">
                        <p style="font-size: 18px;"><b>Description:</b></p>
                        <p style="font-size: 18px;">{{ $issue->body }}</p>
                    </div>
                        @hasanyrole('LeadDemonstrator|Demonstrator|administrator')
                        <div class="col-sm-4">
                            @if($issue->resolved == 0)
                            <a href="/issues/update/{{$issue->id}}" class="btn btn-lg btn-info">View/Update or Resolve</a>
                            @endif
                        </div>
                        @endhasanyrole
                </div>

                @if(!empty(array_filter( (array) $issue->FaultUpdates)))

                    <hr>
                    <div class="text-left">
                        <h3>ISSUE LOG:</h3>
                    </div>

                    <ul> 

                        @foreach($issue->FaultUpdates as $update)
                    
                            <div class="alert alert-info">
                                <div class="row">
                                    <div class="col-sm-12 text-left"><h3><b>Issue update {{$update->id}}</b></h3></div>
                                </div>
                                <div class="row vdivide ">
                                    <div class="col-sm-4 text-left">
                                        <p>Created by</p>
                                        <p><b>{{$update->users_name}}</b></p>
                                    </div>
                                    <div class="col-sm-4 text-left">
                                        <p>Created on</p>
                                        <p>{{ $update->created_at->toDayDateTimeString() }}</p>
                                    </div>
                                    <div class="col-sm-4 text-left">
                                        <p>Printer Status</p>    
                                        <p style="color:red;"><b>{{$update->printer_status}}</b></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-8 text-left">
                                        <p style="font-size: 18px;"><b>Description</b></p>
                                        <p style="font-size: 18px;">{{ $update->body }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </ul>
                @endif

                @if($issue->resolved == 1)
                    

                    <div class="alert alert-success">
                        <div class="row">
                            <div class="col-sm-12 text-left"><h3><b>Issue resolved</b></h3></div>
                        </div>
                        <div class="row vdivide">
                            <div class="col-sm-4 text-left">
                                <p>Created by</p>
                                <p><b>{{$issue->users_name_resolved_issue}}</b></p>
                            </div>
                            <div class="col-sm-4 text-left">
                                <p>Resolved on</p>
                                <p>{{ isset($issue->Repair_Date) ? $issue->Repair_Date : $issue->updated_at->toDayDateTimeString() }}</p>
                            </div>
                            <div class="col-sm-4 text-left">
                                <p>Printer Status</p>    
                                <p><b>Available</b></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-8 text-left">
                                <p style="font-size: 18px;"><b>Resolve message:</b></p>
                                <p style="font-size: 18px;">{{ $issue->message_resolved }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </li>
    @endforeach    
</ul>
@include('layouts.errors')
@endsection
