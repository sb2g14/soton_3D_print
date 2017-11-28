$(function () {
    $("#message_error").hide();

    var error_message = true;

    $("#message").keyup(function () {
        check_message();
    });

    function check_message() {
        var message = $("#message");

        if(message.val().length < 8 || message.val().length > 300){
            $("#message_error").html("The message must be between 8 and 300 characters long");
            $("#message_error").show();
            $("#message").focus();
            $("#message").addClass("parsley-error");
            error_message = true;
        // } else if(!message.val().match(/^[a-z A-Z0-9-.,!?']+$/)){
        //     $("#message_error").html("Only alphanumeric characters are allowed");
        //     $("#message_error").show();
        //     $("#message").focus();
        //     $("#message").addClass("parsley-error");
        //     error_message = true;
        } else {
            $("#message_error").hide();
            $("#message").removeClass("parsley-error");
            $("#message").addClass("parsley-success");
            error_message = false;
        } if(error_message === false){
            $("#submit").addClass("btn-success");
        } else {
            $("#submit").removeClass("btn-success");
        }
    }
    $("#submit").click(function () {
        $("#message_error").hide();
        $("#message").removeClass("parsley-success");
        $("#submit").removeClass("btn-success");
    });
});
