<?php
/**
 * @package WordPress
 * @subpackage Restaurant_Theme
 */

get_header();
get_template_part('bggallery');

$sizes = array(
	'' => '32%',
	'fullwidth' => '87%',
	'half' => '48%',
	'one-third' => '32%'
);

FrontWidgets::getInstance()->add(array(
	'type' => 'SinglePost',
	'id' => 'error404',
	'options' => array(
		'width' => $sizes['one-third'],
		'selector' => '.solid_box'
	)
));

?>
<div class="solid_box blog clearfix <?php echo get_option(SHORTNAME . "_blog_page_layout");?>">
	<div class="clearfix inner">
        <div class="blog_box">
            <h3 class="ind1 title3"><?php _e('Error 404', 'milano'); ?></h3>
            <p><?php _e('The page you are trying to reach can\'t be found', 'milano'); ?></p>
            <a href="<?php echo get_home_url() ?>" class="content_btn"><?php _e('back to home', 'milano'); ?></a>

		</div>
	</div>
</div>
<?php get_footer(); ?>
