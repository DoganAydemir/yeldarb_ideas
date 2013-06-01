<?php
/*
 * Template Name: Homepage Shortcodes Template
 */
?>

<?php get_header (); ?>

<div class="main-content twelve columns">
	<?php
	if ( have_posts() ) : while ( have_posts () ) : the_post();
		?>
		<article id="post-<?php the_ID(); ?>" class="entry group">
			<?php the_content(); ?>
		</article>

	<?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
