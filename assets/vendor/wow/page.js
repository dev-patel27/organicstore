"use strict";
$(document).ready(function() {
    $(".megamenu").on("hover", function(e) {
        e.stopPropagation();
    });
});

$(document).ready(function() {
    new WOW().init();
});