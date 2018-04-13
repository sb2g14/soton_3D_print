@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Frequently Asked Questions
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 pull-left">
                <input class="form-control" id="searchInput" type="text" placeholder="Search.." autocomplete="off">
            </div>
            {{--<div class="col-lg-2 pull-right">
                <a href="/faq/create" type="button" class="btn btn-success pull-right">
                    Add New FAQ
                </a>
            </div>--}}
        </div>
        {{--FAQ LIST--}}
        <div id="faqlist" class="row">
            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" data-target="#answer-1">3D printing WHAT???</div>
                <div id="answer-1" class="panel-body text-left collapse">
                    <p>You heard about 3D printing, think that it may be useful to you, but have no idea where to start?
                   Best is, if you drop into one of our sessions and ask one of our demonstrators. If you want to know more about 3D printing before, why not visit our <a href="/learn">introduction to 3D printing</a>?
                    </p>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" data-target="#answer-2">How do you charge for prints? How much does a print cost?</div>
                <div id="answer-2" class="panel-body text-left collapse">
                    <p>We charge based on the amount of material used and the duration of the print. 
                   The cost is &pound;{{config('prices')['material']}}/100g of material 
                   and &pound;{{config('prices')['time']}}/h of printing time. <br/>
                   You will have to provide a university budget code in order to use this service. 
                   If you are a student printing for your coursework or bachelor/ master project, you
                   can use the module code followed by the first letters of your cohort to print.
                   Alternatively your module coordinator may have provided you with a special code.<br/> 
                Note: <i>Please accept that you currently can not buy and use your own material to save printing cost.</i></p>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" data-target="#answer-3">What printers do you have?</div>
                <div id="answer-3" class="panel-body text-left collapse">
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
                                    <td data-th="Printer model">{{$printer['name']}}</td>
                                    <td data-th="Number available">{{$printer['count']}}</td>
                                    <td data-th="Printing material">{{$printer['material']}}</td>
                                    <td data-th="Print speed">{{$printer['speed']}}</td>
                                    <td data-th="Print size">{{$printer['size']}}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    
                    <p>If the order can not be printed in the workshop, here is the list of printers available for online requests:</p>
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
                                <td data-th="Printer model">{{$printer['name']}}</td>
                                <td data-th="Number available">{{$printer['count']}}</td>
                                <td data-th="Printing material">{{$printer['material']}}</td>
                                <td data-th="Print speed">{{$printer['speed']}}</td>
                                <td data-th="Print size">{{$printer['size']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <p>
                        For Part III and IV UG student, MSc, researcher and staff projects with a sub-project cost (‘budget’) code,
                        the EDMC offers further 3D printing options, for example binder jet powder printing (ABS) and Direct Metal
                        Laser Sintering (typically stainless steel). Please have a look at the
                        <a href="https://www.southampton.ac.uk/autonomous-systems/about/ecdm-workshop.page">
                            EDMC manufacturing methods</a>. Relevant details can be found on the page of the
                        <a href="https://groupsite.soton.ac.uk/Academic/FEE-Engineering-Design-and-Manufacturing-Centre/Pages/Home.aspx">
                            FEE Engineering Design and Manufacturing Centre</a>, in particular the
                        <a href="https://groupsite.soton.ac.uk/Academic/FEE-Engineering-Design-and-Manufacturing-Centre/_layouts/WordViewer.aspx?id=/Academic/FEE-Engineering-Design-and-Manufacturing-Centre/Documents/FEE-Workshop-Facilities-available-for-Student%2BResearcher%2BStaff-Use.docx">
                            'FEE Workshop Facilities available for Student Researcher Staff Use' file</a> in the Documents folder.
                    </p>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" data-target="#answer-10">What else does the university offer?</div>
                <div id="answer-10" class="panel-body text-left collapse">
                    <p>
                        For Part III and IV UG student, MSc, researcher and staff projects with a sub-project cost (‘budget’) code,
                        the EDMC offers further 3D printing options, for example binder jet powder printing (ABS) and Direct Metal
                        Laser Sintering (typically stainless steel). Please have a look at the
                        <a href="https://www.southampton.ac.uk/autonomous-systems/about/ecdm-workshop.page">
                            EDMC manufacturing methods</a>. Relevant details can be found on the page of the
                        <a href="https://groupsite.soton.ac.uk/Academic/FEE-Engineering-Design-and-Manufacturing-Centre/Pages/Home.aspx">
                            FEE Engineering Design and Manufacturing Centre</a>, in particular the
                        <a href="https://groupsite.soton.ac.uk/Academic/FEE-Engineering-Design-and-Manufacturing-Centre/_layouts/WordViewer.aspx?id=/Academic/FEE-Engineering-Design-and-Manufacturing-Centre/Documents/FEE-Workshop-Facilities-available-for-Student%2BResearcher%2BStaff-Use.docx">
                            'FEE Workshop Facilities available for Student Researcher Staff Use' file</a> in the Documents folder.
                    </p>
                </div>
            </div>
            
            @if(Auth()->user())
                <div class="panel panel-default">
                    <div class="panel-heading" data-toggle="collapse" data-target="#answer-6">How do I sign up for sessions?</div>
                    <div id="answer-6" class="panel-body text-left collapse">
                        <p>We are not using the Excel spreadsheet to create the rotas anymore. Instead you should go to "Staff &gt; Rota" and update your availability there using the "Indicate Availability" button. You can also click on your name in the menu and select "Update Availability".<br/>
                            When signing up, you will be prompted with the next couple of sessions when the service is meant to be opened. Please select your availability for each session. Selecting "available" means that you are available and want to demonstrate for that session. If you choose to be tentatively available, you will only be scheduled, if not enough people have signed up for that shift. If you choose busy or away, you indicate that you won't be available for that day and time and you will not be scheduled.
                        </p>
                    </div>
                </div>
            @endif
            @can('staff_manage')
                <div class="panel panel-default">
                    <div class="panel-heading" data-toggle="collapse" data-target="#answer-7">How do I create a rota?</div>
                    <div id="answer-7" class="panel-body text-left collapse">
                        <p>Managing the rota is the resonsibility of the Lead Demonstrator.<br/>
                            As a first step, you need to schedule sessions. Please go to "Staff &gt; Rota" and select a date next to the "Add Session" button. Then click that button to go to that date and add sessions. <br/>
                            Enter the start time and end time for a session, select how many demonstrators are required and choose if the session is public or not. You can use this option, to influence if the session will be shown as an official opening hour or not.
                            Once you added the sessions, wait for demonstrators to fill in their availability. <br/>
                            Before the start of the next session, go to "Staff &gt; Rota" and select "Assign" next to the session to assign demosntrators to. The rota will display with demonstrators pre-allocated. The algorithm tries to ensure that every session contains at least one experienced demonstrator and that every demonstrator get assigned regularly. Use the drop-down to adjust the rota to your liking. Once happy, click the "Save" button. Only afterwards, click the "Email" button, to send the rota out to all staff. You can add a text of your own as appropriate. The email will also contain a reminder for demosntrators to indicate their availability, so make sure that you always have a couple of sessions scheduled in advance!
                        </p>
                    </div>
                </div>
                
                <div class="panel panel-default">
                    <div class="panel-heading" data-toggle="collapse" data-target="#answer-8">What do I use events for?</div>
                    <div id="answer-8" class="panel-body text-left collapse">
                        <p>Events are there to remind you of the busy periods of university and closure periods. They are entirely for your own benefit. We recommend you to add the university key dates for the next half a year every couple of month. Use the "Internal Event" option, to keep track of training sessions for first years or demonstrators get togethers.
                        </p>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" data-toggle="collapse" data-target="#answer-9">What is the "public session" option for?</div>
                    <div id="answer-9" class="panel-body text-left collapse">
                        <p>A session is an instance in time, when demonstrators are in the workshop. Usually, during a session, they will help students to 3D print. But not all sessions are meant for all students. Sometimes you may want to schedule a session for invited students only. An example of this is a training session for first year students. These sessions you can mark as private, so that they are not shown in our official opening hours.
                        </p>
                    </div>
                </div>
            @endcan
            @hasrole('administrator')
                <div class="panel panel-default">
                    <div class="panel-heading" data-toggle="collapse" data-target="#answer-11">How does Laravel work?</div>
                    <div id="answer-11" class="panel-body text-left collapse">
                        <p>Here is a very short introduction to Laravel:
                            The URL you type in the browser is checked in routes/web.php. From there a function is called in a controller as ControllerName@functionName. The controllers are in app/Http/Controllers. The functions there will execute all the main php stuff before loading a blade as foldername.bladename. You can find the blades in resources/views. If you want to edit the stylesheet, go to resources/assets/less. Make sure that the output is compiled into public/css. If you want to edit javascript functions, go to resources/assets/js. Make sure that the output is compiled into public/js. 
                        </p>
                    </div>
                </div>
            @endhasrole
            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" data-target="#answer-4">I want to become a demonstrator, how can I join?</div>
                <div id="answer-4" class="panel-body text-left collapse">
                   <p>We are always looking for new demonstrators. Please contact our Lead Demonstrator to arrange for a training session.</p>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" data-target="#answer-5">I had a look at your website and there are a few things I think can be improved...</div>
                <div id="answer-5" class="panel-body text-left collapse">
                   <p>Found a bug? Report it to our IT Manager. <br/>
                   Have an idea what could be improved? Email our IT Manager and we will add it to our list of things to do. <br/>
                   Want to get it done fast and earn some money doing so? Why not join our team! Knowledge in SQL, PHP (Laravel), JavaScript (jQuery, NodeJS), HTML and CSS (LESS) is preferred but not required. You should have some programming experience though. Just email our IT Manager and we are happy to introduce you to the team.</p>
                </div>
            </div>
        </div>{{--END OF FAQ LIST--}}
    </div>
@endsection

@section('scripts')
    {{--Make faq div searchable--}}
    <script>
    $(document).ready(function(){
      $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#faqlist .panel").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
    </script> 
@endsection
