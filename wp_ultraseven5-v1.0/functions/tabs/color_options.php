<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ($load_defaults===TRUE): ?>
<?php
	add_filter('ci_panel_tabs', 'ci_add_tab_color_options', 30);
	if( !function_exists('ci_add_tab_color_options') ):
		function ci_add_tab_color_options($tabs) 
		{ 
			$tabs[sanitize_key(basename(__FILE__, '.php'))] = __('Color Options', 'ci_theme'); 
			return $tabs; 
		}
	endif;
	
	// Default values for options go here.
	// $ci_defaults['option_name'] = 'default_value';
	// or
	// load_panel_snippet( 'snippet_name' );
	load_panel_snippet('custom_background');
	load_panel_snippet('color_scheme');

	$ci_defaults['bg_pattern'] = 'diagonal';


	// We unhook the default handler for custom background, as we want the background color and
	// image applied to different elements, i.e. 2 different CSS rules.
	// The original ci_custom_background_handler() that lives in the custom_background snippet can only handle one CSS rule.
	remove_action('ci_custom_background', 'ci_custom_background_handler');
	add_action('ci_custom_background', 'ci_theme_custom_background_handler');
	if( !function_exists('ci_theme_custom_background_handler')):
	function ci_theme_custom_background_handler($options)
	{
		if (ci_setting('bg_custom_disabled')!='enabled'):
			?>
			body{
				<?php if (!empty($options['bg_color'])) echo 'background-color: '.$options['bg_color'].';'; ?>
			}
			#page{
				<?php
					if (!empty($options['bg_image']))
					{
						echo 'background-image: url('.$options['bg_image'].');';
						echo 'background-position: '.$options['bg_image_horizontal'].' '.$options['bg_image_vertical'].';';
						if($options['bg_image_attachment']=='fixed') echo 'background-attachment: fixed;';
					}
				?>
				<?php if (!empty($options['bg_image_repeat'])) echo 'background-repeat: '.$options['bg_image_repeat'].';'; ?>
				<?php if ($options['bg_image_disable']=='enabled') echo 'background-image: none;'; ?>				
			}
			<?php
		endif;
	}
	endif;


	// Take note that the priority is 90, while the custom background's priority is 100.
	// This is essential so that it's echoed before the custom backgorund and the user can override the pattern option.
	add_action('wp_head', 'ci_bg_pattern', 90);
	if( !function_exists('ci_bg_pattern') ):
	function ci_bg_pattern()
	{ 
		?>
		<style type="text/css">
			body{
				<?php
					if (ci_setting('bg_pattern')!='none')
					{
						echo 'background-image: url(' . get_child_or_parent_file_uri('/images/patterns/'.ci_setting('bg_pattern').'.png') . ');';
					}
					else
					{
						echo 'background-image: none;';					
					}
				?>
			}
		</style>
		<?php 
	}
	endif;

?>
<?php else: ?>

	<?php load_panel_snippet('color_scheme'); ?>

	<fieldset class="set">
		<p class="guide"><?php _e('Select a background pattern. This appears below the background image that you can set in the <b>Custom Background</b> options below.', 'ci_theme'); ?></p>
		<fieldset class="mb10">
			<?php 
				$bg_patterns = array(
					'none' => _x('No pattern', 'background pattern name', 'ci_theme'),
					'diagonal' => _x('Diagonal (Dark)', 'background pattern name', 'ci_theme'),
					'black_mamba' => _x('Black Mamba (Dark)', 'background pattern name', 'ci_theme'),
					'dark_dotted2' => _x('Dark Dotted', 'background pattern name', 'ci_theme'),
					'dark_geometric' => _x('Dark Geometric', 'background pattern name', 'ci_theme'),
					'rebel' => _x('Rebel (Dark)', 'background pattern name', 'ci_theme'),
					'hexabump' => _x('Hexabump (Dark)', 'background pattern name', 'ci_theme'),
					'wild_olive' => _x('Wild Oliva (Dark)', 'background pattern name', 'ci_theme'),
					'escheresque_ste' => _x('Escheresque Ste (Dark)', 'background pattern name', 'ci_theme'),
					'grey_wash_wall' => _x('Grey Wash Wall (Dark)', 'background pattern name', 'ci_theme'),
					'arches' => _x('Arches', 'background pattern name', 'ci_theme'),
					'clean_textile' => _x('Clean Textile', 'background pattern name', 'ci_theme'),
					'daimond_eyes' => _x('Diamond Eyes', 'background pattern name', 'ci_theme'),
					'frenchstucco' => _x('French Stucco', 'background pattern name', 'ci_theme'),
					'furley_bg' => _x('Furley', 'background pattern name', 'ci_theme'),
					'light_wool' => _x('Light Wool', 'background pattern name', 'ci_theme'),
					'plaid' => _x('Plaid', 'background pattern name', 'ci_theme'),
					'stacked_circles' => _x('Stacked Circles', 'background pattern name', 'ci_theme'),
					'tapestry' => _x('Tapestry', 'background pattern name', 'ci_theme'),
					'white_brick_wall' => _x('White Brick Wall', 'background pattern name', 'ci_theme')
				);
				ci_panel_dropdown('bg_pattern', $bg_patterns, __('Background pattern', 'ci_theme')); 
			?>
		</fieldset>
	</fieldset>

	<?php load_panel_snippet('custom_background'); ?>

<?php endif; ?>
