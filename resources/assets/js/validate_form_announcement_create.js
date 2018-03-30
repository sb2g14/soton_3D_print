/*** validate_form_announcement_create.js ***
 * This file can be loaded into an html containing an 
 * announcement creation form. It will then add javascript 
 * validations from validations.js to the input fields as 
 * defined in 'funs' below.
 * It will also disable the submit button with the id 'post'.
 ***/
const validations = require('./validations');
$(document).ready(function() {

    $(window).load(function () {
        check_all_fields();
    });

    //map the field ids to the functions in this dictionary,
    //assign null to input fields that you need to treat extra...
    var funs = {
        "#announcement": validations.check_message_long
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
    
    //iterate through input and select fields as well as textareas.
    //construct to modify the keyup function for all fields
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


    function check_all_fields() {
        //do all checks again
        for (var i = 0; i < html_triggers.length; i++) {
            var el = html_triggers[i];
            if (funs[el] && $(el).length) {
                errors[el] = funs[el](el);
            }
        }
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
        //if there has been no error, then submit button is good to go, otherwise disable
        if (!hasError) {
            $("#post").prop('disabled', false);
        } else {
            $("#post").prop('disabled', true);
        }
    }

    $("#post").click(function () {
        for (var i = 0; i < html_triggers.length; i++) {
            $(html_triggers[i]).hide();
            $(html_triggers[i]).removeClass("parsley-success");
        }
    });



});
