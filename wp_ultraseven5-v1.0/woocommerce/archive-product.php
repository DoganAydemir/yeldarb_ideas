<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('shop'); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action('woocommerce_before_main_content');
	?>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

	<div class="main-content nine columns">
		<h1 class="section-title"><span><?php woocommerce_page_title(); ?></span></h1>

		<div class="shop-actions group">
			<div class="actions group">
			<div class="result-count">
				<?php woocommerce_get_template( 'loop/result-count.php' ); ?>
			</div>

			<div class="product-number">
				<span><?php _e('View:', 'ci_theme'); ?></span>
				<a href="?view=<?php ci_e_setting('eshop_products_view_first'); ?>"><?php ci_e_setting('eshop_products_view_first'); ?></a>
				<a href="?view=<?php ci_e_setting('eshop_products_view_second'); ?>"><?php ci_e_setting('eshop_products_view_second'); ?></a>


				<?php if ( ci_setting('eshop_products_view_all') ) : ?>
				<a href="?view=-1"><?php _e('All', 'ci_theme'); ?></a>
				<?php endif; ?>
			</div>
			</div>

			<?php	do_action( 'woocommerce_before_shop_loop' ); ?>
		</div>
		<div class="row">

		<div class="twelve columns">
		<?php do_action( 'woocommerce_archive_description' ); ?>
		</div>

	<div class="product-list group">

		<?php endif; ?>

				<?php
					/**
					 * woocommerce_before_shop_loop hook
					 *
					 * @hooked woocommerce_catalog_ordering - 30
					 */
				?>

				<?php if ( have_posts() ) : ?>
		
					<?php woocommerce_product_loop_start(); ?>
		
						<?php woocommerce_product_subcategories(); ?>
		
						<?php while ( have_posts() ) : the_post(); ?>
		
							<?php woocommerce_get_template_part( 'content', 'product' ); ?>
		
						<?php endwhile; // end of the loop. ?>
		
					<?php woocommerce_product_loop_end(); ?>
		
				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
		
					<?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>
		
				<?php endif; ?>
					</div>
				</div>
					<?php
					/**
					 * woocommerce_after_shop_loop hook
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
					?>
			</div>
			<?php
				/**
				 * woocommerce_sidebar hook
				 *
				 * @hooked woocommerce_get_sidebar - 10
				 */
				do_action('woocommerce_sidebar');
			?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
	?>


<?php get_footer('shop'); ?>
