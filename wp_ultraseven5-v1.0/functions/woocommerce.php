<?php if(woocommerce_enabled()):

	// Skip the default woocommerce styling and use our boilerplate.
	define('WOOCOMMERCE_USE_CSS', false);
	
	add_action( 'wp_enqueue_scripts', 'ci_woocommerce_boilerplate', 9 );
	if( !function_exists('ci_woocommerce_boilerplate') ):
	function ci_woocommerce_boilerplate()
	{
		// Skip the default woocommerce styling and use our boilerplate.
		wp_enqueue_style('ci-woocommerce', get_child_or_parent_file_uri('/css/ci_woocommerce.css'));
	}
	endif;


	// Change number of columns in product loop
	add_filter('loop_shop_columns', 'ci_loop_show_columns');
	if( !function_exists('ci_loop_show_columns') ):
	function ci_loop_show_columns() {
		return ci_setting('product_columns');
	}
	endif;

	// Override the related products function so that it outputs the right number of products and columns
	if ( !function_exists( 'woocommerce_output_related_products' ) ):
	function woocommerce_output_related_products() {
		woocommerce_related_products( 4, 4 );
	}
	endif;


	// Change the markup of the woocommerce_breadcrumb() function.
	// This way we won't need to pass parameters and we can keep the original hooks.
	add_filter('woocommerce_breadcrumb_defaults', 'ci_woocommerce_breadcrumb_defaults');
	if( !function_exists('ci_woocommerce_breadcrumb_defaults') ):
	function ci_woocommerce_breadcrumb_defaults($defaults)
	{
		// Only change what we need changed.
		$defaults['delimiter'] = ' > ';
		$defaults['wrap_before'] = '<div id="breadcrumb">';
		$defaults['wrap_after'] = '</div>';
		return $defaults;
	}
	endif;



	/*
	 * Unhook the following functions as they are either not needed, or needed in a place where a hook is not available
	 * therefore called directly from the template files.
	 */

	// Remove result count, e.g. "Showing 1–10 of 22 results"
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

	// We don't need the Rating and Add to Cart button.
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	//remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

	// Move thumbnail from woocommerce_before_shop_loop_item_title to woocommerce_before_shop_loop_item hook
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_thumbnail', 10 );

	// Remove price hook. We need it before the title, but outside the wrapping <a> element, so we call it manually.
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

	// We don't need the coupon form in the checkout page. It's included in the cart page.
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );



	// Override the product thumbnail hooked function, as we just want change its output.
	if ( !function_exists( 'woocommerce_template_loop_product_thumbnail' ) ):
	function woocommerce_template_loop_product_thumbnail() {
		?>
		<a href="<?php the_permalink(); ?>">
			<?php echo woocommerce_get_product_thumbnail(); ?>
		</a>
		<?php
	}
	endif;

	// Override the category thumbnail hooked function, as we want change its output and it doesn't provide any hooks/filters.
	if ( !function_exists( 'woocommerce_subcategory_thumbnail' ) ):
	function woocommerce_subcategory_thumbnail( $category ) {
		global $woocommerce;

		$small_thumbnail_size  	= apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' );
		$dimensions    			= $woocommerce->get_image_size( $small_thumbnail_size );
		$thumbnail_id  			= get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size  );
			$image = $image[0];
		} else {
			$image = woocommerce_placeholder_img_src();
		}

		if ( $image )
		{
			?>
			<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
				<?php echo '<img src="' . $image . '" alt="' . $category->name . '" />'; ?>
			</a>
			<?php
		}
	}
	endif;

	// Replace the default placeholder image with ours (it has the right dimentions).
	add_filter('woocommerce_placeholder_img_src', 'ci_change_woocommerce_placeholder_img_src');
	if ( !function_exists( 'ci_change_woocommerce_placeholder_img_src' ) ):
	function ci_change_woocommerce_placeholder_img_src($src)
	{
		return get_child_or_parent_file_uri('/images/placeholder.png');
	}
	endif;
	
	add_filter('woocommerce_placeholder_img', 'ci_woocommerce_placeholder_img');
	if ( !function_exists( 'ci_woocommerce_placeholder_img' ) ):
	function ci_woocommerce_placeholder_img($html)
	{
		$html = preg_replace('/width="[[:alnum:]%]*"/', '', $html);
		$html = preg_replace('/height="[[:alnum:]%]*"/', '', $html);
		return $html;
	}
	endif;


	// De-register the widgets that WooCommerce provides, and register ours.
	// We can't just remove_action() as the original classes are included from $woocommerce->register_widgets()
	// so the original classes wil be unavailable, and we need them.
	add_action('widgets_init', 'ci_woocommerce_register_widgets');
	if( !function_exists('ci_woocommerce_register_widgets') ):
	function ci_woocommerce_register_widgets()
	{
		// Check that this kind of widgets exists, (WooCommerce >= 2.0)
		// Otherwise this fails miserably (fatal error).
		if( !class_exists('WC_Widget_Best_Sellers') ) return;
		
		// Register the widgets that extend the original WooCommerce widgets.
		unregister_widget('WC_Widget_Best_Sellers');
		register_widget('CI_WC_Widget_Best_Sellers');
		
		unregister_widget('WC_Widget_Recent_Products');
		register_widget('CI_WC_Widget_Recent_Products');

		unregister_widget('WC_Widget_Recently_Viewed');
		register_widget('CI_WC_Widget_Recently_Viewed');

		unregister_widget('WC_Widget_Featured_Products');
		register_widget('CI_WC_Widget_Featured_Products');

		unregister_widget('WC_Widget_Onsale');
		register_widget('CI_WC_Widget_Onsale');

		unregister_widget('WC_Widget_Random_Products');
		register_widget('CI_WC_Widget_Random_Products');

		unregister_widget('WC_Widget_Recent_Reviews');
		register_widget('CI_WC_Widget_Recent_Reviews');

		unregister_widget('WC_Widget_Top_Rated_Products');
		register_widget('CI_WC_Widget_Top_Rated_Products');

		unregister_widget('WC_Widget_Product_Search');
		register_widget('CI_WC_Widget_Product_Search');

		unregister_widget('WC_Widget_Product_Tag_Cloud');
		register_widget('CI_WC_Widget_Product_Tag_Cloud');
	}
	endif;


	/*
	 * Allow users to view more products on shop pages.
	 */
	if ( isset($_GET['view']) ) {
		add_filter( 'loop_shop_per_page', create_function( '$cols', 'return intval($_GET["view"]);' ) );
	}

endif; // woocommerce_enabled() ?>
