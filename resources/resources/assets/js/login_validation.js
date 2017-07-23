$(function () {
    $("#email_error").hide();
    $("#password_error").hide();

    var error_email = true;
    var error_password = true;


    $("#email").keyup(function () {
        check_email();
    });
    $("#password").keyup(function () {
        check_password();
    });
    $("#email").focusout(function () {
        check_email();
    });
    $("#password").focusout(function () {
        check_password();
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
        } if(error_password === false && error_email === false){
            $("#login-button").addClass("btn-success");
        } else {
            $("#login-button").removeClass("btn-success");
        }
    }
    function check_password() {
        var password = $("#password");

        if(password.val().length < 6 || password.val().length > 16){
            $("#password_error").html("The password mast be between 6 and 16 characters long");
            $("#password_error").show();
            $("#password").focus();
            $("#password").addClass("parsley-error");
            error_password = true;
        } else {
            $("#password_error").hide();
            $("#password").removeClass("parsley-error");
            $("#password").addClass("parsley-success");
            error_password = false;
        } if(error_password === false && error_email === false){
            $("#login-button").addClass("btn-success");
        } else {
            $("#login-button").removeClass("btn-success");
        }
    }
    $("#login-button").click(function () {
        $("#email_error").hide();
        $("#password_error").hide();
        $("#email").removeClass("parsley-success");
        $("#password").removeClass("parsley-success");
        $("#login-button").removeClass("btn-success");
    });
});
