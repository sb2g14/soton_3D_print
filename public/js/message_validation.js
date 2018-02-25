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
/******/ 	return __webpack_require__(__webpack_require__.s = 47);
/******/ })
/************************************************************************/
/******/ ({

/***/ 47:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(48);


/***/ }),

/***/ 48:
/***/ (function(module, exports) {

$(function () {
    $("#message_last_error").hide();

    var error_message = true;

    $("#message_last").keyup(function () {
        check_message();
    });
    $("#message_last").focusout(function () {
        check_message();
    });

    function check_message() {
        var message = $("#message_last");

        if (message.val().length < 8 || message.val().length > 300) {
            $("#message_last_error").html("The message must be between 8 and 300 characters long");
            $("#message_last_error").show();
            $("#message_last").addClass("parsley-error");
            error_message = true;
            // } else if(!message.val().match(/^[a-z A-Z0-9-.,?!']+$/)){
            //     $("#message_last_error").html("Only alphanumeric characters are allowed");
            //     $("#message_last_error").show();
            //     $("#message_last").addClass("parsley-error");
            //     error_message = true;
        } else {
            $("#message_last_error").hide();
            $("#message_last").removeClass("parsley-error");
            $("#message_last").addClass("parsley-success");
            error_message = false;
        }if (error_message === false) {
            $("#comment_last").addClass("btn-success");
        } else {
            $("#comment_last").removeClass("btn-success");
        }
    }
    $("#comment_last").click(function () {
        $("#message_last_error").hide();
        $("#message_last").removeClass("parsley-success");
        $("#comment_last").removeClass("btn-success");
    });
});

/***/ })

/******/ });