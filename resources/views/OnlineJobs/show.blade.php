@extends('layouts.layout')

@section('content')
    {{--TITLE--}}
    <div class="text-center m-b-md">
        <div class="title">Job #{{$job->id}}: {{$job->job_title}}</div>    
    </div>

    @php
        $isCustomer = false; 
        if($job->customer_name === Auth::user()->name()){
           $isCustomer = true; 
        }
    @endphp

    {{--NAVIGATION--}}
    <div class="container">
        @if($isCustomer)
            <div class="pull-left">
                <span class="text-justify" data-placement="top" data-toggle="popover"
                    data-trigger="hover" data-content="View all your jobs">
                    <a type="button" class="btn btn-primary" href="/myprints">
                        Back
                    </a>
                </span>
            </div>
        @else
            <div class="pull-left">
                <span class="text-justify" data-placement="top" data-toggle="popover"
                    data-trigger="hover" data-content="View all jobs">
                    <a type="button" class="btn btn-primary" 
                        @if($job->status === 'Waiting')
                            href="/OnlineJobs/requests"
                        @elseif($job->status === 'Approved')
                            href="/OnlineJobs/approved"
                        @elseif($job->status === 'In Progress')
                            href="/OnlineJobs/pending"
                        @else
                            href="/OnlineJobs/finished"
                        @endif
                    >
                        View All
                    </a>
                </span>
            </div>
        @endif
        <hr>
    </div>

    <div class="container well">
        <div class="row vdivide">
            <div class="@if(Auth::user()->hasAnyPermission(['manage_online_jobs'])) col-sm-6 @else col-sm-12 @endif text-left job-details">
                <div class="text-left">
                    <p>
                        Job number: <b>{{$job->id}}</b><br>
                        Job title: <b>{{$job->job_title}}</b><br>
                        @if(!$isCustomer)
                            Requested by: <b>{{$job->customer_name}}</b><br>
                            Requester id: <b>{{$job->customer_id}}</b><br>
                            Requester email: <b>{{$job->customer_email}}</b><br>
                        @endif

                        Status: <b>{{$job->status}}</b><br/>
                        Estimated duration: <b>{{$job->total_duration}}</b><br>
                        Estimated material amount: <b>{{$job->total_material_amount}} grams</b><br>
                        Payment category: <b>{{$job->payment_category}}</b><br>
                        Price: <b>£{{$job->total_price}}</b><br>
                        Cost code: 
                        @if($job->use_case == 'Cost Code - approved') 
                            <b style="color: forestgreen"> {{$job->cost_code}} 
                        @elseif($job->use_case == 'Cost Code - unknown')
                            <b style="color: red"> {{$job->cost_code}} 
                        @else 
                            <b style="color: forestgreen"> {{$job->use_case}} 
                        @endif
                            </b><br>
                        
                    </p>
                    @if(Auth::user()->hasAnyPermission(['manage_online_jobs']))
                        <a class="btn btn-primary" 
                            href="https://dropoff.soton.ac.uk/pickup.php?claimID={{$job->claim_id}}&claimPasscode={{$job->claim_passcode}}&emailAddr=3dprint.soton%40gmail.com">
                            Download .stl files
                        </a>
                    @endif

                </div>
            </div>
{{-- detailed info for Online Managers: --}}
@if(Auth::user()->hasAnyPermission(['manage_online_jobs']))
    @if($job->status === 'Waiting')
            {{--Assign print previews to a requested job--}}
            @include('OnlineJobs.parts.assignPrintPreviews')
    @elseif($job->status === 'Approved')

            <div class="col-sm-6 text-left">
                <h3>Total job stats</h3>
                {{-- Calculate total print time --}}
                <p>Total print duration: <b>{{ $job->total_duration }}</b> <br>
                Total material amount: <b>{{ $job->total_material_amount }}g</b> <br>
                Total price: <b>£{{ $job->total_price }}</b>
                </p>
                <p>
                    Approved on {{ \Carbon\Carbon::parse($job->approved_at)->toDayDateTimeString() }} by {{ $job->staff_approved->first_name }} {{ $job->staff_approved->last_name }}
                </p>
            </div>
        </div>
        {{--Job control buttons--}}
        <div class="row">
            <div class="col-sm-12">
                @if(Auth::user()->hasRole(['OnlineJobsManager']))
                    <a href="/OnlineJobs/approved" class="btn btn-lg btn-primary">Back</a>
                @else
                    <a href="/myprints" class="btn btn-lg btn-primary">Back</a>
                @endif
                <a href="/OnlineJobs/approved/{{$job->id}}/reject" class="btn btn-lg btn-danger">Customer Rejected</a>
                <a href="/OnlineJobs/approved/{{ $job->id }}/accept" class="btn btn-lg btn-success">Customer Approved</a>
            </div>
        </div>


        @elseif($job->status === 'In Progress')

            {{--Assign prints to a requested job--}}
            @include('OnlineJobs.parts.assignPrints')
    @else

            <div class="col-sm-6">
                <div id="reviewJob" class="text-center card">
                    <h4>Prints:</h4><br>
                    @foreach($job->prints()->get() as $print)
                        <div class="alert alert-info text-left">
                            Print number: <b>{{$print->id}}</b><br>
                            Printer number: <b>{{ $print->printers_id }}</b><br/>
                            
                            Requested on: <b>{{ $print->created_at->toDayDateTimeString() }}</b> 
                            by: <b>{{$print->staff_started->name()}}</b><br>
                            @if($print->finished_at)
                                Completed on: <b>{{ $print->finished_at()->toDayDateTimeString() }}</b> 
                                by: <b>{{$print->staff_finished->name()}}</b><br>
                            @endif
                            
                            Status: <b>{{$print->status}}</b><br/>
                            Duration: <b>{{$print->time}}</b><br>
                            Material amount: <b>{{$print->material_amount}} grams</b><br>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>  
    @endif
