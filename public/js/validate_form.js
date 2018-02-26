/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 68);
/******/ })
/************************************************************************/
/******/ ({

/***/ 0:
/***/ (function(module, exports) {

/*** validations.js
 * This file contains all input validation functions.
 * Each function will take parameters and check the field
 * corresponding to fieldname according to the rules defined.
 * If one of the checks fails, the field is marked in red and
 * the corresponding error field is populated with a message.
 * If all the checks pass, the field is marked in green and 
 * the error field is hidden. The function will return a
 * boolean which is true, if the validation failed.
 ***/
module.exports = {
    //ERROR MESSAGE HANDLERS
    addErrorDetail: function (inputfield, errorfield, message) {
        /*shows the error div with the specified message 
         *and sets the input field class to error*/
        $(errorfield).html(message);
        $(errorfield).removeClass("text-muted");
        $(errorfield).addClass("text-danger");
        $(errorfield).show();
        $(inputfield).removeClass("form-control is-valid");
        $(inputfield).addClass("form-control is-invalid");
    },
    removeErrorDetail: function (inputfield, errorfield) {
        /*hides the error div and sets the input field class to success*/
        $(errorfield).removeClass("text-danger");
        $(errorfield).addClass("text-muted");
        $(errorfield).hide();
        $(inputfield).removeClass("form-control is-invalid");
        $(inputfield).addClass("form-control is-valid");
    },
    addError: function addError(target, message) {
        /*shows the error div with the specified message 
         *and sets the input field class to error*/
        module.exports.addErrorDetail(target, target.concat("_error"), message);
    },
    removeError: function removeError(target) {
        /*hides the error div and sets the input field class to success*/
        module.exports.removeErrorDetail(target, target.concat("_error"));
    },
    //PERSON RELATED CHECKS
    check_name: function check_name(fieldname) {
        /*checks name fields if they are correct and returns a boolean. 
         *Also sets the Error on the specified field. The error div needs to have 
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var name = $(fieldname);

        if (name.val().length < 2 || name.val().length > 20) {
            module.exports.addError(fieldname, "The name should be between 2 and 20 characters");
            localerror = true;
        } else if (!name.val().match(/^[a-z ,.'-]+$/i)) {
            module.exports.addError(fieldname, "Only letters and hyphens(-) are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    check_university_email: function check_university_email(fieldname) {
        /*checks university email fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var email = $(fieldname);

        if (email.val().length < 11 || email.val().length > 30) {
            module.exports.addError(fieldname, "Email is too short or too long");
            localerror = true;
        } else if (!email.val().match(/^([a-zA-Z0-9_.+-])+\@soton.ac.uk$/)) {
            module.exports.addError(fieldname, "Only @soton.ac.uk emails are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    check_university_id_number: function check_university_id_number(fieldname) {
        /*checks University ID number fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var id = $(fieldname).val();

        if (id.length < 1) {
            module.exports.addError(fieldname, "Id cannot be empty");
            localerror = true;
        } else if (id[0].match(/^[1]/) && id.length !== 8) {
            module.exports.addError(fieldname, "Id of a member of staff must be 8 digits long");
            localerror = true;
        } else if (id[0].match(/^[2345]/) && id.length !== 9) {
            module.exports.addError(fieldname, "The id of students must be 9 digits long");
            localerror = true;
        } else if (!id.match(/^[0-9]+$/)) {
            module.exports.addError(fieldname, "Only digits are allowed");
            localerror = true;
        } else if (id[0].match(/^[67890]/)) {
            module.exports.addError(fieldname, "This does not seem to be a valid university ID");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    check_phone: function check_phone(fieldname) {
        /*checks phone number fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var phone = $(fieldname);

        if (!phone.val().length === 11) {
            module.exports.addError(fieldname, "The phone number must be 11 digits long");
            localerror = true;
        } else if (!phone.val().match(/^\d{11}$/)) {
            module.exports.addError(fieldname, "Only numbers are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    check_password: function check_password(fieldname) {
        /*checks password fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var password = $(fieldname);
        if (password.val().length < 6 || password.val().length > 16) {
            module.exports.addError(fieldname, "The password must be 6 to 16 character long and contain at least one upper case letter, one lower case letter, and one digit");
            localerror = true;
        } else if (!password.val().match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,16}$/)) {
            module.exports.addError(fieldname, "The password must be 6 to 16 character long and contain at least one upper case letter, one lower case letter, and one digit");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    check_password_match: function check_password_match(fieldname, password) {
        /*checks password fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var password1 = $(password).val();
        var password2 = $(fieldname).val();
        if (password1 !== password2) {
            module.exports.addError(fieldname, "The passwords don't match.");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    //PRINTER RELATED CHECKS
    check_printer_number_select: function check_printer_number_select(fieldname) {
        /*checks that a printer number has been selected from the drop-down list*/
        var localerror = true;
        var printerno = $(fieldname).find(":selected").text();

        if (!isNaN(parseFloat(printerno)) && isFinite(printerno)) {
            module.exports.removeError(fieldname);
            localerror = false;
        } else {
            module.exports.addError(fieldname, "Please select a printer number");
            localerror = true;
        }
        return localerror;
    },
    check_printer_number_input: function check_printer_number_input(fieldname) {
        /*checks printer number fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var printerno = $(fieldname).val();

        if (printerno.length < 1 || printerno.length > 3) {
            module.exports.addError(fieldname, "Printer number should contain between 1 and 3 digits");
            localerror = true;
        } else if (!printerno.match(/^[0-9]+$/)) {
            module.exports.addError(fieldname, "Only digits are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    check_printer_serial: function check_printer_serial(fieldname) {
        /*checks printer serial number fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var printerno = $(fieldname).val();
        if (printerno.length < 1 || printerno.length > 20) {
            module.exports.addError(fieldname, "The serial number must be between 1 and 20 digits long");
            localerror = true;
        } else if (!printerno.match(/^[A-Z a-z-0-9]+$/)) {
            module.exports.addError(fieldname, "Only letters, numbers and hyphens (-) are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    check_printer_type_radio: function check_printer_type_radio(fieldname, otherfieldname) {
        /*checks printer type radio button group if they are correct and returns
         *a boolean. Also checks if the "Other" option was selected and shows the 
         *otherfieldname which should have an _group appended to it. (i.e. if 
         *otherfieldname is "#other", then #other_group will be shown or hidden 
         *depending on the users selection.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var fieldvalue = $('input[name = "' + fieldname + '"]:checked').val();

        if (!fieldvalue) {
            module.exports.addError(fieldname, "Please select a printer type");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
            if (fieldvalue !== "Other") {
                //should be like "#printer_type_other_group" to hide field and label
                $(otherfieldname.concat("_group")).hide();
            } else {
                $(otherfieldname.concat("_group")).show();
                module.exports.check_printer_type_input(otherfieldname, fieldname);
            }
        }
        return localerror;
    },
    check_printer_type_input: function check_printer_type_input(fieldname, radiogroup) {
        /*checks printer serial number fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var fieldvalue = $(fieldname).val();
        var radioselection = $('input[name = "' + radiogroup + '"]:checked').val();
        console.log(radioselection);
        if (radioselection !== "Other") {
            module.exports.removeError(fieldname);
            localerror = false;
        } else if (fieldvalue.length < 1 || fieldvalue.length > 20) {
            //TODO: check if this should be 10, 20 or 100 -> I found different number sin different files, so check with database!
            module.exports.addError(fieldname, "The printer type must be between 1 and 20 characters long");
            localerror = true;
        } else if (!fieldvalue.match(/^[a-z A-Z0-9.,!]+$/)) {
            module.exports.addError(fieldname, "Not permitted characters are inputted");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    //PRINT RELATED CHECKS
    check_job_title: function check_job_title(fieldname) {
        /*check Job Title fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var job_title = $(fieldname);

        if (job_title.val().length < 8 || job_title.val().length > 256) {
            module.exports.addError(fieldname, 'The title should be between 8 and 256 characters');
            localerror = true;
        } else if (!job_title.val().match(/^[a-zA-Z0-9 ,.'-]+$/i)) {
            module.exports.addError(fieldname, "Only these special characters are allowed: ,.'-");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    check_print_duration: function check_print_duration(hrsdropdown, mindropdown, grouperror) {
        /*checks print duration fields if they are correct and returns
         *a boolean. Requires a reference to the drop-down for hours and
         *minutes, as well as group div. the group div should have an _error
         *associated with it.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var varhours = $(hrsdropdown).find(":selected").text();
        var varminutes = $(mindropdown).find(":selected").text();
        if (varhours === "Hours" || varminutes === "Minutes") {
            module.exports.addErrorDetail(mindropdown, grouperror, "");
            module.exports.addErrorDetail(hrsdropdown, grouperror, "Please set the printing time");
            localerror = true;
        } else if (parseInt(varhours) + parseInt(varminutes) == 0) {
            module.exports.addErrorDetail(mindropdown, grouperror, "");
            module.exports.addErrorDetail(hrsdropdown, grouperror, "The printing time cannot be zero");
            localerror = true;
        } else {
            module.exports.removeErrorDetail(mindropdown, grouperror);
            module.exports.removeErrorDetail(hrsdropdown, grouperror);
            localerror = false;
        }
        return localerror;
    },
    check_material_amount: function check_material_amount(fieldname) {
        /*checks printing material amount fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var material = $(fieldname);

        if (material.val().length < 1) {
            module.exports.addError(fieldname, "The value must be between 0.1 and 9999 in grams");
            localerror = true;
        } else if (!material.val().match(/^(?!0(\.?0*)?$)\d{0,3}(\.?\d{0,1})?$/)) {
            module.exports.addError(fieldname, "The value must be between 0.1 and 9999 in grams");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    },
    //PAYMENT RELATED CHECKS
    check_cost_code: function check_cost_code(fieldname) {
        /*checks University cost code fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var use_case = $(fieldname).val();

        if (use_case.length != 9 || !use_case.match(/^[5]{1}/)) {
            module.exports.addError(fieldname, "This Cost Code doesn't seem right");
            localerror = true;
        } else if (!use_case.match(/^[0-9]+$/i)) {
            module.exports.addError(fieldname, "Only digits are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    check_shortage: function check_shortage(fieldname) {
        /*checks University cost code fields if they are correct and returns
         *a boolean.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var use_case = $(fieldname);

        if (use_case.val().length < 3) {
            module.exports.addError(fieldname, "Please choose a longer shortage");
            localerror = true;
        } else if (!use_case.val().match(/^[A-Z0-9]/)) {
            module.exports.addError(fieldname, "Traditionally we only use capital letters and numbers");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    check_cost_code_combination: function check_cost_code_combination(fieldname, budgetholder) {
        /*checks University cost code fields if they are correct and returns
         *a boolean. This function also requires the field for budget holder.
         *Note that there needs to be a div surrounding the Budget Holder input
         *field and its label called the same as the budget holder field but
         *with _group appended.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var use_case = $(fieldname);

        if (use_case.val().length < 3 || use_case.val().length > 15) {
            module.exports.addError(fieldname, "Either 9 digit university cost code or standard module name are allowed");
            localerror = true;
        } else if((!use_case.val().match(/^[A-Z]{3}/) && !use_case.val().match(/^([5]{1}[0-9]{8})$/i))){
            module.exports.addError(fieldname, "Either 9 digit cost code or standard module name are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
            if (!$.isNumeric(use_case.val())) {
                //should be like "#budget_holder_group" to hide field and label
                $(budgetholder.concat("_group")).hide();
            } else {
                $(budgetholder.concat("_group")).show();
                module.exports.check_budget_holder(budgetholder, fieldname);
            }
        }
        return localerror;
    },
    check_budget_holder: function check_budget_holder(fieldname, costcode) {
        /*checks University cost code Budget Holder fields if they are correct
         *and returns a boolean. This function also requires the field containing
         *the cost code.
         *Also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var budget_holder = $(fieldname);
        var use_case = $(costcode);
        if (!$.isNumeric(use_case.val())) {
            module.exports.removeError(fieldname);
            localerror = false;
        } else if (budget_holder.val().length < 3 || budget_holder.val().length > 100) {
            module.exports.addError(fieldname, "The name should be between 2 and 20 characters");
            localerror = true;
        } else if (!budget_holder.val().match(/^[a-z ,.'-]+$/i)) {
            module.exports.addError(fieldname, "Only letters and hyphens(-) are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    //DROPOFF RELATED CHECKS
    check_claim_id: function check_claim_id(fieldname) {
        /*check DropOff claim id fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var claim_id = $(fieldname);
        if (claim_id.val().length !== 16) {
            module.exports.addError(fieldname, "The claim ID must contain 16 characters");
            localerror = true;
        } else if (!claim_id.val().match(/^[a-zA-Z0-9-]+$/i)) {
            module.exports.addError(fieldname, "Only alpha-numeric characters are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    },
    check_claim_passcode: function check_claim_passcode(fieldname) {
        /*check DropOff claim passcode fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var claim_passcode = $(fieldname);
        if (claim_passcode.val().length !== 16) {
            module.exports.addError(fieldname, "The claim passcode must contain 16 characters");
            localerror = true;
        } else if (!claim_passcode.val().match(/^[a-zA-Z0-9-]+$/i)) {
            module.exports.addError(fieldname, "Only alpha-numeric characters are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    },
    //ISSUE RELATED CHECKS
    check_issue_title: function check_issue_title(fieldname) {
        /*check Issue Title fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var issue_title = $(fieldname).val();

        if (issue_title.length < 8 || issue_title.length > 180) {
            module.exports.addError(fieldname, 'The title should be between 8 and 180 characters');
            localerror = true;
        } else if (!issue_title.match(/^[a-zA-Z0-9 .,!?']+$/)) {
            module.exports.addError(fieldname, "Only these special characters are allowed: ,.!?'");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            localerror = false;
        }
        return localerror;
    },
    //CHECKS RELATED TO GENERAL TEXT BOXES LIKE COMMENTS
    check_message: function check_message(fieldname, minlength, maxlength) {
        /*check message fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var message = $(fieldname).val();

        if (message.length < minlength || message.length > maxlength) {
            module.exports.addError(fieldname, "The message must be between " + minlength + " and " + maxlength + " characters long");
            localerror = true;
        } else if (!message.match(/^[a-z A-Z0-9-.,!?()/']+$/ && message)) {
            module.exports.addError(fieldname, "No special characters are allowed");
            localerror = true;
        } else {
            module.exports.removeError(fieldname);
            $(fieldname.concat("_error")).html("Remaining characters : " + (maxlength - message.length));
            $(fieldname.concat("_error")).show();
            localerror = false;
        }
        return localerror;
    },
    check_comment: function check_comment(fieldname) {
        /*checks optional(!) comment fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var maxlength = 300;
        return module.exports.check_message(fieldname, 0, maxlength);
    },
    check_message_long: function check_message_long(fieldname) {
        /*check message fields with maximum length of 2048 characters if they are 
         *correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var maxlength = 2048;
        return module.exports.check_message(fieldname, 8, maxlength);
    },
    check_message_default: function check_message_default(fieldname) {
        /*check message fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var maxlength = 300;
        return module.exports.check_message(fieldname, 8, maxlength);
    },
    check_message_explanation: function check_message_explanation(fieldname) {
        /*checks optional(!) comment fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have
         *the identical fieldname but with _error appended.*/
        var maxlength = 300;
        return module.exports.check_message(fieldname, 15, maxlength);
    }
};

/***/ }),

/***/ 68:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(69);


/***/ }),

