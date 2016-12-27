<?php 
get_header();
get_template_part('bggallery');

$sidebarId = get_post_meta(get_the_ID(), SHORTNAME . '_sidebar_id', true);

$sidebar = ($sidebarId != 'global' && $sidebarId != 'none') ? $sidebarId : false;

$sizes = array(
	'' => '32%',
	'fullwidth' => '87%',
	'half' => '48%',
	'one-third' => '32%'
);

FrontWidgets::getInstance()->add(array(
	'type' => 'SinglePost',
	'id' => 'blog',
	'options' => array(
		'selector' => '.solid_box',
		'sidebar' => $sidebar,
		'width' => $sizes[get_post_meta(get_the_ID(), SHORTNAME . '_page_layout', true)]
	)
));
?>

<div class="solid_box clearfix">
	<div class="clearfix inner">
	<?php
		if (have_posts()) :
		?>
			<div class="blog_box f_left">
				<h3 class="title3"><?php the_title();?></h3>
				<ul class="posts_list">
					<?php while (have_posts()) : the_post(); ?>
						<?php the_content();?>
					<?php endwhile;?>
				</ul>
			</div>
			<?php if($sidebar) { get_sidebar(); } ?>
		<?php  
			endif;
		?>
	</div>
</div>
<?php if(get_post_meta(get_the_ID(), SHORTNAME . '_page_custom_color_options', true)) {?>
	<style>
		.page .contact_box,
		.page .solid_box,
		.page .solid_box:after,
		.page .post_track.open:after,
		.page .ui-tabs .ui-tabs-nav li.ui-tabs-active:after
		{
			background-color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_custom_color', true);?>;
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_content_color', true);?>;
		}

		.page .widget-area .widget_tag_cloud a,
		.page .widget-area .widget_tag_cloud a{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_content_color', true);?>;
		}
		#searchform input, #searchform textarea,
		#commentform input[type="text"],
		#commentform textarea,
		.feedback input[type="text"],
		.feedback textarea,
		.widget-area textarea,
		.contactformWidget input[type="text"],
		.widget_feedburner input[type="text"],
		.widget_mailchimp input[type="text"],
		.solid_box .blog_box{
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

		.page .solid_box .blog_box h1,
		.page .solid_box .blog_box h1 a,
		.page .solid_box .blog_box h2,
		.page .solid_box .blog_box h2 a,
		.page .solid_box .blog_box h3,
		.page .solid_box .blog_box h3 a, 
		.page .solid_box .blog_box h4,
		.page .solid_box .blog_box h4 a,
		.page .solid_box .blog_box h5,
		.page .solid_box .blog_box h5 a,
		.page .solid_box .blog_box h6,
		.page .solid_box .blog_box h6 a{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_title_color', true);?>;
		}
		/*.contact_box, .solid_box, #searchform, #searchform textarea, #commentform input[type="text"], 
		#commentform textarea, .feedback input[type="text"], .feedback textarea, .widget_calendar th
		{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_content_color', true);?>;
		}*/
		
		
		.page section a,
		.page .solid_box .blog_box h4.trigger a{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_link_color', true);?>;
		}
		
		.page section a:hover,
		.page section .ui-state-active>a,
		.page section .trigger.active>a,
		.page .solid_box .blog_box h4.trigger a:hover{
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
		#wp-calendar caption,
		.widget-area .widget_rss ul li a,
		.widget-area .widget_rss ul li:hover a{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_widget_title_color', true);?>;
		}
		.widget-area .widget a,
		.widget-area .widget.widget_recent_posts a.title:hover,
		.widget-area .widget.widget_popular_posts a.title:hover{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_widget_link_color', true);?>;
		}
		
		.flickr_badge_image a:hover:after,
		.widget_popular_posts li>a:hover:after,
		.widget_recent_posts li>a:hover:after{
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
		.page .widget_search input[type="submit"]:hover,
		#wp-calendar #prev a,
		#wp-calendar #next a
		{
			background-color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_accent_on_hover', true);?>;
		}
		.widget-area #wp-calendar td#today,
		.page .widget-area li.current_page_item>a,
		.page .widget-area li.current_page_parent>a,
		.page .widget-area li.current_page_item>a:hover,
		.widget-area .custom_menu li:hover a,
		.widget-area .widget_pages li:hover a,
		.widget-area .widget_rss ul li:hover a,
		.page .widget-area li.current_page_parent>a:hover,
		.widget-area .widget_pages ul li:hover a,
		.widget-area .widget_meta ul li:hover a,
		.widget-area .widget_archive ul li:hover a{
			border-color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_accent', true);?>;
		}
		.widget-area .testimonial_author,
		.solid_box .blog_box li.wrapper:hover h3 a,
		body.search .solid_box .posts_list>li:hover h3 a{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_accent', true);?>;
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
		.page #searchform input[type="submit"], 
		.page .widget_search input[type="submit"],
		.page .pagination li a:hover, .pagination li .current,
		.page .feedback .sub_wrap,
		.solid_box .blog_box .posts_list li>figure a:hover:after,
		.widget-area .widget_rss ul li:hover a,
		body.search .solid_box .posts_list li>figure a:hover:after,
		#wp-calendar #prev a:hover,
		#wp-calendar #next a:hover
		{
			background-color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_accent', true);?>;
		}

		.page .testimonial_author{
			color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_page_accent', true);?>;
		}
		
	</style>
<?php } ?>

<?php get_footer(); ?>
