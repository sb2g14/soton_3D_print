/*** validate_form.js ***
 * This file can be loaded into an html containing a form
 * it will then add javascript validations from validations.js
 * to the input fields as defined in 'funs' below.
 * it will also disable the submit button with the name 'submit'
 * until all the validations are fulfilled and update the price
 * in the field with the name 'price'.
 * You should use this file in all blades that contain only one
 * form. If a blade contains more than one form, you need to 
 * create one copy of this file for each of the forms. Ensure that
 * all ids for the inputs and buttons are unique accross the blade
 * and only keep the function assignments that are used within one
 * form for the file corresponding to that form. Also remember to
 * rename the button id in the file.
 ***/
const validations = require('./validations');
$(document).ready(function() {
    
    
    $(window).load(function () {
        check_all_fields();
        //hide elements after checking all fields.
        //this may crash if a group field doesn't exist.
        //also we shouldn't require this, since the validation 
        //functions should hide/ show them automatically.
        //$("#budget_holder_group").hide();
        //$("#printer_type_other_group").hide();
    });
    
    //these functions are defined so that the check function only takes one argument.
    //these need to be adapted if the stadard ids for the input fields changes.
    function local_check_cost_code(fieldname) {
        return validations.check_cost_code_combination(fieldname,"#budget_holder");
    }
    function local_check_budget_holder(fieldname) {
        return validations.check_budget_holder(fieldname,"#use_case");
    }
    function local_check_time_minutes(fieldname){
        return validations.check_print_duration("#hours",fieldname,"#time_error")
    }
    function local_check_time_hours(fieldname){
        return validations.check_print_duration(fieldname,"#minutes","#time_error")
    }
    function local_check_printer_type_radio(fieldname) {
        return validations.check_printer_type_radio(fieldname,"#printer_type_other");
    }
    function local_check_printer_type_input(fieldname) {
        //passing printer_type without # since the radio buttons have no id
        return validations.check_printer_type_input(fieldname,"printer_type");
    }
    function local_check_password_match(fieldname) {
        return validations.check_password_match(fieldname,"#password");
    }

    //map the field ids to the functions in this dictionary,
    //assign null to input fields that you need to treat extra... 
    var funs = {
        "#customer_name": validations.check_name,
        "#student_name": validations.check_name,
        "#holder_name": validations.check_name,
        "#staff_name": validations.check_name,
        "#first_name": validations.check_name,
        "#last_name": validations.check_name,
        "#customer_email": validations.check_university_email,
        "#email": validations.check_university_email,
        "#customer_id": validations.check_university_id_number,
        "#student_id": validations.check_university_id_number,
        "#password": validations.check_password,
        "#password_confirm": local_check_password_match,
        "#phone": validations.check_phone,
        "#job_title": validations.check_job_title,
        "#claim_id": validations.check_claim_id,
        "#claim_passcode": validations.check_claim_passcode,
        "#printers_id": validations.check_printer_number_select,
        "#number": validations.check_printer_number_input,
        "#serial": validations.check_printer_serial,
        "#printer_type": local_check_printer_type_radio,
        "#printer_type_other": local_check_printer_type_input,
        "#material_amount": validations.check_material_amount,
        "#hours": local_check_time_hours,
        "#minutes": local_check_time_minutes,
        "#shortage": validations.check_shortage,
        "#cost_code": validations.check_cost_code,
        "#use_case": local_check_cost_code,
        "#budget_holder": local_check_budget_holder,
        "#issue": validations.check_issue_title,
        "#comment": validations.check_comment,
        "#message": validations.check_message_default,
        "#message_last": validations.check_message_default,
        "#message_long": validations.check_message_long,
        "#explanation": validations.check_message_explanation,
        "#description": validations.check_message_default
    };
    /*//proposed new naming of the fields:
    var funs = {
        "#customer_name": validations.check_name,
        "#user_name": validations.check_name,
        "#first_name": validations.check_name,
        "#last_name": validations.check_name,
        "#customer_email": validations.check_university_email,
        "#user_email": validations.check_university_email,
        "#customer_id": validations.check_university_id_number,
        "#user_id": validations.check_university_id_number,
        "#password": validations.check_password,
        "#password_confirm": validations.check_password,
        "#user_phone": validations.check_phone,
        "#job_title": validations.check_job_title,
        "#dropoff_claim_id": validations.check_claim_id,
        "#dropoff_claim_passcode": validations.check_claim_passcode,
        "#printer_no_select": validations.check_printer_number_select,
        "#printer_no": validations.check_printer_number_input,
        "#printer_serial": validations.check_printer_serial,
        "#printer_type": local_check_printer_type_radio,
        "#printer_type_other": local_check_printer_type_input,
        "#material_amount": validations.check_material_amount,
        "#time_hours": local_check_time_hours,
        "#time_minutes": local_check_time_minutes,
        "#pay_cost_code": local_check_cost_code,
        "#pay_budget_holder": local_check_budget_holder,
        "#issue_title": validations.check_issue_title,
        "#comment": validations.check_comment,
        "#message": validations.check_message_default,
        "#message_last": validations.check_message_default,
        "#message_long": validations.check_message_long
    };*/

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
    $("input, select, textarea").keyup(function() {
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
    $("input, select, textarea").focusout(function() {
        //here we create a variable for the validation function for that field,
        //passing the field id to it as an argument
        var fun = funs["#" + $(this).attr('id')];
        //if that function was in the dictionary, then call it.
        if (fun) {
            errors["#" + $(this).attr('id')] = fun("#" + $(this).attr('id'));
            check_all_fields();
        }
    });
    //special case "printer type" since this is a group of radio buttons, their id is different/ undefined so we need to select them by name.
    $("input[name='printer_type']").click(function() {
        //this is a special case, where we have radio buttons that have a consistent name, not id.
        var fun = funs["#" + $(this).attr('name')];
        errors["#" + $(this).attr('name')] = local_check_printer_type_radio($(this).attr('name'));
        check_all_fields();
    });



    function check_all_fields() {
        //do all checks again
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
        /* check if a price field exists, calculates the price 
         * and enters it into that field */
        var idPrice = "#price"; //name of the field containing the price.
        //the following three names should be the same as defined in funs!
        var idHours = "#hours";
        var idMinutes = "#minutes";
        var idMaterial = "#material_amount";
        if ($(idPrice).length) {
            if( !errors[idMaterial] && !errors[idHours] && !errors[idMinutes]){
                var time = $(idHours).find(":selected").text() + $(idMinutes).find(":selected").text()/60; //time in hours
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