/***/ 69:
/***/ (function(module, exports, __webpack_require__) {

/*** validate_form.js ***
 * This file can be loaded into an html containing a form
 * it will then add javascript validations from validations.js
 * to the input fields as defined in 'funs' below.
 * it will also disable the submit button with the name 'submit'
 * until all the validations are fulfilled and update the price
 * in the field with the name 'price'.
 ***/
var validations = __webpack_require__(0);
$(document).ready(function () {

    $(window).load(function () {
        check_all_fields();
        $("#budget_holder_group").hide();
        $("#printer_type_other_group").hide();
    });
    function local_check_cost_code(fieldname) {
        return validations.check_cost_code_combination(fieldname, "#budget_holder");
    }
    function local_check_budget_holder(fieldname) {
        return validations.check_budget_holder(fieldname, "#use_case");
    }
    function local_check_time_minutes(fieldname) {
        return validations.check_print_duration("#hours", fieldname, "#time_error");
    }
    function local_check_time_hours(fieldname) {
        return validations.check_print_duration(fieldname, "#minutes", "#time_error");
    }
    //TODO: this field is sometimes called #other, sometimes #other_printer_type. I suggest always calling it #printer_type_other and the selection group belonging to it #printer_type. Also remember to add a group around the input field so it can be hidden if not needed.
    function local_check_printer_type_radio(fieldname) {
        return validations.check_printer_type_radio(fieldname, "#printer_type_other");
    }
    function local_check_printer_type_input(fieldname) {
        //passing printer_type without # since the radio buttons have no id
        return validations.check_printer_type_input(fieldname, "printer_type");
    }
    function local_check_password_match(fieldname) {
        return validations.check_password_match(fieldname, "#password");
    }

    //map the field ids to the functions in this dictionary,
    //assign null to input fields that you need to treat extra...
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
    //TODO: message_long is currently defined as message in print_preview_validation.js -> need to change that in the blade!
    //TODO: definition of printer_type and other field is not consistent accross blades -> suggest to make them cosistent as mentioned above...
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
        "#printer_type": null,
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
    $("input, select, textarea").keyup(function () {
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
    $("input, select, textarea").focusout(function () {
        //here we create a variable for the validation function for that field,
        //passing the field id to it as an argument
        var fun = funs["#" + $(this).attr('id')];
        //if that function was in the dictionary, then call it.
        if (fun) {
            errors["#" + $(this).attr('id')] = fun("#" + $(this).attr('id'));
            check_all_fields();
        }
    });
    $("input[name='printer_type']").click(function () {
        //this is a special case, where we have radio buttons that have a consistent name, not id.
        errors["#" + $(this).attr('name')] = local_check_printer_type_radio($(this).attr('name'));
        check_all_fields();
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
                errCount++;
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
            if (!errors[idMaterial] && !errors[idHours] && !errors[idMinutes]) {
                var time = $(idHours).find(":selected").text() + $(idMinutes).find(":selected").text() / 60; //time in hours
                var material = $(idMaterial).val(); //material in g
                var $price = 3 * time + 5 * material / 100;
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

/***/ })

/******/ });
