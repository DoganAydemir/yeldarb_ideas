<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ($load_defaults===TRUE): ?>
<?php
	add_filter('ci_panel_tabs', 'ci_add_tab_homepage_options', 20);
	if( !function_exists('ci_add_tab_homepage_options') ):
		function ci_add_tab_homepage_options($tabs) 
		{ 
			$tabs[sanitize_key(basename(__FILE__, '.php'))] = __('Homepage Options', 'ci_theme'); 
			return $tabs; 
		}
	endif;

	// Default values for options go here.
	// $ci_defaults['option_name'] = 'default_value';
	// or
	// load_panel_snippet( 'snippet_name' );
	load_panel_snippet('slider_flexslider');

	$ci_defaults['slider_type']= 'flexslider';
	$ci_defaults['revo_slider_alias']= '';

?>
<?php else: ?>

	<fieldset class="set">
		<p class="guide"><?php _e('The following options control whether you wish to show the standard Flexslider slideshow or the Revolution Slider powered one for your widgetized homepage. If you choose the Revolution Slider please enter your exact slider alias as it is presented in the Edit Slider screen.' , 'ci_theme'); ?></p>
		<fieldset>
			<?php ci_panel_radio('slider_type', 'slider_type_flexslider', 'flexslider', __('Use Flexslider', 'ci_theme')); ?>
			<?php ci_panel_radio('slider_type', 'slider_type_revo_slider', 'revo_slider', __('Use Revolution Slider', 'ci_theme')); ?>
			<?php ci_panel_radio('slider_type', 'slider_type_no_slider', 'no_slider', __('I don\'t want a slider on my homepage', 'ci_theme')); ?>
		</fieldset>
		<fieldset>
			<?php ci_panel_input('revo_slider_alias', __('Revolution Slider Alias:', 'ci_theme')); ?>
		</fieldset>
	</fieldset>

	<?php load_panel_snippet('slider_flexslider'); ?>

	
<?php endif; ?>
