$(function () {
    $("#email_error").hide();

    var error_email = true;

    $("#email").keyup(function () {
        check_email();
    });
    $("#email").focusout(function () {
        check_email();
    });

    function check_email() {
        var email = $("#email");

        if(email.val().length < 11 || email.val().length > 30){
            $("#email_error").html("Email is too short or too long");
            $("#email_error").show();
            $("#email").focus();
            $("#email").addClass("parsley-error");
            error_email = true;
        } else if(!email.val().match(/^([a-zA-Z0-9_.+-])+\@soton.ac.uk$/)){
            $("#email_error").html("Only @soton.ac.uk emails are allowed");
            $("#email_error").show();
            $("#email").focus();
            $("#email").addClass("parsley-error");
            error_email = true;
        } else {
            $("#email_error").hide();
            $("#email").removeClass("parsley-error");
            $("#email").addClass("parsley-success");
            error_email = false;
        } if(error_email === false){
            $("#reset_button").addClass("btn-success");
        } else {
            $("#reset_button").removeClass("btn-success");
        }
    }
    $("#reset_button").click(function () {
        $("#email_error").hide();
        $("#email").removeClass("parsley-success");
        $("#reset_button").removeClass("btn-success");
    });
});
