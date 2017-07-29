$(function () {
    $("#password_error").hide();
    $("#email_error").hide();
    $("#password_confirm_error").hide();

    var error_email = true;
    var error_password = true;
    var error_password_confirm = true;


    $("#email").keyup(function () {
        check_email();
    });
    $("#password").keyup(function () {
        check_password();
    });
    $("#password-confirm").keyup(function () {
        confirm_password();
    });
    $("#email").focusout(function () {
        check_email();
    });
    $("#password").focusout(function () {
        check_password();
    });
    $("#password-confirm").focusout(function () {
        confirm_password();
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
        } if(error_password === false && error_email === false &&
        error_password_confirm === false){
            $("#reset-button").addClass("btn-success");
        } else {
            $("#reset-button").removeClass("btn-success");
        }
    }
    function check_password() {
        var password = $("#password");

        if (password.val().length < 6 || password.val().length > 16){
            $("#password_error").html("The password mast be 6 to 16 character long and contain at least one upper " +
                "case letter, one lower case letter, and one digit");
            $("#password_error").show();
            $("#password").focus();
            $("#password").addClass("parsley-error");
            error_password = true;
        } else if(!password.val().match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,16}$/)){
            $("#password_error").html("The password mast be 6 to 16 character long and contain at least one upper " +
                "case letter, one lower case letter, and one digit");
            $("#password_error").show();
            $("#password").focus();
            $("#password").addClass("parsley-error");
            error_password = true;
        } else {
            $("#password_error").hide();
            $("#password").removeClass("parsley-error");
            $("#password").addClass("parsley-success");
            error_password = false;
        } if( error_password_confirm === false &&
            error_password === false &&
            error_email === false){
            $("#reset-button").addClass("btn-success");
        } else {
            $("#reset-button").removeClass("btn-success");
        }
    }
    function confirm_password() {
            var password = $("#password").val();
            var confirmPassword = $("#password-confirm").val();

            if (password !== confirmPassword) {
                $("#password-confirm_error").html("Passwords do not match");
                $("#password-confirm_error").show();
                $("#password-confirm").focus();
                $("#password-confirm").addClass("parsley-error");
                error_password_confirm = true;
            } else {
                $("#password-confirm_error").hide();
                $("#password-confirm").removeClass("parsley-error");
                $("#password-confirm").addClass("parsley-success");
                error_password_confirm = false;
        } if( error_password_confirm === false &&
            error_password === false &&
            error_email === false){
        $("#reset_button").addClass("btn-success");
    } else {
        $("#reset_button").removeClass("btn-success");
    }
    }

    $("#reset_button").click(function () {
        $("#email_error").hide();
        $("#password_error").hide();
        $("#password_confirm_error").hide();
        $("#email").removeClass("parsley-success");
        $("#password").removeClass("parsley-success");
        $("#password-confirm").removeClass("parsley-success");
        $("#reset_button").removeClass("btn-success");
    });
});
