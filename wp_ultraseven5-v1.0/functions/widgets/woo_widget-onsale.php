<?php
if(class_exists('WC_Widget_Onsale')):
if( !class_exists('CI_WC_Widget_Onsale') ):
class CI_WC_Widget_Onsale extends WC_Widget_Onsale {

	function __construct() {
		parent::__construct();
	}

	function widget( $args, $instance ) {
		global $wp_query, $woocommerce;

		$cache = wp_cache_get('widget_onsale', 'widget');

		if ( !is_array($cache) ) $cache = array();

		if ( isset($cache[$args['widget_id']]) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('On Sale', 'ci_theme' ) : $instance['title'], $instance, $this->id_base);
		if ( !$number = (int) $instance['number'] )
			$number = 10;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 15 )
			$number = 15;

		// Get products on sale
		$product_ids_on_sale = woocommerce_get_product_ids_on_sale();
		$product_ids_on_sale[] = 0;

		$meta_query = $woocommerce->query->get_meta_query();

    	$query_args = array(
    		'posts_per_page' 	=> $number,
    		'no_found_rows' => 1,
    		'post_status' 	=> 'publish',
    		'post_type' 	=> 'product',
    		'orderby' 		=> 'date',
    		'order' 		=> 'ASC',
    		'meta_query' 	=> $meta_query,
    		'post__in'		=> $product_ids_on_sale
    	);

		$r = new WP_Query($query_args);

		if ( $r->have_posts() ) {

			echo $before_widget;

			if ( $title )
				echo $before_title . $title . $after_title;

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
				echo '<ul class="product_list_widget">';
	
				while ( $r->have_posts() ) {
					$r->the_post();
					global $product;
	
					echo '<li>
						<a href="' . get_permalink() . '">
							' . ( has_post_thumbnail() ? get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ) : woocommerce_placeholder_img( 'shop_thumbnail' ) ) . ' ' . get_the_title() . '
						</a> ' . $product->get_price_html() . '
					</li>';
				}
	
				echo '</ul>';
			}

			echo $after_widget;
		}

		$content = ob_get_clean();

		if ( isset( $args['widget_id'] ) ) $cache[$args['widget_id']] = $content;

		echo $content;

		wp_cache_set('widget_onsale', $cache, 'widget');
	}


	function awidget($args, $instance) {
		global $wp_query, $woocommerce;
		
		$cache = wp_cache_get('widget_onsale', 'widget');

		if ( !is_array($cache) ) $cache = array();

		if ( isset($cache[$args['widget_id']]) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract($args);
		
		$title = apply_filters('widget_title', empty($instance['title']) ? __('On Sale', 'ci_theme') : $instance['title'], $instance, $this->id_base);
		if ( !$number = (int) $instance['number'] )
			$number = 10;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 15 )
			$number = 15;

		// Get products on sale
		if ( false === ( $product_ids_on_sale = get_transient( 'wc_products_onsale' ) ) ) :
		
			$meta_query = array();
		    $meta_query[] = array(
		    	'key' => '_sale_price',
		        'value' 	=> 0,
				'compare' 	=> '>',
				'type'		=> 'NUMERIC'
		    );
	
			$on_sale = get_posts(array(
				'post_type' 		=> array('product', 'product_variation'),
				'posts_per_page' 	=> -1,
				'post_status' 		=> 'publish',
				'meta_query' 		=> $meta_query,
				'fields' 			=> 'id=>parent'
			));
			
			$product_ids_on_sale = array_unique(array_merge(array_values($on_sale), array_keys($on_sale)));
			
			set_transient( 'wc_products_onsale', $product_ids_on_sale );
					
		endif;
		
		$product_ids_on_sale[] = 0;
		
		$meta_query = array();
		$meta_query[] = $woocommerce->query->visibility_meta_query();
	    $meta_query[] = $woocommerce->query->stock_status_meta_query();
		    
    	$query_args = array(
    		'posts_per_page' 	=> $number, 
    		'no_found_rows' => 1,
    		'post_status' 	=> 'publish', 
    		'post_type' 	=> 'product',
    		'orderby' 		=> 'rand',
    		'meta_query' 	=> $meta_query,
    		'post__in'		=> $product_ids_on_sale
    	);

		$r = new WP_Query($query_args);
		
		if ($r->have_posts()) :
?>
			<?php echo $before_widget; ?>
			<?php if ( $title ) echo $before_title . $title . $after_title; ?>
	
			<?php global $post; ?>
			<?php if($id=='front-page-widgets' or $id=='eshop-front-page-widgets'): ?>
	
				<div class="s-content group">
					<ul class="entry-list group">
						<?php while ($r->have_posts()) : $r->the_post(); global $product; ?>
							<li>
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
							
								<div class="entry-meta">
									<?php echo get_the_term_list($post->ID, 'product_cat', '', ', ', ''); ?>
								</div>
								<span class="price">
									<?php echo $product->get_price_html(); ?>
								</span>			
								<?php woocommerce_show_product_loop_sale_flash(); ?>
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>	
							</li>
						<?php endwhile; ?>
					</ul>
				</div>

			<?php else: ?>

				<ul class="product_list_widget">
				<?php  while ($r->have_posts()) : $r->the_post(); global $product; ?>
				<li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
					<?php if (has_post_thumbnail()) the_post_thumbnail('shop_thumbnail'); else echo '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="'.$woocommerce->get_image_size('shop_thumbnail_image_width').'" height="'.$woocommerce->get_image_size('shop_thumbnail_image_height').'" />'; ?>
					<?php if ( get_the_title() ) the_title(); else the_ID(); ?>
				</a> <?php echo $product->get_price_html(); ?></li>
				<?php endwhile; ?>
				</ul>

			<?php endif; ?>	
	
			<?php echo $after_widget; ?>
<?php
		endif;

		wp_reset_query();

		if (isset($args['widget_id']) && isset($cache[$args['widget_id']])) $cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_onsale', $cache, 'widget');
	}
} 
endif; //!class_exists
endif; //class_exists
?>
