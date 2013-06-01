jQuery(window).on("load", function() {

	/* -----------------------------------------
	 FlexSlider Init
	 ----------------------------------------- */
	var homeSlider = jQuery(".home-slider");

	homeSlider.flexslider({
		slideshow: true,
		directionNav: false,
		controlNav: false,
		animation: "slide"
	});

	jQuery(".flex-prev").on('click', function(e) {
		homeSlider.flexslider('prev');
		e.preventDefault();
	});

	jQuery(".flex-next").on('click', function(e) {
		homeSlider.flexslider('next');
		e.preventDefault();
	});

	/* -----------------------------------------
	 equalHeights Init
	 ----------------------------------------- */
	jQuery(".product-list").equalHeights();
	jQuery(".news-hold").equalHeights();
});

jQuery(document).ready(function($) {

	/* -----------------------------------------
	 Main Navigation Init
	 ----------------------------------------- */
	$('ul#navigation').superfish({
		delay:       300,
		animation:   {opacity:'show'},
		speed:       'fast',
		dropShadows: false
	});

	/* -----------------------------------------
	 Responsive Menus Init with jPanelMenu
	 ----------------------------------------- */
	var jPM = $.jPanelMenu({
		menu: '#navigation',
		trigger: '.menu-trigger',
		excludedPanelContent: "style, script, #wpadminbar"
	});

	var jRes = jRespond([
		{
			label: 'mobile',
			enter: 0,
			exit: 767
		}
	]);

	jRes.addFunc({
		breakpoint: 'mobile',
		enter: function() {
			jPM.on();
		},
		exit: function() {
			jPM.off();
		}
	});

	$(window).resize(function() {
		$(".product-list").equalHeights();
	});

	/* -----------------------------------------
	 Custom Dropdowns (Dropkick.js)
	 ----------------------------------------- */
	$("table.variations select").dropkick({
		change: function(value, label) {
			$(this).change();
		}
	});

	$(".woocommerce-ordering select").dropkick({
		change: function(value, label) {
			$(this).change();
		}
	});

	/* -----------------------------------------
	 PrettyPhoto (Image Lightbox) Init
	 ----------------------------------------- */
	$("a[rel='prettyPhoto']").prettyPhoto({
		social_tools: false,
		inline_markup: false,
		show_title: false,
		theme: 'pp_woocommerce',
		horizontal_padding: 40,
		opacity: 0.9,
		deeplinking: false
	});

});
