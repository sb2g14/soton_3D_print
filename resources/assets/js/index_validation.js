$(function () {
    $("#issue_error").hide();
    $("#message_error").hide();
    $("#comment_last").hide();
    $("#comment_last_error").hide();

    var error_issue = true;
    var error_message = true;
    var error_comment_last = true;

    // Invoke validation of ISSUES
    $("#add_issue").onclick(function () {
        $("#issue").keyup(function () {
            check_issue();
        });
        $("#issue").focusout(function() {
            check_issue();
        });
        $("#message").keyup(function () {
            check_message();
        });
        $("#message_last").focusout(function () {
            check_message();
        });
    });
    // Invoke validation of COMMENTS
    $("#show_comments").onclick(function () {
       $("#comment_last").keyup(function () {
           check_comment();
       });
        $("#comment_last").focusout(function () {
           check_comment();
        });
    });
    // Invoke validation of ANNOUNCEMENTS
    $("#add_announcement").onclick(function () {
        $("#announcement").keyup(function () {
            check_announcements();
        });
        $("#announcement").focusout(function () {
            check_announcements();
        });
    });

    // CHECK FUNCTIONS

    function check_issue() {
        var issue = $("#issue");
        if(issue.val().length < 8 || issue.val().length > 180){
            $("#issue_error").html("Issue name mast be between 8 and 180 characters long");
            $("#issue_error").show();
            $("#issue").addClass("parsley-error");
            error_issue = true;
        } else if(!issue.val().match(/^[a-z A-Z0-9.,!?]+$/)){
            $("#issue_error").html("Only alphanumeric characters are allowed");
            $("#issue_error").show();
            $("#issue").addClass("parsley-error");
            error_issue = true;
        } else {
            $("#issue_error").hide();
            $("#issue").removeClass("parsley-error");
            $("#issue").addClass("parsley-success");
            error_issue = false;
        } if(error_issue === false && error_message === false){
            $("#report_issue").addClass("btn-success");
        } else {
            $("#report_issue").removeClass("btn-success");
        }
    }

    function check_message() {
        var message = $("#message_last");
        if(message.val().length < 8 || message.val().length > 300){
            $("#message_last_error").html("The message mast be between 8 and 300 characters long");
            $("#message_last_error").show();
            $("#message_last").addClass("parsley-error");
            error_message = true;
        } else if(!message.val().match(/^[a-z A-Z0-9.,]+$/)){
            $("#message_last_error").html("Only alphanumeric characters are allowed");
            $("#message_last_error").show();
            $("#message_last").addClass("parsley-error");
            error_message = true;
        } else {
            $("#message_last_error").hide();
            $("#message_last").removeClass("parsley-error");
            $("#message_last").addClass("parsley-success");
            error_message = false;
        } if(error_message === false){
            $("#comment_last").addClass("btn-success");
        } else {
            $("#comment_last").removeClass("btn-success");
        }
    }

    function check_comment() {
        var comment = $("#comment_last");
        if(comment.val().length < 8 || comment.val().length > 300){
            $("#comment_last_error").html("The comment mast be between 8 and 300 characters long");
            $("#comment_last_error").show();
            $("#comment_last").addClass("parsley-error");
            error_comment_last = true;
        } else if(!comment.val().match(/^[a-z A-Z0-9.,]+$/)){
            $("#comment_last_error").html("Only alphanumeric characters are allowed");
            $("#message_last_error").show();
            $("#message_last").addClass("parsley-error");
            error_message = true;
        } else {
            $("#message_last_error").hide();
            $("#message_last").removeClass("parsley-error");
            $("#message_last").addClass("parsley-success");
            error_message = false;
        } if(error_message === false){
            $("#comment_last").addClass("btn-success");
        } else {
            $("#comment_last").removeClass("btn-success");
        }
    }


    $("#comment_last").click(function () {
        $("#message_last_error").hide();
        $("#message_last").removeClass("parsley-success");
        $("#comment_last").removeClass("btn-success");
    });
});
