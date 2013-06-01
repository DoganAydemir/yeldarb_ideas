<?php get_header (); ?>

<div class="main-content nine columns blog">
	<h1 class="section-title">
		<span>
			<?php _e("From The Blog", "ci_theme"); ?>
		</span>
	</h1>

	<?php
	if ( have_posts() ) : while ( have_posts () ) : the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('entry group'); ?>>
			<?php if ( ci_has_image_to_show() ) : ?>
				<figure class="entry-thumb">
					<?php $img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
					<a href="<?php echo $img_url[0]; ?>" rel="prettyPhoto">
						<?php ci_the_post_thumbnail(); ?>
					</a>
				</figure>
			<?php endif; ?>

			<div class="entry-content group">
				<p class="entry-cats"><?php the_category(', '); ?></p>

				<h1 class="entry-title"><?php the_title(); ?></h1>

				<time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php the_date(); ?></time>

				<?php the_content(); ?>
			</div>

			<?php comments_template(); ?>
		</article>

		<?php if ( ci_setting('show_related_posts') ) : ?>
			<?php
			// Related Posts Query
			$categories = get_the_category($post->ID);
			$category_ids = array();
			foreach( $categories as $individual_category ) {
				$category_ids[] = $individual_category->term_id;
			}

			$args = array(
				'category__in' => $category_ids,
				'post__not_in' => array($post->ID),
				'showposts' => 3,
				'orderby' => 'rand',
				'caller_get_posts '=> 1
			);

			$r = new WP_Query($args);
			?>
			<?php if ( $r->have_posts() ) : ?>
				<div class="related-posts">
					<h3 class="section-title"><span><?php _e('You may also like', 'ci_theme'); ?>	</span></h3>
					<div class="row news-hold">
						<?php while ( $r->have_posts() ) : $r->the_post(); ?>
							<article class="entry four columns group">
								<figure class="entry-thumb">
									<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog_col_thumb'); ?></a>
								</figure>

								<div class="entry-content">
									<p class="entry-cats"><?php the_category(', '); ?></p>
									<h1 class="entry-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h1>
									<time datetime="<?php esc_attr(get_the_date('Y-m-d')); ?>"><?php echo get_the_date(); ?></time>
									<?php the_excerpt(); ?>
								</div>
							</article>
						<?php endwhile; wp_reset_postdata(); ?>
					</div>

				</div>
			<?php
			endif; // $r-have_posts
		endif; // show_related_posts
		?>

	<?php endwhile; endif; ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
