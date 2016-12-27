<?php
/**
 * Template Name: Contact Page
 * @package WordPress
 * @subpackage Restaurant_Theme
 */

get_header();  

$markers = get_post_meta(get_the_ID(), SHORTNAME . '_markers', true);
$sidebarId = get_post_meta(get_the_ID(), SHORTNAME . '_sidebar_id', true);

$sidebar = ($sidebarId != 'global' && $sidebarId != 'none') ? $sidebarId : false;

if (get_post_meta( get_the_ID(), '_wp_page_template', true ) == 'template-contact.php' && isset($markers['markers'])) {
	
	FrontWidgets::getInstance()->add(array(
		'type' => 'Gmap',
		'id' => 'gmap1',
		'options' => array(
			'selector' => '#slider_box',
			'retina' => get_post_meta(get_the_ID(), SHORTNAME . '_marker_img_retina', true),
			'mapType' => get_post_meta(get_the_ID(), SHORTNAME . '_map_type', true),
			'zoomWithScroll' => get_post_meta(get_the_ID(), SHORTNAME . '_zoom_with_scroll_wheel', true),
			'markerImage' => (get_post_meta(get_the_ID(), SHORTNAME . '_marker_img', true))? get_post_meta(get_the_ID(), SHORTNAME . '_marker_img', true):'//mts.googleapis.com/vt/icon/name=icons/spotlight/spotlight-poi.png'
		),
		'data' => $markers
	));
} else {
	get_template_part('bggallery');
}

$sizes = array(
	'' => '32%',
	'fullwidth' => '87%',
	'half' => '48%',
	'one-third' => '32%'
);

?>

<div class="post_track p_abs contacts">
	<script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
	<div class="post_wrap clearfix p_rel">
		<div class="f_left contact_box preview">
			<div class="inner">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php 
						$more = false;
						$preview = get_the_content(__('Read more &rarr;', 'milano'));
						$more = true; 
						$full = get_the_content();
					?>
					<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
						<h4 class="title4"><?php the_title();?></h4>
						<div class="post_description"><?php 
							if($preview != $full) {
								$more = false;
								the_content(__('Read more &rarr;', 'milano'));
							}?>
						</div>
						<div class="full_text"><?php 
							$more = true; 
							the_content();?>
						</div>
					</div>
				
				<?php endwhile; else: ?>
				
					<p><?php _e('Sorry, no posts matched your criteria.', 'milano'); ?></p>
				
				<?php endif; ?>
			</div>
		</div>
		<?php if($sidebar) { get_sidebar();}?>
		<span class="d_block p_abs close_btn"></span>
	</div>
</div>

<?php
FrontWidgets::getInstance()->add(array(
	'type' => 'SinglePost',
	'id' => 'single_post',
	'options' => array(
		'selector' => '.post_track',
		'click_area' => '.contact_box',
		'hoverSound' => '',
		'width' => $sizes[get_post_meta(get_the_ID(), SHORTNAME . '_page_layout', true)],
		'sidebar' => $sidebar,
		'keepOpen' => $full === $preview
	)
));
?>

<style>
	<?php
		if($full === $preview){
			echo '.close_btn {display:none!important}';
		}
	?>
</style>

