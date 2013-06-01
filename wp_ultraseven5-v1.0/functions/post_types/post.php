<?php
//
// Normal Post related functions.
//
add_action('admin_init', 'ci_add_cpt_post_meta');
add_action('save_post', 'ci_update_cpt_post_meta');

if( !function_exists('ci_add_cpt_post_meta') ):
function ci_add_cpt_post_meta()
{
	add_meta_box("ci_all_formats_box", __('Slider Details', 'ci_theme'), "ci_add_all_formats_meta_box", "post", "normal", "high");
}
endif;

if( !function_exists('ci_update_cpt_post_meta') ):
function ci_update_cpt_post_meta($post_id)
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
	if (isset($_POST['post_view']) and $_POST['post_view']=='list') return;
	
	if (isset($_POST['post_type']) && $_POST['post_type'] == "post")
	{
		update_post_meta($post_id, "ci_post_slider", (isset($_POST["ci_post_slider"]) ? $_POST["ci_post_slider"] : '') );
	}
}
endif;

if( !function_exists('ci_add_all_formats_meta_box') ):
function ci_add_all_formats_meta_box(){
	global $post;
	$slider = get_post_meta($post->ID, 'ci_post_slider', true);
	?>
	<p><input type="checkbox" id="ci_post_slider" name="ci_post_slider" value="slider" <?php checked($slider, 'slider'); ?> /> <label for="ci_post_slider"><?php _e("Show this post on the homepage slider.", 'ci_theme'); ?></label></p>
	<?php
}
endif;

?>
