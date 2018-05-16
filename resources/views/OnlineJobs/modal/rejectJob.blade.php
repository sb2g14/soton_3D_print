<!-- Modal add comment to a rejected job-->
    <div id="jobReject" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title text-center">Please explain why this job was rejected</h3>
                </div>
                {{--Modal body--}}
                <div class="modal-body text-left">

                    {{--Form to add a coment to a rejected job--}}
                    <form class="form-horizontal" role="form" method="POST" action="/OnlineJobs/{{ $job->id }}/delete">
                        {{ csrf_field() }}

                        <div class="form-group text-left">
                            <div class="col-md-12">
                                <label for="comments">Add comments for the customer:</label><br>
                                <textarea id="message_long" name="comment" 
                                    rows="4" class="form-control" 
                                    placeholder="Please explain why the job was rejected"></textarea>
                                @if ($errors->has('comments'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comments') }}</strong>
                                    </span>
                                @endif
                                <span class="help-block" id="message_long_error"></span>
                            </div>
                        </div>

                        <button id="reject" type="submit" class="btn btn-lg btn-primary">Submit</button>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
