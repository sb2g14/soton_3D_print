@extends('layouts.layout')

@section('content')
    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
            {{ $flash }}
        </div>
    @endif

 {{--<div class="container text-center m-b-md">--}}
     {{--<ul class="nav nav-pills nav-justified">--}}
        {{--<li><a href="/printingData/index">Pending Jobs</a></li>--}}
        {{--<li><a href="/printingData/approved">Approved Jobs / Printing</a></li>--}}
        {{--<li class="active"><a href="#">Completed Jobs</a></li>--}}
    {{--</ul>--}}
{{--</div>--}}
     <div class="text-center m-b-md">
        <div class="title">Cost Codes</div>
        <a href="/costCodes/create" class="btn btn-lg btn-success">Add cost code</a>
        {{--<a href="/printingData/approved" type="button" class="btn btn-lg btn-success" style="display: inline-block;">Show currently approved jobs</a>--}}

    </div>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Shortage</th>
                    <th>Cost Code</th>
                    <th>Member of Staff Approved</th>
                    <th>Expiry Date</th>
                    <th>Holder</th>
                    <th>Description</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cost_codes as $cost_code)
                    <tr class="text-left">
                        <td data-th="ID">{{ $cost_code->id }}</td>
                        <td data-th="Shortage">{{ $cost_code->shortage }}</td>
                        <td data-th="Cost Code">{{ $cost_code->cost_code }}</td>
                        <td data-th="Member of Staff Approved">{{ $cost_code->aproving_member_of_staff }}</td>
                        <td data-th="Expiry Date">{{ $cost_code->expires }} </td>
                        <td data-th="Holder"> {{ $cost_code->holder }}</td>
                        <td data-th="Description">{{ $cost_code->description }}</td>
                        <td data-th="Update"><a href="/costCodes/update/{{  $cost_code->id }}" class="btn btn-primary">Update</a></td>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
