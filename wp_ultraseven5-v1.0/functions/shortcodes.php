<?php
/**
 * Theme Specific Shortcodes.
 *
 * @version		1.0.0
 * @package		functions/
 * @category	Shortcodes
 * @author 		CSSIgniter
 */

/**
 * Used to output a shortcode without executing it.
 *
 * @access public
 * @param array $atts
 * @return string
 */

if ( !function_exists('ci_shortcode') ) {
	function ci_shortcode($atts, $content = null ) {
		return '<code>' . $content .  '</code>';
	}

	add_shortcode('ci_shortcode', 'ci_shortcode');
} // function_exists('ci_shortcode')


/**
 * Outputs <div class="row"></div> container
 *
 * @access public
 * @param array $atts
 * @return string
 */

if ( !function_exists('ci_row') ) {
	function ci_row($atts, $content = null ) {
		return '<div class="row">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('ci_row', 'ci_row');
} // function_exists('ci_row')

/**
 * Outputs <div class="row"></div> container, second level
 *
 * @access public
 * @param array $atts
 * @return string
 */

if ( !function_exists('ci_row2') ) {
	function ci_row2($atts, $content = null ) {
		return '<div class="row">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('ci_row2', 'ci_row2');
} // function_exists('ci_row2')

/**
 * Outputs <div class="row"></div> container third level
 *
 * @access public
 * @param array $atts
 * @return string
 */

if ( !function_exists('ci_row3') ) {
	function ci_row3($atts, $content = null ) {
		return '<div class="row">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('ci_row3', 'ci_row3');
} // function_exists('ci_row3')

/**
 * Outputs columns markup
 *
 * @access public
 * @param array $atts
 * @return string
 */

if ( !function_exists('ci_column') ) {
	function ci_column($atts, $content = null ) {

		extract(shortcode_atts(
			array(
				'span' => '',
				'mobile_span' => ''
			), $atts ));

		return '<div class="'. $span . ' ' . $mobile_span . ' columns">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('ci_column', 'ci_column');
} // function_exists('ci_column')


/**
 * Outputs fancy titles
 *
 * @access public
 * @param array $atts
 * @return string
 */

if ( !function_exists('ci_big_title') ) {
	function ci_big_title( $atts, $content = null ) {

		return '<h3 class="section-title"><span>' . $content . '</span></h3>';
	}
	add_shortcode('ci_big_title', 'ci_big_title');
} // function_exists('ci_big_title')


/**
 * Outputs offer box row
 *
 * @access public
 * @param array $atts
 * @return string
 */

if ( !function_exists('ci_offer') ) {
	function ci_offer( $atts, $content = null ) {

		extract(shortcode_atts(
			array(
				'url' => '',
				'title' => '',
				'button_text' => 'View Offer'
			), $atts ));

		return
		'<section class="promo">'.
		'<h1><a href="' . esc_attr($url) . '">' . $title . '</a></h1>'.
		'<p>' . do_shortcode($content) . '</p>'.
		'<a class="view-btn" href="' . esc_attr($url) . '"><span>' . $button_text . '</span></a>'.
		'</section>';
	}

	add_shortcode('ci_offer', 'ci_offer');
} // function_exists('ci_offer')

/**
 * Outputs latest articles
 *
 * @access public
 * @param array $atts
 * @return string
 */

if ( !function_exists('ci_from_blog') ) {
	function ci_from_blog($atts, $content = null ) {

		extract(shortcode_atts(
			array(
				'posts' => '4',
				'title' => '',
				'columns' => '4'
			), $atts ));

		if ( $columns == '4' )  {
			$cols = 'three';
		} elseif ( $columns = '3' ) {
			$cols = 'four';
		} elseif ( $columns = '5' ) {
			$cols = 'five-col';
		} elseif ( $columns = '2' ) {
			$cols = 'six';
		} elseif ( $columns = '6' ) {
			$cols = 'two';
		} else {
			$cols = 'three';
		}

		$args = array (
			'post_type' => 'post',
			'posts_per_page' => $posts,
			'no_found_rows' => true,
			'post_status' => 'publish',
			'ignore_sticky_posts' => true
		);

		$r = new WP_Query($args);

		if ( $r->have_posts() ) :
		if ( !empty($title) ) :
			$output = '<h3 class="section-title"><span>' . $title . '</span></h3><div class="row news-hold">';
		endif;
			while ( $r-> have_posts() ) : $r->the_post();
				$output .=
					'<article class="entry ' . $cols . ' columns group">'.
					'<figure class="entry-thumb">'.
					'<a href="' . get_permalink() . '">' . get_the_post_thumbnail($post->ID, "blog_col_thumb") . '</a>'.
					'</figure>'.
					'<div class="entry-content">'.
					'<p class="entry-cats">' . get_the_category_list(', ') . '</p>'.
					'<h1 class="entry-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h1>'.
					'<time datetime="' . esc_attr(get_the_date('Y-m-d')) . '">' . get_the_date() . '</time>' . get_the_excerpt() .
					'</div>'.
					'</article>';
			endwhile;
		$output .= '</div>';
		endif;
		wp_reset_postdata();
		return $output;
	}
	add_shortcode('ci_from_blog', 'ci_from_blog');
} // function_exists('ci_from_blog')


/**
 * Outputs a FlexSlider slider.
 *
 * @access public
 * @param array $atts
 * @return string
 */

if ( !function_exists('ci_slider') ) {
	function ci_slider( $atts, $content = null ) {

		extract(shortcode_atts(
			array(
				'posts' => array()
			), $atts ));

		if ( isset( $atts[ 'posts' ] ) ) {
			$posts = explode( ',', $atts[ 'posts' ] );
			$posts = array_map( 'trim', $posts );
		} else {
			$posts = array();
		}

		global $post;

		$sld_q = new WP_Query( array(
			'post_type'=> array('cpt_slider', 'post'),
			'posts_per_page' => -1,
			'post__in' => $posts
		));

		if ( $sld_q->have_posts() ) :
			$output =
				'<div class="home-slider flexslider">'.
					'<ul class="slides">';
						while ( $sld_q->have_posts() ) : $sld_q->the_post();
					$output .=
							'<li>'.
								'<div class="slide-container">'.
									get_the_post_thumbnail($post->ID, 'homepage_slider').
									'<div class="slide-content">';
										if ( post_custom('ci_cpt_slider_url') ) {
											$permalink = post_custom('ci_cpt_slider_url');
										} else {
											$permalink = get_permalink();
										}
							$output .=
										'<h2 class="slide-title"><a href="'. $permalink.'">'.get_the_title().'</a></h2>'
										.'<p>' . get_the_excerpt() . '</p>' .
										'<ul class="flex-direction-nav">
											<li><a class="flex-prev" href="#"></a></li>
											<li><a class="flex-next" href="#"></a></li>
										</ul>
									</div>
								</div>
							</li>';
						endwhile;
						wp_reset_postdata();
					$output .=
					'</ul>
			</div>';
			return $output;
		else :
			return '';
		endif; // endif slider have_posts()
	}
	add_shortcode('ci_slider', 'ci_slider');
} // function_exists('ci_big_title')


/**
 * Outputs a line separator
 *
 * @access public
 * @param array $atts
 * @return string
 */

if ( !function_exists('ci_separator') ) {
	function ci_separator($atts, $content = null ) {
		return '<div class="ci_separator"></div>';
	}

	add_shortcode('ci_separator', 'ci_separator');
} // function_exists('ci_separator')
