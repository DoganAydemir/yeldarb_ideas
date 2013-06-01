<?php
/*
 * Template Name: Fullwidth Page
 */
?>

<?php get_header (); ?>

<div class="main-content twelve columns">
	<?php
	if ( have_posts() ) : while ( have_posts () ) : the_post();
		?>
		<article id="post-<?php the_ID(); ?>" class="entry group">
			<h1 class="section-title">
				<span>
					<?php single_post_title();  ?>
				</span>
			</h1>

			<?php if ( ci_has_image_to_show() ) : ?>
				<figure class="entry-thumb">
					<?php $img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
					<a href="<?php echo $img_url; ?>">
						<?php ci_the_post_thumbnail(); ?>
					</a>
				</figure>
			<?php endif; ?>

			<div class="entry-content group">
				<?php ci_e_content(); ?>
			</div>

			<?php comments_template(); ?>
		</article>

	<?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
