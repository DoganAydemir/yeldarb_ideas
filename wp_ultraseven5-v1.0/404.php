<?php get_header (); ?>

<div class="main-content nine columns">
		<article class="entry group">
			<h1 class="section-title">
				<span>
					<?php _e('Page not found', 'ci_theme'); ?>
				</span>
			</h1>

			<div class="entry-content">
				<p><?php _e('Perhaps try searching?', 'ci_theme'); ?></p>
				<?php  get_search_form(); ?>
			</div>

		</article>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
