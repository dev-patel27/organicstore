"use strict";

$(document).ready(function() {

$('.latest-products').owlCarousel({
loop:true,
margin:30,
nav:true,
responsive:{
0:{
items:1,
nav:false,
dots:true,
loop:false,
},

414:{
items:1,
nav:false,
dots:true,
loop:false,
},

480:{
items:2,
nav:false,
dots:true,
loop:false,
},

767:{
items:2,
nav:true,
dots:false,
loop:false,
},

1000:{
items:4,
nav:true,
dots:false,
loop:false,
}
}
})


});