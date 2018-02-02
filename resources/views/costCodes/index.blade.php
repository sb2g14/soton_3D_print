@extends('layouts.layout')

@section('content')
    @if ($flash=session('message'))
        <div id="flash_message" class="alert alert-success" role="alert" style="position: relative; top: -10px">
            {{ $flash }}
        </div>
    @endif

    <div class="container text-center m-b-md">
        <ul class="nav nav-pills nav-justified">
            <li class="active"><a href="#">Active cost codes</a></li>
            <li><a href="/costCodes/expired">Expired cost codes</a></li>
        </ul>
    </div>

    <a href="/costCodes/create" class="btn btn-lg btn-success">Add cost code</a>

    <div class="container">
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
            <tbody>
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
                            <td data-th="Update"><a href="/costCodes/update/{{  $cost_code->id }}" class="btn btn-primary">Update</a></td>
                        </tr>

                @endforeach
            </tbody>
        </table>

    </div>

@endsection

@section('scripts')
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
