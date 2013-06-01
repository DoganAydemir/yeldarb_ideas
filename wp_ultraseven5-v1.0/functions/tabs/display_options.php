<?php global $ci, $ci_defaults, $load_defaults, $content_width; ?>
<?php if ($load_defaults===TRUE): ?>
<?php
	add_filter('ci_panel_tabs', 'ci_add_tab_display_options', 40);
	if( !function_exists('ci_add_tab_display_options') ):
		function ci_add_tab_display_options($tabs) 
		{ 
			$tabs[sanitize_key(basename(__FILE__, '.php'))] = __('Display Options', 'ci_theme'); 
			return $tabs; 
		}
	endif;
	
	// Default values for options go here.
	// $ci_defaults['option_name'] = 'default_value';
	// or
	// load_panel_snippet( 'snippet_name' );

	load_panel_snippet('excerpt');
	load_panel_snippet('seo');
	load_panel_snippet('comments');

	// Allow users to enable/disable the featured image on the single slider pages.
	add_filter('ci_featured_image_post_types', 'ci_add_featured_img_cpt');
	if( !function_exists('ci_add_featured_img_cpt') ):
	function ci_add_featured_img_cpt($post_types)
	{
		$post_types[] = 'cpt_slider';
		return $post_types;		
	}
	endif;
	load_panel_snippet('featured_image_single');

	// Set our full width template width and options.
	add_filter('ci_full_template_width', 'ci_fullwidth_width');
	if( !function_exists('ci_fullwidth_width') ):
	function ci_fullwidth_width()
	{ 
		return 1220;
	}
	endif;
	load_panel_snippet('featured_image_fullwidth');

	$ci_defaults['show_related_posts']	= 'enabled';
?>
<?php else: ?>

	<?php load_panel_snippet('excerpt'); ?>	

	<?php load_panel_snippet('seo'); ?>	

	<?php load_panel_snippet('comments'); ?>

	<fieldset class="set">
		<p class="guide"><?php _e('You can enable or disable the "You may also like" section that appears on each single post, just below the content.' , 'ci_theme'); ?></p>
		<?php ci_panel_checkbox('show_related_posts', 'enabled', __('Show Related Posts', 'ci_theme')); ?>
	</fieldset>

	<?php load_panel_snippet('featured_image_single'); ?>

	<?php load_panel_snippet('featured_image_fullwidth'); ?>

<?php endif; ?>
