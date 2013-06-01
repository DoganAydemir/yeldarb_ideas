<?php
if(class_exists('WC_Widget_Product_Tag_Cloud')):
if( !class_exists('CI_WC_Widget_Product_Tag_Cloud') ):
class CI_WC_Widget_Product_Tag_Cloud extends WC_Widget_Product_Tag_Cloud {

	function __construct() {
		parent::__construct();
	}
	
	function widget( $args, $instance ) {
		extract($args);
		$current_taxonomy = $this->_get_current_taxonomy($instance);
		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			if ( 'product_tag' == $current_taxonomy ) {
				$title = __('Product Tags', 'ci_theme' );
			} else {
				$tax = get_taxonomy($current_taxonomy);
				$title = $tax->labels->name;
			}
		}
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		if($id=='front-page-widgets' or $id=='eshop-front-page-widgets' or $id=="front-page-widgets-2")
			echo '<div class="s-content group">';
		else
			echo '<div class="tagcloud">';

		wp_tag_cloud( apply_filters('woocommerce_product_tag_cloud_widget_args', array('taxonomy' => $current_taxonomy) ) );
		echo "</div>\n";
		echo $after_widget;
	}

}
endif; //!class_exists
endif; //class_exists
?>
