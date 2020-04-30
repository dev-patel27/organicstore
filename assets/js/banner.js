'use strict';
var revapi7,
			tpj;
		(function() {
			if (!/loaded|interactive|complete/.test(document.readyState)) document.addEventListener("DOMContentLoaded", onLoad);
			else onLoad();

			function onLoad() {
				if (tpj === undefined) {
					tpj = jQuery;
					if ("off" == "on") tpj.noConflict();
				}
				if (tpj("#rev_slider_7_1").revolution == undefined) {
					revslider_showDoubleJqueryError("#rev_slider_7_1");
				} else {
					revapi7 = tpj("#rev_slider_7_1").show().revolution({
						sliderType: "standard",
						jsFileLocation: "vendor/revslider/js/",
						sliderLayout: "fullwidth",
						dottedOverlay: "none",
						delay: 6000,
						navigation: {
							keyboardNavigation: "off",
							keyboard_direction: "horizontal",
							mouseScrollNavigation: "off",
							mouseScrollReverse: "default",
							onHoverStop: "off",
							arrows: {
								style: "gyges",
								enable: true,
								hide_onmobile: false,
								hide_under: 350,
								hide_onleave: true,
								hide_delay: 100,
								hide_delay_mobile: 1200,
								tmp: '',
								left: {
									h_align: "left",
									v_align: "center",
									h_offset: 20,
									v_offset: 0
								},
								right: {
									h_align: "right",
									v_align: "center",
									h_offset: 20,
									v_offset: 0
								}
							},
							bullets: {
								enable: false,
								hide_onmobile: false,
								hide_over: 992,
								style: "zeus",
								hide_onleave: false,
								direction: "horizontal",
								h_align: "center",
								v_align: "bottom",
								h_offset: 0,
								v_offset: 20,
								space: 5,
								tmp: '<span class="tp-bullet-image"></span><span class="tp-bullet-imageoverlay"></span><span class="tp-bullet-title">{{title}}</span>'
							}
						},
						responsiveLevels: [1240, 1024, 778, 320],
						visibilityLevels: [1240, 1024, 778, 420],
						gridwidth: [1900, 1366, 800, 576],
						gridheight: [768, 640, 550, 480],
						lazyType: "none",
						minHeight: "720",
						shadow: 0,
						spinner: "spinner0",
						stopLoop: "off",
						stopAfterLoops: -1,
						stopAtSlide: -1,
						shuffle: "off",
						autoHeight: "off",
						disableProgressBar: "on",
						hideThumbsOnMobile: "off",
						hideSliderAtLimit: 0,
						hideCaptionAtLimit: 0,
						hideAllCaptionAtLilmit: 0,
						debugMode: false,
						fallbacks: {
							allowHTML5AutoPlayOnAndroid: false,
							simplifyAll: "on",
							nextSlideOnWindowFocus: "off",
							disableFocusListener: false,
						}
					});
				}; /* END OF revapi call */
			}; /* END OF ON LOAD FUNCTION */
		}()); /* END OF WRAPPING FUNCTION */
		
		 // You can also use "$(window).load(function() {"
   