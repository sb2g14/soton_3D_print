@extends('layouts.layout')

@section('slider')
    {{--Slider --}}
    
        <div class="container">
            <div class="bl-welcome">    
                <div class="row">
                    <div class="col-sm-12">
                        <p>Welcome to 3D printing workshop<br>at the University of Southampton</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn btn-lg pull-right"><a href="{{ url('/OnlineJobs/create') }}">Request a job <br> online!</a></div>
                        <div class="btn-lg btn-success pull-left"><a href="{{ url('/printingData/create') }}">Request a job <br> in the workshop!</a></div>
                    </div>
                </div>
            </div>

    <div class="ctr">
        <div class="bl-welcome">
            <p>Welcome to 3D printing workshop<br>at the University of Southampton</p>
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
    <section class="s-welcome" style="position: relative; top: -130px">
        <div class="container">
            
            @if (Auth::check())  {{--Check whether user is logged in--}}
                <div class="row is-table-row">
                    <div class="col-sm-4 item">
                        <div class="bl-header">
                            <div class="bl-logo logo-issue"></div>
                            <div>
                                <h3>ISSUES</h3>
                                {{--This is a button to add an issue:--}}
                                @can('add_private_posts_and_announcements')
                                <button id="add_issue" type="button" class="btn btn-info" data-toggle="collapse" data-target="#addIssue">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </button>
                                @endcan
                            </div>
                            {{--Form to add issue--}}
                            <div id="addIssue" class="card collapse text-left">
                                <form method="POST" action="/posts">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="title">Issue Name</label><br>
                                        <input id="issue" name="title" placeholder="Specify issue name" class="form-control">
                                        <span id="issue_error" class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="body">Message</label><br>
                                        <textarea id="message" name="body" placeholder="Describe your issue" class="form-control"></textarea>
                                        <span id="message_error" class="help-block"></span>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="critical" value="critical">Issue affects printer status</label>
                                    </div>
                                    <button id="report_issue" type="submit" class="btn btn-primary">Report Issue</button>
                                </form>
                            </div>
                        </div>

                        {{--Here we show issues:--}}
                        @if(!empty($post_last))
                            <ul id="form" class=" lsn list-group">
                                <li class="list-group-item">
                                    <div class="alert alert-warning">
                                        {{--Print title of a post--}}
                                         <h4><b> {{ isset($post_last->printer)  ? 'Printer '.$post_last->printer->id.':' : '' }} {{ $post_last->title }}</b></h4>
                                        {{--Print name of a user who created a post--}}
                                        <h5 class="media-heading"> {{$post_last->user->name}}  <small><i>
                                                    {{--Print date and time when a post was created--}}
                                                    Posted on {{ $post_last->created_at->toDayDateTimeString() }}:</i></small></h5>
                                        {{--Print the text of a post--}}
                                        {{ $post_last->body }}
                                    </div>

                                    {{--Here we show comments to each issue:--}}
                                    <button id="show_comments" type="button" class="btn btn-info" data-toggle="collapse" data-target="#{{ $post_last->id }}">
                                            Show comments
                                    </button>
                                    <div id="{{ $post_last->id}}" class="card collapse">
                                        <ul class="lsn">
                                            @foreach($post_last->comments as $comment)
                                                <li>
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <img src="/Images/img_avatar3.png" class="media-object">
                                                        </div>
                                                        <div class="media-body">
                                                            <h5 class="media-heading"> {{$comment->user->name}}  <small><i>Posted on {{ $comment->created_at->toDayDateTimeString() }}:</i></small></h5>
                                                            <p>{{ $comment->body }}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @can('add_private_posts_and_announcements')
                                        <div id="{{ $post_last->id }}" class="card">
                                            <form method="POST" action="/posts/{{ $post_last->id }}/comments">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <textarea id="comment_last" name="body" placeholder="Your comment here"  class="form-control" required></textarea>
                                                    <span id="comment_last_error" class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                    <button id="comment_last" type="submit" class="btn btn-primary">Comment</button>
                                                </div>
                                            </form>
                                        </div>
                                        @endcan
                                    </div>
                                </li>
                            </ul>
                        @endif

                        <button type="button" class="btn btn-lg view-all" data-toggle="collapse" data-target="#all-issues">VIEW ALL</button>

                        <div id="all-issues" class="card collapse">
                            @foreach($posts as $post)
                                <li class="list-group-item">
                                    {{--Print title of a post--}}
                                    <h4><b>{{ isset($post->printer)  ? 'Printer '.$post->printer->id.':' : '' }} {{ $post->title }}</b></h4>
                                    {{--Print name of a user who created a post--}}
                                    <h5 class="media-heading"> {{$post->user->name}}  <small><i>
                                                {{--Print date and time when a post was created--}}
                                                Posted on {{ $post->created_at->toDayDateTimeString() }}:</i></small></h5>
                                    {{--Print the text of a post--}}
                                    <p>{{ $post->body }}</p>
                                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#{{ $post->id}}">
                                            Show comments
                                    </button>
                                    <div id="{{ $post->id}}" class="card collapse">
                                        {{--Here we show comments to each issue:--}}
                                        <ul class="lsn">
                                            @foreach($post->comments as $comment)
                                                <li>
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <img src="/Images/img_avatar3.png" class="media-object">
                                                        </div>
                                                        <div class="media-body">
                                                            <h5 class="media-heading"> {{$comment->user->name}}  <small><i>Posted on {{ $comment->created_at->toDayDateTimeString() }}:</i></small></h5>
                                                            <p>{{ $comment->body }}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        {{--This is a form to add a comment--}}
                                        @can('add_private_posts_and_announcements')
                                        <div id="{{ $post->id }}" class="card">
                                            <form method="POST" action="/posts/{{ $post->id }}/comments">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <textarea id="message" name="body" placeholder="Your comment here"  class="form-control" required></textarea>
                                                    <span id="message_error" class="help-block"></span>
                                                </div>
                                                <div class="form-group">
                                                    <button id="comment" type="submit" class="btn btn-primary">Comment </button>
                                                </div>
                                            </form>
                                        </div>
                                        @endcan
                                    </div>
                                </li>
                            @endforeach
                        </div>
                        @include('layouts.errors')
                    </div>

                    <div class="col-sm-4 item">
                        <div class="bl-header">
                            <div class="bl-logo logo-announcement"></div>
                            <div>
                                <h3>ANNOUNCEMENTS</h3>
                                {{--This is a button to create an announcement:--}}
                                @can('add_private_posts_and_announcements')
                                <button id="add_announcement" type="button" class="btn btn-info" data-toggle="collapse" data-target="#addAnnouncement">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </button>
                                @endcan
                            </div>

                            {{--Form to add announcement--}}
                            <div id="addAnnouncement" class="card collapse text-left">
                                <form method="POST" action="/announcements">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="message">New Announcement</label><br>
                                        <textarea id="announcement" name="message" @if(Auth::user()->can('add_private_posts_and_announcements')) placeholder="Post will appear only for registered users unless you check 'Public announcement' " @else placeholder="Post will appear only for registered users" @endif class="form-control"></textarea>
                                        <span id="announcement_error" class="help-block"></span>
                                    </div>
                                    @can('add_public_posts_and_announcements')
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="public" value="public">Public announcement</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="email" value="email">Inform all by email</label>
                                    </div>
                                    @endcan
                                    <button id="post" type="submit" class="btn btn-primary">Post</button>
                                </form>
                            </div>
                        </div>


                        <ul class="lsn list-group">
                            <li class="list-group-item">
                                <div class="alert alert-info">
                                    <h4><b>Announcement {{  $announcement_last->id + 1 }} </b></h4>
                                    <h5 class="media-heading"> {{ $announcement_last->user->name}}  <small><i>
                                                {{--Print date and time when a post was created--}}
                                                Posted on {{ $announcement_last->created_at->toDayDateTimeString() }}:</i></small></h5>
                                    <h5> {{ $announcement_last->message }} </h5>
                                </div>
                            </li>
                        </ul>
                        <ul class="lsn list-group">
                            <li class="list-group-item">
                                <div class="alert alert-info">
                                    {{--<h4><b>Announcement 1</b></h4>--}}
                                    {{--<h4 style="color: red"><b>Download the induction presentation <a href={{ asset('files/induction_presentation.ppt') }}>--}}
                                                {{--here</a>.</b></h4>--}}
                                    {{--<ul class="lsn">--}}
                                    {{--<li><a href={{ asset('files/Demonstrating_procedure_April2017.docx') }}>Demonstrating procedure</a></li>--}}
                                    {{--<li><a href={{ asset('files/FEE_Demonstrator_Consultancy_Policy_March4017.rtf') }}>Consultancy policy</a></li>--}}
                                    {{--<li><a href={{ asset('files/Demonstrating_Claim_April_2016.doc') }}>Claim form</a></li>--}}
                                    {{--<li><a href={{ asset('files/FORMS_DC1_AND_DC2_v2.doc') }}>Claim forms DC1 and DC2</a></li>--}}
                                    {{--</ul><br>--}}
                                    <h4 style="color: red"><b>Please visit <a href="{{ url('http://3dprint.clients.soton.ac.uk/news') }}"
                                                                              target="_blank">NEWS</a> to check how to use this resource.</b></h4>
                                    <br>
                                    <h1>Development team.</h1>
                                </div>
                            </li>
                        </ul>
                        <button type="button" class="btn btn-lg view-all" data-toggle="collapse" data-target="#all-announcements">VIEW ALL</button>

                        <div id="all-announcements" class="card collapse">
                            @foreach($announcements as $announcement)
                                <li class="list-group-item">
                                    <!-- <div class="alert alert-info"> -->
                                    <h4><b>Announcement {{ $announcement->id + 1 }}</b></h4>
                                    <h5 class="media-heading"> {{$announcement->user->name}}  <small><i>
                                                {{--Print date and time when a post was created--}}
                                                Posted on {{ $announcement->created_at->toDayDateTimeString() }}:</i></small></h5>
                                    <h5> {{ $announcement->message }} </h5>
                                    <!-- </div> -->
                                </li>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-sm-4 item">
                        <div class="bl-header">
                            <div class="bl-logo logo-stat"></div>
                            <div>
                                <h3>STATISTICS</h3>
                            </div>
                        </div>
                    </div>
                </div>

                @else
                <div class="row is-table-row">
                    <div class="col-sm-4 item">
                        <div class="bl-header">
                            <div class="bl-logo logo-issue"></div>
                            <div>
                                <h3>RULES FOR USING THE 3D PRINTERS</h3>
                            </div>
                        </div>
                        <p>
                        <ol>
                            <li>Export your file to .stl format and bring it with you to the workshop
                            <li>Talk to a demonstrator to request a printer and printer equipment. <b>Please DO NOT HELP YOUSELF to the cupboards!</b></li>
                            <li>Set up the printer and check the print preview. <b>DO NOT PRINT!</b></li>
                            <li>Request a job
                                <ol type="a">
                                    <li>Access the workshop website <a href="https://3dprint.clients.soton.ac.uk/">https://3dprint.clients.soton.ac.uk/</a></a></li>
                                    <li>Select <q><a href="https://3dprint.clients.soton.ac.uk/printingData/create">Request a job in the workshop!</a></q></li>
                                    <li>Fill in all required details</li>
                                    <li>Click submit</li>
                                </ol>
                            </li>
                            <li>Ask a demonstrator to come to you to approve the print</li>
                            <li>Press the print button to start the print <b>after your print has been approved</b></li>
                            <li>Wait for at least 10 layers to see if there are any errors. Most errors will happen at this point</li>
                            <li type="disc" style="list-style-type:disc">If there is an error:
                                <ol type="a">
                                    <li>Stop the print</li>
                                    <li>Tell a demonstrator to mark the print as failed so you don't get charged</li>
                                    <li>Set up the print again. Ask a demonstrator for advice on how to avoid this error</li>
                                    <li>Go through the same <q><a href="https://3dprint.clients.soton.ac.uk/printingData/create">Request a job in the workshop!</a></q> procedure.</li>
                                </ol>
                            </li>
                            <li type="disc" style="list-style-type:disc">If you need to leave the workshop during your print, leave your contact details on a piece of paper with your expected return time next to your printer</li>
                            <li value="8">Once your print is finished, tell a demonstrator to mark the print as finished</li>
                            <li>Remove the print from the platform</li>
                            <li>Once finished, return all printing materials to the cupboards</li>
                        </ol>
                        </p>
                    </div>
                    <div class="col-sm-4 item">
                        <div class="bl-header">
                            <div class="bl-logo logo-announcement"></div>
                            <div>
                                <h3>ANNOUNCEMENTS</h3>
                            </div>
                        </div>

                        <ul class=" lsn list-group">
                            @if(!empty($public_announcement_last))
                                <li class="list-group-item">
                                    <div class="alert alert-info">
                                        <h4><b>Announcement {{ $public_announcement_last->id }}</b></h4>
                                        <h5 class="media-heading"> 
                                            @if($public_announcement_last->user_id != 0)  
                                            {{$public_announcement_last->user->name}} 
                                            @else Anonym 
                                            @endif
                                                {{--Print date and time when a post was created--}}
                                            <small><i>Posted on {{ $public_announcement_last->created_at->toDayDateTimeString() }}:</i></small>
                                        </h5>
                                        <h5> {{ $public_announcement_last->message }} </h5>
                                    </div>
                                </li>
                            @endif

                            <button type="button" class="btn btn-lg view-all" data-toggle="collapse" data-target="#all-announcements">VIEW ALL</button>

                            <div id="all-announcements" class="card collapse">

                                @foreach($public_announcements as $announcement)
                                    <li class="list-group-item">
                                        <!-- <div class="alert alert-info"> -->
                                        <h4><b>Announcement {{ $announcement->id }}</b></h4>
                                        <h5 class="media-heading"> @if($announcement->user_id != 0)  {{$announcement->user->name}} @else Anonym @endif <small><i>
                                                    {{--Print date and time when a post was created--}}
                                                    Posted on {{ $announcement->created_at->toDayDateTimeString() }}:</i></small></h5>
                                        <h5> {{ $announcement->message }} </h5>
                                        <!-- </div> -->
                                    </li>
                                @endforeach
                            </div>
                        </ul>
                    </div>
                    <div class="col-sm-4 item">
                        <div class="bl-header">
                            <div class="bl-logo logo-stat"></div>
                            <div>
                                <h3>STATISTICS</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
@section('scripts')
<script src="/js/issue_validation.js"></script>
<script src="/js/message_validation.js"></script>
@endsection
