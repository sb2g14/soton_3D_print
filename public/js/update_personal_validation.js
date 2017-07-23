/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
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
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
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
/******/ 	return __webpack_require__(__webpack_require__.s = 18);
/******/ })
/************************************************************************/
/******/ ({

/***/ 18:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(8);


/***/ }),

/***/ 8:
/***/ (function(module, exports) {

$(function () {
    $("#first_name_error").hide();
    $("#last_name_error").hide();
    $("#email_error").hide();
    $("#phone_error").hide();

    var error_first_name = true;
    var error_last_name = true;
    var error_email = true;
    var error_phone = true;

    $("#first_name").keyup(function () {
        check_first_name();
    });
    $("#last_name").keyup(function () {
        check_last_name();
    });
    $("#email").keyup(function () {
        check_email();
    });
    $("#phone").keyup(function () {
        check_phone();
    });

    $("#first_name").focusout(function () {
        check_first_name();
    });
    $("#last_name").focusout(function () {
        check_last_name();
    });
    $("#email").focusout(function () {
        check_email();
    });
    $("#phone").focusout(function () {
        check_phone();
    });

    function check_first_name() {
        var name = $("#first_name");

        if (name.val().length < 2 || name.val().length > 20) {
            $("#first_name_error").html("The name should be between 2 and 20 characters");
            $("#first_name_error").show();
            $("#first_name").focus();
            $("#first_name").addClass("parsley-error");
            error_first_name = true;
        } else if (!name.val().match(/[\w\-'\s]+/)) {
            $("#first_name_error").html("Only letters and hyphens(-) are allowed");
            $("#first_name_error").show();
            $("#first_name").focus();
            $("#first_name").addClass("parsley-error");
            error_first_name = true;
        } else {
            $("#first_name_error").hide();
            $("#first_name").removeClass("parsley-error");
            $("#first_name").addClass("parsley-success");
            error_first_name = false;
        }if (error_first_name === false && error_last_name === false && error_email === false && error_phone === false) {
            $("#update-button").addClass("btn-success");
        } else {
            $("#update-button").removeClass("btn-success");
        }
    }
    function check_last_name() {
        var name = $("#last_name");

        if (name.val().length < 2 || name.val().length > 20) {
            $("#last_name_error").html("The name should be between 2 and 20 characters");
            $("#last_name_error").show();
            $("#last_name").focus();
            $("#last_name").addClass("parsley-error");
            error_last_name = true;
        } else if (!name.val().match(/[\w\-'\s]+/)) {
            $("#last_name_error").html("Only letters and hyphens(-) are allowed");
            $("#last_name_error").show();
            $("#last_name").focus();
            $("#last_name").addClass("parsley-error");
            error_last_name = true;
        } else {
            $("#last_name_error").hide();
            $("#last_name").removeClass("parsley-error");
            $("#last_name").addClass("parsley-success");
            error__last_name = false;
        }if (error_first_name === false && error_last_name === false && error_email === false && error_phone === false) {
            $("#update-button").addClass("btn-success");
        } else {
            $("#update-button").removeClass("btn-success");
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
        }if (error_first_name === false && error_last_name === false && error_email === false && error_phone === false) {
            $("#update-button").addClass("btn-success");
        } else {
            $("#update-button").removeClass("btn-success");
        }
    }
    function check_phone() {
        var phone = $("#phone");

        if (!phone.val().length === 11) {
            $("#phone_error").html("The phone must be 11 digits long");
            $("#phone_error").show();
            $("#phone").focus();
            $("#phone").addClass("parsley-error");
            error_phone = true;
        } else if (!phone.val().match(/^\d{11}$/)) {
            $("#phone_error").html("Only numbers are allowed");
            $("#phone_error").show();
            $("#phone").focus();
            $("#phone").addClass("parsley-error");
            error_phone = true;
        } else {
            $("#phone_error").hide();
            $("#phone").removeClass("parsley-error");
            $("#phone").addClass("parsley-success");
            error_phone = false;
        }if (error_first_name === false && error_last_name === false && error_email === false && error_phone === false) {
            $("#update-button").addClass("btn-success");
        } else {
            $("#update-button").removeClass("btn-success");
        }
    }

    $("#update-button").click(function () {
        $("#first_name_error").hide();
        $("#last_name_error").hide();
        $("#email_error").hide();
        $("#phone_error").hide();
        $("#firs_name").removeClass("parsley-success");
        $("#last_name").removeClass("parsley-success");
        $("#email").removeClass("parsley-success");
        $("#phone").removeClass("parsley-success");
        $("#update-button-button").removeClass("btn-success");
    });
});

/***/ })

/******/ });