@endif

    </div>
    <div id="messagelist" class="container" style="overflow-y:scroll; max-height:30%;">
        <div class="row">
            
            @foreach($events as $event)
                @php
                    if( ($isCustomer  && $event["Name"] === $job->customer_name )
                      ||(!$isCustomer && $event["Name"] !== $job->customer_name ) ){
                        $pull = "pull-right";
                    }else{
                        $pull = "pull-left";
                    }
                @endphp
                <div class="col-sm-10 well {{$pull}}">
                    <div class="text-left col-sm-12 text-primary">{{$event["Name"]}}</div>
                    <div class="text-left">{{$event["Message"]}}</div><div class="pull-right text-muted">{{$event["Date"]}}</div>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="container well">
        <div class="row">
            <div class="col-sm-12 pull-right">
                {!! Form::open(['url' => '/OnlineJobs/'.$job->id.'/message', 'method' => 'POST', 'class' => 'text-left']) !!}
                    {{--Job ID--}}
                    {!! Form::hidden('id',$job -> id) !!}
                    {{--Message--}}
                    <div class="form-group">
                        {!! Form::label('body', Auth::user()->name(), ['class' => 'control-label text-primary']) !!}
                        {!! Form::textarea('body', $value = null, ['class' => 'form-control', 'placeholder' => 'Write message...', 'id' => 'job_message']) !!}
                        <span id="job_message_error"></span> <br/>
                    </div>
                    {{--Buttons--}}
                    <div class="col-sm-12 text-center">
                        {{-- Form::submit('Submit', ['class' => 'btn btn-lg btn-success', 'id' => 'submit'] ) --}}
                        <button id="submit" type="submit" class="btn btn-lg btn-success">
                            <i class="fa fa-paper-plane"></i> Send
                        </button>
                        <button id="reset" type="reset" class="btn btn-lg btn-danger">
                            <i class="fa fa-eraser"></i> Clear
                        </button>
                        @if($isCustomer && $job->status === 'Approved')
                            <a class="btn btn-lg btn-success" href="/OnlineJobs/approved/{{$job->id}}/accept">Accept Job</a>
                            <a class="btn btn-lg btn-danger" href="/OnlineJobs/approved/{{$job->id}}/reject">Reject Job</a>
                        @endif

                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

{{-- MODALS --}}
@if(Auth::user()->hasAnyPermission(['manage_online_jobs']))
    @if($job->status === 'Waiting')
        <!-- Modal assign print Preview-->
        @include('OnlineJobs.modal.assignPrintPreview')
    @elseif($job->status === 'In Progress')
        <!-- Modal assign prints-->
        @include('OnlineJobs.modal.assignPrint')
    @endif
    <!-- Modal add comment to a rejected job-->
    @include('OnlineJobs.modal.rejectJob')
@endif

@endsection

@section('scripts')
    <script>
        // Scroll to bottom of message list
        $(document).ready(function(){
            var $messagelist = $('#messagelist');
            $messagelist.scrollTop($messagelist[0].scrollHeight);
        });
    </script>
    <!-- TODO: need to load custom validation scripts here -->
    <script src="/js/validate_form_online_job_message.js"></script>
    <script src="/js/validate_form_online_print.js"></script>
    <script src="/js/validate_form_online_job_reject.js"></script>
@endsection


