jQuery(function ($) {

"use strict";
    // -------------------------------------------------------------
    // Countdown
    // -------------------------------------------------------------
    (function () {

        $(".back-countdiown").countdown({
            date: "4 March 2020 12:00:00",
            format: "on"
        });
    
    }()); 


}); // JQuery end


$(document).on('click', '.m-menu .dropdown-menu', function(e) {
  e.stopPropagation()
})