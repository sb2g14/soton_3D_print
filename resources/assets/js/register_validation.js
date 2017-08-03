$(function () {
    $("#name_error").hide();
    $("#email_error").hide();
    $("#password_error").hide();
    $("#password_confirm_error").hide();
    $("#student_id_error").hide();

    var error_name = true;
    var error_password_confirm = true;
    var error_email = true;
    var error_password = true;
    var error_id = true;


    $("#name").keyup(function () {
        check_name();
    });
    $("#email").keyup(function () {
        check_email();
    });
    $("#password").keyup(function () {
        check_password();
    });
    $("#password-confirm").keyup(function () {
        confirm_password();
    });
    $("#student_id").keyup(function () {
        check_student_id();
    });
    $("#name").focusout(function () {
        check_name();
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
    $("#student_id").focusout(function () {
        check_student_id();
    });


    function check_name() {
        var name = $("#name");

        if (!name.val().match(/^[a-z-A-Z- ]{3,20}$/)){
            $("#name_error").html("Only letters and hyphens(-) are allowed. Maximum name length is 25 characters");
            $("#name_error").show();
            $("#name").focus();
            $("#name").addClass("parsley-error");
            error_name = true;
        } else {
            $("#name_error").hide();
            $("#name").removeClass("parsley-error");
            $("#name").addClass("parsley-success");
            error_name = false;
        } if( error_name === false && error_password_confirm === false &&
            error_password === false && error_email === false && error_id === false){
            $("#register-button").addClass("btn-success");
        } else {
            $("#register-button").removeClass("btn-success");
        }
    }
    function check_student_id() {
        var id = $("#student_id");

        if (id.val().length < 1) {
            $("#student_id_error").html("Id cannot be empty");
            $("#student_id_error").show();
            $("#student_id").focus();
            $("#student_id").addClass("parsley-error");
            error_id = true;
        } else if (id.val()[0].match(/^[1]/) && id.val().length !== 8) {
            $("#student_id_error").html("Id of a member of staff must be 8 digits long");
            $("#student_id_error").show();
            $("#student_id").focus();
            $("#student_id").addClass("parsley-error");
            error_id = true;
        } else if (id.val()[0].match(/^[2345]/) && id.val().length !== 9) {
            $("#student_id_error").html("The id of students must be 9 digits long");
            $("#student_id_error").show();
            $("#student_id").focus();
            $("#student_id").addClass("parsley-error");
            error_id = true;
        } else if (!id.val().match(/*/^[0-9]+$/*/)) {
            $("#student_id_error").html("Only digits are allowed");
            $("#student_id_error").show();
            $("#student_id").addClass("parsley-error");
            $("#student_id").focus();
            error_id = true;
        } else {
            $("#student_id_error").hide();
            $("#student_id").removeClass("parsley-error");
            $("#student_id").addClass("parsley-success");
            error_id = false;
        }if( error_name === false && error_password_confirm === false &&
            error_password === false && error_email === false && error_id === false){
            $("#register-button").addClass("btn-success");
            $("#register-button").trigger("cssClassChanged");
            $("#register-button").prop('disabled', false);
        } else {
            $("#register-button").removeClass("btn-success");
        }
    }
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
        } if( error_name === false && error_password_confirm === false &&
            error_password === false && error_email === false && error_id === false){
            $("#register-button").addClass("btn-success");
        } else {
            $("#register-button").removeClass("btn-success");
        }
    }
    function check_password() {
        var password = $("#password");

        if (password.val().length < 6 || password.val().length > 16){
            $("#password_error").html("The password must be 6 to 16 character long and contain at least one upper " +
                "case letter, one lower case letter, and one digit");
            $("#password_error").show();
            $("#password").focus();
            $("#password").addClass("parsley-error");
            error_password = true;
        } else if(!password.val().match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,16}$/)){
            $("#password_error").html("The password must be 6 to 16 character long and contain at least one upper " +
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
        } if( error_name === false && error_password_confirm === false &&
            error_password === false && error_email === false && error_id === false){
            $("#register-button").addClass("btn-success");
        } else {
            $("#register-button").removeClass("btn-success");
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
        } if( error_name === false && error_password_confirm === false &&
        error_password === false && error_email === false && error_id === false){
        $("#register-button").addClass("btn-success");
    } else {
        $("#register-button").removeClass("btn-success");
    }
    }

    $("#register-button").click(function () {
        $("#name_error").hide();
        $("#email_error").hide();
        $("#password_error").hide();
        $("#password_confirm_error").hide();
        $("#student_id_error").hide();
        $("#email").removeClass("parsley-success");
        $("#password").removeClass("parsley-success");
        $("#name").removeClass("parsley-success");
        $("#password-confirm").removeClass("parsley-success");
        $("#student_id").removeClass("parsley-success");
        $("#register-button").removeClass("btn-success");
    });
});
