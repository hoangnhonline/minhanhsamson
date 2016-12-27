<?php
$id = get_option('page_for_posts');
if ($id != 0)
{
	$layout = get_post_meta($id, SHORTNAME . '_page_layout', true);
	if (get_post_meta($id, SHORTNAME . '_sidebar_id', true) && get_post_meta($id, SHORTNAME . '_sidebar_id', true) != 'global')
	{
		$sidebarOn = get_post_meta($id, SHORTNAME . '_sidebar_id', true) != 'none';
	}
	else
	{
		$sidebarOn = get_option(SHORTNAME . '_blog_listing_sidebar') != 'none';
	}
}
else
{
	$layout = get_option(SHORTNAME . "_blog_page_layout");
	$sidebarOn = get_option(SHORTNAME . '_blog_listing_sidebar') != 'none';
}

if (get_option(SHORTNAME . '_blog_template') == 'carousel')
{



	$data = array();

	if (have_posts()) :
		while (have_posts()) : the_post();
			$post_id = get_the_ID();

			$data[] = array(
				'post_id' => $post_id,
				'thumbnail' => get_the_post_thumbnail($post_id, 'carousel_thumbnail'),
				'original' => wp_get_attachment_url(get_post_thumbnail_id()),
				'title' => get_the_title(),
				'url' => get_permalink(),
				'day' => get_the_date('d'),
				'month' => get_the_date('M'),
				'excerpt' => get_excerpt(150, '', true)
			);
		endwhile;
	endif;

	$thumbW = (get_option(SHORTNAME . "_blog_carousel_w")) ? get_option(SHORTNAME . "_blog_carousel_w") : 300;
	$thumbH = (get_option(SHORTNAME . "_blog_carousel_h")) ? get_option(SHORTNAME . "_blog_carousel_h") : 400;
	
	FrontWidgets::getInstance()->add(array(
		'type' => 'GridSlider',
		'id' => 'blogCarousel',
		'options' => array(
			'selector' => '.blog_carousel',
			'sound' => get_option(SHORTNAME . '_rollover_carousel'),
			'soundOgg' => get_option(SHORTNAME . '_rollover_carousel_ogg'),
			'thumbWidth' => (int)$thumbW ,
			'thumbHeight' => (int) $thumbH
		),
		'data' => $data
	));
	?>
	<div class="carousel blog_carousel p_abs align_center"></div>
	<?php
} else
{

	$sizes = array(
		'0' => '32%',
		'fullwidth' => '87%',
		'half' => '48%',
		'one-third' => '32%'
	);

	FrontWidgets::getInstance()->add(array(
		'type' => 'SinglePost',
		'id' => 'blog',
		'options' => array(
			'selector' => '.solid_box',
			'width' => $sizes[$layout],
			'sidebar' => $sidebarOn
		)
	));
	?>

	<div class="solid_box blog clearfix <?php echo $layout; ?>">
		<div class="clearfix inner">
			<div class="blog_box f_left">
				<?php if (!is_front_page())
				{
					?><h3 class="title3"><?php
					if (is_day())
					{
						printf(__('Daily Archives: <span>%s</span>', 'simplicity'), get_the_date());
					}
					elseif (is_month())
					{
						printf(__('Monthly Archives: <span>%s</span>', 'simplicity'), get_the_date('F Y'));
					}
					elseif (is_year())
					{
						printf(__('Yearly Archives: <span>%s</span>', 'simplicity'), get_the_date('Y'));
					}
					elseif (is_tag())
					{
						echo single_tag_title("", false);
					}
					elseif (is_category())
					{
						echo single_cat_title("", false);
					}
					elseif (is_tax())
					{
						global $wp_query;
						$term = $wp_query->get_queried_object();
						echo $term->name;
					}
					elseif (get_option("show_on_front") == 'page' && is_home())
					{
						echo get_the_title(get_option("page_for_posts"));
					}
					elseif (is_author())
					{
						if (have_posts()) :
							the_post();
							_e('Author Archives: ', 'simplicity');
							the_author();
						else:
							_e('No posts for current author', 'simplicity');
						endif;
					}
					else
					{
						the_title();
					}
					?>	</h3>
					<?php } ?>
				<ul class="posts_list">
					<?php
					if (have_posts()) :
						while (have_posts()) : the_post();
							$postId = get_the_ID();
							$thumbnail = get_the_post_thumbnail($postId, 'listing_thumbnail_' . $layout);
							$listClass = $thumbnail ? 'with_thumb' : 'without_thumb';
							?>
							<li class="wrapper post_id_<?php echo $postId; ?> <?php echo $listClass; ?>">
								<?php if ($thumbnail)
								{
									?>
									<figure class="post_img">
										<a href="<?php the_permalink() ?>"><?php echo $thumbnail; ?></a>
									</figure>
			<?php } ?>
								<div class="post">
									<div class="f_left postmetadata">
										<div class="inner reg">
											<strong><?php echo get_the_date('d'); ?></strong>
											<span><?php echo get_the_date('M'); ?></span>
										</div>

										<div class="postdata_rollover">
											<div class="inner reg">
												<strong><?php echo get_the_date('d'); ?></strong>
												<span>	<?php echo get_the_date('M'); ?></span>
											</div>
										</div>
									</div>
									<div class="wrapper post_content">
										<h3 class="title6"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
										<p class="p2">
											<?php
											if (get_option(SHORTNAME . "_excerpt"))
											{
												the_content(__('Read more &rarr;', 'milano'));
											}
											else
											{
												$readMoreText = ( get_post_meta($postId, SHORTNAME . '_read_more_text', true) != '') ? get_post_meta($postId, SHORTNAME . '_read_more_text', true) : get_option(SHORTNAME . "_blog_read_more_text");
												echo get_excerpt(300, $readMoreText);
											}
											?>
										</p> 
									</div>
								</div>
							</li>


						<?php
						endwhile;



					endif;
					?>
				</ul>
				<?php
				global $wp_query;
				$total = $wp_query->max_num_pages;
				$current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
				if ($total > 1)
				{
					?>
					<div class="pagination clearfix">
						<?php
						// structure of “format” depends on whether we’re using pretty permalinks
						$permalink_structure = get_option('permalink_structure');

						if (empty($permalink_structure))
						{
							$format = is_front_page() ? '?paged=%#%' : '&paged=%#%';
						}
						else
						{
							$format = 'page/%#%/';
						}

						echo paginate_links(array(
							'base' => get_pagenum_link(1) . '%_%',
							'format' => $format,
							'current' => $current_page,
							'total' => $total,
							'mid_size' => 10,
							'type' => 'list',
							'prev_text' => __('&larr; Previous', 'milano'),
							'next_text' => __('Next &rarr;', 'milano')
						));
						?>
					</div><?php
		}
					?>

			</div>
			<?php
			$id = get_option('page_for_posts');
			$sidebarOn = false;
			if (is_home() && $id != 0 && get_post_meta($id, SHORTNAME . '_sidebar_id', true) && get_post_meta($id, SHORTNAME . '_sidebar_id', true) != 'global')
			{
				$sidebarOn = get_post_meta($id, SHORTNAME . '_sidebar_id', true) != 'none';
			}
			else
			{
				$sidebarOn = get_option(SHORTNAME . '_blog_listing_sidebar') != 'none';
			}
			if ($sidebarOn)
			{
				get_sidebar();
			}
			?>
		</div>
	</div>
	<?php
}
?>