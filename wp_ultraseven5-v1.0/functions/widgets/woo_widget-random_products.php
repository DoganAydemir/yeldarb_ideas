<?php
if(class_exists('WC_Widget_Random_Products')):
if( !class_exists('CI_WC_Widget_Random_Products') ):
class CI_WC_Widget_Random_Products extends WC_Widget_Random_Products {
	function __construct() {
		parent::__construct();
	}

	function widget( $args, $instance ) {
		global $woocommerce;

		extract($args);

		// Use default title as fallback
		$title = ( '' === $instance['title'] ) ? __('Random Products', 'ci_theme' ) : $instance['title'];
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		// Setup product query
		$query_args = array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => $instance['number'],
			'orderby'        => 'rand',
			'no_found_rows'  => 1
		);

		$query_args['meta_query'] = array();

		if ( ! $instance['show_variations'] ) {
			$query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
			$query_args['post_parent'] = 0;
		}

	    $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
	    $query_args['meta_query']   = array_filter( $query_args['meta_query'] );

		$query = new WP_Query( $query_args );

		if ( $query->have_posts() ) {
			echo $args['before_widget'];

			if ( '' !== $title ) {
				echo $args['before_title'], $title, $args['after_title'];
			}

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
					<?php while ($query->have_posts()) : $query->the_post(); ?>
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
					<?php while ($query->have_posts()) : $query->the_post(); global $product; ?>
						<li>
							<a href="<?php the_permalink() ?>">
								<?php
									if ( has_post_thumbnail() )
										the_post_thumbnail( 'shop_thumbnail' );
									else
										echo woocommerce_placeholder_img( 'shop_thumbnail' );
								?>
								<?php the_title() ?>
							</a>
							<?php echo $product->get_price_html() ?>
						</li>
					<?php endwhile; ?>
				</ul>
				<?php
			}

			echo $args['after_widget'];
		}
	}

}
endif; //!class_exists
endif; //class_exists
?>
