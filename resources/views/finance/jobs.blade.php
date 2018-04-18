@extends('layouts.layout')

@section('content')
    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
            {{ $flash }}
        </div>
    @endif

 {{--<div class="container text-center m-b-md">
     <ul class="nav nav-pills nav-justified">
         <li><a href="/OnlineJobs/index">Requests <span class="badge">{{$counts['requests']}}</span></a></li>
         <li><a href=/OnlineJobs/approved>Approved Jobs <span class="badge">{{$counts['approved']}}</span></a></li>
         <li class="nav-left"><a href="/OnlineJobs/pending">Pending Jobs <span class="badge">{{$counts['pending']}}</span></a></li>
         <li class="nav-right"><a href="/OnlineJobs/prints">Prints</a></li>
         <li class="active"><a href="#">Completed Jobs</a></li>
    </ul>
  </div>--}}
    <!-- <div class="text-center m-b-md">
        <div class="title">Printing Jobs History</div>
        <a href="/printingData/index" class="btn btn-lg btn-danger">Show pending jobs</a>
        <a href="/printingData/approved" type="button" class="btn btn-lg btn-success" style="display: inline-block;">Show currently approved jobs</a>
        
    </div> -->

    <div class="container">
        <div class="title">Jobs in {{$t1->format('M Y')}}</div>
        <ul class="pagination">
          @foreach($pages as $p)
            @if($p == $t1)
                <li class="active">
            @else
                <li>
            @endif
            <a href="/finance/jobs/{{$p->toDateString()}}">{{$p->format('M')}}</a></li>
          @endforeach
        </ul> 
        <div class="row">
            <div class="col-lg-10 pull-left">
                <input class="form-control" id="searchInput" type="text" placeholder="Search.." autocomplete="off">
            </div>
            <!-- <div class="col-lg-2 pull-right">
                <a href="/finance/jobs/{{$t1->toDateString()}}/download" type="button" class="btn btn-info pull-right">
                    Download {{--Download all Jobs for this month (ignores filter)--}}
                </a>
            </div> -->
            <div class="col-sm-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Job ID</th>
                            <th>Date Created</th>
                            <th>Customer</th>
                            <th>Job Title</th>
                            <th>Cost Code</th>
                            <th>Budget Holder</th>
                            <th>Print Time</th>
                            <th>Material Amount</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="tableJobs">
                        @foreach($jobs as $job)
                            @php
                                if($job->status === 'Success'){
                                   $jobclass = "p-success";
                                }else{
                                   $jobclass = "p-failed";
                                }
                            @endphp
                            <tr class="text-left">
                                <td data-th="Job ID">{{ $job->id }}</td>
                                <td data-th="Date Created">{{ $job->created_at->formatLocalized('%d %b, %H:%M') }}</td>
                                <td data-th="Customer">{{$job->customer_name}} ({{$job->customer_id}})</td>
                                <td data-th="Job Title">{{ $job->job_title }}</td>
                                <td data-th="Cost Code">{{ $job->cost_code }}</td>
                                <td data-th="Budget Holder">{{ $job->budget_holder }}</td>
                                <td data-th="Time">{{ date("H:i", strtotime($job->total_duration)) }}</td>
                                <td data-th="Material Amount">{{ $job->total_material_amount }} g</td>
                                <td data-th="Price">£{{ $job->total_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <ul class="pagination">
          @foreach($pages as $p)
            @if($p == $t1)
                <li class="active">
            @else
                <li>
            @endif
            <a href="/finance/jobs/{{$p->toDateString()}}">{{$p->format('M')}}</a></li>
          @endforeach
        </ul> 
    </div>

@endsection

@section('scripts')
    {{--Make table searchable--}}
    <script>
    $(document).ready(function(){
      $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tableJobs tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
    </script> 
@endsection
