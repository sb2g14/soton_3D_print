{{--Assign print previews to a requested job--}}
            <div class="col-sm-6 text-left">
                <ul class="list-group lsn">
                    {{--List assigned prints--}}
                    @foreach($job->prints as $print)
                        <li class="alert alert-info text-left">
                            <a type="button" class="close" style="color: red" data-placement="top" data-toggle="popover"
                               data-trigger="hover" data-content="Delete this print-preview"
                                    href="/OnlineJobs/PrintPreview/{{$print->id}}/delete">&times;</a>
                            <p>
                                Preview: <b>{{ $print->id }}</b>
                                Time: <b>{{ $print->time }}</b>
                                Material amount: <b>{{$print->material_amount}}g</b>
                                Price: <b>£{{$print->price}}</b>
                            </p>
                        </li>
                    @endforeach
                </ul>
                <h3>Total job stats</h3>
                {{-- Calculate total print time --}}
                @php
                    $total_minutes = 0;
                    foreach ($job->prints as $print){
                    list($h, $i, $s) = explode(':', $print->time);
                    $minutes = $h*60 + $i;
                    $total_minutes = $total_minutes + $minutes;
                    }
                    $total_time = round($total_minutes/60).':'.sprintf('%02d', $total_minutes%60);
                @endphp

                <p>
                    Total job duration: <b>{{ $total_time }}</b> <br>
                    Total material amount: <b>{{ $job->prints->sum('material_amount') }}g</b> <br>
                    Total price: <b>£{{ $job->prints->sum('price') }}</b>
                </p>
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
        </div>
        {{--Job control buttons--}}
        <div class="col-sm-12 text-center">
            <span class="text-justify" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="You should specify at least
            one print-preview in each job. Each print-preview is used to calculate printing cost only and is separate
            entity from the actual print.">
                <a class="btn btn-lg btn-info" data-toggle="modal" data-target="#addPrintPreviewModal">Add print preview</a>
            </span>

            <a href="/OnlineJobs/requests" class="btn btn-lg btn-primary">Back</a>

            <span data-placement="top" data-toggle="popover" data-trigger="hover" data-content="If you think that the requested
            job cannot be printed for some reason, please click on this button and provide an explanation for the customer.">
            <button class="btn btn-lg btn-danger" data-toggle="modal" data-target="#jobReject">Reject a job</button></span>

            @if($job->prints->isEmpty())
                <a href="#" class="btn btn-lg btn-success" data-placement="top" data-toggle="popover" data-trigger="hover"
                   data-content="You cannot approve this job if no print-previews have been created." disabled>Approve job</a>
            @else
            <a href="/OnlineJobs/requests/{{ $job->id }}/approve" class="btn btn-lg btn-success"
               data-placement="top" data-toggle="popover" data-trigger="hover"
               data-content="You may approve this job now. When you do so the total job stats will be sent to a customer for
               approval.">Approve job</a>
            @endif

        </div>
