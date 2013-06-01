<?php
/*
* CI_Recent_Posts widget class
*/

if ( !class_exists('CI_Recent_Posts') ) :
class CI_Recent_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'ci_widget_recent_entries', 'description' => __( 'The most recent posts on your site', 'ci_theme') );
		parent::__construct('ci-recent-posts', __('-= CI Recent Posts =-', 'ci_theme'), $widget_ops);
		$this->alt_option_name = 'ci_widget_recent_entries';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('ci_widget_recent_entries', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('From the Blog', 'ci_theme') : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
			$number = 4;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		$columns = isset( $instance['columns'] ) ? $instance['columns'] : 4;

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

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
		if ($r->have_posts()) :
			?>
			<?php echo $before_widget; ?>
			<?php
				if ( $title ) :
			?>
			<h3 class="section-title"><span><?php echo $title; ?></span></h3>
			<?php endif; ?>

			<div class="row">
				<?php while ( $r->have_posts() ) : $r->the_post(); ?>
					<article class="entry <?php echo $cols; ?> columns group">
						<figure class="entry-thumb">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog_col_thumb'); ?></a>
						</figure>

						<div class="entry-content">
							<p class="entry-cats"><?php the_category(', '); ?></p>
							<h1 class="entry-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h1>
							<?php if ( $show_date ) : ?>
								<time datetime="<?php esc_attr(get_the_date('Y-m-d')); ?>"><?php echo get_the_date(); ?></time>
							<?php endif; ?>
							<?php the_excerpt(); ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<?php echo $after_widget; ?>
			<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('ci_widget_recent_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['columns'] = (int) $new_instance['columns'];
		$instance['show_date'] = (bool) $new_instance['show_date'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['ci_widget_recent_entries']) )
			delete_option('ci_widget_recent_entries');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('ci_widget_recent_posts', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 4;
		$columns    = isset( $instance['columns'] ) ? absint( $instance['columns'] ) : 4;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ci_theme' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'ci_theme' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><label for="<?php echo $this->get_field_id( 'columns' ); ?>"><?php _e( 'Number of columns to show (single number):', 'ci_theme' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'columns' ); ?>" name="<?php echo $this->get_field_name( 'columns' ); ?>" type="text" value="<?php echo $columns; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', 'ci_theme' ); ?></label></p>
	<?php
	}
}
	register_widget('CI_Recent_Posts');
endif;
