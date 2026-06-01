/*-----------------------------------------------------------------------------------

    Theme Name: GYM - Fitness and Gym Responsive Template
    Description: Fitness and Gym Responsive Template
    Author: Chitrakoot Web
    Version: 1.0

    /* ----------------------------------

    JS Active Code Index

        01. Preloader
        02. scrollIt
        03. Scroll To Top
        04. Sidemenu toggle
        05. Navbar scrolling background
        06. Parallax
        07. Video
        08. Resize function
        09. FullScreenHeight function
        10. ScreenFixedHeight function
        11. FullScreenHeight and screenHeight with resize function
        12. Sliders
        13. CountUp
        14. Isotop

    ---------------------------------- */

(function($) {

    "use strict";

    var $window = $(window);

        /*------------------------------------
            01. Preloader
        --------------------------------------*/

        $('#preloader').fadeOut('normall', function() {
           // $(this).remove();
        });

        /*------------------------------------
            02. scrollIt
        --------------------------------------*/

        $.scrollIt({
          upKey: 38,                // key code to navigate to the next section
          downKey: 40,              // key code to navigate to the previous section
          easing: 'swing',          // the easing function for animation
          scrollTime: 600,          // how long (in ms) the animation takes
          activeClass: 'active',    // class given to the active nav element
          onPageChange: null,       // function(pageIndex) that is called when page is changed
          topOffset: -70            // offste (in px) for fixed top navigation
        });

        /*------------------------------------
            03. Scroll To Top
        --------------------------------------*/

        $window.on('scroll', function() {
            if ($(this).scrollTop() > 500) {
                $(".scroll-to-top").fadeIn(400);

            } else {
                $(".scroll-to-top").fadeOut(400);
            }
        });

        $(".scroll-to-top").on('click', function(event) {
            event.preventDefault();
            $("html, body").animate({
                scrollTop: 0
            }, 600);
        });

        /*------------------------------------
            04. Sidemenu toggle
        --------------------------------------*/

        if ($("#sidebar_toggle").length) {
           $("body").addClass("sidebar-menu");
           $("#sidebar_toggle").on("click", function () {
              $(".sidebar-menu").toggleClass("active");
              $(".side-menu").addClass("side-menu-active"), $("#close_sidebar").fadeIn(700)
           }), $("#close_sidebar").on("click", function () {
              $(".side-menu").removeClass("side-menu-active"), $(this).fadeOut(200), $(".sidebar-menu").removeClass("active")
           }), $("#btn_sidebar_colse").on("click", function () {
              $(".side-menu").removeClass("side-menu-active"), $("#close_sidebar").fadeOut(200), $(".sidebar-menu").removeClass("active")
           });
        }

        /*------------------------------------
            05. Navbar scrolling background
        --------------------------------------*/

        $window.on("scroll",function () {

            var bodyScroll = $window.scrollTop(),
                navbar = $(".navbar"),
                navbloglogo = $(".blog-nav .logo> img"),
                darkbg = $(".bg-black .logo> img"),
                logo = $(".navbar .logo> img");

            if(bodyScroll > 100){
                navbar.addClass("nav-scroll");
                logo.attr('src', 'img/logos/logo-dark.png');
                darkbg.attr('src', 'img/logos/logo-light.png');

            }else{
                navbar.removeClass("nav-scroll");
                logo.attr('src', 'img/logos/logo-light.png');
                navbloglogo.attr('src', 'img/logos/logo-dark.png');
            }
        });

         var windowsize = $window.width();
            if (windowsize <= 991) {
            $('.navbar-nav .nav-link').on("click", function(){
                $('.navbar-collapse.show').removeClass('show');
                $('.navbar .navbar-toggler').addClass('collapsed');
            });
          }

        /*------------------------------------
            06. Parallax
        --------------------------------------*/

        // sections background image from data background
        var pageSection = $(".parallax,.bg-img");
        pageSection.each(function(indx) {

            if ($(this).attr("data-background")) {
                $(this).css("background-image", "url(" + $(this).data("background") + ")");
            }
        });

        /*------------------------------------
            07. Video
        --------------------------------------*/

        $('.popup-video').magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false
        });

        /*------------------------------------
            08. Resize function
        --------------------------------------*/

        $window.resize(function(event) {
            setTimeout(function() {
                SetResizeContent();
            }, 500);
            event.preventDefault();
        });

        /*------------------------------------
            09. FullScreenHeight function
        --------------------------------------*/

        function fullScreenHeight() {
            var element = $(".full-screen");
            var $minheight = $window.height();
            element.css('min-height', $minheight);
        }

        /*------------------------------------
            10. ScreenFixedHeight function
        --------------------------------------*/

        function ScreenFixedHeight() {
            var $headerHeight = $("header").height();
            var element = $(".screen-height");
            var $screenheight = $window.height() - $headerHeight;
            element.css('height', $screenheight);
        }

        /*------------------------------------
            11. FullScreenHeight and screenHeight with resize function
        --------------------------------------*/

        function SetResizeContent() {
            fullScreenHeight();
            ScreenFixedHeight();
        }

        SetResizeContent();

    // === when document ready === //
    $(document).ready(function() {

        /*------------------------------------
            12. Sliders
        --------------------------------------*/

        // service carousel
        $('.service-carousel').owlCarousel({
            loop: true,
            responsiveClass: true,
            autoplay: false,
            autoplayTimeout: 5000,
            smartSpeed: 900,
            nav: false,
            dots: true,
            center:true,
            margin: 30,
            responsive: {
                0: {
                    items: 1

                },
                768: {
                    items: 2
                },
                992: {
                    items: 2
                }
            }
        });

        // team carousel
        /*
        $('.team-carousel').owlCarousel({
            loop: true,
            responsiveClass: true,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 900,
            nav: false,
            dots: true,
            center:false,
            margin: 20,
            responsive: {
                0: {
                    items: 1

                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                }
            }
        });
        */

        // Testmonials carousel1
        $('.testimonial-carousel').owlCarousel({
            loop: true,
            responsiveClass: true,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1300,
            nav: false,
            dots: true,
            center:false,
            margin: 25,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 1
                },
                992: {
                    items: 1
                }
            }
        });

        // team carousel
        /*
        $('.product-carousel').owlCarousel({
            loop: true,
            responsiveClass: true,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 900,
            nav: false,
            dots: true,
            center:false,
            margin: 30,
            responsive: {
                0: {
                    items: 1,
                    margin: 15
                },
                480: {
                    items: 2,
                    margin: 15
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                }
            }
        });
        */

        // client-carousel
        $('.client-carousel').owlCarousel({
            loop: true,
            responsiveClass: true,
            autoplay: true,
            smartSpeed: 1500,
            nav: false,
            dots: true,
            center:false,
            margin: 0,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 1
                },
                992: {
                    items: 1
                },
            }
        });

        // Slider owlCarousel
        $('.slider-fade .owl-carousel').owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            autoplay: true,
            smartSpeed: 1000,
            mouseDrag: false,
            animateIn: 'fadeIn',
            animateOut: 'fadeOut'
        });

        // Default owlCarousel
        $('.owl-carousel').owlCarousel({
            items: 1,
            loop:true,
            dots: true,
            margin: 0,
            autoplay:false,
            smartSpeed:500
        });

        // Slider text animation
        var owl = $('.header .owl-carousel');
        owl.on('changed.owl.carousel', function (event) {
            var item = event.item.index - 2; // Position of the current item
            $('h3').removeClass('animated fadeInUp');
            $('h1').removeClass('animated fadeInUp');
            $('p').removeClass('animated fadeInUp');
            $('.btn').removeClass('animated fadeInUp');
            $('.owl-item').not('.cloned').eq(item).find('h3').addClass('animated fadeInUp');
            $('.owl-item').not('.cloned').eq(item).find('h1').addClass('animated fadeInUp');
            $('.owl-item').not('.cloned').eq(item).find('p').addClass('animated fadeInUp');
            $('.owl-item').not('.cloned').eq(item).find('.btn').addClass('animated fadeInUp');
        });

        /*------------------------------------
            13. CountUp
        --------------------------------------*/

        $('.countup').counterUp({
            delay: 25,
            time: 2000
        });

    });

    // === when window loading === //
    $window.on("load", function() {

        /*------------------------------------
            14. Isotop
        --------------------------------------*/

        // gallery with magnificPopup
        $('.gallery').magnificPopup({
            delegate: '.popimg',
            type: 'image',
            gallery: {
                enabled: true
            }
        });

        // gallery with magnificPopup
        $('.single-img').magnificPopup({
            delegate: '.popimg',
            type: 'image'
        });

        // stellar
        $window.stellar();

    });

})(jQuery);
