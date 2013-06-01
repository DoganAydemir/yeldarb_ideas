<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', ci_setting('product_columns') );

// Ensure visibility
if ( ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array('product');
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

if ( $woocommerce_loop['columns'] == 3 ) {
	$col_class = 'four';
} elseif ( $woocommerce_loop['columns'] == 4 ) {
	$col_class = 'three';
} elseif ( $woocommerce_loop['columns'] == 5 ) {
	$col_class = 'five-col';
} elseif ( $woocommerce_loop['columns'] == 6 ) {
	$col_class = 'two';
} elseif ( $woocommerce_loop['columns'] == 1 ) {
	$col_class = 'twelve';
} elseif ( $woocommerce_loop['columns'] == 2 ) {
	$col_class = 'six';
} else {
	$col_class = ' ';
}

?>

<div class="product-item <?php echo $col_class; ?> mobile-two columns <?php echo implode(' ', $classes); ?>">

	<?php
		/**
		 * woocommerce_before_shop_loop_item hook
		 *
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
	?>

	<?php
		// get the product attachments so that we can bring the second attached image
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
		<?php
		/**
		 * woocommerce_before_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		<h4 class="product-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		<?php
		/**
		 * woocommerce_after_shop_loop_item_title hook
		 *
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
		<?php woocommerce_template_loop_price(); ?>
		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

	</div>

</div>
