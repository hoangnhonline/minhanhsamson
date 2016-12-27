<?php
/**
 * @package WordPress
 * @subpackage Restaurant_Theme
 */
get_header(); 
get_template_part('bggallery');?>
<?php
FrontWidgets::getInstance()->add(array(
	'type' => 'SinglePost',
	'id' => 'blog',
	'options' => array(
		'selector' => '.solid_box',
		'width' => '50%'
	)
));
?>
	<div class="solid_box wrapper search_box <?php echo get_option(SHORTNAME . "_blog_page_layout");?>">

		<div class="clearfix inner">
			<?php if (have_posts()) : ?>
			
				<h3 class="title3 ind1"><?php _e('Search Results', 'milano'); ?></h3>
				<ul class="posts_list post search_list">
				<?php while (have_posts()) : the_post(); ?>
					<li <?php post_class(); ?>>
						<figure class="f_left postmetadata">
							<div class="inner reg">
								<strong><?php the_time('d') ?></strong>
								<?php the_time('M') ?>
							</div>
							<div class="postdata_rollover">
								<div class="inner reg">
									<strong><?php echo get_the_date('d');?></strong>
									<?php echo get_the_date('M');?>
								</div>
							</div>
						</figure>
						<div class="wrapper post_content">
							<h3 class="title6" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'milano'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h3>
							<?php the_tags(__('Tags:', 'milano') . ' ', ', ', '<br />'); ?> <?php printf(__('Posted in %s', 'milano'), get_the_category_list(', ')); ?> | <?php edit_post_link(__('Edit', 'milano'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments', 'milano'), __('1 Comment &rarr;', 'milano'), __('% Comments &rarr;', 'milano'), '', __('Comments Closed', 'milano') ); ?>
						</div>
					</li>
				<?php endwhile; ?>
				</ul>
			<?php else : ?>
			
				<h3 class="title3 ind1"><?php _e('No posts found. Try a different search?', 'milano'); ?></h3>
				<?php get_search_form(); ?>
			
			<?php endif; ?>
		</div>
		

	</div>


<?php get_footer(); ?>
