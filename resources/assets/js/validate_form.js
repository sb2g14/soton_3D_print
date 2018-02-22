/*** validate_form.js ***
 * This file can be loaded into an html containing a form
 * it will then add javascript validations from validations.js
 * to the input fields as defined in 'funs' below.
 * it will also disable the submit button with the id 'submit'
 * until all the validations are fulfilled.
 ***/
const validations = require('./validations');
$(document).ready(function() {

    $(window).load(function () {
        $("#budget_holder_group").hide();
        check_all_fields();
    });
    function local_check_cost_code(fieldname) {
        return validations.check_cost_code(fieldname, "#budget_holder");
    }
    function local_check_budget_holder(fieldname) {
        return validations.check_budget_holder(fieldname,"#use_case");
    }
    function local_check_time_minutes(fieldname){
        return validations.check_print_duration("#hours",fieldname,"#time")
    }
    function local_check_time_hours(fieldname){
        return validations.check_print_duration(fieldname,"#minutes","#time")
    }

    //map the field ids to the functions in this dictionary,
    //assign null to input fields that you need to treat extra...
    var funs = {
        "#customer_name": validations.check_name,
        "#student_name": validations.check_name,
        "#customer_email": validations.check_email,
        "#email": validations.check_email,
        "#customer_id": validations.check_university_id_number,
        "#student_id": validations.check_university_id_number,
        "#job_title": validations.check_job_title,
        "#claim_id": validations.check_claim_id,
        "#claim_passcode": validations.check_claim_passcode,
        "#printers_id": validations.check_printer_number,
        "#material_amount": validations.check_material_amount,
        "#hours": local_check_time_hours,
        "#minutes": local_check_time_minutes,
        "#use_case": local_check_cost_code,
        "#budget_holder": local_check_budget_holder,
        "#comment": validations.check_comment,
        "#message": validations.check_message_default,
    };
    //get a list of all the input fields from previous dictionary so we don't need to redefine.
    var html_triggers = Object.keys(funs);
    //create a dictionary to keep track of the errors for the fields and
    //pre-populate it to set all errors to true.
    var errors = {};
    for (var i = 0; i < html_triggers.length; i++) {
        errors[html_triggers[i]] = true;
    };
    //hide all the error fields initially
    for (var i = 0; i < html_triggers.length; i++) {
        var el = html_triggers[i];
        $(el.concat("_error")).hide();
    }

    //construct to modify the keyup function for all fields
    //iterates through input fields of type text or customer_email, as well as select fields
    $("input[type='text'], select, input[type='customer_email']").keyup(function() {
        //here we create a variable for the validation function for that field,
        //passing the field id to it as an argument
        var fun = funs["#" + $(this).attr('id')];
        //if that function was in the dictionary, then call it.
        if (fun) {
            errors["#" + $(this).attr('id')] = fun("#" + $(this).attr('id'));
            check_all_fields();
        }
    });
    //construct to modify the focusout function for all fields
    $("input, select").focusout(function() {
        //here we create a variable for the validation function for that field,
        //passing the field id to it as an argument
        var fun = funs["#" + $(this).attr('id')];
        //if that function was in the dictionary, then call it.
        if (fun) {
            errors["#" + $(this).attr('id')] = fun("#" + $(this).attr('id'));
            check_all_fields();
        }
    });


    function check_all_fields() {
        //could do all checks again
        for (var i = 0; i < html_triggers.length; i++) {
            var el = html_triggers[i];
            if (funs[el] && $(el).length) {
                errors[el] = funs[el](el);
            }
        }
        //but only really need special checks that affect more than one field
        //errors["#use_case"] = check_cost_code("#use_case","#budget_holder");
        //errors["#budget_holder"] = check_budget_holder("#budget_holder","#use_case");
        //now count the errors
        console.log("checking number of errors");
        var hasError = false;
        var errCount = 0;
        for (e in errors) {
            if (errors[e] && $(e).length) {
                hasError = true;
                errCount ++;
            }
        }
        //update the price preview as we are on it
        evaluate_price();
        //if there has been no error, then submit button is good to go, otherwise disable
        if (!hasError) {
            //$("#submit").addClass("btn-success");
            //$("#submit").trigger("cssClassChanged");
            //$("#submit").html("Submit");
            $("#submit").prop('disabled', false);
        } else {
            //$("#submit").removeClass("btn-success");
            //$("#submit").trigger("cssClassChanged");
            //$("#submit").html(errCount+" validations failed");
            $("#submit").prop('disabled', true);
        }
    }

    function evaluate_price() {
        var idPrice = "#price";
        var idHours = "#hours"; //select
        var idMinutes = "#minutes";
        var idMaterial = "#material_amount";
        if ($(idPrice).length) {
            if( !errors[idMaterial] && !errors[idHours] && errors[idMinutes]){
                var time = $(idHours).val() + $(idMinutes).val()/60; //time in hours
                var material = $(idMaterial).val(); //material in g
                var $price = 3*time + 5*material/100;
                $(idPrice).html($price);
            }
        }
    }

    $("#submit").click(function () {
        for (var i = 0; i < html_triggers.length; i++) {
            $(html_triggers[i]).hide();
            $(html_triggers[i]).removeClass("parsley-success");
        }
    });



});