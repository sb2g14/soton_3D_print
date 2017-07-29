$(function () {
    $("#issue_error").hide();
    $("#message_error").hide();

    var error_issue = true;
    var error_message = true;

    $("#issue").keyup(function () {
        check_issue();
    });
    $("#issue").focusout(function(){
       check_issue();
    });
    $("#message").keyup(function () {
        check_message();
    });
    $("#message").focusout(function () {
        check_message();
    });

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
        var message = $("#message");

        if(message.val().length < 8 || message.val().length > 300){
            $("#message_error").html("The message mast be between 8 and 300 characters long");
            $("#message_error").show();
            $("#message").addClass("parsley-error");
            error_message = true;
        } else if(!message.val().match(/^[a-z A-Z0-9.,!?]+$/)){
            $("#message_error").html("Only alphanumeric characters are allowed");
            $("#message_error").show();
            $("#message").addClass("parsley-error");
            error_message = true;
        } else {
            $("#message_error").hide();
            $("#message").removeClass("parsley-error");
            $("#message").addClass("parsley-success");
            error_message = false;
        } if(error_issue === false && error_message === false){
            $("#report_issue").addClass("btn-success");
        } else {
            $("#report_issue").removeClass("btn-success");
        }
    }
    $("#report_issue").click(function () {
        $("#issue_error").hide();
        $("#message_error").hide();
        $("#issue").removeClass("parsley-success");
        $("#message").removeClass("parsley-success");
        $("#report_issue").removeClass("btn-success");
    });
});
