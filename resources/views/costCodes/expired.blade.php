@extends('layouts.layout')

@section('content')
    
    <div class="text-center m-b-md">
        <div class="title">Expired Cost Codes</div> 
    </div>
    
    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
            {{ $flash }}
        </div>
    @endif

    {{--<div class="container text-center m-b-md">
        <ul class="nav nav-pills nav-justified">
            <li class="nav-left"><a href="/costCodes">Active cost codes</a></li>
            <li class="nav-right active"><a href="#">Expired cost codes</a></li>
        </ul>
    </div>--}}
    
    <div class="container">
        <div class="col-lg-2 pull-left">
            <a href="/costCodes" type="button" class="btn btn-primary pull-left">
                Active cost codes
            </a>
        </div>
        <hr>
    </div>

    <div class="container">
        <div class="col-lg-10 pull-left">
            <input class="form-control" id="searchInput" type="text" placeholder="Search.." autocomplete="off">
        </div>
        <div class="col-lg-2 pull-right">
            <a href="/costCodes/create" type="button" class="btn btn-success pull-right">
                Add cost code
            </a>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Shortage</th>
                    <th>Cost Code</th>
                    <th>Member of Staff Approved</th>
                    <th>Expiry Date</th>
                    <th>Holder</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody id="tableCostCodes">
                @foreach($cost_codes as $cost_code)

                        <tr class="text-left">
                            <td data-th="ID">{{ $cost_code->id }}</td>
                            <td data-th="Shortage">
                                <span class="text-justify" data-placement="top" data-toggle="popover"
                                 data-trigger="hover" data-content="{{$cost_code->explanation}}">{{ $cost_code->shortage }}</span>
                            </td>
                            <td data-th="Cost Code">
                                <span class="text-justify" data-placement="top" data-toggle="popover"
                                      data-trigger="hover" data-content="{{$cost_code->description}}">{{ $cost_code->cost_code }}</span>
                            </td>
                            <td data-th="Member of Staff Approved">{{ $cost_code->aproving_member_of_staff }}</td>
                            <td data-th="Expiry Date">{{ $cost_code->expires }} </td>
                            <td data-th="Holder"> {{ $cost_code->holder }}</td>
                            <td data-th="Update"><a href="/costCodes/update/{{  $cost_code->id }}" class="btn btn-info">Update</a></td>
                        </tr>

                @endforeach
            </tbody>
        </table>

    </div>

@endsection

@section('scripts')
    {{--Make table searchable--}}
    <script>
    $(document).ready(function(){
      $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tableCostCodes tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
    </script> 
    {{--Load notification--}}
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
