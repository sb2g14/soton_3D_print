@extends('layouts.layout')

@section('slider')
    {{--Slider --}}
    <div class="container">
        <div class="bl-welcome">    
            <div class="row">
                <div class="col-xs-12">
                    <p>Welcome to the 3D printing service<br>at the University of Southampton!</p>
                </div>
            </div>
            @if (Auth::check())
                <div class="row">
                    <div class="col-xs-12">
                        @if ($workshopIsOpen) 
                            <p>
                                <br/>
                                <a href="{{ url('/printingData/create') }}">  Start by requesting to print in the workshop now!</a>
                            </p>
                        @else
                            <p>
                                <br/>
                                <a href="{{ url('/OnlineJobs/create') }}">  Start by ordering a print now!</a>
                            </p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div id="image-slider_home" class="image-slider bl-slider owl-carousel owl-theme">
        <div class="item img_1"></div>
        <div class="item img_2"></div>
        <div class="item img_3"></div>
        <div class="item img_4"></div>
        {{--<div class="item print3"></div>--}}
    </div>
    
@endsection

@section('content')
    {{--Show the result of a registration--}}
    @if ($flash=session('message'))
        <div id="flash_message" class="alert {{ session()->get('alert-class', 'alert-info') }}" role="alert" style="position: relative; top: -80px">
            {{ $flash }}
        </div>
    @endif
    {{--Main content--}}
    <div class="s-welcome">
        {{-- style="position: relative; top: -130px">--}}

        <div class="container"> 
