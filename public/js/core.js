(function() {

    $(document).ready(function() {


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
        var forEach = function(t, o, r) {
            if ("[object Object]" === Object.prototype.toString.call(t))
                for (var c in t) Object.prototype.hasOwnProperty.call(t, c) && o.call(r, t[c], c, t);
            else
                for (var e = 0, l = t.length; l > e; e++) o.call(r, t[e], e, t)
        };

        var hamburgers = document.querySelectorAll(".hamburger");
        if (hamburgers.length > 0) {
            forEach(hamburgers, function(hamburger) {
                hamburger.addEventListener("click", function() {
                    this.classList.toggle("is-active");
                }, false);
            });
        }

        $('#toggle-menu').click(function() {

            $(this).toggleClass('active');
            $('#my-menu').slideToggle("slow");
        });

        if ($(window).width() < 900) {
            $('#my-menu a').click(function() {
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

      var element = $('.list-group-item').html();
      $('.list-group').append( element );

    });
})();