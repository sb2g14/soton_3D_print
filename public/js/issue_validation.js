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
/******/ 	return __webpack_require__(__webpack_require__.s = 10);
/******/ })
/************************************************************************/
/******/ ({

/***/ 1:
/***/ (function(module, exports) {

$(function () {
    $("#issue_error").hide();
    $("#message_error").hide();

    var error_issue = true;
    var error_message = true;

    $("#issue").keyup(function () {
        check_issue();
    });
    $("#message").keyup(function () {
        check_message();
    });

    function check_issue() {
        var issue = $("#issue");

        if (issue.val().length < 8 || issue.val().length > 180) {
            $("#issue_error").html("Issue name mast be between 8 and 180 characters long");
            $("#issue_error").show();
            $("#issue").focus();
            $("#issue").addClass("parsley-error");
            error_issue = true;
        } else if (!issue.val().match(/^[a-z A-Z0-9.,]+$/)) {
            $("#issue_error").html("Only alphanumeric characters are allowed");
            $("#issue_error").show();
            $("#issue").focus();
            $("#issue").addClass("parsley-error");
            error_issue = true;
        } else {
            $("#issue_error").hide();
            $("#issue").removeClass("parsley-error");
            $("#issue").addClass("parsley-success");
            error_issue = false;
        }if (error_issue === false && error_message === false) {
            $("#submit").addClass("btn-success");
        } else {
            $("#submit").removeClass("btn-success");
        }
    }
    function check_message() {
        var message = $("#message");

        if (message.val().length < 8 || message.val().length > 300) {
            $("#message_error").html("The message mast be between 8 and 300 characters long");
            $("#message_error").show();
            $("#message").focus();
            $("#message").addClass("parsley-error");
            error_message = true;
        } else if (!message.val().match(/^[a-z A-Z0-9.,]+$/)) {
            $("#message_error").html("Only alphanumeric characters are allowed");
            $("#message_error").show();
            $("#message").focus();
            $("#message").addClass("parsley-error");
            error_message = true;
        } else {
            $("#message_error").hide();
            $("#message").removeClass("parsley-error");
            $("#message").addClass("parsley-success");
            error_message = false;
        }if (error_issue === false && error_message === false) {
            $("#submit").addClass("btn-success");
        } else {
            $("#submit").removeClass("btn-success");
        }
    }
    $("#submit").click(function () {
        $("#issue_error").hide();
        $("#message_error").hide();
        $("#issue").removeClass("parsley-success");
        $("#message").removeClass("parsley-success");
        $("#submit").removeClass("btn-success");
    });
});

/***/ }),

/***/ 10:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(1);


/***/ })

/******/ });