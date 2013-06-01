<?php
if(class_exists('WC_Widget_Recent_Reviews')):
if( !class_exists('CI_WC_Widget_Recent_Reviews') ):
class CI_WC_Widget_Recent_Reviews extends WC_Widget_Recent_Reviews {

	function __construct() {
		parent::__construct();
	}

	 function widget( $args, $instance ) {
		global $comments, $comment, $woocommerce;

		$cache = wp_cache_get('widget_recent_reviews', 'widget');

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

 		ob_start();
		extract($args);

 		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Reviews', 'ci_theme' ) : $instance['title'], $instance, $this->id_base);
		if ( ! $number = absint( $instance['number'] ) ) $number = 5;

		$comments = get_comments( array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish', 'post_type' => 'product' ) );

		if ( $comments ) {
			echo $before_widget;
			if ( $title ) echo $before_title . $title . $after_title;

			if($id=='front-page-widgets' or $id=='eshop-front-page-widgets' or $id=="front-page-widgets-2")
				echo '<div class="s-content group">
					<ul class="entry-list group">';
			else
				echo '<ul class="product_list_widget">';

			foreach ( (array) $comments as $comment) {

				$_product = get_product( $comment->comment_post_ID );

				$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

				$rating_html = $_product->get_rating_html( $rating );

				if($id=='front-page-widgets' or $id=='eshop-front-page-widgets' or $id=="front-page-widgets-2")
				{
					foreach ( (array) $comments as $comment)
					{
						// This is needed because the $product object is not set by the code above
						// and the woocommerce_show_product_loop_sale_flash() doesn't work without it.
						global $product, $post;
						$_product = get_product( $comment->comment_post_ID );
						$old_product = $product;
						$product = $_product;
						$old_post = $post;
						$post = $product->post;
						setup_postdata($post);
						?>
						<li>
							<?php echo woocommerce_get_product_thumbnail(); ?>
							<div class="entry-meta">
								<?php echo get_the_term_list($post->ID, 'product_cat', '', ', ', ''); ?> 
							</div>
							<div class="user-rating">
								<?php 
									echo $rating_html;
									printf(_x('Rated by %1$s', 'by comment author', 'ci_theme'), get_comment_author()) . '</li>';
								?>
							</div>
							<?php woocommerce_template_loop_price(); ?>
							<?php woocommerce_show_product_loop_sale_flash(); ?>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>	
						</li>
						<?php
						// Restore the previous product.
						$product = $old_product; 
						$post = $old_post;
						setup_postdata($post);
					}					
				}
				else
				{
					echo '<li><a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">';
	
					echo $_product->get_image();
	
					echo $_product->get_title().'</a>';
	
					echo $rating_html;
	
					printf( _x( 'by %1$s', 'by comment author', 'ci_theme' ), get_comment_author() ) . '</li>';
				}
			}

			echo '</ul>';

			if($id=='front-page-widgets' or $id=='eshop-front-page-widgets' or $id=="front-page-widgets-2")
				echo '</div>';

			echo $after_widget;
		}

		$content = ob_get_clean();

		if ( isset( $args['widget_id'] ) ) $cache[$args['widget_id']] = $content;

		echo $content;

		wp_cache_set('widget_recent_reviews', $cache, 'widget');
	}

}
endif; //!class_exists
endif; //class_exists
?>
