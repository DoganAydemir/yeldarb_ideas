<div class="sidebar three columns">
<?php
	if ( woocommerce_enabled() ) {
		if ( is_woocommerce() ) {
			dynamic_sidebar('eshop-sidebar');
		} else if ( is_page() ) {
			dynamic_sidebar('pages-sidebar');
		} else {
			dynamic_sidebar('blog-sidebar');
		}
	} else {
		if ( is_page() ) {
			dynamic_sidebar('pages-sidebar');
		} else {
			dynamic_sidebar('blog-sidebar');
		}
	}
?>
</div> <!-- .sidebar -->
