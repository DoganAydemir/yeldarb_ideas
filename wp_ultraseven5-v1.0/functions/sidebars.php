<?php
add_action( 'widgets_init', 'ci_widgets_init' );
if( !function_exists('ci_widgets_init') ):
function ci_widgets_init() {

	register_sidebar(array(
		'name' => __( 'Blog Sidebar', 'ci_theme'),
		'id' => 'blog-sidebar',
		'description' => __( 'The list of widgets assigned here will appear in your blog posts.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	));

	register_sidebar(array(
		'name' => __( 'Navigation Sidebar', 'ci_theme'),
		'id' => 'nav-widgets',
		'description' => __( 'Only the search widget is allowed here.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	));

	register_sidebar(array(
		'name' => __( 'Pages Sidebar', 'ci_theme'),
		'id' => 'pages-sidebar',
		'description' => __( 'The list of widgets assigned here will appear in your normal pages.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	));

	register_sidebar(array(
		'name' => __( 'e-Shop Sidebar', 'ci_theme'),
		'id' => 'eshop-sidebar',
		'description' => __( 'The list of widgets assigned here will appear in your e-shop pages.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	));

	register_sidebar(array(
		'name' => __( 'Front Page Widget Area', 'ci_theme'),
		'id' => 'front-page-1',
		'description' => __( 'The list of widgets assigned here will appear in the first row of your widgetized frontpage. It is recommended to assign WooCommerce product widgets.', 'ci_theme'),
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="section-title"><span>',
		'after_title' => '</span></h3>',
	));

	register_sidebar(array(
		'name' => __( 'Before Footer Widget Area', 'ci_theme'),
		'id' => 'before-footer',
		'description' => __( 'The list of widgets assigned here will appear just before your footer in every page except the homepage.', 'ci_theme'),
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="section-title"><span>',
		'after_title' => '</span></h3>',
	));

	register_sidebar(array(
		'name' => __( 'Footer Widgets Column 1', 'ci_theme'),
		'id' => 'footer-widgets-1',
		'description' => __( 'The widgets here will appear in the first column of your website\'s footer.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	));

	register_sidebar(array(
		'name' => __( 'Footer Widgets Column 2', 'ci_theme'),
		'id' => 'footer-widgets-2',
		'description' => __( 'The widgets here will appear in the second column of your website\'s footer.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	));

	register_sidebar(array(
		'name' => __( 'Footer Widgets Column 3', 'ci_theme'),
		'id' => 'footer-widgets-3',
		'description' => __( 'The widgets here will appear in the third column of your website\'s footer.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	));

	register_sidebar(array(
		'name' => __( 'Footer Widgets Column 4', 'ci_theme'),
		'id' => 'footer-widgets-4',
		'description' => __( 'The widgets here will appear in the fourth column of your website\'s footer.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	));

}
endif;
?>
