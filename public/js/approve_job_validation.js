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
/******/ 	return __webpack_require__(__webpack_require__.s = 10);
/******/ })
/************************************************************************/
/******/ ({

/***/ 10:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(11);


/***/ }),

/***/ 11:
/***/ (function(module, exports) {

$(function () {
    $("#student_name_error").hide();
    $("#email_error").hide();
    $("#student_id_error").hide();
    $("#material_amount_error").hide();
    $("#message_error").hide();

    var error_name = true;
    var error_email = true;
    var error_id = true;
    var error_material = true;

    var error_message = true;

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

    $("#hours").focusout(function () {
        evaluate_price();
    });
    $("#minutes").focusout(function () {
        evaluate_price();
    });
    $("#material_amount").focusout(function () {
        evaluate_price();
    });
    $("#message").keyup(function () {
        check_message();
    });
    $(window).load(function () {
        check_student_name();
        check_email();
    });

    function check_student_name() {
        var name = $("#student_name");

        if (name.val().length < 3 || name.val().length > 100) {
            $("#student_name_error").html("The name should be between 2 and 100 characters");
            $("#student_name_error").show();
            $("#student_name").focus();
            $("#student_name").addClass("parsley-error");
            error_name = true;
        } else if (!name.val().match(/^[a-z ,.'-]+$/i)) {
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
        }
        if (error_name === false && error_email === false && error_id === false && error_material === false) {
            $("#submit").addClass("btn-success");
            $("#submit").trigger("cssClassChanged");
            $("#submit").prop('disabled', false);
        } else {
            $("#submit").removeClass("btn-success");
        }
    }

    function check_email() {
        var email = $("#email");

        if (email.val().length < 11 || email.val().length > 30) {
            $("#email_error").html("Email is too short or too long");
            $("#email_error").show();
            $("#email").focus();
            $("#email").addClass("parsley-error");
            error_email = true;
        } else if (!email.val().match(/^([a-zA-Z0-9_.+-])+\@soton.ac.uk$/)) {
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
        }
        if (error_name === false && error_email === false && error_id === false && error_material === false) {
            $("#submit").addClass("btn-success");
            $("#submit").trigger("cssClassChanged");
            $("#submit").prop('disabled', false);
        } else {
            $("#submit").removeClass("btn-success");
        }
    }

    function check_student_id() {
        var id = $("#student_id");

        if (id.val().length < 1) {
            $("#student_id_error").html("Id cannot be empty");
            $("#student_id_error").show();
            $("#student_id").focus();
            $("#student_id").addClass("parsley-error");
            error_id = true;
        } else if (id.val()[0].match(/^[1]/) && id.val().length !== 8) {
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
        }
        if (error_name === false && error_email === false && error_id === false && error_material === false) {
            $("#submit").addClass("btn-success");
            $("#submit").trigger("cssClassChanged");
            $("#submit").prop('disabled', false);
        } else {
            $("#submit").removeClass("btn-success");
        }
    }

    function check_material_amount() {
        var material = $("#material_amount");

        if (material.val().length < 1) {
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
        }
        if (error_name === false && error_email === false && error_id === false && error_material === false && error_use_case === false) {
            $("#submit").addClass("btn-success");
            $("#submit").trigger("cssClassChanged");
            $("#submit").prop('disabled', false);
        } else {
            $("#submit").removeClass("btn-success");
        }
    }

    function check_message() {
        var message = $("#message");

        if (message.val().length < 8 || message.val().length > 300) {
            $("#message_error").html("The message must be between 8 and 300 characters long");
            $("#message_error").show();
            $("#message").focus();
            $("#message").addClass("parsley-error");
            error_message = true;
            // } else if(!message.val().match(/^[a-z A-Z0-9-.,!?']+$/)){
            //     $("#message_error").html("Only alphanumeric characters are allowed");
            //     $("#message_error").show();
            //     $("#message").focus();
            //     $("#message").addClass("parsley-error");
            //     error_message = true;
        } else {
            $("#message_error").hide();
            $("#message").removeClass("parsley-error");
            $("#message").addClass("parsley-success");
            error_message = false;
        }
        if (error_message === false) {
            $("#submit").addClass("btn-success");
        } else {
            $("#submit").removeClass("btn-success");
        }
    }

    function evaluate_price() {
        if (error_material === false && $("#hours") != null && $("#minutes" != null)) {
            var $price = 3 * ($("#hours").val() + $("#minutes").val()) / 60 + 5 * $("#material_amount").val() / 100;
            $("#price").html($price);
        }
    }

    $("#submit").click(function () {
        $("#student_name_error").hide();
        $("#email_error").hide();
        $("#student_id_error").hide();
        $("#material_amount_error").hide();
        $("#student_name").removeClass("parsley-success");
        $("#email").removeClass("parsley-success");
        $("#student_id").removeClass("parsley-success");
        $("#material_amount").removeClass("parsley-success");
        $("#submit").removeClass("btn-success");
    });
});

/***/ })

/******/ });