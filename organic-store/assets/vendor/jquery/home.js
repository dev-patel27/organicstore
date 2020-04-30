"use strict";
jQuery(window).on('load', function() {

    // will first fade out the loading animation
    jQuery("#status").fadeOut();
    // will fade out the whole DIV that covers the website.
    jQuery("#preloader").delay(500).fadeOut("slow");

})


$(document).ready(function() {

    $('.owl-carousel1').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4,
                nav: true,
                dots: false,
                loop: false,
            }




        }
    })




    $('.latest-products').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        responsive: {
            0: {
                items: 1,
                dots: false,
            },

            414: {
                items: 1,
                dots: false,
            },

            480: {
                items: 2,
                dots: false,
            },

            767: {
                items: 2,
                dots: false,
            },

            1000: {
                items: 3,
                nav: true,
                dots: false,
                loop: false,
            },

            1024: {
                items: 3,
                nav: true,
                dots: false,
                loop: false,
            },


            1280: {
                items: 4,
                nav: true,
                dots: false,
                loop: false,
            },

            1440: {
                items: 4,
                nav: true,
                dots: false,
                loop: false,
            },

            1600: {
                items: 5,
                nav: true,
                dots: false,
                loop: false,
            }
        }
    })


    $('.featured-products').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4,
                nav: true,
                dots: false,
                loop: false,
            }
        }
    })




    $('.owl-carousel2').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 3,
                nav: true,
                dots: false,
                loop: false,
            }
        }
    })




    $('.our-service-carousel').owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        responsive: {
            0: {
                items: 1,
                nav: false,
                dots: true,
                loop: false,
            },
            800: {
                items: 2,
                nav: false,
                dots: true,
                loop: false,
            },
            1000: {
                items: 3,
                nav: false,
                dots: true,
                loop: false,
            }
        }
    })




    $('.testimonial').owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        responsive: {
            0: {
                items: 1,
                nav: false,
                dots: false,
                loop: false,
            },
            800: {
                items: 2,
                nav: false,
                dots: false,
                loop: false,
            },
            1000: {
                items: 3,
                nav: false,
                dots: true,
                loop: false,
            }
        }
    })


    $('.partner-logo').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        responsive: {
            0: {
                items: 3,
                nav: false,
                dots: false,
                loop: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            },


            480: {
                items: 3,
                nav: false,
                dots: false,
                loop: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            },


            600: {
                items: 5,
                nav: false,
                dots: false,
                loop: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            },

            1000: {
                items: 6,
                nav: true,
                dots: false,
                loop: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            }
        }
    })

});