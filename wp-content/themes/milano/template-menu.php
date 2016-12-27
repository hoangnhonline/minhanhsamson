<?php
/**
 * Template Name: Center Menu
 * @package WordPress
 * @subpackage Restaurant_Theme
 */
get_header(); 
get_template_part('bggallery');
?>
<style>
	.nav_box .menu-item{background: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_center_menu_color', true)?>;}
	.middle_menu .menu-item em{background: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_center_menu_color_on_hover', true)?>;}
	.nav_box .menu-item a{color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_menu_text_color', true)?>;}
	.nav_box .menu-item:hover a{color: <?php echo get_post_meta(get_the_ID(), SHORTNAME . '_menu_text_color_on_hover', true)?>;}
</style>
<div class="nav_wrap top_left_zero">
	<div class="nav_inner">
		<?php
			$class = 'middle_menu';
			FrontWidgets::getInstance()->add(array(
				'type' => 'CenterMenu',
				'id' => 'center_menu',
				'options' => array(
					'selector' => '.' . $class,
					'pool' => '.nav_box',
					// may be pool_zone should be optional
					'pool_zone' => (get_post_meta(get_the_ID(),SHORTNAME . '_fixed_menu',true))?0:70,
					'sound' => get_option(SHORTNAME . '_center_menu_sound'),
					'soundOgg' => get_option(SHORTNAME . '_center_menu_sound_ogg')
				)
			));
			$menu = get_post_meta(get_the_ID(), SHORTNAME . '_page_menu', true);
			if($menu) {
				wp_nav_menu(array(
					'menu' => get_post_meta(get_the_ID(), SHORTNAME . '_page_menu', true), 
					'container_class' => 'nav_box', 
					'menu_class' => $class, 
					'fallback_cb' => '', 
					'container' => 'nav', 
					'link_before' => '', 
					'link_after' => ''
				));
			}
		?>
	</div>
</div>
<?php
	get_footer(); 
?>
