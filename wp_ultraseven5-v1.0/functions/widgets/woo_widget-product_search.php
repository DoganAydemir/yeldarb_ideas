<?php
if(class_exists('WC_Widget_Product_Search')):
if( !class_exists('CI_WC_Widget_Product_Search') ):
class CI_WC_Widget_Product_Search extends WC_Widget_Product_Search {

	function __construct() {
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract($args);

		$title = $instance['title'];
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		echo $before_widget;

		if ($title) echo $before_title . $title . $after_title;

		if($id=='front-page-widgets' or $id=='eshop-front-page-widgets' or $id=="front-page-widgets-2")
		{
			echo '<div class="s-content group">';
			get_product_search_form();
			echo '</div>';
		}
		else
		{
			get_product_search_form();
		}

		echo $after_widget;
	}

}
endif; //!class_exists
endif; //class_exists
?>
