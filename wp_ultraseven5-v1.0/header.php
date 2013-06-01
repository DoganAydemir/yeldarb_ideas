<!doctype html>
<!--[if IE 8]> <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title><?php ci_e_title(); ?></title>

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<?php // JS files are loaded via /functions/scripts.php ?>

	<?php // CSS files are loaded via /functions/styles.php ?>

	<?php wp_head(); ?>

</head>


<body <?php body_class(); ?>>
<?php do_action('after_open_body_tag'); ?>
<?php get_template_part('inc_mobile_bar'); ?>

<div id="page">
	<div class="row">
		<header id="header" class="twelve columns">
			<div id="topnav">
				<div class="row">
					<div class="six columns">
						<?php
							wp_nav_menu( array(
								'theme_location' 	=> 'ci_top_menu',
								'fallback_cb' 		=> '',
								'container' 		=> '',
								'menu_id' 			=> '',
								'menu_class' 		=> 'top-nav'
							));
						?>
					</div>

					<div class="six columns">
						<?php if ( woocommerce_enabled() ) : ?>
							<?php global $woocommerce; ?>
							<div id="topcart">
								<span><?php _e('Shopping Bag:', 'ci_theme'); ?> <span class="topcart-price"><?php echo $woocommerce->cart->get_cart_total(); ?></span></span>
								<a class="topcart-items" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->get_cart_contents_count(), 'ci_theme'), $woocommerce->cart->get_cart_contents_count()); ?> </a>
							</div>
						<?php endif; ?>
					</div>
				</div> <!-- .row -->
			</div> <!-- #topnav -->

			<div id="logo">
				<hgroup class="<?php logo_class(); ?>">
					<?php ci_e_logo('<h1>', '</h1>'); ?>
					<?php ci_e_slogan('<h2>', '</h2>'); ?>
				</hgroup>
			</div>

			<nav id="nav">
				<div class="row">
					<div class="ten columns">
						<?php
							if(has_nav_menu('ci_main_menu'))
								wp_nav_menu( array(
									'theme_location' 	=> 'ci_main_menu',
									'fallback_cb' 		=> '',
									'container' 		=> '',
									'menu_id' 			=> 'navigation',
									'menu_class' 		=> 'sf-menu'
								));
							else
								wp_page_menu();
						?>
					</div>
					<?php dynamic_sidebar('nav-widgets'); ?>
				</div>
			</nav>
		</header>

		<section id="main" class="twelve columns">
			<div class="row">
