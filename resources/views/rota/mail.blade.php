@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Email the rota to everyone.
    </div>
    {{--TODO: remember to have a "reply to all demonstrators" set for the email, so they can discuss if they become unavailable!--}}
    <div class="container">
        <div class="row">
            
            <form method="post" class="form-horizontal" action="/rota/email/{{$date}}">
                {{ csrf_field() }}
                <input id="date" name="date" type="text" hidden value="{{$date}}" />
                <div class="col-sm-12 well text-left">
                    Dear Demonstrator,<br/>
                    Please find the rota for <b>{{ Carbon\Carbon::parse($date)->format('D, dS \\of M Y') }}</b> as below.<br/>
                    <table>
                        <tbody>
                            @foreach($sessions as $s)
                                @php
                                    $starttime = Carbon\Carbon::parse($s->start_date)->format('G:i');
                                    $endtime = Carbon\Carbon::parse($s->end_date)->format('G:i');
                                @endphp
                                <tr>
                                    <td class="text-right">   
                                        {{$starttime}} &ndash; {{$endtime}} &nbsp;
                                    </td>
                                    <td class="text-left">
                                        @if($s->staff()->count()>0)
                                            @php
                                                $dems = [];
                                                foreach($s->staff as $dem){
                                                    $dems[] = $dem->first_name.' '.$dem->last_name;
                                                }
                                            @endphp
                                            {!!implode(", ",$dems)!!}
                                        @else
                                            (to be decided)
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table><br/>
                    <div id="comment_group">
                        <textarea id="comment" name="comment" type="text" class="input-lg col-lg-12" /></textarea>
                        <span id="comment_error"></span><br/>
                    </div>
                    <b>Please remember to indicate your availability for the future sessions by clicking on the button below!</b><br/>
                    <a href="/availability" class="btn btn-primary">
                        Indicate Availability
                    </a><br/>
                    Kind regards,<br/>
                      {{ Auth()->user()->staff->name() }}
                </div>
                <div class="col-sm-12">    
                    <button id="submit" name="btn_update" type="submit" class="btn btn-lg btn-success" value="{{$date}}">
                        <i class="fa fa-envelope"></i> Send
                    </button>
                    <a type="button" class="btn btn-lg btn-danger" href="/rota/assign/{{$date}}">
                        <i class="fa fa-times"></i> Cancel
                    </a>
                </div>
            </form>
            
        </div>
        
    </div>
@endsection
@section('scripts')
    <script src="/js/validate_form.js"></script>
@endsection