<!-- CARDS DISPLAYED FOR DEMONSTRATOR -->        
            @if ($usertype === "Staff") {{-- Auth::check() && Auth::user()->id != 100 --}} {{--Check whether user is logged in & NOT a customer--}}
                <div class="row row-flex">
                    <!-- Issues -->
                    <div class="col-xs-12 col-md-4">
                        <div class="cardblock card-issue hover-expand-effect">
                            <div class="info-box box-issue">
                                <div class="bl-logo logo-issue"></div>
                                <div class="caption"><h3>ISSUES</h3></div>
                            </div>
                            <div class="body bg-issue">
                                
                                {{--Here we show last issue:--}}
                                @php
                                    $post_last = $issues->first();
                                @endphp
                                
                                <ul id="form" class=" lsn list-group">
                                    @if($lostPrinter)
                                        <li class="list-group-item">
                                            <div class="alert">
                                                {{--Print title of a post--}}
                                                <h4><b> 
                                                    Printer not seen for a long time
                                                </b></h4>
                                                {{--Print the text of a post--}}
                                                Printer number {{$lostPrinter->id}} has not been seen since {{$lostPrinter->lastUpdateDatetime()->format('j/m/Y') }}. Please check if it is still in the workshop and give it to the next student for printing so that I know it's still there.
                                            </div>
                                        </li>
                                    @endif
                                    @if(!empty($post_last))
                                        <li class="list-group-item">
                                            <div class="alert">
                                                {{--Print title of a post--}}
                                                <h4><b> 
                                                    {{ isset($post_last->printers_id)  ? 'Printer '.$post_last->printers_id.':' : '' }} 
                                                    {{ $post_last->title }}
                                                </b></h4>
                                                {{--Print name of a user who created a post--}}
                                                <h5 class="media-heading"> 
                                                    {{App\staff::where('id', $post_last->staff_id)->first()->name()}}               
                                                    {{--Print date and time when a post was created--}}
                                                    <small><i>
                                                        Posted {{ $post_last->created_at->diffForHumans() }}:
                                                    </i></small>
                                                </h5>
                                                {{--Print the text of a post--}}
                                                {{ $post_last->body }}
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Issues -->
                    <!-- Demonstrator Announcements -->
                    <div class="col-xs-12 col-md-4">
                        <div class="cardblock card-announcement hover-expand-effect">
                            <div class="info-box box-announcement">
                                <div class="bl-logo logo-announcement"></div>
                                <div class="caption"><h3>ANNOUNCEMENTS</h3></div>
                            </div>
                            <div class="body bg-announcement">
                                <ul class="lsn list-group">
                                    <li class="list-group-item">
                                        <div class="alert">
                                            @php
                                                $announcement_last = $announcements->first();
                                                $shortmessage = $announcement_last->message;
                                                $shortmessage = (strlen($shortmessage) > 653) ? substr($shortmessage,0,650).'...' : $shortmessage;
                                                $shortmessage = str_replace("\n","<br/>",$shortmessage);
                                            @endphp
                                            <h5 class="media-heading"> {{ $announcement_last->user->name}}
                                                {{--Print date and time when a post was created--}}
                                                <small><i>
                                                        Posted {{ $announcement_last->created_at->diffForHumans() }}:
                                                </i></small>
                                            </h5>
                                            <h5> {!! $shortmessage !!} <br/>  (See more)</h5>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Demonstrator Announcements -->
                    <!-- Demonstrator Statistics -->
                    <div class="col-xs-12 col-md-4">
                        <div class="cardblock card-stat hover-expand-effect">
                            <div class="info-box box-stat">
                                <div class="bl-logo logo-stat"></div>
                                <div class="caption"><h3>STATISTICS</h3></div>
                            </div>
                            <div class="body bg-stat">
                                {{--<h3>The number of prints in the last 12 months</h3>--}}
                                @php $chart_height = 300; @endphp
                                <iframe id="C_demonstrator_main" 
                                    height="{{ $chart_height + 150 }}" width="100%" style="width:100%; border:none;"
                                    src="{{ route('chart', [
                                        'name' => 'printspm', 
                                        'color' => 'prussian', 
                                        'height' => $chart_height]) }}" >
                                </iframe>
                                <div style="text-align: left; font-weight: bold"> 
                                    Number of prints in {{$count_months[1]->format('F')}}: {{$count_prints[1]}}<br/>
                                    Number of users last year: {{$count_users}}<br/>
                                    Total material used: {{$count_material}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Demonstrator Statistics -->
                </div>

                @else
<!-- CARDS DISPLAYED FOR CUSTOMER -->
                <div class="row row-flex">
                    <!-- RULES -->
                    <div class="col-xs-12 col-md-4 ">
                        <div class="cardblock card-rules hover-expand-effect">
                            <div class="info-box box-issue">
                                <div class="bl-logo logo-issue"></div>
                                <div class="caption"><h3>WORKSHOP RULES</h3></div>
                            </div>
                            <div class="body bg-issue">
                                
                                <ul id="form" class=" lsn list-group">
                                    <li class="list-group-item">
                                        <p>
                                            <ol>
                                                <li>Export your file to .stl format and bring it with you to the workshop</li>
                                                <li>Talk to a demonstrator to request a printer and printer equipment. 
                                                    <b>Please DO NOT HELP YOURSELF to the cupboards!</b>
                                                </li>
                                                <li>Set up the printer and check the print preview. <b>DO NOT PRINT!</b></li>
                                                <li>Request a job on this website</li>
                                                <li>Ask a demonstrator to come to you to approve the print</li>
                                                <li>Press the print button to start the print 
                                                    <b>after your print has been approved</b>
                                                </li>
                                                <li>Wait for at least 10 layers to see if there are any errors....</li>
                                            </ol>
                                            View more...
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Rules -->
                    <!-- Customer Announcements -->
                    <div class="col-xs-12 col-md-4">
                        <div class="cardblock card-announcement hover-expand-effect">
                            <div class="info-box box-announcement">
                                <div class="bl-logo logo-announcement"></div>
                                <div class="caption"><h3>ANNOUNCEMENTS</h3></div>
                            </div>
                            <div class="body bg-announcement">
                                <ul class="lsn list-group">
                                    <li class="list-group-item">
                                        <div class="alert">
                                            @php
                                                $public_announcement_last = $announcements->where('public', 1)->first();
                                                $shortmessage = $public_announcement_last->message;
                                                $shortmessage = (strlen($shortmessage) > 653) ? substr($shortmessage,0,650).'...' : $shortmessage;
                                            @endphp
                                            <h5 class="media-heading"> 
                                                {{ $public_announcement_last->user->name}}
                                                {{--Print date and time when a post was created--}} 
                                                <small><i>
                                                        Posted {{ $public_announcement_last->created_at->diffForHumans() }}:
                                                </i></small>
                                            </h5>
                                            <h5> {{ $shortmessage }} </h5>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Customer Announcements -->
                    <!-- Customer Statistics -->
                    <div class="col-xs-12 col-md-4">
                        <div class="cardblock hover-expand-effect">
                            <div class="info-box box-stat">
                                <div class="bl-logo logo-stat"></div>
                                <div class="caption"><h3>STATISTICS</h3></div>
                            </div>
                            <div class="body bg-stat">
                                @php $chart_height = 300; @endphp
                                @if ($workshopIsOpen)
                                    <div style="text-align: center; font-size: larger; font-weight: bold"> Printers available </div>
                                    <iframe id="C_printer_availability" 
                                        height="{{$chart_height + 50}}" width="100%" style="width:100%; border:none;"
                                        src="{{ route('chart', [
                                            'name' => 'printer_availability', 
                                            'height' => $chart_height, 
                                            'color' => 'coral']) }}" >
                                    </iframe>
                                @else
                                    <iframe id="C_workshop_usage" 
                                        height="{{$chart_height + 150}}" width="100%" style="width:100%; border:none;"
                                        src="{{ route('chart', [
                                            'name' => 'workshop_usage', 
                                            'height' => $chart_height, 
                                            'color' => 'coral']) }}">
                                    </iframe>
                                @endif
                                <div style="text-align: left; font-weight: bold"> 
                                    Number of prints in {{$count_months[1]->format('F')}}: {{$count_prints[1]}}<br/>
                                    Number of users last year: {{$count_users}}<br/>
                                    Total material used: {{$count_material}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Customer Statistics -->
                </div>
            @endif
        </div>

<!-- DETAIL CARDS WITH FORMS TO EDIT CONTENT -->

        

        <!-- Modal ISSUES-->
        @if ($usertype === "Staff")
        <div id="issueModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title text-center">ISSUES</h3>
                </div>
                <div class="modal-body text-left">
                    {{--This is a button to add an issue:--}}
                    @can('add_private_posts_and_announcements')
                        <button id="add_issue" 
                            type="button" class="btn btn-info btn-block" 
                            data-toggle="collapse" data-target="#addIssue">
                            Add new issue
                        </button>
                    @endcan
                            
                    {{--Form to add issue--}}
                    <div id="addIssue" class="card collapse">
                        <form method="POST" action="/posts">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Issue Name</label><br>
                                <input id="issue" name="title" placeholder="Specify issue name" class="form-control" required>
                                <span id="issue_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="body">Message</label><br>
                                <textarea id="message_issue" name="body" 
                                    rows="4" class="form-control" 
                                    required placeholder="Describe your issue" ></textarea>
                                <span id="message_issue_error"></span>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" name="critical" value="critical">Issue affects printer status</label>
                            </div>
                            <button id="report_issue" type="submit" class="btn btn-success">Report Issue</button>
                        </form>
                    </div>
                    @if(Auth::check())
                        {{--Display all issues--}}
                        <div id="all-issues">
                            @foreach($issues as $post)
                                <li class="list-group-item well alert {{isset($post->printers_id) ? 'alert-info' : 'alert-default'}}">
                                    {{--Print title of a post--}}
                                    <h4><b>
                                        {{ isset($post->printers_id)  ? 'Printer '.$post->printers_id.':' : '' }} {{ $post->title }}
                                    </b></h4>
                                    {{-- Button to delete the issue--}}
                                    @if( isset($post->printers_id) && $post->created_at->addMinutes(5)->gte(\Carbon\Carbon::now('Europe/London')))
                                        <span data-toggle="popover" data-trigger="hover" data-placement="top" 
                                            data-content="Delete this issue from the database (this option is available only first 
                                                5 minutes after creation).The printer status will be changed to Available.">
                                            <a id="deleteIssue" type="button" class="close" style="color: red" 
                                               href="/issues/{{$post->id}}/delete">&times;</a>
                                        </span>
                                    @endif
                                    {{-- Button to delete post--}}
                                    @if( !isset($post->printers_id) && $post->created_at->addMinutes(5)->gte(\Carbon\Carbon::now('Europe/London')))
                                        <span data-toggle="popover" data-trigger="hover" data-placement="top" 
                                            data-content="Delete this post from the database (this option is available only first 
                                                5 minutes after creation)">
                                            <a id="deletePost" type="button" class="close" style="color: red" 
                                               href="/post/delete/{{$post->id}}">&times;</a>
                                        </span>
                                    @endif
                                    {{--Print name of a user who created a post--}}
                                    <h5 class="media-heading"> 
                                        {{App\staff::where('id', $post->staff_id)->first()->first_name}}
                                        {{App\staff::where('id', $post->staff_id)->first()->last_name}}
                                        <small><i>
                                            {{--Print date and time when a post was created--}}
                                            Posted {{ $post->created_at->diffForHumans() }}:
                                        </i></small>
                                    </h5>
                                    {{--Print the text of a post--}}
                                    <p>{{ $post->body }}</p>
                                    {{-- Button to resolve post--}}
                                    @if(!isset($post->printers_id) 
                                        && (Auth::user()->staff->id == App\staff::where('id', $post->staff_id)->first()->id 
                                            || Auth::user()->hasRole(['administrator', 'LeadDemonstrator', 'Coordinator']) ))
                                        <a href="/posts/resolve/{{$post->id}}" class="btn btn-danger">Resolve{{ $post->resolved }}</a>
                                    @endif
                                    {{-- Button to show/hide comments--}}
                                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#{{ $post->id}}">
                                        Show comments
                                    </button>
                                    <div id="{{ $post->id}}" class="card collapse">
                                        {{--Here we show comments to each issue:--}}
                                        <ul class="lsn">
                                            @php
                                            if(isset($post->printers_id)){
                                                $comments = \App\FaultUpdates::where('fault_data_id', $post->id)->get();
                                            } else {
                                                $comments = \App\comments::where('posts_id', $post->id)->get();
                                            }
                                            @endphp
                                            @foreach($comments as $comment)
                                                <li>
                                                    <div class="media">
                                                        <div class="media-body">
                                                            @if( isset($comment->posts_id) && $comment->created_at->addMinutes(5)->gte(\Carbon\Carbon::now('Europe/London')))
                                                                <span data-toggle="popover" data-trigger="hover" data-placement="top" 
                                                                    data-content="Delete this comment from the datable (this option 
                                                                        is available only first 5 minutes after creation)">
                                                                    <a id="deleteComment" type="button" 
                                                                        class="close" style="color: red"
                                                                        href="/comments/delete/{{$comment->id}}">&times;</a>
                                                                </span>
                                                            @endif
                                                            <h5 class="media-heading"> 
                                                                {{$comment->staff->name()}}
                                                                <small>
                                                                    <i>Posted {{ $comment->created_at->diffForHumans() }}:</i>
                                                                </small>
                                                            </h5>
                                                            <p>
                                                                <h5 style="color: red">
                                                                    {{ isset($comment->printer_status) ? 'Printer Status: '.$comment->printer_status : ''}}
                                                                </h5>
                                                                {{ $comment->body }}
                                                            </p>

                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul><!-- end of issue comments-->
                                        {{--This is a form to add a comment--}}
                                        @can('add_private_posts_and_announcements')
                                            @if(isset($post->printers_id))
                                                <div class="card">
                                                    <div class="form-group">
                                                        <a class="btn btn-info" href="/issues/{{ $post->id }}/edit#buttons">Update </a>
                                                    </div>
                                                </div>
                                            @else
                                                <div id="{{ $post->id }}" class="card">
                                                    <form method="POST" action="/posts/{{ $post->id }}/comments">
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <textarea id="message_comment" name="body" 
                                                                class="form-control" 
                                                                required placeholder="Your comment here"></textarea>
                                                            <span id="message_comment_error"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <button id="comment" type="submit" class="btn btn-success">Comment </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif
                                        @endcan
                                    </div>
                                </li>
                            @endforeach
                        </div><!-- end of issues list-->
                    {{--missing endif?--}}
                </div>
                        
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

          </div>
        </div>
        @endif

        <!-- Modal ANNOUNCEMENTS-->
        @if ($usertype === "Staff")
        <div id="announcementModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">ANNOUNCEMENTS</h3>
                    </div>
                    <div class="modal-body text-left">
                        {{--This is a button to create an announcement:--}}
                        @can('add_private_posts_and_announcements')
                            <button id="add_announcement" 
                                type="button" class="btn btn-info btn-block" 
                                data-toggle="collapse" data-target="#addAnnouncement">
                                Add new announcement
                            </button>
                        @endcan
                        
                        {{--Form to add announcement--}}
                        <div id="addAnnouncement" class="card collapse text-left">
                            <form method="POST" action="/announcements">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="message">New Announcement</label><br>
                                    <div id="helperpreannouncement" class="form-text text-muted text-user">Dear Demonstrator</div>
                                    <textarea id="announcement" name="message" 
                                        class="form-control" rows="8"
                                        placeholder="Post will appear only for registered users unless you check 'Public announcement"
                                        ></textarea>
                                    <div  id="helperpostannouncement" class="form-text text-muted text-user">
                                        Thanks,<br/>&nbsp;&nbsp;{{Auth::user()->staff->name()}}, 3D Printing Service Team<br/>
                                    </div>
                                    <span id="announcement_error" class=""></span>
                                    <div class="form-text text-muted">
                                        Note: This form supports 
                                        <a href="https://daringfireball.net/projects/markdown/syntax">markdown</a> 
                                        when sending emails.
                                    </div>
                                </div>
                                @can('add_public_posts_and_announcements')
                                    <div class="checkbox">
                                        <label>
                                            <input name="public" type="checkbox" value="public">
                                            Public announcement
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input id="chkancmntem" name="email" type="checkbox" value="email">
                                            Inform all by email
                                        </label>
                                    </div>
                                @endcan
                                <button id="post" type="submit" class="btn btn-success">Post</button>
                            </form>
                        </div>
                    {{--endif without if?--}}
                    @endif

                        <div id="all-announcements">
                            @if(Auth::check())
                                @foreach($announcements as $announcement)
                                    <li class="list-group-item well alert @if($announcement->public === 0) alert-info @else alert-default @endif ">
                                        <h5 class="media-heading">
                                            <i class="fa @if($announcement->public === 0) fa-comment @else fa-bullhorn @endif"></i> 
                                            {{$announcement->user->name}}
                                            <small><i>
                                                {{-- Delete the announcement if you have appropriate permissions--}}
                                                @if( strtolower(Auth::user()->email) == strtolower($announcement->user->email) || Auth::user()->can('delete_announcements'))
                                                    <span data-toggle="popover" data-trigger="hover" data-placement="top" 
                                                        data-content="This button is to delete the announcement from the database. 
                                                            Please use it with care.">
                                                        <a id="deleteAnnouncement" 
                                                            type="button" class="close" style="color: red"
                                                            href="/announcement/delete/{{$announcement->id}}">&times;</a>
                                                    </span>
                                                @endif
                                                {{--Print date and time when a post was created--}}
                                                Posted {{ $announcement->created_at->diffForHumans() }}:
                                            </i></small>
                                        </h5>
                                        <h5> {{ $announcement->message }} </h5>
                                    </li>
                                @endforeach
                            @else
                                @php
                                    $public_announcements = $announcements->where('public', 1);
                                @endphp
                                @foreach($public_announcements as $announcement)
                                    <li class="list-group-item">
                                        <h5 class="media-heading"> 
                                            {{$announcement->user->name}}
                                            <small><i>
                                                {{--Print date and time when a post was created--}}
                                                Posted {{ $announcement->created_at->diffForHumans() }}:
                                            </i></small>
                                        </h5>
                                        <h5> {{ $announcement->message }} </h5>
                                    </li>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Modal WORKSHOP RULES-->
        <div id="rulesModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">WORKSHOP RULES</h3>
                    </div>
                    <div class="modal-body text-left">
                        <p>
                            <ol>
                                <li>Export your file to .stl format and bring it with you to the workshop</li>
                                <li>Talk to a demonstrator to request a printer and printer equipment. 
                                    <b>Please DO NOT HELP YOURSELF to the cupboards!</b>
                                </li>
                                <li>Set up the printer and check the print preview. <b>DO NOT PRINT!</b></li>
                                <li>Request a job
                                    <ol type="a">
                                        <li>Access the workshop website 
                                            <a href="https://3dprint.clients.soton.ac.uk/">https://3dprint.clients.soton.ac.uk/</a>
                                        </li>
                                        <li>Select <q><a href="https://3dprint.clients.soton.ac.uk/printingData/create">
                                            Request a job in the workshop!</a></q>
                                        </li>
                                        <li>Fill in all required details</li>
                                        <li>Click submit</li>
                                    </ol>
                                </li>
                                <li>Ask a demonstrator to come to you to approve the print</li>
                                <li>Press the print button to start the print <b>after your print has been approved</b></li>
                                <li>Wait for at least 10 layers to see if there are any errors. 
                                    Most errors will happen at this point
                                </li>
                                <li type="disc" style="list-style-type:disc">If there is an error:
                                    <ol type="a">
                                        <li>Stop the print</li>
                                        <li>Tell a demonstrator to mark the print as failed so you don't get charged</li>
                                        <li>Set up the print again. Ask a demonstrator for advice on how to avoid this error</li>
                                        <li>Go through the same <q>
                                            <a href="https://3dprint.clients.soton.ac.uk/printingData/create">
                                            Request a job in the workshop!</a></q> procedure.
                                        </li>
                                    </ol>
                                </li>
                                <li type="disc" style="list-style-type:disc">
                                    If you need to leave the workshop during your print, leave your contact details on a 
                                    piece of paper with your expected return time next to your printer
                                </li>
                                <li value="8">Once your print is finished, tell a demonstrator to mark the print as finished</li>
                                <li>Remove the print from the platform</li>
                                <li>Once finished, return all printing materials to the cupboards</li>
                            </ol>
                        </p>   
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
     
@endsection
@section('scripts')
    {{--Load validation scripts--}}
    <script src="/js/validate_form_issue_create.js"></script>
    <script src="/js/validate_form_issue_comment.js"></script>
    <script src="/js/validate_form_announcement_create.js"></script>
    {{--Toggle email helper--}}
    <script>
        $(function() {
            if($('#chkancmntem').is(':checked')){
                $('#helperpreannouncement').show();
                $('#helperpostannouncement').show();
            }else{
                $('#helperpreannouncement').hide();
                $('#helperpostannouncement').hide();
            }
        });
        $('#chkancmntem').click(function(){
            if($('#chkancmntem').is(':checked')){
                $('#helperpreannouncement').show();
                $('#helperpostannouncement').show();
            }else{
                $('#helperpreannouncement').hide();
                $('#helperpostannouncement').hide();
            }
        });
    </script>
@endsection

