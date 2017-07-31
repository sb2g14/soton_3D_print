@extends('layouts.layout')

@section('slider')
    {{--Slider --}}
    <div class="ctr">
        <div class="bl-welcome">
            <p>Welcome to 3D printing workshop</p>
            <p>at University of Southampton</p>
            <div class="btn btn-lg"><a href="{{ url('/printingData/create') }}">Request a job!</a></div>
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
    <section class="s-welcome">
        <div class="container">
            <div class="row is-table-row">
                @if (Auth::check())  {{--Check whether user is logged in--}}
                <div class="col-sm-4 item">
                    <div class="bl-header">
                        <div class="bl-logo logo-issue"></div>
                        <div>
                            <h3>ISSUES</h3>
                            {{--This is a button to add an issue:--}}
                            <button id="add_issue" type="button" class="btn btn-info" data-toggle="collapse" data-target="#addIssue">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button>
                        </div>
                        {{--Form to add issue--}}
                        <div id="addIssue" class="card collapse text-left">
                            <form method="POST" action="/posts">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="title">Issue Name</label><br>
                                    <input id="issue" name="title" placeholder="Specify issue name" class="form-control">
                                    <span id="issue_error" class="help-block" style="color: red"></span>
                                </div>
                                <div class="form-group">
                                    <label for="body">Message</label><br>
                                    <textarea id="message" name="body" placeholder="Describe your issue" class="form-control"></textarea>
                                    <span id="message_error" class="help-block" style="color: red"></span>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="critical" value="critical">Issue affects printer status</label>
                                </div>
                                <button id="report_issue" type="submit" class="btn btn-primary">Report Issue</button>
                            </form>
                        </div>
                    </div>

                    {{--Here we show issues:--}}
                    <ul id="form" class="list-group">
                        <li class="list-group-item">
                            <div class="alert alert-warning">
                                {{--Print title of a post--}}
                                <h4><b>{{ $post_last->title }}:</b></h4>
                                {{--Print name of a user who created a post--}}
                                <h5 class="media-heading"> {{$post_last->user->name}}  <small><i>
                                            {{--Print date and time when a post was created--}}
                                            Posted on {{ $post_last->created_at->toDayDateTimeString() }}:</i></small></h5>
                                {{--Print the text of a post--}}
                                {{ $post_last->body }}
                            </div>

                            {{--Here we show comments to each issue:--}}
                            <div class="btn">
                                <button id="show_comments" type="button" class="btn btn-info" data-toggle="collapse" data-target="#{{ $post_last->id }}">
                                    Show comments
                                </button>
                            </div>
                            <div id="{{ $post_last->id}}" class="card collapse">
                                <ul>
                                    @foreach($post_last->comments as $comment)
                                        <li>
                                            <div class="media">
                                                <div class="media-left">
                                                    <img src="/Images/img_avatar3.png" class="media-object" style="width:30px">
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="media-heading"> {{$comment->user->name}}  <small><i>Posted on {{ $comment->created_at->toDayDateTimeString() }}:</i></small></h5>
                                                    <p>{{ $comment->body }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div id="{{ $post_last->id }}" class="card">
                                    <form method="POST" action="/posts/{{ $post_last->id }}/comments">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <textarea id="comment_last" name="body" placeholder="Your comment here"  class="form-control" required></textarea>
                                            <span id="comment_last_error" class="help-block" style="color: red"></span>
                                        </div>
                                        <div class="form-group">
                                            <button id="comment_last" type="submit" class="btn btn-primary">Comment</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <button type="button" class="btn btn-lg view-all" data-toggle="collapse" data-target="#all-issues">VIEW ALL</button>

                    <div id="all-issues" class="card collapse">
                        @foreach($posts as $post)
                            <li class="list-group-item">
                                {{--Print title of a post--}}
                                <h4><b>{{ $post->title }}:</b></h4>
                                {{--Print name of a user who created a post--}}
                                <h5 class="media-heading"> {{$post->user->name}}  <small><i>
                                            {{--Print date and time when a post was created--}}
                                            Posted on {{ $post->created_at->toDayDateTimeString() }}:</i></small></h5>
                                {{--Print the text of a post--}}
                                {{ $post->body }}
                                <div class="btn">
                                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#{{ $post->id}}">
                                        Show comments
                                    </button>
                                </div>
                                <div id="{{ $post->id}}" class="card collapse">
                                    {{--Here we show comments to each issue:--}}
                                    <ul>
                                        @foreach($post->comments as $comment)
                                            <li>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <img src="/Images/img_avatar3.png" class="media-object" style="width:30px">
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
                                    <div id="{{ $post->id }}" class="card">
                                        <form method="POST" action="/posts/{{ $post->id }}/comments">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <textarea id="message" name="body" placeholder="Your comment here"  class="form-control" required></textarea>
                                                <span id="message_error" class="help-block" style="color: red"></span>
                                            </div>
                                            <div class="form-group">
                                                <button id="comment" type="submit" class="btn btn-primary">Comment </button>
                                            </div>
                                        </form>
                                    </div>
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
                            <button id="add_announcement" type="button" class="btn btn-info" data-toggle="collapse" data-target="#addAnnouncement">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button>
                        </div>

                        {{--Form to add announcement--}}
                        <div id="addAnnouncement" class="card collapse text-left">
                            <form method="POST" action="/announcements">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="message">New Announcement</label><br>
                                    <textarea id="announcement" name="message" placeholder="Post something" class="form-control"></textarea>
                                    <span id="announcement_error" style="color: red"></span>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="critical" value="critical">Public announcement</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="critical" value="critical">Inform all by email</label>
                                </div>
                                <button id="post" type="submit" class="btn btn-primary">Post</button>
                            </form>
                        </div>
                    </div>

                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="alert alert-info">
                                <h4><b>Announcement 1</b></h4>
                                <h5> Please download an up-to-date FEE PGR Demonstrating policy and claim forms.</h5>
                                <ul class="lsn">
                                    <li><a href={{ asset('files/Demonstrating_procedure_April2017.docx') }}>Demonstrating procedure</a></li>
                                    <li><a href={{ asset('files/FEE_Demonstrator_Consultancy_Policy_March4017.rtf') }}>Consultancy policy</a></li>
                                    <li><a href={{ asset('files/Demonstrating_Claim_April_2016.doc') }}>Claim form</a></li>
                                    <li><a href={{ asset('files/FORMS_DC1_AND_DC2_v2.doc') }}>Claim forms DC1 and DC2</a></li>
                                </ul>
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
                @else
                    <div class="col-sm-4 item"></div>
                    <div class="col-sm-4 item">
                        <div class="bl-header">
                            <div class="bl-logo logo-announcement"></div>
                            <div>
                                <h3>ANNOUNCEMENTS</h3>
                            </div>
                        </div>

                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="alert alert-info">
                                    <h4><b>Announcement 1</b></h4>
                                    <h5> Please download an up-to-date FEE PGR Demonstrating policy and claim forms.</h5>
                                    <ul class="lsn">
                                        <li><a href={{ asset('files/Demonstrating_procedure_April2017.docx') }}>Demonstrating procedure</a></li>
                                        <li><a href={{ asset('files/FEE_Demonstrator_Consultancy_Policy_March4017.rtf') }}>Consultancy policy</a></li>
                                        <li><a href={{ asset('files/Demonstrating_Claim_April_2016.doc') }}>Claim form</a></li>
                                        <li><a href={{ asset('files/FORMS_DC1_AND_DC2_v2.doc') }}>Claim forms DC1 and DC2</a></li>
                                    </ul>
                                </div>
                            </li>

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
                        </ul>
                    </div>
                    <div class="col-sm-4 item"></div>
                @endif
            </div>
        </div>
    </section>

@endsection
@section('scripts')
    <script src="/js/issue_validation.js"></script>
    <script src="/js/message_validation.js"></script>
@endsection