<?php if(get_post_meta(get_the_ID(), SHORTNAME . '_page_custom_color_options', true)) {?>
	<style>
		.page .contact_box,
		.page .solid_box,
		.page .solid_box:after,
		.page .post_track.open:after,
		.post_track .widget-area .widget,
		.page .ui-tabs .ui-tabs-nav li.ui-tabs-active:after
		{
			background-color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_custom_color', true);?>;
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_content_color', true);?>;
		}

		.page .widget-area .widget_tag_cloud a,
		.page .widget-area .widget_tag_cloud a{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_content_color', true);?>;
		}
		#searchform input,
		#searchform textarea,
		#commentform input[type="text"],
		#commentform textarea,
		.feedback input[type="text"],
		.feedback textarea,
		.widget-area textarea,
		.contactformWidget input[type="text"],
		.widget_feedburner input[type="text"],
		.widget_mailchimp input[type="text"]{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_content_color', true);?>;
		}
		input::-webkit-input-placeholder{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_content_color', true);?>;
		}
		input:-moz-placeholder{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_content_color', true);?>;
		}
		textarea::-webkit-input-placeholder{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_content_color', true);?>;
		}
		textarea:-moz-placeholder{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_content_color', true);?>;
		}
		.page .contact_box h1, 
		.page .contact_box h2, 
		.page .contact_box h3, 
		.page .contact_box h4,
		.page .contact_box h5,
		.page .contact_box h6,
		.page .contact_box #reply-title{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_title_color', true);?>;
		}
		/*.contact_box, .solid_box, #searchform, #searchform textarea, #commentform input[type="text"], 
		#commentform textarea, .feedback input[type="text"], .feedback textarea, .widget_calendar th
		{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_content_color', true);?>;
		}*/
		
		
		.page section a,
		.page .solid_box .blog_box h4.trigger a,
		.page section a.more-link:hover{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_link_color', true);?>;
		}
		
		.page section a:hover,
		.page section .ui-state-active>a,
		.page section .trigger.active>a,
		.page .solid_box .blog_box h4.trigger a:hover,
		.page section a.more-link{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_link_color_on_hover', true);?>;
		}

		.widget-area .widget a:hover,
		.widget .widget-title a,
		.widget-area .widget a.title,
		.widget_menu li:hover>a,
		#today>a
		{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_widget_link_color_on_hover', true);?>;
		}
		
		.widget-area .widget-title,
		.widget-area .widget-title a,
		.widget-area .widget_menu li a,
		.widget-area .widget_menu li a:hover,
		.widget-area .widget_archive li a,
		.widget-area .widget_archive li a:hover,
		.widget-area .widget_categories a,
		.widget-area .widget_categories a:hover,
		.widget-area .widget_meta ul li a,
		.widget-area .widget_meta ul li a:hover,
		.widget-area .widget_nav_menu ul li a,
		.widget-area .widget_nav_menu ul li a:hover,
		.widget-area .widget_pages li a,
		.widget-area .widget_pages li a:hover,
		.widget-area li.current_page_item>a,
		.widget-area li.current_page_parent>a,
		.widget-area .widget_categories ul li a,
		#wp-calendar caption{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_widget_title_color', true);?>;
		}
		.widget-area .widget a,
		.widget-area .widget.widget_recent_posts a.title:hover,
		.widget-area .widget.widget_popular_posts a.title:hover{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_widget_link_color', true);?>;
		}
		
		.widget-area #searchform .sub_wrap, 
		.widget-area .widget_feedburner .sub_wrap,
		.widget-area .custom_menu li:hover a,
		.widget-area .widget_pages li:hover a,
		.widget-area .widget_tag_cloud a:hover, 
		.widget-area .widget_meta ul li:hover a,
		.widget-area .widget_categories ul li:hover a, 
		.widget-area .widget_archive ul li:hover,
		.widget-area .sub_wrap,
		.page .jp-play:hover,
		.page .jp-pause,
		.widget-area #wp-calendar td#today,
		.page .testimonials .controls a:hover,
		.page .widget-area li.current_page_item>a,
		.page .widget-area li.current_page_parent>a,
		.page .widget-area li.current_page_item>a:hover,
		.page .widget-area li.current_page_parent>a:hover,
		.page .widget-area li.menu-item.open>a,
		.page .close_btn:after,
		.page .th_contact-form .sub_wrap,
		#searchform input[type="submit"],
		.widget_search input[type="submit"],
		.page .pagination li a:hover, .pagination li .current
		{
			background-color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_accent', true);?>;
		}
		
		.page .widget-area li.current_page_item>a,
		.page .widget-area li.current_page_parent>a,
		.page .widget-area li.current_page_item>a:hover,
		.page .widget-area li.current_page_parent>a:hover,
		.page .widget-area li.menu-item.open>a,
		.widget-area .custom_menu li:hover a,
		.widget-area .widget_pages li:hover a,
		.widget-area .widget_tag_cloud a:hover, 
		.widget-area .widget_meta ul li:hover a,
		.widget-area .widget_categories ul li:hover a{
			border-color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_accent', true);?>;
		}
		.widget-area #wp-calendar td#today{
			border-color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_accent', true);?>;
		}
		.page .testimonial_author{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_accent', true);?>;
		}

		.flickr_badge_image a:after,
		.widget_popular_posts li>a:after,
		.widget_recent_posts li>a:after{
			background-color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_widget_link_color', true);?>;
		}
		
		.widget-area .widget_calendar #prev a:hover,
		.widget-area .widget_calendar #next a:hover,
		.widget-area .widget_tag_cloud a:hover,
		.widget-area #searchform .sub_wrap:after, 
		.widget-area .widget_feedburner .sub_wrap:after, 
		.widget-area .contactformWidget .sub_wrap:after,
		.widget-area .sub_wrap:after,
		.page .close_btn,
		.page .feedback .sub_wrap:after,
		.page .jp-play,
		.page .jp-play-bar,
		.page .jp-volume-bar-value,
		.page .testimonials .controls a,
		.page #searchform input[type="submit"]:hover, 
		.page .widget_search input[type="submit"]:hover
		{
			background-color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_accent_on_hover', true);?>;
		}
		
		
	</style>
<?php } ?>

<?php get_footer(); ?>
