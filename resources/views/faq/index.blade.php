@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Frequently Asked Questions
    </div>
    <div class="container">
        <div class="col-sm-12 text-left">
            <p>You heard about 3D printing, think that it may be useful to you, but have no idea where to start?
                Best is to drop into one of our sessions and ask one of our demonstrators. If you want to know more
                about 3D printing before, why not visit our <a href="/learn">introduction to 3D printing</a>?
            </p>
        </div><br/>
        <div class="row">
            <div class="col-lg-9 pull-left">
                <input class="form-control" id="searchInput" type="text" placeholder="Search.." autocomplete="off">
            </div>
            <div class="pull-right">
                <a href="/faq/create" class="btn btn-success"  >Add New Question</a>
            </div>
        </div>
        
    </div>

    <br/>


    <div class="container well">

        <div id="faqlist" class="row">
            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" data-target="#Remain4">
                    What printers do you have?
                </div>
                <div id="Remain4" class="panel-body text-left collapse">
                    <p>Currently the workshop provides access to the following types of printers:</p>

                    <table class="table table-responsive table-hover table-sm">
                        <thead>
                        <tr>
                            <th>Printer model</th>
                            <th>Number available</th>
                            <th>Printing material</th>
                            <th>Print speed</th>
                            <th>Print size</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($workshop_printers as $printer)
                            <tr>
                                <td>{{$printer['name']}}</td>
                                <td>{{$printer['count']}}</td>
                                <td>{{$printer['material']}}</td>
                                <td>{{$printer['speed']}}</td>
                                <td>{{$printer['size']}}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                    <p>If the order can not be printed in the workshop, here is the list of printers available for
                        online requests:</p>
                    <table class="table table-responsive table-hover table-sm">
                        <thead>
                        <tr>
                            <th>Printer model</th>
                            <th>Number available</th>
                            <th>Printing material</th>
                            <th>Print speed</th>
                            <th>Print size</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($online_printers as $printer)
                            <tr>
                                <td>{{$printer['name']}}</td>
                                <td>{{$printer['count']}}</td>
                                <td>{{$printer['material']}}</td>
                                <td>{{$printer['speed']}}</td>
                                <td>{{$printer['size']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">

                <div class="panel-heading" data-toggle="collapse" data-target="#Remain1">
                    How do you charge for prints? How much does a print cost?
                </div>

                <div id="Remain1" class="panel-body text-left collapse">
                    <p>We charge based on the amount of material used and the duration of the print.
                        The cost is &pound;{{config('prices')['material']}}/100g of material
                        and &pound;{{config('prices')['time']}}/h of printing time. <br/>
                        You will have to provide a university budget code in order to use this service.
                        If you are a student printing for your coursework or bachelor/ master project, you
                        can use the module code followed by the first letters of your cohort to print.
                        Alternatively your module coordinator may have provided you with a special code.<br/>
                        Note: <i>Please accept that you currently can not buy and use your own material to save printing
                            cost.</i></p>
                </div>

            </div>
            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" data-target="#Remain2">
                    I had a look at your website and there are a few things I think can be improved...
                </div>
                <div id="Remain2" class="panel-body text-left collapse">
                    <p>Found a bug? Report it to our IT Manager. <br/>
                        Have an idea what could be improved? Email our IT Manager and we will add it to our list of
                        things to do. <br/>
                        Want to get it done fast and earn some money doing so? Why not join our team! Knowledge in SQL,
                        PHP (Laravel), JavaScript (jQuery, NodeJS), HTML and CSS (LESS) is preferred but not required.
                        You should have some programming experience though. Just email our IT Manager and we are happy
                        to introduce you to the team.</p>
                </div>
            </div>

            @foreach($faq as $item)
                <div class="panel panel-default">
                    <div class="panel-heading" data-toggle="collapse" data-target="#collapse{{$item->ID}}">
                        {{$item->Question}} 
                        <div class="pull-right">
                            <a href="/faq/edit/{{$item->ID}}"><i class="fa fa-edit"></i></a>
                        </div>
                    </div>
                    <div id="collapse{{$item->ID}}" class="panel-body text-left collapse">
                        <p> {{$item->Answer}}</p>
                    </div>
                </div>
            @endforeach


        </div>

    </div>

@endsection

@section('scripts')
    {{--Make faq div searchable--}}
    <script>
        $(document).ready(function () {
            $("#searchInput").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#faqlist .panel").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
