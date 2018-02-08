@extends('layouts.layout')

@section('content')
    {{--<div class="title m-b-md">--}}
        {{--Manage Approved Job--}}
    {{--</div>--}}

    <div class="container well">
        <div class="row vdivide">

            {{--Review the request information and download the .stl files--}}
            <div class="col-sm-6 text-left job-details">
                <div class="alert alert-info text-left">
                    <p>
                        Requested on: <b>{{ $job->created_at->toDayDateTimeString() }}</b><br>
                        Requested by: <b>{{$job->customer_name}}</b><br>
                        Requester id: <b>{{$job->customer_id}}</b><br>
                        Requester email: <b>{{$job->customer_email}}</b><br>
                        Payment category: <b>{{$job->payment_category}}</b><br>
                        Cost code: @if($job->use_case == 'Cost Code - approved') <b style="color: forestgreen"> {{$job->cost_code}} @elseif($job->use_case == 'Cost Code - unknown')</b> <b style="color: red"> {{$job->cost_code}} @else <b style="color: forestgreen"> {{$job->use_case}} @endif  </b><br>
                        Budget Holder: <b> {{ $job->budget_holder }} </b> <br>
                        Job Title: <b> {{ $job->job_title }} </b> <br>
                        Job number: <b>{{$job->id}}</b><br>
                    </p>
                    <a class="btn btn-danger" href="https://dropoff.soton.ac.uk/pickup.php?claimID=
                                                 {{$job->claim_id}}&claimPasscode={{$job->claim_passcode}}
                            &emailAddr=3dprint.soton%40gmail.com">Download .stl files</a>
                </div>
            </div>

            {{--Assign prints to a requested job--}}
            <div class="col-sm-6 text-left">
                <h3>Total job stats</h3>
                {{-- Calculate total print time --}}
                <p>Total job duration: <b>{{ $job->total_duration }}</b> <br>
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
                <a href="/OnlineJobs/approved" class="btn btn-lg btn-info">Back</a>
                <a href="/OnlineJobs/customerReject/{{$job->id}}" class="btn btn-lg btn-danger">Customer Rejected</a>
                <a href="/OnlineJobs/customerApproved/{{ $job->id }}" class="btn btn-lg btn-success">Customer Approved</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
    <script src="/js/print_preview_validation.js"></script>
@endsection


