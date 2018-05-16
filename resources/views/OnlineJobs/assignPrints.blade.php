{{--Assign prints to a requested job--}}
            <div class="col-sm-6 text-left">
                {{--List assigned prints--}}
                @foreach($job->prints as $print)
                @php list($h, $i, $s) = explode(':', $print->time);
                    $time_finish = $print->created_at->addHour($h)->addMinutes($i);
                @endphp
                    <div class="alert alert-warning">
                        @if($print->created_at->addMinutes(5)->gte(\Carbon\Carbon::now('Europe/London')))
                            <span data-placement="top" data-toggle="popover" data-trigger="hover"
                                  data-content="Delete this print only if the print has not started!">
                                <a type="button" id="deletePrint" href="/OnlineJobs/prints/{{$print->id}}/delete"
                                   class="close" style="color: red">&times;</a>
                            </span>
                        @endif
                        <p>
                            Print: <b>{{ $print->id }}</b> on Printer <b> {{ $print->printers_id }} </b> started <b> {{ $print->created_at->diffForHumans() }}</b> by <b>{{ $print->staff_started->first_name }} {{ $print->staff_started->last_name }}</b>
                            Material amount: <b>{{$print->material_amount}}g</b>
                            Total Time: <b>{{ $print->time }}</b>
                            Time Remain: <b>@if (Carbon\Carbon::now('Europe/London')->gte($time_finish) || $print->status == 'Success' || $print->status == 'Failed')  completed  @else {{ $time_finish->diffInHours(Carbon\Carbon::now('Europe/London')) }}:{{ sprintf('%02d', $time_finish->diffInMinutes(Carbon\Carbon::now('Europe/London'))%60)}} @endif</b>
                            Status: <b> {{ $print->status }} </b>
                        </p>
                        <p>
                            Comment: <b>{{$print->print_comment}}</b>
                        </p>
                        @if($print->status == 'In Progress')
                            <div class="text-right">
                                <a href="/OnlineJobs/prints/{{ $print->id }}/success" class="btn btn-success">Print Successful</a>
                                <a href="/OnlineJobs/prints/{{ $print->id }}/failed" class="btn btn-danger">Print Failed</a>
                            </div>
                        @endif
                    </div>
                @endforeach
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input. Please return to fix them.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            
            {{--Job control buttons--}}
            <div class="col-sm-12 text-center">
                <span data-placement="top" data-toggle="popover" data-trigger="hover" data-content="This button calls the
                    window to specify print details.">
                    <a class="btn btn-lg btn-info" data-toggle="modal" data-target="#addPrintModal">Assign Prints</a>
                </span>

                <a href="/OnlineJobs/pending" class="btn btn-lg btn-primary">View All Jobs</a>


                @if($query_in_progress == null)
                    <span data-placement="top" data-toggle="popover" data-trigger="hover" data-content="If the requested job
                cannot be printed for some reason, please click on this button and provide an explanation for the customer.">
                    <button class="btn btn-lg btn-danger" data-toggle="modal" data-target="#jobReject">Job Failed/Cancel Job</button>
                </span>
                @else
                    <span data-placement="top" data-toggle="popover" data-trigger="hover" data-content="If the requested job
                cannot be printed for some reason, please click on this button and provide an explanation for the customer. Please finish all the started prints before doing so.">
                    <a href="#" class="btn btn-lg btn-danger" data-placement="top" data-toggle="popover" data-trigger="hover"
                            data-content="You cannot mark this job as failed because you still have some unfinished prints." disabled>Job Failed/Cancel Job</a>
                </span>
                @endif

                @if($query_in_progress == null & $query_success !== null)
                    <a href="/OnlineJobs/{{$job->id}}/success" class="btn btn-lg btn-success" data-placement="top"
                       data-toggle="popover" data-trigger="hover" data-content="You may mark this job as completed now.
                       When you do so the customer will be notified of a successful job completion.">Job Completed</a>
                @else
                    <a href="#" class="btn btn-lg btn-success"
                       data-placement="top" data-toggle="popover" data-trigger="hover"
                       data-content="You cannot mark this job as completed because you still have some unfinished prints."
                       disabled>Job Completed</a>
                @endif
            </div>
        </div>
