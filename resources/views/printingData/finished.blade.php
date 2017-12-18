@extends('layouts.layout')

@section('content')


 <div class="container text-center m-b-md">
     <ul class="nav nav-pills nav-justified">
        <li><a href="/printingData/index">Pending Jobs</a></li>
        <li><a href="/printingData/approved">Approved Jobs / Printing</a></li>
        <li class="active"><a href="#">Completed Jobs</a></li>
    </ul>
</div>
    <!-- <div class="text-center m-b-md">
        <div class="title">Printing Jobs History</div>
        <a href="/printingData/index" class="btn btn-lg btn-danger">Show pending jobs</a>
        <a href="/printingData/approved" type="button" class="btn btn-lg btn-success" style="display: inline-block;">Show currently approved jobs</a>
        
    </div> -->

    <div class="container">
        <table class="table table-sm table-hover table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Printer</th>
                    <th>Job title</th>
                    <th>Name</th>
                    <th>Time</th>
                    <th>Material Amount</th>
                    <th>Price</th>
                    <th>Created</th>
                    <th>Last updated</th>
                    <th>Completed by</th>
                    <th>Status</th>
                    {{--@hasanyrole('LeadDemonstrator|administrator|OnlineJobsManager')--}}
                    <th>Edit</th>
                    {{--@endhasanyrole--}}
                </tr>
            </thead>
            <tbody>
                @foreach($finished_jobs as $job)
                    @php list($h, $i, $s) = explode(':', $job->total_duration);
                    $print = $job->prints->first()
                    @endphp
                    {{--Add number of hours job takes to the time when it was approved--}}
                    {{--Add number of minutes job takes--}}
                    @if (Carbon\Carbon::now('Europe/London')->gte(Carbon\Carbon::parse($job->approved_at)->addHour($h)->addMinutes($i)) || $job->status == 'Failed' || $job->status == 'Success')
                    <tr class="text-left">
                        <td data-th="ID">{{ $job->id }}</td>
                        <td data-th="Printer No">{{ $print->printers_id }}</td>
                        <td data-th="Job title">{{ $job->job_title  }}</td>
                        <td data-th="Name"><a href="mailto:{{$job->customer_email}}?Subject=Soton3Dprint Job {{ $job->id }}" target="_top">{{$job->customer_name}}</a></td>
                        {{--<td data-th="Payment Category">{{$job->payment_category}}</td>--}}
                        <td data-th="Time">{{ date("H:i", strtotime($job->total_duration)) }}</td>
                        <td data-th="Material Amount">{{ $job->total_material_amount }} g</td>
                        <td data-th="Price">£{{ $job->total_price }}</td>
                        <td data-th="Created on">{{ $job->created_at->formatLocalized('%d %b, %H:%m') }}</td>
                        <td data-th="Updated last">{{ Carbon\Carbon::parse($job->updated_at)->formatLocalized('%d %b, %H:%m') }}</td>
                        <td data-th="Completed by">{{ $job->staff_approved->first_name }} {{ $job->staff_approved->last_name }}</td>
                        @if ($job->status === 'Success')
                            <td data-th="Status" class="success">{{ $job->status }}</td>
                        @elseif ($job->status === 'Failed')
                            <td data-th="Status" class="danger">{{ $job->status }}</td>
                        @else
                            <td data-th="Status" class="info">{{ $job->status }}</td>
                        @endif
                        <td data-th="Edit">
                            {{--@hasanyrole('LeadDemonstrator|administrator|OnlineJobsManager')--}}
                            <a href="/printingData/edit/{{$job->id}}" class="btn btn-danger" data-placement="top"
                               data-toggle="popover" data-trigger="hover"
                               data-content="Be very cautious in editing finished jobs as this action will alter the
                               historic events!">Manage Job</a>
                            {{--@endhasanyrole--}}
                        </td>
                        {{--<td data-th="Restart">--}}
                            {{--@if($job->status == 'Failed')--}}
                            {{--<a href="/printingData/restart/{{$job->id}}" class="btn btn-primary">Restart</a>--}}
                            {{--@endif--}}
                        {{--</td>--}}
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
@section('scripts')
    <script src="/js/approve_job_validation.js"></script>
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