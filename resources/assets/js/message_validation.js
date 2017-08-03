$(function () {
    $("#message_last_error").hide();

    var error_message = true;

    $("#message_last").keyup(function () {
        check_message();
    });
    $("#message_last").focusout(function () {
        check_message();
    });

    function check_message() {
        var message = $("#message_last");

        if(message.val().length < 8 || message.val().length > 300){
            $("#message_last_error").html("The message must be between 8 and 300 characters long");
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
    $("#comment_last").click(function () {
        $("#message_last_error").hide();
        $("#message_last").removeClass("parsley-success");
        $("#comment_last").removeClass("btn-success");
    });
});
