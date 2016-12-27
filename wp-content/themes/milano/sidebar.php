<?php 
$sidebar_id = "default-sidebar";

if (is_home()) {
	$id = get_option('page_for_posts');
	if ($id != 0 && get_post_meta($id, SHORTNAME . '_sidebar_id', true) && get_post_meta($id, SHORTNAME . '_sidebar_id', true) != 'global') {
		$sidebar_id = get_post_meta($id, SHORTNAME . '_sidebar_id', true);
	} else {
		$sidebar_id = get_option(SHORTNAME . '_blog_listing_sidebar');
	}
} elseif (get_post_meta(get_the_ID(), SHORTNAME . '_sidebar_id', true) != 'global') {
	$sidebar_id = get_post_meta(get_the_ID(), SHORTNAME . '_sidebar_id', true);
} else {
	if (get_post_type() == 'th_portfolio') {
		$sidebar_id = get_option(SHORTNAME . '_portfolio_single_sidebar');
	} elseif (get_post_type() == 'post') {
		$sidebar_id = get_option(SHORTNAME . '_blog_single_sidebar');
	}
}

 ?>
	<aside id="secondary" class="widget-area wrapper" role="complementary">
			<?php dynamic_sidebar( $sidebar_id ); ?>
	</aside><!-- #secondary -->

