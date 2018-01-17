$(function () {
    $("#other_printer_type_error").hide();

    $("#other").focusin(function () {
        check_not_empty();
    });
    $("#other_printer_type").keyup(function () {
        check_not_empty();
    });


    function check_not_empty() {
        var other_printer_type = $("#other_printer_type");

        if (other_printer_type.val().length < 3 || other_printer_type.val().length > 100) {
            $("#other_printer_type_error").html("The printer type is too long or too short");
            $("#other_printer_type_error").show();
            $("#other_printer_type").addClass("parsley-error");
        } else {
            $("#other").prop("checked", true);
            $("#other_printer_type_error").hide();
            $("#other_printer_type").removeClass("parsley-error");
            $("#other_printer_type").addClass("parsley-success");
        }
    }
    });
