// $(function () {
//     $("#student_name_error").hide();
//     $("#email_error").hide();
//     $("#student_id_error").hide();
//     $("#material_amount_error").hide();
//     $("#use_case_error").hide();
//     $("#budget_holder_error").hide();
//     $("#job_title_error").hide();
//     $("#time_error").hide();
//
//     var error_name = true;
//     var error_email = true;
//     var error_id = true;
//     var error_material = true;
//     var error_use_case = true;
//     var error_budget_holder = true;
//     var error_job_title = true;
//     var error_time = true;
//
//     function check_all_fields(){
//         if( !error_name && !error_email && !error_id && !error_material
//             && !error_use_case && !error_budget_holder && !error_job_title && !error_time){
//             $("#submit").addClass("btn-success");
//             $("#submit").trigger("cssClassChanged");
//             $("#submit").prop('disabled', false);
//         } else {
//             $("#submit").removeClass("btn-success");
//             //$("#submit").prop('disabled', true);
//         }
//     }
//     function addError(target, message){
//         $(target.concat("_error")).html(message);
//         $(target.concat("_error")).show();
//         //$(target).focus();
//         $(target).addClass("parsley-error");
//     }
//     function removeError(target){
//         $(target.concat("_error")).hide();
//         $(target).removeClass("parsley-error");
//         $(target).addClass("parsley-success");
//     }
//
//     $("#student_name").keyup(function () {
//         check_student_name();
//     });
//     $("#email").keyup(function () {
//         check_email();
//     });
//     $("#student_id").keyup(function () {
//        check_student_id();
//     });
//     $("#material_amount").keyup(function () {
//         check_material_amount();
//     });
//     $("#use_case").keyup(function () {
//        check_use_case();
//     });
//     $("#budget_holder").keyup(function () {
//         check_budget_holder();
//     });
//     $("#job_title").keyup(function () {
//         check_job_title();
//     });
//     $("#hours").keyup(function () {
//         check_time();
//     });
//     $("#minutes").keyup(function () {
//         check_time();
//     });
//     $("#hours").change(function () {
//         check_time();
//     });
//     $("#minutes").change(function () {
//         check_time();
//     });
//
//     $("#student_name").focusout(function () {
//         check_student_name();
//     });
//     $("#email").focusout(function () {
//         check_email();
//     });
//     $("#student_id").focusout(function () {
//         check_student_id();
//     });
//     $("#material_amount").focusout(function () {
//         check_material_amount();
//     });
//     $("#use_case").focusout(function () {
//         check_use_case();
//     });
//     $("#hours").focusout(function () {
//         evaluate_price();
//         check_time();
//     });
//     $("#minutes").focusout(function () {
//         evaluate_price();
//         check_time();
//     });
//     $("#material_amount").focusout(function () {
//         evaluate_price();
//     });
//     $("#budget_holder").focusout(function () {
//         check_budget_holder();
//     });
//     $("#job_title").focusout(function () {
//         check_job_title();
//     });
//     $( window ).load(function() {
//         check_student_name();
//         check_email();
//         check_student_id();
//         check_time();
//         $("#budget_holder_group").hide()
//     });
//
//
//     function check_student_name() {
//      var name = $("#student_name");
//
//      if(name.val().length < 3 || name.val().length > 100){
//          addError("#student_name","The name should be between 2 and 20 characters");
//          error_name = true;
//      } else if (!name.val().match(/^[a-z ,.'-]+$/i)){
//          addError("#student_name","Only letters and hyphens(-) are allowed");
//          error_name = true;
//      } else {
//          removeError("#student_name");
//          error_name = false;
//      }
//      check_all_fields();
//     }
//
//     function check_email() {
//         var email = $("#email");
//
//         if(email.val().length < 11 || email.val().length > 30){
//             addError("#email","Email is too short or too long");
//             error_email = true;
//         } else if(!email.val().match(/^([a-zA-Z0-9_.+-])+\@soton.ac.uk$/)){
//             addError("#email", "Only @soton.ac.uk emails are allowed");
//             error_email = true;
//         } else {
//             removeError("#email");
//             error_email = false;
//         }
//         check_all_fields();
//     }
//     function check_student_id() {
//         var id = $("#student_id");
//
//         if(id.val().length < 1){
//             addError("#student_id", "Id cannot be empty");
//             error_id = true;
//         }else if (id.val()[0].match(/^[1]/) && id.val().length !== 8) {
//             addError("#student_id", "Id of a member of staff must be 8 digits long");
//             error_id = true;
//         } else if (id.val()[0].match(/^[2345]/) && id.val().length !== 9) {
//             addError("#student_id", "The id of students must be 9 digits long");
//             error_id = true;
//         } else if (!id.val().match(/^[0-9]+$/)) {
//             addError("#student_id", "Only digits are allowed");
//             error_id = true;
//         } else {
//             removeError("#student_id");
//
//             error_id = false;
//         }
//         check_all_fields();
//     }
//     function check_time() {
//         var varhours = $("#hours").find(":selected").text();
//         var varminutes = $("#minutes").find(":selected").text();
//         if (varhours === "Hours" || varminutes === "Minutes"){
//             addError("#time", "Please set the printing time");
//             error_time = true
//         } else if(parseInt(varhours) + parseInt(varminutes) == 0){
//             addError("#time", "The printing time cannot be zero");
//             error_time = true
//         } else {
//             removeError("#time");
//             error_time = false
//         }
//         check_all_fields();
//     }
//     function check_material_amount() {
//         var material = $("#material_amount");
//
//         if(material.val().length < 1){
//             addError("#material_amount", "The value must be between 0.1 and 9999 in grams");
//             error_material = true;
//         } else if (!material.val().match(/^(?!0(\.?0*)?$)\d{0,3}(\.?\d{0,1})?$/)) {
//             addError("#material_amount", "The value must be between 0.1 and 9999 in grams");
//             error_material = true;
//         } else {
//             removeError("#material_amount");
//             error_material = false;
//         }
//         check_all_fields();
//     }
//     function check_use_case() {
//         var use_case = $("#use_case");
//
//         if(use_case.val().length < 3 || use_case.val().length > 15) {
//             addError("#use_case", "Either 9 digit cost code or standard module name are allowed");
//             error_use_case = true;
//         } else if((!use_case.val().match(/^[A-Z]{3}/) &&
//         !use_case.val().match(/^[a-z0-9]+$/i))){
//             addError("#use_case", "Either 9 digit cost code or standard module name are allowed");
//             error_use_case = true;
//         } else {
//             removeError("#use_case");
//             error_use_case = false;
//             if(!$.isNumeric(use_case.val())){
//                 $("#budget_holder_group").hide();
//             } else {
//                 $("#budget_holder_group").show();
//                 check_budget_holder();
//                 //$("#use_case").focus();
//             }
//         }
//         check_all_fields();
//     }
//     function check_budget_holder() {
//         var budget_holder = $("#budget_holder");
//         var use_case = $("#use_case");
//         if(!$.isNumeric(use_case.val())){
//             removeError("#budget_holder");
//             error_budget_holder = false;
//         } else if(budget_holder.val().length < 3 || budget_holder.val().length > 100){
//             addError("#budget_holder","The name should be between 2 and 20 characters");
//             error_budget_holder = true;
//         } else if (!budget_holder.val().match(/^[a-z ,.'-]+$/i)){
//             addError("#budget_holder","Only letters and hyphens(-) are allowed");
//             error_budget_holder = true;
//         } else {
//             removeError("#budget_holder");
//             error_budget_holder = false;
//         }
//         check_all_fields();
//     }
//     function check_job_title() {
//         var job_title= $("#job_title");
//
//         if(job_title.val().length < 8 || job_title.val().length > 256) {
//             addError("#job_title", 'The title should be between 8 and 256 characters')
//             error_job_title = true;
//         } else if(!job_title.val().match(/^[a-zA-Z0-9 ,.'-]+$/i)){
//             addError("#job_title","Only these special characters are allowed: ,.'-");
//             error_job_title = true;
//         } else {
//             removeError("#job_title");
//             error_job_title = false;
//         }
//     }
//
//     function evaluate_price() {
//         if( error_material === false && $("#hours") != null && $("#minutes" != null)){
//             var $price = (3*(parseInt($("#hours").val()) + parseInt($("#minutes").val())/60) +
//                 5*parseFloat($("#material_amount").val())/100).toFixed(2);
//             $("#price").html($price);
//         }
//     }
//     $("#submit").click(function () {
//         $("#student_name_error").hide();
//         $("#email_error").hide();
//         $("#student_id_error").hide();
//         $("#material_amount_error").hide();
//         $("#use_case_error").hide();
//         $("#student_name").removeClass("parsley-success");
//         $("#email").removeClass("parsley-success");
//         $("#student_id").removeClass("parsley-success");
//         $("#material_amount").removeClass("parsley-success");
//         $("#submit").removeClass("btn-success");
//
//     });
// });
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
        "#printers_id": validations.check_printer_number,
        "#student_name": validations.check_name,
        "#email": validations.check_email,
        "#student_id": validations.check_university_id_number,
        "#material_amount": validations.check_material_amount,
        "#use_case": local_check_cost_code,
        "#budget_holder": local_check_budget_holder,
        "#job_title": validations.check_job_title,
        "#hours": local_check_time_hours,
        "#minutes": local_check_time_minutes
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
            if (funs[el]) {
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
            if(errors[e]){
                hasError = true;
                errCount ++;
            }
        }
        //if there has been no error, then submit button is good to go, otherwise disable
        if (!hasError) {
            $("#submit").addClass("btn-success");
            $("#submit").trigger("cssClassChanged");
            $("#submit").prop('disabled', false);
            $("#submit").html("Submit");
        } else {
            $("#submit").removeClass("btn-success");
            $("#submit").html(errCount+" validations failed");
            $("#submit").prop('disabled', true);
        }
    }

    $("#submit").click(function () {
        for (var i = 0; i < html_triggers.length; i++) {
            $(html_triggers[i]).hide();
            $(html_triggers[i]).removeClass("parsley-success");
        }
    });



});
