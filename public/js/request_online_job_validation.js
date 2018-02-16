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
/******/ 	return __webpack_require__(__webpack_require__.s = 58);
/******/ })
/************************************************************************/
/******/ ({

/***/ 58:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(59);


/***/ }),

/***/ 59:
/***/ (function(module, exports) {

$(function () {
    
    $(window).load(function () {
        $("#budget_holder_group").hide();
        check_all_fields();
    });

    
    function addError(target, message) {
        $(target.concat("_error")).html(message);
        $(target.concat("_error")).show();
        $(target).addClass("parsley-error");
        console.warn(message);
    }
    function removeError(target) {
        $(target.concat("_error")).hide();
        $(target).removeClass("parsley-error");
        $(target).addClass("parsley-success");
    }

    function check_name(fieldname) {
        /*checks name fields if they are correct and returns a boolean. 
         *Also sets the Error on the specified field. The error div needs to have 
         *the identical fieldname but with _error appended.*/
        console.log("checking name");
        var localerror = true;
        var name = $(fieldname);

        if(name.val().length < 3 || name.val().length > 100){
            addError(fieldname,"The name should be between 2 and 20 characters");
            localerror = true;
        } else if (!name.val().match(/^[a-z ,.'-]+$/i)){
            addError(fieldname,"Only letters and hyphens(-) are allowed");
            localerror = true;
        } else {
            removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    };
    function check_email(fieldname) {
        /*checks university email fields if they are correct and returns
         *a boolean. 
         *Also sets the Error on the specified field. The error div needs to have 
         *the identical fieldname but with _error appended.*/
        console.log("checking email");
        var localerror = true;
        var email = $(fieldname);
        if(email.val().length < 11 || email.val().length > 30){
            addError(fieldname,"Email is too short or too long");
            localerror = true;
        } else if(!email.val().match(/^([a-zA-Z0-9_.+-])+\@soton.ac.uk$/)){
            addError(fieldname, "Only @soton.ac.uk emails are allowed");
            localerror = true;
        } else {
            removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    };
    function check_university_id_number(fieldname) {
        /*checks University ID number fields if they are correct and returns
         *a boolean. 
         *Also sets the Error on the specified field. The error div needs to have 
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var id = $(fieldname);

        if(id.val().length < 1){
            addError(fieldname, "Id cannot be empty");
            localerror = true;
        }else if (id.val()[0].match(/^[1]/) && id.val().length !== 8) {
            addError(fieldname, "Id of a member of staff must be 8 digits long");
            localerror = true;
        }else if (id.val()[0].match(/^[2345]/) && id.val().length !== 9) {
            addError(fieldname, "The id of students must be 9 digits long");
            localerror = true;
        }else if (!id.val().match(/^[0-9]+$/)) {
            addError(fieldname, "Only digits are allowed");
            localerror = true;
        }else{
            removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    };
    function check_cost_code(fieldname,budgetholder) {
        /*checks University cost code fields if they are correct and returns
         *a boolean. This function also requires the field for budget holder. 
         *Note that there needs to be a div surrounding the Budget Holder input 
         *field and its label called the same as the budget holder field but 
         *with _group appended.
         *Also sets the Error on the specified field. The error div needs to have 
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var use_case = $(fieldname);

        if(use_case.val().length < 3 || use_case.val().length > 15) {
            addError(fieldname, "Either 9 digit university cost code or standard module name are allowed");
            localerror = true;
        } else if((!use_case.val().match(/^[A-Z]{3}/) &&
        !use_case.val().match(/^[a-z0-9]+$/i))){
            addError(fieldname, "Either 9 digit cost code or standard module name are allowed");
            localerror = true;
        } else {
            removeError(fieldname);
            localerror = false;
            if(!$.isNumeric(use_case.val())){
                //should be like "#budget_holder_group" to hide field and label
                $(budgetholder.concat("_group")).hide(); 
            } else {
                $(budgetholder.concat("_group")).show();
                check_budget_holder(budgetholder,fieldname);
            }
        }
        //check_all_fields();
        return localerror;
    };
    function check_budget_holder(fieldname,costcode) {
        /*checks University cost code Budget Holder fields if they are correct 
         *and returns a boolean. This function also requires the field containing 
         *the cost code.
         *Also sets the Error on the specified field. The error div needs to have 
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var budget_holder = $(fieldname);
        var use_case = $(costcode);
        if(!$.isNumeric(use_case.val())){
            removeError(fieldname);
            localerror = false;
        } else if(budget_holder.val().length < 3 || budget_holder.val().length > 100){
            addError(fieldname,"The name should be between 2 and 20 characters");
            localerror = true;
        } else if(!budget_holder.val().match(/^[a-z ,.'-]+$/i)){
            addError(fieldname,"Only letters and hyphens(-) are allowed");
            localerror = true;
        } else {
            removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    };
    function check_claim_id(fieldname) {
        /*check DropOff claim id fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have 
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var claim_id = $(fieldname);
        if(claim_id.val().length !== 16){
            addError(fieldname, "The claim ID must contain 16 characters");
            localerror = true;
        } else if(!claim_id.val().match(/^[a-zA-Z0-9-]+$/i)){
            addError(fieldname, "Only alpha-numeric characters are allowed");
            localerror = true;
        } else {
            removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    };
    function check_claim_passcode(fieldname) {
        /*check DropOff claim passcode fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have 
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var claim_passcode = $(fieldname);
        if(claim_passcode.val().length !== 16){
            addError(fieldname, "The claim passcode must contain 16 characters");
            localerror = true;
        } else if(!claim_passcode.val().match(/^[a-zA-Z0-9-]+$/i)){
            addError(fieldname, "Only alpha-numeric characters are allowed");
            localerror = true;
        } else {
            removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    };
    function check_job_title(fieldname) {
        /*check Job Title fields if they are correct and returns a boolean
         *also sets the Error on the specified field. The error div needs to have 
         *the identical fieldname but with _error appended.*/
        var localerror = true;
        var job_title= $(fieldname);

        if(job_title.val().length < 8 || job_title.val().length > 256) {
            addError(fieldname, 'The title should be between 8 and 256 characters');
            localerror = true;
        } else if(!job_title.val().match(/^[a-zA-Z0-9 ,.'-]+$/i)){
            addError(fieldname,"Only these special characters are allowed: ,.'-");
            localerror = true;
        } else {
            removeError(fieldname);
            localerror = false;
        }
        //check_all_fields();
        return localerror;
    };
    
    
    //map the field ids to the functions in this dictionary, 
    //assign null to input fields that you need to treat extra...
    var funs = {
        "#customer_name": check_name,
        "#customer_email": check_email,
        "#customer_id": check_university_id_number,
        "#use_case": null,
        "#budget_holder": null,
        "#claim_id": check_claim_id,
        "#claim_passcode": check_claim_passcode,
        "#job_title": check_job_title
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
    $("input[type='text'], select, input[type=customer_email]").keyup(function() {
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
    $("input[type='text'], select, input[type=customer_email]").focusout(function() {
        //here we create a variable for the validation function for that field, 
        //passing the field id to it as an argument
        var fun = funs["#" + $(this).attr('id')];
        //if that function was in the dictionary, then call it.
        if (fun) {
            errors["#" + $(this).attr('id')] = fun("#" + $(this).attr('id'));
            check_all_fields();
        }
    });
    
    //then deal with special input fields
    $("#use_case").keyup(function() {
        errors["#" + $(this).attr('id')] = check_cost_code("#" + $(this).attr('id'),"#budget_holder");
        check_all_fields();
    });
    $("#budget_holder").keyup(function() {
        errors["#" + $(this).attr('id')] = check_budget_holder("#" + $(this).attr('id'),"#use_case");
        check_all_fields();
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
        errors["#use_case"] = check_cost_code("#use_case","#budget_holder");
        errors["#budget_holder"] = check_budget_holder("#budget_holder","#use_case");
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

/***/ })

/******/ });
