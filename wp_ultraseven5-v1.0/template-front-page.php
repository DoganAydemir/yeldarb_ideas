<?php
/*
 * Template Name: Homepage Widgetized Template
 */
?>

<?php get_header(); ?>

<div class="main-content twelve columns">
	<?php get_template_part('inc_slider'); ?>
	<?php dynamic_sidebar('front-page-1'); ?>
</div>

<?php get_footer(); ?>
