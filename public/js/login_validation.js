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
/******/ 	return __webpack_require__(__webpack_require__.s = 15);
/******/ })
/************************************************************************/
/******/ ({

/***/ 15:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(3);


/***/ }),

/***/ 3:
/***/ (function(module, exports) {

$(function () {
    $("#email_error").hide();
    $("#password_error").hide();

    var error_email = true;
    var error_password = true;

    $("#email").keyup(function () {
        check_email();
    });
    $("#password").keyup(function () {
        check_password();
    });
    $("#email").focusout(function () {
        check_email();
    });
    $("#password").focusout(function () {
        check_password();
    });

    function check_email() {
        var email = $("#email");

        if (email.val().length < 11 || email.val().length > 100) {
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
        }if (error_password === false && error_email === false) {
            $("#login-button").addClass("btn-success");
        } else {
            $("#login-button").removeClass("btn-success");
        }
    }
    function check_password() {
        var password = $("#password");

        if (password.val().length < 6 || password.val().length > 16) {
            $("#password_error").html("The password mast be 6 to 16 character long and contain at least one upper " + "case letter, one lower case letter, and one digit");
            $("#password_error").show();
            $("#password").focus();
            $("#password").addClass("parsley-error");
            error_password = true;
        } else if (!password.val().match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,16}$/)) {
            $("#password_error").html("The password mast be 6 to 16 character long and contain at least one upper " + "case letter, one lower case letter, and one digit");
            $("#password_error").show();
            $("#password").focus();
            $("#password").addClass("parsley-error");
            error_password = true;
        } else {
            $("#password_error").hide();
            $("#password").removeClass("parsley-error");
            $("#password").addClass("parsley-success");
            error_password = false;
        }if (error_password === false && error_email === false) {
            $("#login-button").addClass("btn-success");
        } else {
            $("#login-button").removeClass("btn-success");
        }
    }
    $("#login-button").click(function () {
        $("#email_error").hide();
        $("#password_error").hide();
        $("#email").removeClass("parsley-success");
        $("#password").removeClass("parsley-success");
        $("#login-button").removeClass("btn-success");
    });
});

/***/ })

/******/ });