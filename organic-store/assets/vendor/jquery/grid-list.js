"use strict";
$(document).ready(function() {
						   
    $("#list").on('click', function(t) {
        t.preventDefault(), $("#products .item").addClass("list-group-item")
    }), $("#grid").on('click', function(t) {
        t.preventDefault(), $("#products .item").removeClass("list-group-item"), $("#products .item").addClass("grid-group-item")
    })
	
});