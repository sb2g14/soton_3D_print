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
                      
            @if (Auth::check())  {{--Check whether user is logged in--}}
                <div class="row clearfix is-table-row">
                    <!-- Issues -->
                    <div class="col-md-4">
                        <div class="cardblock card-issue hover-expand-effect">
                            <div class="info-box box-issue">
                                <div class="bl-logo logo-issue"></div>
                                <div class="caption"><h3>ISSUES</h3></div>
                            </div>
                            <div class="body bg-pink">
                                
                                {{--Here we show last issue:--}}
                                @if(!empty($post_last))
                                    <ul id="form" class=" lsn list-group">
                                        <li class="list-group-item">
                                            <div class="alert">
                                                {{--Print title of a post--}}
                                                 <h4><b> {{ isset($post_last->printer)  ? 'Printer '.$post_last->printer->id.':' : '' }} {{ $post_last->title }}</b></h4>
                                                {{--Print name of a user who created a post--}}
                                                <h5 class="media-heading"> {{$post_last->user->name}}  <small><i>
                                                            {{--Print date and time when a post was created--}}
                                                            Posted {{ $post_last->created_at->diffForHumans() }}:</i></small></h5>
                                                {{--Print the text of a post--}}
                                                {{ $post_last->body }}
                                            </div>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- #END# Issues -->
                    <!-- Announcements -->
                    <div class="col-md-4">
                        <div class="cardblock card-announcement hover-expand-effect">
                            <div class="info-box box-announcement">
                                <div class="bl-logo logo-announcement"></div>
                                <div class="caption"><h3>ANNOUNCEMENTS</h3></div>
                            </div>
                            <div class="body bg-cyan">
                                <ul class="lsn list-group">
                                    <li class="list-group-item">
                                        <div class="alert">
                                            <h5 class="media-heading"> {{ $announcement_last->user->name}}  <small><i>
                                                        {{--Print date and time when a post was created--}}
                                                        Posted {{ $announcement_last->created_at->diffForHumans() }}:</i></small></h5>
                                            <h5> {{ $announcement_last->message }} </h5>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Announcements -->
                    <!-- Statistics -->
                    <div class="col-md-4">
                        <div class="cardblock hover-expand-effect">
                            <div class="info-box box-stat">
                                <div class="bl-logo logo-stat"></div>
                                <div class="caption"><h3>STATISTICS</h3></div>
                            </div>
                            <div class="body bg-teal">
                                
                            </div>
                        </div>
                    </div>
                    <!-- #END# Statistics -->
                </div>

                @else
                <div class="row clearfix is-table-row">
                    <!-- RULES -->
                    <div class="col-md-4">
                        <div class="cardblock card-rules hover-expand-effect">
                            <div class="info-box box-issue">
                                <div class="bl-logo logo-issue"></div>
                                <div class="caption"><h3>WORKSHOP RULES</h3></div>
                            </div>
                            <div class="body bg-pink">
                                
                                <ul id="form" class=" lsn list-group">
                                    <li class="list-group-item">
                                        <p>
                                            <ol>
                                                <li>Export your file to .stl format and bring it with you to the workshop</li>
                                                <li>Talk to a demonstrator to request a printer and printer equipment. <b>Please DO NOT HELP YOUSELF to the cupboards!</b></li>
                                                <li>Set up the printer and check the print preview. <b>DO NOT PRINT!</b></li>
                                                <li>Request a job...</li>
                                            </ol>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Rules -->
                    <!-- Announcements -->
                    <div class="col-md-4">
                        <div class="cardblock card-announcement hover-expand-effect">
                            <div class="info-box box-announcement">
                                <div class="bl-logo logo-announcement"></div>
                                <div class="caption"><h3>ANNOUNCEMENTS</h3></div>
                            </div>
                            <div class="body bg-cyan">
                                <ul class="lsn list-group">
                                    <li class="list-group-item">
                                        <div class="alert">
                                            <h5 class="media-heading"> {{ $public_announcement_last->user->name}}  <small><i>
                                                        {{--Print date and time when a post was created--}}
                                                        Posted {{ $public_announcement_last->created_at->diffForHumans() }}:</i></small></h5>
                                            <h5> {{ $public_announcement_last->message }} </h5>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Announcements -->
                    <!-- Statistics -->
                    <div class="col-md-4">
                        <div class="cardblock hover-expand-effect">
                            <div class="info-box box-stat">
                                <div class="bl-logo logo-stat"></div>
                                <div class="caption"><h3>STATISTICS</h3></div>
                            </div>
                            <div class="body bg-teal">
                                
                            </div>
                        </div>
                    </div>
                    <!-- #END# Statistics -->
                </div>
            @endif
        </div>


        <!-- Modal ISSUES-->
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
                        <button id="add_issue" type="button" class="btn btn-info btn-block" data-toggle="collapse" data-target="#addIssue">Add new issue</button>
                    @endcan
                            
                    {{--Form to add issue--}}
                    <div id="addIssue" class="card collapse">
                        <form method="POST" action="/posts">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Issue Name</label><br>
                                <input id="issue" name="title" placeholder="Specify issue name" class="form-control" required>
                                <span id="issue_error" class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label for="body">Message</label><br>
                                <textarea id="message" name="body" rows="4" placeholder="Describe your issue" class="form-control" required></textarea>
                                <span id="message_error" class="help-block"></span>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" name="critical" value="critical">Issue affects printer status</label>
                            </div>
                            <button id="report_issue" type="submit" class="btn btn-primary">Report Issue</button>
                        </form>
                    </div>

                    <div id="all-issues"> 
                        @foreach($posts as $post)
                            <li class="list-group-item well">
                                {{--Print title of a post--}}
                                <h4><b>{{ isset($post->printer)  ? 'Printer '.$post->printer->id.':' : '' }} {{ $post->title }}</b></h4>
                                {{--Print name of a user who created a post--}}
                                <h5 class="media-heading"> {{$post->user->name}}  <small><i>
                                            {{--Print date and time when a post was created--}}
                                            Posted {{ $post->created_at->diffForHumans() }}:</i></small></h5>
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
                                                        <h5 class="media-heading"> {{$comment->user->name}}  <small><i>Posted {{ $comment->created_at->diffForHumans() }}:</i></small></h5>
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
                </div>
                        
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>

        <!-- Modal ANNOUNCEMENTS-->
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
                        <button id="add_announcement" type="button" class="btn btn-info btn-block" data-toggle="collapse" data-target="#addAnnouncement">Add new announcement</button>
                        @endcan
                        
                        {{--Form to add announcement--}}
                        <div id="addAnnouncement" class="card collapse text-left">
                            <form method="POST" action="/announcements">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="message">New Announcement</label><br>
                                    <textarea id="announcement" name="message" rows="8"
                                              {{--@if(Auth::user()->can('add_private_posts_and_announcements')) --}}
                                                {{--placeholder="Post will appear only for registered users unless you check 'Public announcement' " --}}
                                              {{--@else --}}
                                                placeholder="Post will appear only for registered users"
                                              {{--@endif --}}
                                                class="form-control"></textarea>
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

                        <div id="all-announcements">
                            @if(Auth::check())
                                @foreach($announcements as $announcement)
                                    <li class="list-group-item">
                                        <!-- <div class="alert alert-info"> -->
                                        <h5 class="media-heading"> {{$announcement->user->name}}  <small><i>
                                                    {{--Print date and time when a post was created--}}
                                                    Posted {{ $announcement->created_at->diffForHumans() }}:</i></small></h5>
                                        <h5> {{ $announcement->message }} </h5>
                                        <!-- </div> -->
                                    </li>
                                @endforeach
                            @else
                                @foreach($public_announcements as $announcement)
                                    <li class="list-group-item">
                                        <!-- <div class="alert alert-info"> -->
                                        <h5 class="media-heading"> {{$announcement->user->name}}  <small><i>
                                                    {{--Print date and time when a post was created--}}
                                                    Posted {{ $announcement->created_at->diffForHumans() }}:</i></small></h5>
                                        <h5> {{ $announcement->message }} </h5>
                                        <!-- </div> -->
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
                                <li>Talk to a demonstrator to request a printer and printer equipment. <b>Please DO NOT HELP YOURSELF to the cupboards!</b></li>
                                <li>Set up the printer and check the print preview. <b>DO NOT PRINT!</b></li>
                                <li>Request a job
                                    <ol type="a">
                                        <li>Access the workshop website <a href="https://3dprint.clients.soton.ac.uk/">https://3dprint.clients.soton.ac.uk/</a></li>
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
    <script src="/js/issue_validation.js"></script>
    <script src="/js/message_validation.js"></script>

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

