$(function () {
    $("#material_amount_error").hide();

    var error_material = true;

    $("#material_amount").keyup(function () {
        check_material_amount();
    });

    $("#material_amount").focusout(function () {
        check_material_amount();
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
        $("#material_amount_error").hide();
        $("#material_amount").removeClass("parsley-success");
        $("#submit").removeClass("btn-success");

    });
});
