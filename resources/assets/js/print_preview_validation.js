$(function () {
    $("#material_amount_error").hide();
    $("#message_error").hide();

    var error_material = true;
    var error_message = true;


    $("#material_amount").keyup(function () {
        check_material_amount();
    });
    $("#message").keyup(function () {
        check_message();
    });
    $("#material_amount").focusout(function () {
        check_material_amount();
    });
    $("#message").focusout(function () {
        check_message();
    });

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
        } if( error_material === false && error_message === false){
            $("#submit").addClass("btn-success");
            $("#submit").trigger("cssClassChanged");
            $("#submit").prop('disabled', false);
        } else {
            $("#submit").removeClass("btn-success");
        }
    }
    function check_message() {
        var message = $("#message");

        if(message.val().length < 8 || message.val().length > 500){
            $("#message_error").html("The message must be between 8 and 500 characters long");
            $("#message_error").show();
            $("#message").addClass("parsley-error");
            error_message = true;
        } else {
            $("#message_error").hide();
            $("#message").removeClass("parsley-error");
            $("#message").addClass("parsley-success");
            error_message = false;
        } if(error_material === false && error_message === false){
            $("#submit").addClass("btn-success");
            $("#submit").trigger("cssClassChanged");
            $("#submit").prop('disabled', false);
        } else {
            $("#submit").removeClass("btn-success");
        }
    }
    $("#submit").click(function () {
        $("#material_amount_error").hide();
        $("#message_error").hide();
        $("#material_amount").removeClass("parsley-success");
        $("#message").removeClass("parsley-success");
        $("#submit").removeClass("btn-success");
    });
});
