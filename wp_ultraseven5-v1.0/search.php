<?php get_header (); ?>
<?php
	global $wp_query;

	$found = $wp_query->post_count > $wp_query->found_posts ? $wp_query->post_count : $wp_query->found_posts;
	$none = __('No results found. Please broaden your terms and try a different search.', 'ci_theme');
	$one = __('Just one result found. We either nailed it, or you might want to broaden your terms and try a different search.', 'ci_theme');
	$many = sprintf(__("%d results found.", 'ci_theme'), $found);
?>

<div class="main-content nine columns blog">
	<h1 class="section-title">
		<span>
			<?php _e('Search Results', 'ci_theme'); ?>
		</span>
	</h1>
	<div class="search-notice">
		<p><?php ci_e_inflect($found, $none, $one, $many); ?></p>
		<?php if($found==0) get_search_form(); ?>
	</div>

	<?php
	if ( have_posts() ) : while ( have_posts () ) : the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('entry group'); ?>>
			<?php if ( ci_has_image_to_show() ) : ?>
				<figure class="entry-thumb">
					<a href="<?php the_permalink(); ?>">
						<?php ci_the_post_thumbnail(); ?>
					</a>
				</figure>
			<?php endif; ?>

			<div class="entry-content">
				<p class="entry-cats"><?php the_category(', '); ?></p>

				<h1 class="entry-title"><a title="<?php sprintf( __('Permanent Link to: %s', 'ci_theme'), esc_attr(get_the_title()) ); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

				<time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php the_date(); ?></time>

				<?php ci_e_content(); ?>

				<a class="read-more" title="<?php sprintf( __('Permanent Link to: %s', 'ci_theme'), esc_attr(get_the_title()) ); ?>" href="<?php the_permalink(); ?>"><?php ci_e_setting('read_more_text'); ?></a>
			</div>
		</article>

	<?php endwhile; endif; ?>

	<?php ci_pagination(array(
		'container_id' => 'paging',
		'container_class' => 'group',
		'prev_text' => __('Older posts', 'ci_theme'),
		'next_text' => __('Newer posts', 'ci_theme')
	)); ?>

</div>

<?php get_sidebar(); ?>


<?php get_footer(); ?>
