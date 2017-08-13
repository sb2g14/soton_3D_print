$(function () {
    $("#student_name_error").hide();
    $("#email_error").hide();
    $("#student_id_error").hide();
    $("#material_amount_error").hide();
    $("#use_case_error").hide();

    var error_name = true;
    var error_email = true;
    var error_id = true;
    var error_material = true;
    var error_use_case = true;

    $("#student_name").keyup(function () {
        check_student_name();
    });
    $("#email").keyup(function () {
        check_email();
    });
    $("#student_id").keyup(function () {
       check_student_id();
    });
    $("#material_amount").keyup(function () {
        check_material_amount();
    });
    $("#use_case").keyup(function () {
       check_use_case();
    });

    $("#student_name").focusout(function () {
        check_student_name();
    });
    $("#email").focusout(function () {
        check_email();
    });
    $("#student_id").focusout(function () {
        check_student_id();
    });
    $("#material_amount").focusout(function () {
        check_material_amount();
    });
    $("#use_case").focusout(function () {
        check_use_case();
    });
    $("#hours").focusout(function () {
        evaluate_price();
    });
    $("#minutes").focusout(function () {
        evaluate_price();
    });
    $("#material_amount").focusout(function () {
        evaluate_price();
    });
    $( window ).load(function() {
        check_student_name();
        check_email();
    });


    function check_student_name() {
     var name = $("#student_name");

     if(name.val().length < 3 || name.val().length > 20){
         $("#student_name_error").html("The name should be between 2 and 20 characters");
         $("#student_name_error").show();
         $("#student_name").focus();
         $("#student_name").addClass("parsley-error");
         error_name = true;
     } else if (!name.val().match(/^[a-z ,.'-]+$/i)){
         $("#student_name_error").html("Only letters and hyphens(-) are allowed");
         $("#student_name_error").show();
         $("#student_name").focus();
         $("#student_name").addClass("parsley-error");
         error_name = true;
     } else {
         $("#student_name_error").hide();
         $("#student_name").removeClass("parsley-error");
         $("#student_name").addClass("parsley-success");
         error_name = false;
     } if( error_name === false && error_email === false &&
            error_id === false && error_material === false && error_use_case === false){
            $("#submit").addClass("btn-success");
            $("#submit").trigger("cssClassChanged");
            $("#submit").prop('disabled', false);
        } else {
            $("#submit").removeClass("btn-success");
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
        } if( error_name === false && error_email === false &&
            error_id === false && error_material === false && error_use_case === false){
            $("#submit").addClass("btn-success");
            $("#submit").trigger("cssClassChanged");
            $("#submit").prop('disabled', false);
        } else {
            $("#submit").removeClass("btn-success");
        }
    }
    function check_student_id() {
        var id = $("#student_id");

        if(id.val().length < 1){
            $("#student_id_error").html("Id cannot be empty");
            $("#student_id_error").show();
            $("#student_id").focus();
            $("#student_id").addClass("parsley-error");
            error_id = true;
        }else if (id.val()[0].match(/^[1]/) && id.val().length !== 8) {
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
        } else if (!id.val().match(/^[0-9]+$/)) {
            $("#student_id_error").html("Only digits are allowed");
            $("#student_id_error").show();
            $("#student_id").focus();
            $("#student_id").addClass("parsley-error");
            error_id = true;
        } else {
            $("#student_id_error").hide();
            $("#student_id").removeClass("parsley-error");
            $("#student_id").addClass("parsley-success");
            error_id = false;
        } if( error_name === false && error_email === false &&
            error_id === false && error_material === false && error_use_case === false){
            $("#submit").addClass("btn-success");
            $("#submit").trigger("cssClassChanged");
            $("#submit").prop('disabled', false);
        } else {
            $("#submit").removeClass("btn-success");
        }
    }
    function check_material_amount() {
        var material = $("#material_amount");

        if(material.val().length < 1){
            $("#material_amount_error").html("The value must be between 0.1 and 9999 in grams");
            $("#material_amount_error").show();
            $("#material_amount").focus();
            $("#material_amount").addClass("parsley-error");
            error_material = true;
        } else if (!material.val().match(/^(?!0(\.?0*)?$)\d{0,3}(\.?\d{0,1})?$/)) {
            $("#material_amount_error").html("The value must be between 0.1 and 9999 in grams");
            $("#material_amount_error").show();
            $("#material_amount").focus();
            $("#material_amount").addClass("parsley-error");
            error_material = true;
        } else {
            $("#material_amount_error").hide();
            $("#material_amount").removeClass("parsley-error");
            $("#material_amount").addClass("parsley-success");
            error_material = false;
        } if( error_name === false && error_email === false &&
            error_id === false && error_material === false && error_use_case === false){
            $("#submit").addClass("btn-success");
            $("#submit").trigger("cssClassChanged");
            $("#submit").prop('disabled', false);
        } else {
            $("#submit").removeClass("btn-success");
        }
    }
    function check_use_case() {
        var use_case = $("#use_case");

        if(use_case.val().length < 3 || use_case.val().length > 13) {
            $("#use_case_error").html("Either 9 digit cost code or standard module name are allowed");
            $("#use_case_error").show();
            $("#use_case").focus();
            $("#use_case").addClass("parsley-error");
            error_use_case = true;
        } else if(!use_case.val().match(/^[A-Z0-9-]*$/)){
            $("#use_case_error").html("Either 9 digit cost code or standard module name are allowed");
            $("#use_case_error").show();
            $("#use_case").focus();
            $("#use_case").addClass("parsley-error");
        } else {
            $("#use_case_error").hide();
            $("#use_case").removeClass("parsley-error");
            $("#use_case").addClass("parsley-success");
            error_use_case = false;
        } if( error_name === false && error_email === false &&
            error_id === false && error_material === false && error_use_case === false){
            $("#submit").addClass("btn-success");
            $("#submit").trigger("cssClassChanged");
            $("#submit").prop('disabled', false);
        } else {
            $("#submit").removeClass("btn-success");
        }
    }
    function evaluate_price() {
        if( error_material === false && $("#hours") != null && $("#minutes" != null)){
            var $price = 3*($("#hours").val() + $("#minutes").val())/60 + 5*$("#material_amount").val()/100;
            $("#price").html($price);
        }
    }
    $("#submit").click(function () {
        $("#student_name_error").hide();
        $("#email_error").hide();
        $("#student_id_error").hide();
        $("#material_amount_error").hide();
        $("#use_case_error").hide();
        $("#student_name").removeClass("parsley-success");
        $("#email").removeClass("parsley-success");
        $("#student_id").removeClass("parsley-success");
        $("#material_amount").removeClass("parsley-success");
        $("#submit").removeClass("btn-success");
    });
});
