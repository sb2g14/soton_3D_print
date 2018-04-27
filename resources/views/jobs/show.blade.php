@extends('layouts.layout')

@section('content')
    <div class="title m-b-md">
        Job details
    </div>

    

    <div class="container well">
        <div class="row vdivide">
            <div class="col-sm-6 text-left job-details">
                <div class="alert alert-info text-left">
                    <p>
                        Job number: <b>{{$job->id}}</b><br>
                        Job title: <b>{{$job->job_title}}</b><br>
                        
                        Requested by: <b>{{$job->customer_name}}</b><br>
                        Requester id: <b>{{$job->customer_id}}</b><br>
                        Requester email: <b>{{$job->customer_email}}</b><br>
                        
                        Requested on: <b>{{ $job->created_at->toDayDateTimeString() }}</b> by: <b>{{$job->customer_name}}</b><br>
                        @if($job->approved_at)
                            Approved on: <b>{{ $job->approved_at()->toDayDateTimeString() }}</b> 
                            by: <b>{{$job->staff_approved->name()}}</b><br>
                        @endif
                        @if($job->finished_at)
                            Completed on: <b>{{ $job->finished_at()->toDayDateTimeString() }}</b> 
                            by: <b>{{$job->staff_finished->name()}}</b><br>
                        @endif
                        
                        Status: <b>{{$job->status}}</b><br/>
                        Estimated duration: <b>{{$job->total_duration}}</b><br>
                        Estimated material amount: <b>{{$job->total_material_amount}} grams</b><br>
                        Payment category: <b>{{$job->payment_category}}</b><br>
                        Price: <b>£{{$job->total_price}}</b><br>
                        Cost code: @if($job->use_case == 'Cost Code - approved') 
                            <b style="color: forestgreen"> {{$job->cost_code}} 
                        @elseif($job->use_case == 'Cost Code - unknown')
                            <b style="color: red"> {{$job->cost_code}} 
                        @else 
                            <b style="color: forestgreen"> {{$job->use_case}} 
                        @endif </b><br>
                        
                        Comment: <b>{{$job->job_approved_comment}}</b><br>
                    </p>
                </div>
               
            </div>
            <div class="col-sm-6">
                <div id="reviewJob" class="text-center card">
                    <h4>Prints:</h4><br>
                    @foreach($prints as $print)
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
    </div>
@endsection

@section('scripts')
    <script src="/js/validate_form.js"></script>
@endsection


