<?php 
	get_template_part('panel/constants');

	load_theme_textdomain( 'ci_theme', get_template_directory() . '/lang' );

	// This is the main options array. Can be accessed as a global in order to reduce function calls.
	$ci = get_option(THEME_OPTIONS);
	$ci_defaults = array();

	// The $content_width needs to be before the inclusion of the rest of the files, as it is used inside of some of them.
	if ( ! isset( $content_width ) ) $content_width = 900;

	//
	// Let's bootstrap the theme.
	//
	get_template_part('panel/bootstrap');
	get_template_part('functions/woocommerce');
	get_template_part('functions/shortcodes');


	//
	// Define our various image sizes.
	//
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 480, 360, true );
	add_image_size( 'homepage_slider', 1220, 480, true);
	add_image_size( 'blog_col_thumb', 480, 360, true);


	// Let the user choose a color scheme on each post individually.
	add_ci_theme_support('post-color-scheme', array('page', 'post', 'product'));


    // Let WooCommerce know that we support it.
    add_theme_support('woocommerce');

	// Set image sizes also for woocommerce.
	// Run only when the theme or WooCommerce is activated.
	add_action('ci_theme_activated', 'ci_woocommerce_image_dimensions');
	register_activation_hook( WP_PLUGIN_DIR.'/woocommerce/woocommerce.php', 'ci_woocommerce_image_dimensions' );
	if( !function_exists('ci_woocommerce_image_dimensions') ):
	function ci_woocommerce_image_dimensions()
	{
		// Image sizes
		update_option('shop_thumbnail_image_size', array(
			'width' => '100',
			'height' => '100',
			'crop' => 1
		));
		update_option('shop_catalog_image_size', array(
			'width' => '320',
			'height' => '430',
			'crop' => 1
		));
		update_option('shop_single_image_size', array(
			'width' => '560',
			'height' => '9999',
			'crop' => 0
		));
	}
	endif;


	// Since it's a responsive theme, remove width and height attributes from the <img> tag.
	// Remove also when an image is sent to the editor. When the user resizes the image from the handles, width and height
	// are re-inserted, so expected behaviour is not lost.
	add_filter('post_thumbnail_html', 'ci_remove_thumbnail_dimentions');
	add_filter('image_send_to_editor', 'ci_remove_thumbnail_dimentions');
	if( !function_exists('ci_remove_thumbnail_dimentions') ):
	function ci_remove_thumbnail_dimentions($html)
	{
		$html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
		return $html;
	}
	endif;
	
?>
