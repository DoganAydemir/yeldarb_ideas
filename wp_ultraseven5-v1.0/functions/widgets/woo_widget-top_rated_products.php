<?php
if(class_exists('WC_Widget_Top_Rated_Products')):
if( !class_exists('CI_WC_Widget_Top_Rated_Products') ):
class CI_WC_Widget_Top_Rated_Products extends WC_Widget_Top_Rated_Products {
	
	function __construct() {
		parent::__construct();
	}

	function widget($args, $instance) {
		global $woocommerce;

		$cache = wp_cache_get('widget_top_rated_products', 'widget');

		if ( !is_array($cache) ) $cache = array();

		if ( isset($cache[$args['widget_id']]) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Top Rated Products', 'ci_theme' ) : $instance['title'], $instance, $this->id_base);

		if ( !$number = (int) $instance['number'] ) $number = 10;
		else if ( $number < 1 ) $number = 1;
		else if ( $number > 15 ) $number = 15;

		add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );

		$query_args = array('posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product' );

		$query_args['meta_query'] = $woocommerce->query->get_meta_query();

		$top_rated_posts = new WP_Query( $query_args );

		if ($top_rated_posts->have_posts()) :

			echo $before_widget;

			if ( $title ) echo $before_title . $title . $after_title;

			if($id=='front-page-1' or $id=='front-page-2' or $id=="front-page-3")	{
				global $post, $product;
				?>
				<?php
				$product_cols = ci_setting('product_columns');
				switch ( $product_cols ) {
					case 2 :
						$cols = 'six';
						break;
					case 3 :
						$cols = 'four';
						break;
					case 4 :
						$cols = 'three';
						break;
					case 5 :
						$cols = 'five-col';
						break;
					case 6 :
						$cols = 'two';
						break;
					default :
						$cols = 'three';
				}
				?>
				<div class="product-list row">
					<?php while ($r->have_posts()) : $r->the_post(); ?>
						<div class="product-item <?php echo $cols; ?> mobile-two columns">

							<?php
							// get the product attachments so that we can bring the second attached image
							global $product;
							$attachment_ids = $product->get_gallery_attachment_ids();

							?>

							<div class="product-thumb">
								<a href="<?php the_permalink(); ?>">

									<?php if ( $attachment_ids ) : $i = 0; ?>
										<div class="main-thumb">
											<?php echo get_the_post_thumbnail( $post->ID, 'shop_catalog') ?>
										</div>

										<div class="secondary-thumb">
											<?php
											foreach ( $attachment_ids as $attachment ) :

												// Make sure we don't get the featured image again in case someone also puts it in the product gallery
												if ( get_post_thumbnail_id($post->ID) !== $attachment ) {
													$i++;
													echo wp_get_attachment_image( $attachment, 'shop_catalog', false );
												} else {
													$i = 0;
												}
												if ($i == 1) break;

											endforeach;
											?>
										</div>
									<?php else: ?>
										<div class="main-thumb noflip">
											<?php echo get_the_post_thumbnail( $post->ID, 'shop_catalog') ?>
										</div>
									<?php endif; ?>

								</a>
							</div>

							<div class="product-info">
								<p class="product-cats"><?php echo get_the_term_list($post->ID, 'product_cat', '', ', ', ''); ?></p>
								<h4 class="product-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							</div>

							<?php woocommerce_template_loop_price(); ?>
							<?php woocommerce_show_product_loop_sale_flash(); ?>
						</div>
					<?php endwhile; ?>
				</div>
			<?php
			}
			else
			{
				?>
				<ul class="product_list_widget">
					<?php while ($top_rated_posts->have_posts()) : $top_rated_posts->the_post(); global $product;
					?>
					<li><a href="<?php echo esc_url( get_permalink( $top_rated_posts->post->ID ) ); ?>" title="<?php echo esc_attr($top_rated_posts->post->post_title ? $top_rated_posts->post->post_title : $top_rated_posts->post->ID); ?>">
						<?php echo $product->get_image(); ?>
						<?php if ( $top_rated_posts->post->post_title ) echo get_the_title( $top_rated_posts->post->ID ); else echo $top_rated_posts->post->ID; ?>
					</a> <?php echo $product->get_rating_html(); ?><?php echo $product->get_price_html(); ?></li>

					<?php endwhile; ?>
				</ul>
				<?php
			}

			echo $after_widget;
		endif;

		wp_reset_query();
		remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_rating_post_clauses' ) );

		$content = ob_get_clean();

		if ( isset( $args['widget_id'] ) ) $cache[$args['widget_id']] = $content;

		echo $content;

		wp_cache_set('widget_top_rated_products', $cache, 'widget');
	}

}
endif; //!class_exists
endif; //class_exists
?>
