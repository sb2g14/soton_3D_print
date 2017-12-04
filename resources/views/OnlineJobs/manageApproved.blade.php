@extends('layouts.layout')

@section('content')
    <div class="title m-b-md">
        Manage Approved Job
    </div>

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
                        Module name or cost code:
                        @if($job->use_case == 'Cost Code - approved')
                            <b style="color: forestgreen">
                        @elseif($job->use_case == 'Cost Code - unknown')
                            <b style="color: red">
                        @endif {{$job->use_case}}
                            </b><br>
                        Cost code:
                        @if($job->use_case == 'Cost Code - approved')
                            <b style="color: forestgreen">
                        @elseif($job->use_case == 'Cost Code - unknown')
                            <b style="color: red">
                        @endif {{$job->cost_code}}
                            </b><br>
                        Job number: <b>{{$job->id}}</b><br>
                    </p>
                    <a class="btn btn-danger" href="https://dropoff.soton.ac.uk/pickup.php?claimID=
                                                 {{$job->claim_id}}&claimPasscode={{$job->claim_passcode}}
                            &emailAddr=3DPrintFEE%40soton.ac.uk">Download .stl files</a>
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
            </div>
            <hr>
            Approved on {{ \Carbon\Carbon::parse($job->approved_at)->toDayDateTimeString() }} by {{ $job->staff_approved->first_name }} {{ $job->staff_approved->last_name }}<br>
            Waiting for Customer to accept
        </div>
        {{--Job control buttons--}}
        <a href="/OnlineJobs/approved" class="btn btn-lg btn-info">Save Changes</a>
        <a href="/OnlineJobs/customerReject/{{ $job->id }}" class="btn btn-lg btn-danger">Customer Rejected</a>
        <a href="/OnlineJobs/customerApproved/{{ $job->id }}" class="btn btn-lg btn-success">Customer Accepted</a>
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


