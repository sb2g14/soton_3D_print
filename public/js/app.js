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
/******/ 	return __webpack_require__(__webpack_require__.s = 12);
/******/ })
/************************************************************************/
/******/ ({

/***/ 0:
/***/ (function(module, exports) {

(function () {

    $(document).ready(function () {

        /*SLIDER script*/
        $("#image-slider_home").owlCarousel({
            loop: true,
            items: 1,
            nav: false,
            dots: true,
            autoplay: true,
            autoplayTimeout: 4000,
            slideSpeed: 2000,
            paginationSpeed: 600,
            smartSpeed: 1300,
            rewindSpeed: 10
        });

        /*HAMBURGER*/
        var forEach = function forEach(t, o, r) {
            if ("[object Object]" === Object.prototype.toString.call(t)) for (var c in t) {
                Object.prototype.hasOwnProperty.call(t, c) && o.call(r, t[c], c, t);
            } else for (var e = 0, l = t.length; l > e; e++) {
                o.call(r, t[e], e, t);
            }
        };

        var hamburgers = document.querySelectorAll(".hamburger");
        if (hamburgers.length > 0) {
            forEach(hamburgers, function (hamburger) {
                hamburger.addEventListener("click", function () {
                    this.classList.toggle("is-active");
                }, false);
            });
        }

        $('#toggle-menu').click(function () {

            $(this).toggleClass('active');
            $('#my-menu').slideToggle("slow");
        });

        if ($(window).width() < 900) {
            $('#my-menu a').click(function () {
                $('.hamburger').removeClass('is-active');
                $('#my-menu').slideUp("slow");
            });
        }

        if ($(window).width() > 899) {
            $('#my-menu').slideDown("slow");
        }
    });

    /*Add issues/announcements*/

    $('#load-more').click(function () {

        var element = $('#form').html();
        $('#form').append(element);
    });

    //PREVENT GOOGLE MAP SCALING ON SCROLL

    // enable the pointer events only on click;

    $('#map_canvas1').addClass('scrolloff'); // set the pointer events to none on doc ready
    $('#canvas1').on('click', function () {
        $('#map_canvas1').removeClass('scrolloff'); // set the pointer events true on click
    });

    //disable pointer events when the mouse leave the canvas area;

    $("#map_canvas1").mouseleave(function () {
        $('#map_canvas1').addClass('scrolloff'); // set the pointer events to none when mouse leaves the map area
    });

    //Show hints on focus

    if ($('.s-request-form').length) {

        $('[data-help]').focus(function () {
            $('.s-request-form .hint').removeClass('is-active');

            if ($('[data-hint="' + $(this).attr('data-help') + '"]').length) {
                $('[data-hint="' + $(this).attr('data-help') + '"]').addClass('is-active');
            } else {
                $('[data-hint="general"]').addClass('is-active');
            }
        });

        $("#submit").on("cssClassChanged", function () {
            $('.s-request-form .hint').removeClass('is-active');
            $('[data-hint="final"]').addClass('is-active');
            evaluate_price();
        });
    }

    function evaluate_price() {
        if ($('#material_amount') !== null && $("#hours") !== null && $("#minutes") !== null) {
            var $price = (3 * (parseInt($("#hours").val()) + parseInt($("#minutes").val()) / 60) + 5 * parseFloat($("#material_amount").val()) / 100).toFixed(2);
            $("#price").html($price);
            $("#price-final").html($price);
        }
    }

    $("#hours").keyup(function () {
        evaluate_price();
    });
    $("#minutes").keyup(function () {
        evaluate_price();
    });
    $("#material_amount").keyup(function () {
        evaluate_price();
    });
})();

/***/ }),

/***/ 11:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 12:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(0);
module.exports = __webpack_require__(11);


/***/ })

/******/ });