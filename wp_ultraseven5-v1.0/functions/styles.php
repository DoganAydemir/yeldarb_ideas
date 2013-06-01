<?php
add_action('init', 'ci_register_theme_styles');
if( !function_exists('ci_register_theme_styles') ):
function ci_register_theme_styles()
{
	//
	// Register all front-end and admin styles here. 
	// There is no need to register them conditionally, as the enqueueing can be conditional.
	//

	wp_register_style('ci-googlefont', 'http://fonts.googleapis.com/css?family=Neuton|Muli&subset=latin,latin-ext');
	wp_register_style('ci-color-scheme', get_child_or_parent_file_uri('/colors/'.ci_setting('stylesheet')));
	wp_register_style('foundation', get_child_or_parent_file_uri('/css/foundation.css'));
	wp_register_style('ci-flexslider', get_child_or_parent_file_uri('/css/flexslider.css'));
	wp_register_style('mediaqueries', get_child_or_parent_file_uri('/css/mediaqueries.css'));
	wp_register_style('ci-woocommerce', get_child_or_parent_file_uri('/css/ci_woocommerce.css'));
	wp_register_style('ci-prettyPhoto', get_child_or_parent_file_uri('/css/prettyPhoto.css'));
	wp_register_style('ci-style', get_stylesheet_uri(), array(), CI_THEME_VERSION, 'screen');

}
endif;

add_action('wp_enqueue_scripts', 'ci_enqueue_theme_styles');
if( !function_exists('ci_enqueue_theme_styles') ):
function ci_enqueue_theme_styles()
{
	//
	// Enqueue all (or most) front-end styles here.
	//	
	wp_enqueue_style('ci-googlefont');
	wp_enqueue_style('foundation');
	wp_enqueue_style('ci-flexslider');
	wp_enqueue_style('ci-woocommerce');
	wp_enqueue_style('ci-style');
	wp_enqueue_style('mediaqueries');
	wp_enqueue_style('ci-prettyPhoto');
	wp_enqueue_style('ci-color-scheme');

}
endif;


if( !function_exists('ci_enqueue_admin_theme_styles') ):
add_action('admin_enqueue_scripts','ci_enqueue_admin_theme_styles');
function ci_enqueue_admin_theme_styles() 
{
	global $pagenow;

	//
	// Enqueue here styles that are to be loaded on all admin pages.
	//

	if(is_admin() and $pagenow=='themes.php' and isset($_GET['page']) and $_GET['page']=='ci_panel.php')
	{
		//
		// Enqueue here styles that are to be loaded only on CSSIgniter Settings panel.
		//

	}
}
endif;

?>
