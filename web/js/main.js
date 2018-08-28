// SMOOTH SCROLLING //
$('.scroll').click(function (e) {
	"use strict";
	e.preventDefault(); //Prevent flickring before scroll
	var link = $(this).attr('href');
	var posi = $(link).offset().top;
	$('body,html').animate({
		scrollTop: posi
	}, 1000);
});


// BECKUP FOR MOBILE//
jQuery(function ($) {

	// Touch Device Detection
	var isTouchDevice = 'ontouchstart' in document.documentElement;
	if (isTouchDevice) {
		$('.dropdown').click(function () {
			$('.dropdown-hide').toggle();
		});
	}

});

function sliderShapeChanged(e) {
	var options = {
		circleShape: e.value
	};
	if (e.value == "pie") options["startAngle"] = 0;
	else if (e.value == "custom-quarter" || e.value == "custom-half") options["startAngle"] = 45;
	$("#shape").roundSlider(options);
}

/*
$('.header-background-image').waitForImages(function () {
	//$(this).addClass("expandOpen");
});
*/
/*$(".control-panel__cube").click(function () {
	var myelement = $(this).attr("href")
	$(myelement).slideToggle("slow");
	$(".panel__hidden:visible").not(myelement).hide();

});*/