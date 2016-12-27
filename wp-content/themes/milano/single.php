<?php
get_header();
get_template_part('bggallery');
$postId = get_the_ID();
if (have_posts()) : while (have_posts()) : the_post();

		if (get_post_meta($id, SHORTNAME . '_sidebar_id', true) && get_post_meta($id, SHORTNAME . '_sidebar_id', true) != 'global')
		{
			$sidebarOn = (get_post_meta($postId, SHORTNAME . '_sidebar_id', true) != 'none');
		}
		else
		{
			if (get_post_type() == 'th_portfolio')
			{
				$sidebarOn = get_option(SHORTNAME . '_portfolio_single_sidebar') != 'none';
			}
			if (get_post_type() == 'post')
			{
				$sidebarOn = get_option(SHORTNAME . '_blog_single_sidebar') != 'none';
			}
		}

		if (get_post_type() == 'post')
		{
			$single_nav = get_option(SHORTNAME . "_single_post_disable_nav");
		}
		if (get_post_type() == 'th_portfolio')
		{
			$single_nav = get_option(SHORTNAME . "_single_portfolio_disable_nav");
		}
		
		
		$sizes = array(
			'' => '32%',
			'fullwidth' => '87%',
			'half' => '48%',
			'one-third' => '32%'
		);

		FrontWidgets::getInstance()->add(array(
			'type' => 'SinglePost',
			'id' => 'single_post',
			'options' => array(
				'selector' => '.post_track',
				'sidebar' => $sidebarOn,
				'retina' => Custom_Thumbnail_Multi::get_the_post_thumbnail_src(get_post_type($postId), 'retina', $postId),
				'sidebarSound' => get_option(SHORTNAME . '_sound_sidebar'),
				'sidebarSoundOgg' => get_option(SHORTNAME . '_sound_sidebar_ogg'),
				'hoverSound' => get_option(SHORTNAME . '_sound_post_hover'),
				'hoverSoundOgg' => get_option(SHORTNAME . '_sound_post_hover_ogg'),
				'width' => $sizes[get_post_meta($postId, SHORTNAME . '_page_layout', true)],
				'location' => get_post_type(),
				'keepOpen' => get_post_meta($postId, SHORTNAME . '_keep_open', true)
			)
		));
		?>

		<div class="post_track p_abs">
			<div class="post_wrap p_rel">
				<div class="post_box preview f_left">
					<?php
					if (get_post_type() == 'post')
					{
						?>
						<div class="postmetadata p_abs">
							<div class="inner">
								<strong><?php printf(get_the_time('j')) ?></strong>
								<span><?php printf(get_the_time('M')) ?></span>
							</div>
						</div>
								<?php } ?>
					<div class="inner">
						<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
							<h4 class="title4"><?php the_title(); ?></h4>

							<div class="entry">
								<?php
								global $more;
								$more = false;
								if (get_post_type() == 'th_portfolio')
								{
									if (get_option(SHORTNAME . "_portfolio_excerpt"))
									{
										$post_description = get_the_content(__('Read more &rarr;', 'milano'));
									}
									else
									{
										$readMoreText = ( get_post_meta($postId, SHORTNAME . '_read_more_text', true) != '') ? get_post_meta($postId, SHORTNAME . '_read_more_text', true) : get_option(SHORTNAME . "_portfolio_read_more_text");
										$post_description = get_excerpt(300, $readMoreText);
									}
								}
								else
								{
									if (get_option(SHORTNAME . "_excerpt"))
									{
										$post_description = get_the_content(__('Read more &rarr;', 'milano'));
									}
									else
									{
										$readMoreText = ( get_post_meta($postId, SHORTNAME . '_read_more_text', true) != '') ? get_post_meta($postId, SHORTNAME . '_read_more_text', true) : get_option(SHORTNAME . "_blog_read_more_text");
										$post_description = get_excerpt(300, $readMoreText);
									}
								}
								if ($post_description)
								{
									?>
									<div class="post_description"><?php echo $post_description; ?></div>
		<?php } ?>
								<div class="full_text">
					<?php
					$more = true;
					the_content('<p class="serif">' . __('Read the rest of this entry &raquo;', 'milano') . '</p>');
					wp_link_pages(array('before' => '<p><strong>' . __('Pages:', 'milano') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));
					the_tags('<div class="tags">' . __('Tags:', 'milano') . ' ', ', ', '</div>');
					?>
								</div>
							</div>
						</div>
					</div>
				<?php
				if (comments_open() && !post_password_required())
				{
					comments_template();
				}
				?>
					<!--All Comments and-->
				</div>
			<?php
			if ($sidebarOn)
			{
				get_sidebar();
			}
			?>
				<span class="d_block p_abs close_btn"></span>
			</div>
			<div class="clear"></div>
					<?php
					if (!$single_nav)
					{
						?>
				<div class="navigation p_abs">
					<div class="inner wrapper">
						<?php
						if (isset($_GET['cats']))
						{
							$terms = explode(',', $_GET['cats']);
							$ids = getPortfolioList($terms);

							// find current post in list
							foreach ($ids['list'] as $k => $v)
							{
								if ($v['post_id'] == $postId)
								{
									$current = $k;
									break;
								}
							}

							if (isset($ids['list'][$current - 1]))
							{
								echo '<a href="' . $ids['list'][$current - 1]['url'] . '" rel="prev" class=""></a>';
							}
							if (isset($ids['list'][$current + 1]))
							{
								echo '<a href="' . $ids['list'][$current + 1]['url'] . '" rel="next" class=""></a>';
							}
						}
						else
						{
							previous_post_link('%link', '', $in_same_cat);
							next_post_link('%link', '', $in_same_cat);
						}
						?>

					</div>
				</div>
		<?php } ?>
		</div>
		<?php
		if (get_post_meta($postId, SHORTNAME . '_custom_color_options', true) == 'on')
		{
			?>
			<style>
				.single-post .post_box .postmetadata .inner {
					background-color: <?php echo get_post_meta($postId, SHORTNAME . '_single_post_date_bg_color', true); ?>;
					color: <?php echo get_post_meta($postId, SHORTNAME . '_date_text_color', true); ?>;
				}

				.single-post .post_box:hover .postmetadata .inner,
				.single-post .post_track.open .post_box .postmetadata .inner {
					background-color: <?php echo get_post_meta($postId, SHORTNAME . '_single_post_date_bg_color_on_hover', true); ?>;
				}

				.single-post .post_box:hover .postmetadata .inner,
				.single-post .post_track.open .post_box .postmetadata .inner{
					color: <?php echo get_post_meta($postId, SHORTNAME . '_date_text_color_on_hover', true); ?>;
				}

				.single-post h1,
				.single-post h2,
				.single-post h3,
				.single-post h4,
				.single-post h5,
				.single-post h6,
				.single-th_portfolio h1,
				.single-th_portfolio h2,
				.single-th_portfolio h3,
				.single-th_portfolio h4,
				.single-th_portfolio h5,
				.single-th_portfolio h6{
					color: <?php echo get_post_meta($postId, SHORTNAME . '_title_color', true); ?>;
				}
				.single-post .post_box:hover h1,
				.single-post .post_box:hover h2,
				.single-post .post_box:hover h3,
				.single-post .post_box:hover h4,
				.single-post .post_box:hover h5,
				.single-post .post_box:hover h6,
				.single-post .post_track.open .post_box h1,
				.single-post .post_track.open .post_box h2,
				.single-post .post_track.open .post_box h3,
				.single-post .post_track.open .post_box h4,
				.single-post .post_track.open .post_box h5,
				.single-post .post_track.open .post_box h6,
				.single-post #reply-title,
				.single-th_portfolio .post_box:hover h1,
				.single-th_portfolio .post_box:hover h2,
				.single-th_portfolio .post_box:hover h3,
				.single-th_portfolio .post_box:hover h4,
				.single-th_portfolio .post_box:hover h5,
				.single-th_portfolio .post_box:hover h6,
				.single-th_portfolio .post_track.open .post_box h1,
				.single-th_portfolio .post_track.open .post_box h2,
				.single-th_portfolio .post_track.open .post_box h3,
				.single-th_portfolio .post_track.open .post_box h4,
				.single-th_portfolio .post_track.open .post_box h5,
				.single-th_portfolio .post_track.open .post_box h6,
				.single-th_portfolio #reply-title{
					color: <?php echo get_post_meta($postId, SHORTNAME . '_title_color_on_hover', true); ?>;
				}

				.th_portfolio .post_box,
				.single-post .post_box{
					background-color: <?php echo get_post_meta($postId, SHORTNAME . '_background_color', true); ?>;
					color: <?php echo get_post_meta($postId, SHORTNAME . '_content_color', true); ?>;
				}

				.single-post .post_box.preview:hover,
				.single-post .post_track.open:after,
				.single-post .post_track.open .post_box,
				.single-th_portfolio .post_box.preview:hover,
				.single-th_portfolio .post_track.open:after,
				.single-th_portfolio .post_track.open .post_box,
				.single-post .ui-tabs .ui-tabs-nav li.ui-tabs-active:after,
				.single-th_portfolio .ui-tabs .ui-tabs-nav li.ui-tabs-active:after{
					background-color: <?php echo get_post_meta($postId, SHORTNAME . '_background_color_on_hover', true); ?>;
					color: <?php echo get_post_meta($postId, SHORTNAME . '_content_color_on_hover', true); ?>;
				}

				.single-post .post_box a,
				.single-th_portfolio .post_box a,
				.single-post .testimonial_author,
				.single-th_portfolio .testimonial_author,
				.single-post .post_box .more-link:hover,
				.single-th_portfolio .post_box .more-link:hover{
					color: <?php echo get_post_meta($postId, SHORTNAME . '_content_link_color', true); ?>;
				}

				.single-post .post_box a:hover,
				.single-th_portfolio .post_box a:hover,
				.ui-state-active a,
				.trigger.active>a, 
				.single-post .commentlist div strong a,
				.single-th_portfolio .commentlist div strong a,
				.single-post .commentlist div strong, 
				.single-post .commentlist div strong a:hover,
				.single-th_portfolio .commentlist div strong, 
				.single-th_portfolio .commentlist div strong a:hover,
				.single-th_portfolio .post_box .ui-tabs .ui-tabs-nav li.ui-tabs-active>a,
				.single-post .post_box .ui-tabs .ui-tabs-nav li.ui-tabs-active>a,
				.single-post .post_box .more-link,
				.single-th_portfolio .post_box .more-link{
					color: <?php echo get_post_meta($postId, SHORTNAME . '_content_link_color_on_hover', true); ?>;
				}

				.single-post .close_btn,
				.single-post .nav_btn,
				.single-post .navigation a,
				.single-post .comments-area .sub_wrap:after,
				.single-post .comment-respond .sub_wrap:after,
				.single-th_portfolio .close_btn,
				.single-th_portfolio .nav_btn,
				.single-th_portfolio .navigation a,
				.single-th_portfolio .comments-area .sub_wrap:after,
				.single-th_portfolio .comment-respond .sub_wrap:after,
				.single-th_portfolio .jp-play:hover,
				.single-th_portfolio .jp-pause,
				.single-post .jp-play:hover,
				.single-post .jp-pause,
				.single .post_box .testimonials .controls a{
					background-color: <?php echo get_post_meta($postId, SHORTNAME . "_accent_color", true); ?>;
				}

				.th_portfolio .widget-area .widget_tag_cloud a:hover,
				.single-post .widget-area .widget_tag_cloud a:hover{
					color: <?php echo get_post_meta($postId, SHORTNAME . "_accent_color", true); ?>
				}

				.single-post .close_btn:after,
				.single-post .nav_btn:after,
				.single-post .navigation a:after,
				.single-post .comments-area .sub_wrap,
				.single-post .comment-respond .sub_wrap,
				.single .post_box  .testimonials .controls a:hover,
				.single-th_portfolio .close_btn:after,
				.single-th_portfolio .nav_btn:after,
				.single-th_portfolio .navigation a:after,
				.single-th_portfolio .comments-area .sub_wrap,
				.single-th_portfolio .comment-respond .sub_wrap,
				.single-post .jp-play,
				.single-post .jp-play-bar,
				.single-post .jp-volume-bar-value,
				.single-th_portfolio .jp-play,
				.single-th_portfolio .jp-play-bar,
				.single-th_portfolio .jp-volume-bar-value,
				.single-th_portfolio .widget-area li.current_page_item>a,
				.single-th_portfolio .widget-area li.current_page_parent>a,
				.single-post .widget-area li.current_page_item>a,
				.single-post .widget-area li.current_page_parent>a,
				.single-post .widget-area li.menu-item.open>a,
				.single-th_portfolio .widget-area li.menu-item.open>a
				{
					background-color: <?php echo get_post_meta($postId, SHORTNAME . "_accent_color_on_hover", true); ?>
				}

				/* Widgets custom options*/
				.single-th_portfolio .post_track .widget-area .widget,
				.single-post .post_track .widget-area .widget{
					background:  <?php echo get_post_meta($postId, SHORTNAME . '_sidebar_bg', true); ?>;
					color: <?php echo get_post_meta($postId, SHORTNAME . '_sidebar_widget_content', true); ?>;
				}

				.th_portfolio .widget-area .widget.widget_tag_cloud a,
				.single-post .widget-area .widget.widget_tag_cloud a{
					color: <?php echo get_post_meta($postId, SHORTNAME . '_sidebar_widget_content', true); ?>;
				}

				.single-th_portfolio .widget-area .widget-title, 
				.single-th_portfolio .widget-area .widget-title a,
				.single-th_portfolio .widget-area .widget_menu li a,
				.single-th_portfolio .widget-area .widget_archive ul li a, 
				.single-th_portfolio .widget-area .widget_categories ul li a, 
				.single-th_portfolio .widget-area .widget_meta ul li a, 
				.single-th_portfolio .widget-area .widget_nav_menu ul li a, 
				.single-th_portfolio .widget-area .widget_pages ul li a, 
				.single-th_portfolio .widget-area .widget_rss ul li a,

				.single-post .widget-area .widget-title, 
				.single-post .widget-area .widget-title a,
				.single-post .widget-area .widget_menu li a,
				.single-post .widget-area .widget_archive ul li a, 
				.single-post .widget-area .widget_categories ul li a, 
				.single-post .widget-area .widget_meta ul li a, 
				.single-post .widget-area .widget_nav_menu ul li a, 
				.single-post .widget-area .widget_pages ul li a, 
				.single-post .widget-area .widget_rss ul li a
				{
					color:  <?php echo get_post_meta($postId, SHORTNAME . '_sidebar_widget_title', true); ?>;
				}

				.single-th_portfolio .widget-area .widget a,
				.single-th_portfolio .widget-area .widget a.title:hover,

				.single-post .widget-area .widget a,
				.single-post .widget-area .widget a.title:hover
				{
					color:  <?php echo get_post_meta($postId, SHORTNAME . '_sidebar_widget_link', true); ?>;
				}

				.single-th_portfolio .flickr_badge_image a:after,
				.single-th_portfolio .widget_popular_posts li>a:after,
				.single-th_portfolio .widget_recent_posts li>a:after,

				.single-post .flickr_badge_image a:after,
				.single-post .widget_popular_posts li>a:after,
				.single-post .widget_recent_posts li>a:after{
					background:  <?php echo get_post_meta($postId, SHORTNAME . '_sidebar_widget_link', true); ?>;
				}

				.single-post .widget-area .widget a:hover,
				.single-post .widget .widget-title a,
				.single-post .widget-area .widget a.title,
				.single-post .widget_menu li:hover>a,
				.single-post .widget_menu li.current-menu-item>a,
				.single-post .widget_menu li.current_page_parent>a,
				.single-post #today>a,

				.single-th_portfolio .widget-area .widget a:hover,
				.single-th_portfolio .widget .widget-title a,
				.single-th_portfolio .widget-area .widget a.title,
				.single-th_portfolio .widget_menu li:hover>a,
				.single-th_portfolio .widget_menu li.current-menu-item>a,
				.single-th_portfolio .widget_menu li.current_page_parent>a,
				.single-th_portfolio #today>a
				{
					color: <?php echo get_post_meta($postId, SHORTNAME . '_sidebar_widget_link_on_hover', true); ?>;
				}

				.widget-area .testimonials .controls a:hover{
					background-color:<?php echo $ml_widget_accent_color; ?>;
					background-position: 50% -13px;
				}

				.single-th_portfolio .widget-area .testimonials .controls a:hover,
				.single-th_portfolio .widget-area .custom_menu>li:hover>a,
				.single-th_portfolio .widget-area .widget_pages li:hover a,
				.single-th_portfolio .widget-area li.current_page_item>a,
				.single-th_portfolio .widget-area li.current_page_parent>a,
				.single-th_portfolio .widget-area li.menu-item.open>a,
				.single-th_portfolio .widget-area .widget_tag_cloud a:hover, 
				.single-th_portfolio .widget-area .widget_meta ul li:hover a,
				.single-th_portfolio .widget-area .widget_categories ul li:hover a, 
				.single-th_portfolio .widget-area .widget_archive ul li:hover,
				.single-th_portfolio .widget-area .sub_wrap,
				.single-th_portfolio .widget-area #wp-calendar td#today,
				.single-th_portfolio .widget-area .widget_tag_cloud a:hover,
				.single-th_portfolio .widget-area .widget_calendar #prev a:hover,
				.single-th_portfolio .widget-area .widget_calendar #next a:hover,
				.single-th_portfolio .widget-area .widget_rss ul li a:hover,
				.single-th_portfolio #searchform input[type="submit"], 
				.single-th_portfolio .widget_search input[type="submit"],

				.single-post .widget-area .testimonials .controls a:hover,
				.single-post .widget-area .custom_menu>li:hover>a,
				.single-post .widget-area .widget_pages li:hover a,
				.single-post .widget-area li.current_page_item>a,
				.single-post .widget-area li.current_page_parent>a,
				.single-post .widget-area li.menu-item.open>a,
				.single-post .widget-area .widget_tag_cloud a:hover, 
				.single-post .widget-area .widget_meta ul li:hover a,
				.single-post .widget-area .widget_categories ul li:hover a, 
				.single-post .widget-area .widget_archive ul li:hover,
				.single-post .widget-area .sub_wrap,
				.single-post .widget-area #wp-calendar td#today,
				.single-post .widget-area .widget_tag_cloud a:hover,
				.single-post .widget-area .widget_calendar #prev a:hover,
				.single-post .widget-area .widget_calendar #next a:hover,
				.single-post .widget-area .widget_rss ul li a:hover,
				.single-post #searchform input[type="submit"], 
				.single-post .widget_search input[type="submit"]{
					background-color: <?php echo get_post_meta($postId, SHORTNAME . '_sidebar_widget_accent', true); ?>;
				}

				.single-post .widget-area .widget_archive ul li:hover a,
				.single-post .widget-area .widget_categories ul li:hover a,
				.single-post .widget-area .widget_meta ul li:hover a,
				.single-post .widget-area .widget_nav_menu ul li:hover a,
				.single-post .widget-area .widget_pages ul li:hover a,
				.single-post .widget-area .widget_rss ul li:hover a, 
				.single-post .widget-area .custom_menu>li:hover>a,
				.single-post .widget-area .side_menu .current_page_item>a,
				.single-post .widget-area .side_menu .current_page_parent>a,

				.single-th_portfolio .widget-area .widget_archive ul li:hover a,
				.single-th_portfolio .widget-area .widget_categories ul li:hover a,
				.single-th_portfolio .widget-area .widget_meta ul li:hover a,
				.single-th_portfolio .widget-area .widget_nav_menu ul li:hover a,
				.single-th_portfolio .widget-area .widget_pages ul li:hover a,
				.single-th_portfolio .widget-area .widget_rss ul li:hover a, 
				.single-th_portfolio .widget-area .custom_menu>li:hover>a,
				.single-th_portfolio .widget-area .side_menu .current_page_item>a,
				.single-th_portfolio .widget-area .side_menu .current_page_parent>a{
					border-color: <?php echo get_post_meta($postId, SHORTNAME . '_sidebar_widget_accent', true); ?>;
				}

				.single-th_portfolio .widget-area .testimonial_author,
				.single-th_portfolio .widget-area .custom_menu ul ul li a:hover,

				.single-post .widget-area .testimonial_author,
				.single-post .widget-area .custom_menu ul ul li a:hover{
					color: <?php echo get_post_meta($postId, SHORTNAME . '_sidebar_widget_accent', true); ?>;
				}

				.single-post .widget-area #wp-calendar td#today,
				.single-th_portfolio .widget-area #wp-calendar td#today{
					border-color: <?php echo get_post_meta($postId, SHORTNAME . '_sidebar_widget_accent', true); ?>;
				}

				.single-post .widget-area .testimonials .controls a,
				.single-post .widget-area #searchform .sub_wrap:after, 
				.single-post .widget-area .widget_feedburner .sub_wrap:after,
				.single-post .widget-area .widget_calendar #prev a,
				.single-post .widget-area .widget_calendar #next a,
				.single-post .widget-area #searchform .sub_wrap:after,
				.single-post .widget-area .widget_feedburner .sub_wrap:after,
				.single-post .widget-area .sub_wrap:after,
				.single-post .widget-area .sub_wrap:after,
				.single-post #searchform input[type="submit"]:hover, 
				.single-post .widget_search input[type="submit"]:hover,

				.single-th_portfolio .widget-area .testimonials .controls a,
				.single-th_portfolio .widget-area #searchform .sub_wrap:after, 
				.single-th_portfolio .widget-area .widget_feedburner .sub_wrap:after,
				.single-th_portfolio .widget-area .widget_calendar #prev a,
				.single-th_portfolio .widget-area .widget_calendar #next a,
				.single-th_portfolio .widget-area #searchform .sub_wrap:after,
				.single-th_portfolio .widget-area .widget_feedburner .sub_wrap:after,
				.single-th_portfolio .widget-area .sub_wrap:after,
				.single-th_portfolio .widget-area .sub_wrap:after,
				.single-th_portfolio #searchform input[type="submit"]:hover, 
				.single-th_portfolio .widget_search input[type="submit"]:hover{
					background-color: <?php echo get_post_meta($postId, SHORTNAME . '_sidebar_widget_accent_on_hover', true); ?>;
				}

				/*--------------> Responsive -------------------------*/
				@media only screen and (max-width: 802px) {
					/*Single Blog*/
					.single-post .post_box .postmetadata .inner,
					.single-post .post_track .post_box .postmetadata .inner,

					.single-th_portfolio .post_box .postmetadata .inner,
					.single-th_portfolio .post_track .post_box .postmetadata .inner{
						color: <?php echo get_post_meta($postId, SHORTNAME . '_date_text_color_on_hover', true); ?>;
					}

					.single-post .post_box .postmetadata .inner,
					.single-post .post_track .post_box .postmetadata .inner,

					.single-th_portfolio .post_box .postmetadata .inner,
					.single-th_portfolio .post_track .post_box .postmetadata .inner{
						background-color: <?php echo get_post_meta($postId, SHORTNAME . '_single_post_date_bg_color_on_hover', true); ?>;
					}
					.single-post .post_box,
					.single-post .post_box,
					.single-post .post_track:after,
					.single-post .post_track.open .post_box

					.single-th_portfolio .post_box,
					.single-th_portfolio .post_box,
					.single-th_portfolio .post_track:after,
					.single-th_portfolio .post_track.open .post_box{
						background-color: <?php echo get_post_meta($postId, SHORTNAME . '_background_color_on_hover', true); ?>;
						color: <?php echo get_post_meta($postId, SHORTNAME . '_content_color_on_hover', true); ?>;
					}
					/*.comment-reply-title,*/
					.single-post .post_track.open .post_box h1,
					.single-post .post_track.open .post_box h1,
					.single-post .post_track.open .post_box h2,
					.single-post .post_track.open .post_box h3,
					.single-post .post_track.open .post_box h4,
					.single-post .post_track.open .post_box h5,
					.single-post .post_track.open .post_box h6,
					.single-post .post_track.open .post_box #reply-title,

					.single-th_portfolio .post_track.open .post_box h1,
					.single-th_portfolio .post_track.open .post_box h2,
					.single-th_portfolio .post_track.open .post_box h3,
					.single-th_portfolio .post_track.open .post_box h4,
					.single-th_portfolio .post_track.open .post_box h5,
					.single-th_portfolio .post_track.open .post_box h6,
					.single-th_portfolio .post_track.open .post_box #reply-title{
						color: <?php echo get_post_meta($postId, SHORTNAME . '_title_color_on_hover', true); ?>;
					}

				}

			</style>
		<?php } ?>

	<?php
	endwhile;
else:
	?>
	<p><?php _e('Sorry, no posts matched your criteria.', 'milano'); ?></p>
<?php
endif;
get_footer();
?>