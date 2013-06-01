<?php
if( !class_exists('CI_OfferBox') ):
	class CI_OfferBox extends WP_Widget {

		function CI_OfferBox() {
			$widget_ops = array('description' => __('Displays an Offer Box', 'ci_theme'));
			$control_ops = array('width' => 300, 'height' => 400);
			parent::WP_Widget('ci_offer_box_widget', $name='-= CI Offer Box =-', $widget_ops, $control_ops);
		}

		function widget($args, $instance) {

			extract($args);
			$ci_title = apply_filters( 'widget_title', empty( $instance['ci_title'] ) ? '' : $instance['ci_title'], $instance, $this->id_base );

			$url = esc_attr($instance['url']);
			$button_text = $instance['button_text'];
			$text = $instance['text'];

			echo $before_widget;
			echo
				'<section class="promo">'.
				'<h1><a href="' . esc_attr($url) . '">' . $ci_title . '</a></h1>'.
				'<p>' . $text . '</p>'.
				'<a class="view-btn" href="' . esc_attr($url) . '"><span>' . $button_text . '</span></a>'.
				'</section>';
			echo $after_widget;


		} // widget

		function update($new_instance, $old_instance){
			$instance = $old_instance;
			$instance['ci_title'] = stripslashes($new_instance['ci_title']);
			$instance['url'] = esc_attr($new_instance['url']);
			$instance['button_text'] = stripslashes($new_instance['button_text']);
			$instance['text'] = stripslashes($new_instance['text']);

			return $instance;
		} // save

		function form($instance){

			$instance = wp_parse_args( (array) $instance, array('ci_title' => '', 'url' => '', 'button_text' => 'View Offer', 'text' => ''));

			$ci_title = htmlspecialchars($instance['ci_title']);
			$url = esc_attr($instance['url']);
			$button_text = stripslashes($instance['button_text']);
			$text = stripslashes($instance['text']);

			echo '<p><label>' . __('Title', 'ci_theme') . '</label><input id="' . $this->get_field_id('ci_title') . '" name="' . $this->get_field_name('ci_title') . '" type="text" value="' . $ci_title . '" class="widefat" /></p>';
			echo '<p><label>' . __('URL (with http:// in front):', 'ci_theme') . '</label><input id="' . $this->get_field_id('url') . '" name="' . $this->get_field_name('url') . '" type="text" value="' . esc_attr($url) . '" class="widefat" /></p>';
			echo '<p><label>' . __('Button Text', 'ci_theme') . '</label><input id="' . $this->get_field_id('button_text') . '" name="' . $this->get_field_name('button_text') . '" type="text" value="' . $button_text . '" class="widefat" /></p>';
			echo '<textarea class="widefat" rows="16" cols="20" id="' . $this->get_field_id('text') . '" name="' .  $this->get_field_name('text') . '">' .  $text . '</textarea>';


		} // form

	} // class


	register_widget('CI_OfferBox');

endif; //class_exists

?>
