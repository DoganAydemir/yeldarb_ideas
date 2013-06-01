<?php if ( ci_setting('slider_type') == 'flexslider' ) : ?>

	<?php $sld_q = new WP_Query( array(
		'post_type' => array('cpt_slider', 'post'),
		'meta_key' => 'ci_post_slider',
		'meta_value' => 'slider',
		'posts_per_page' => -1
	)); ?>

	<?php if ( $sld_q->have_posts() ) : ?>
	
		<div class="home-slider flexslider">
			<ul class="slides">
			<?php while ( $sld_q->have_posts() ) : $sld_q->the_post(); ?>
				<li>
					<div class="slide-container">
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('homepage_slider'); ?></a>
						<div class="slide-content">
							<?php
							if ( post_custom('ci_cpt_slider_url') ) {
								$permalink = post_custom('ci_cpt_slider_url');
							} else {
								$permalink = get_permalink();
							}
							?>
							<h2 class="slide-title"><a href="<?php echo $permalink; ?>"><?php the_title(); ?></a></h2>
							<?php the_excerpt(); ?>
							<ul class="flex-direction-nav">
								<li><a class="flex-prev" href="#"></a></li>
								<li><a class="flex-next" href="#"></a></li>
							</ul>
						</div>
					</div>
				</li>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
			</ul>
		</div>
	
	<?php endif; // endif slider have_posts() ?>

<?php elseif ( ci_setting('slider_type') == 'revo_slider' ) : ?>

	<?php if ( function_exists('putRevSlider') and ci_setting('revo_slider_alias') ) : ?>
		 <?php putRevSlider( ci_setting('revo_slider_alias') ) ?>
	<?php else : ?>
			<div class="woocommerce-message woocommerce-error group"><?php _e('The Revolution Slider Plugin doesn\'t seem to be installed, please install and activate it!', 'ci_theme'); ?></div>
	<?php endif; // putRevSlider exists ?>

<?php else : ?>
<?php endif; // slider_type ?>
