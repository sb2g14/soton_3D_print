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
/******/ 	return __webpack_require__(__webpack_require__.s = 48);
/******/ })
/************************************************************************/
/******/ ({

/***/ 48:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(49);


/***/ }),

/***/ 49:
/***/ (function(module, exports) {

$(function () {
    $("#number_error").hide();
    $("#serial_error").hide();
    $("#other_error").hide();

    var error_number = true;
    var error_serial = true;
    var error_other = true;

    $("#number").keyup(function () {
        check_number();
    });
    $("#serial").keyup(function () {
        check_serial();
    });
    $("#other").keyup(function () {
        check_other();
    });

    function check_number() {
        var number = $("#number");

        if (number.val().length < 1 || number.val().length > 3) {
            $("#number_error").html("Printer number should contain between 1 and 3 digits");
            $("#number_error").show();
            $("#number").focus();
            $("#number").addClass("parsley-error");
            error_number = true;
        } else if (!number.val().match(/^[0-9]+$/)) {
            $("#number_error").html("Only digits are allowed");
            $("#number_error").show();
            $("#number").focus();
            $("#number").addClass("parsley-error");
            error_number = true;
        } else {
            $("#number_error").hide();
            $("#number").removeClass("parsley-error");
            $("#number").addClass("parsley-success");
            error_number = false;
        }if (error_number === false && error_serial === false && error_other === false) {
            $("#submit").addClass("btn-success");
        } else {
            $("#submit").removeClass("btn-success");
        }
    }
    function check_serial() {
        var serial = $("#serial");

        if (serial.val().length < 1 || serial.val().length > 20) {
            $("#serial_error").html("The serial number must be between 1 and 10 digits long");
            $("#serial_error").show();
            $("#serial").focus();
            $("#serial").addClass("parsley-error");
            error_serial = true;
        } else if (!serial.val().match(/^[A-Z a-z-0-9]+$/)) {
            $("#serial_error").html("Only numbers are allowed");
            $("#serial_error").show();
            $("#serial").focus();
            $("#serial").addClass("parsley-error");
            error_serial = true;
        } else {
            $("#serial_error").hide();
            $("#serial").removeClass("parsley-error");
            $("#serial").addClass("parsley-success");
            error_serial = false;
        }if (error_number === false && error_serial === false && error_other === false) {
            $("#submit").addClass("btn-success");
        } else {
            $("#submit").removeClass("btn-success");
        }
    }
    function check_other() {
        var other = $("#other");

        if (!other.val().match(/^[a-z A-Z0-9.,!]+$/)) {
            $("#other_error").html("Not permitted characters are inputted");
            $("#other_error").show();
            $("#other").focus();
            $("#other").addClass("parsley-error");
            error_other = true;
        } else {
            $("#other_error").hide();
            $("#other").removeClass("parsley-error");
            $("#other").addClass("parsley-success");
            error_other = false;
        }if (error_number === false && error_serial === false && error_other === false) {
            $("#submit").addClass("btn-success");
        } else {
            $("#submit").removeClass("btn-success");
        }
    }
    $("#submit").click(function () {
        $("#issue_error").hide();
        $("#message_error").hide();
        $("#other_error").hide();
        $("#issue").removeClass("parsley-success");
        $("#message").removeClass("parsley-success");
        $("#other").removeClass("parsley-success");
        $("#submit").removeClass("btn-success");
    });
});

/***/ })

/******/ });