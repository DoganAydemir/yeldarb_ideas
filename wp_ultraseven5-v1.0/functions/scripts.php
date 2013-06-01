<?php
//
// Uncomment one of the following two. Their functions are in panel/generic.php
//
add_action('wp_enqueue_scripts', 'ci_enqueue_modernizr');
//add_action('wp_enqueue_scripts', 'ci_print_html5shim');


// This function lives in panel/generic.php
add_action('wp_footer', 'ci_print_selectivizr', 100);



add_action('init', 'ci_register_theme_scripts', 20);
if( !function_exists('ci_register_theme_scripts') ):
function ci_register_theme_scripts()
{
	//
	// Register all scripts here, both front-end and admin. 
	// There is no need to register them conditionally, as the enqueueing can be conditional.
	//

	wp_register_script('jquery-flexslider', get_child_or_parent_file_uri('/panel/scripts/jquery.flexslider-min.js'), array('jquery'), false, true);
	wp_register_script('equalHeights', get_child_or_parent_file_uri('/js/jquery.equalHeights.js'), array('jquery'), false, true);
	wp_register_script('dropkick', get_child_or_parent_file_uri('/js/dropkick.js'), array('jquery'), false, true);
	wp_register_script('jRespond', get_child_or_parent_file_uri('/js/jRespond.min.js'), array('jquery'), false, true);
	wp_register_script('jpanelmenu', get_child_or_parent_file_uri('/js/jquery.jpanelmenu.min.js'), array('jquery'), false, true);
	wp_register_script('prettyPhoto', get_child_or_parent_file_uri('/js/jquery.prettyPhoto.min.js'), array('jquery'), false, true);

	wp_register_script('ci-front-scripts', get_child_or_parent_file_uri('/js/scripts.js'),
		array(
			'jquery',
			'jquery-superfish',
			'jquery-flexslider',
			'equalHeights',
			'prettyPhoto',
			'dropkick',
			'jRespond',
			'jpanelmenu'
		),
		CI_THEME_VERSION, true);
		
}
endif;



add_action('wp_enqueue_scripts', 'ci_enqueue_theme_scripts');
if( !function_exists('ci_enqueue_theme_scripts') ):
function ci_enqueue_theme_scripts()
{
	//
	// Enqueue all (or most) front-end scripts here.
	// They can be also enqueued from within template files.
	// There is a list of pre-registered scripts in /panel/ci_panel.php inside ci_register_theme_default_scripts()
	//	
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );


	wp_enqueue_script('ci-front-scripts');

}
endif;


if( !function_exists('ci_enqueue_admin_theme_scripts') ):
add_action('admin_enqueue_scripts','ci_enqueue_admin_theme_scripts');
function ci_enqueue_admin_theme_scripts() 
{
	global $pagenow;

	//
	// Enqueue here scripts that are to be loaded on all admin pages.
	//

	if(is_admin() and $pagenow=='themes.php' and isset($_GET['page']) and $_GET['page']=='ci_panel.php')
	{
		//
		// Enqueue here scripts that are to be loaded only on CSSIgniter Settings panel.
		//

	}
}
endif;


?>
