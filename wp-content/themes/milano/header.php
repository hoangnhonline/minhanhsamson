<!doctype html>
<?php 
$id = get_the_ID();

?>
<html  <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">		
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="<?php echo home_url(); ?>">
		<title>
			<?php
			if (!defined('WPSEO_VERSION'))
			{
				// if there is no WordPress SEO plugin activated

				wp_title(' | ', true, 'right');
				bloginfo('name');
				?> | <?php
				bloginfo('description'); // or some WordPress default
			}
			else
			{
				wp_title();
			}
			?>	
		</title>
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Feed" href="<?php bloginfo('rss2_url'); ?>">	
		<style type="text/css" id="scenario"></style>

		<?php
		if (is_singular())
		{
			wp_enqueue_script('comment-reply');
		}
		
		wp_head();
		?>
		<style type="text/css" media="screen">
			html{margin-top: 0px !important;}
			* html body { margin-top: 0px !important; }
		</style>
	</head>	
	<body <?php body_class('main_bg_color'); ?>>
		<?php 
		global $menu;
			$menu = wp_nav_menu(array(
				'echo' => false,
				'theme_location' => 'main-menu',
				'container_class' => '', 
				'menu_class' => 'sf-menu2', 
				'fallback_cb' => '', 
				'container' => '', 
				'link_before' => '', 
				'link_after' => '', 
				'walker' => new Walker_Nav_Menu_Sub()
			));
		?>		
		<div class="global_wrap <?php echo get_post_type();?> ">
			<header class="p_rel wrapper">
				<?php if(!get_option(SHORTNAME . "_hidden_logo") ) {
					if (!get_option(SHORTNAME . "_menu_logo") || (is_page() && (get_post_meta( $id, '_wp_page_template', TRUE ) == 'template-menu.php')) || !$menu) {?>
				<div class="f_left logo">
					<h1>
					<?php
					if (get_option(SHORTNAME . "_logo_custom")) {
						$data_retina = '';
						$retina = get_option(SHORTNAME . "_logo_retina_custom");
						if ($retina)
						{
							$data_retina = ' data-retina="' . $retina . '" ';
						}
						?>
						<a href="<?php echo (get_option(SHORTNAME . "_preview")) ? '/' : wpml_get_home_url(); ?>">
							<img src="<?php echo get_option(SHORTNAME . "_logo_custom"); ?>" alt="<?php bloginfo('name'); ?>"<?php echo $data_retina; ?>>
							<span class="hidden"><?php bloginfo('name'); ?></span>
						</a>
						<?php
					} else {
						if (get_bloginfo('name')) {
							?><a href="<?php echo (get_option(SHORTNAME . "_preview")) ? '/' : wpml_get_home_url(); ?>"><span style="display:block;"><?php bloginfo('name'); ?></span></a><?php
						}
					}?>
					</h1>
				</div>
					<?php } }
				if(!(is_page() && (get_post_meta( $id, '_wp_page_template', TRUE ) == 'template-menu.php'))) { ?>
					<div class="f_right header_content">
						<div class="inner wrapper">
							<?php echo do_shortcode(get_option(SHORTNAME . "_header_tinymce"));?>
						</div>
					</div>
				<?php }	?>
			</header>
			<?php 
				FrontWidgets::getInstance()->add(array(	
					'type' => 'Main',
					'id' => 'main',
					'options' => array(
						'sound' => get_option(SHORTNAME . '_bg_sound'),
						'soundOgg' => get_option(SHORTNAME . '_bg_sound_ogg'),
						'accentSound' => get_option(SHORTNAME . '_accent_sound'),
						'accentSoundOgg' => get_option(SHORTNAME . '_accent_sound_ogg'),
						'responsiveWidth' => 802,
					)
				));
				
				
		
		if(!(is_page() && (get_post_meta( $id, '_wp_page_template', TRUE ) == 'template-menu.php')) && $menu) { ?>
			<nav class="bg_color2 main_menu">
			<?php if(!get_option(SHORTNAME . "_hidden_logo") && get_option(SHORTNAME . "_menu_logo")) { ?>
				<div class="logo">
					<h1>
					<?php
					if (get_option(SHORTNAME . "_logo_custom")) {
						$data_retina = '';
						$retina = get_option(SHORTNAME . "_logo_retina_custom");
						if ($retina)
						{
							$data_retina = ' data-retina="' . $retina . '" ';
						}
						?>
						<a href="<?php echo (get_option(SHORTNAME . "_preview")) ? '/' : wpml_get_home_url(); ?>">
							<img src="<?php echo get_option(SHORTNAME . "_logo_custom"); ?>" alt="<?php bloginfo('name'); ?>"<?php echo $data_retina; ?>>
							<span class="hidden"><?php bloginfo('name'); ?></span>
						</a>
						<?php
					} else {
						if (get_bloginfo('name')) {
							?><a href="<?php echo (get_option(SHORTNAME . "_preview")) ? '/' : wpml_get_home_url(); ?>"><span style="display:block;"><?php bloginfo('name'); ?></span></a><?php
						}
					}?>
					</h1>
				</div>
				<?php }
			
			
			
			if($menu) {
				echo $menu;
				FrontWidgets::getInstance()->add(array(
					'type' => 'Menu',
					'id' => 'left_menu',
					'options' => array(
						'selector' => '.main_menu',
						'slider_box_offset' => (get_option(SHORTNAME . '_left_menu_opened'))?283:60,
						'sound' => get_option(SHORTNAME . '_sound_menu'),
						'soundOgg' => get_option(SHORTNAME . '_sound_menu_ogg'),
						'elementSound' => get_option(SHORTNAME . '_left_menu_item_sound'),
						'elementSoundOgg' => get_option(SHORTNAME . '_left_menu_item_sound_ogg'),						
						'content_offset' => (get_option(SHORTNAME . '_left_menu_opened'))?283:223
					)
				));
			}
			?>
			</nav>	
		<?php }

	// sorry for this :(
	$sidebar = false;
	if(is_home()){
		$id = get_option('page_for_posts');
		if ($id != 0 && get_post_meta($id, SHORTNAME . '_sidebar_id', true) && get_post_meta($id, SHORTNAME . '_sidebar_id', true) != 'global') {
			$sidebar = get_post_meta($id, SHORTNAME . '_sidebar_id', true) != 'none';
		} else {
			$sidebar = get_option(SHORTNAME . '_blog_listing_sidebar') != 'none';
		}
	} elseif ( get_post_meta($id, SHORTNAME . '_sidebar_id', true) && get_post_meta($id, SHORTNAME . '_sidebar_id', true) != 'global') {
		$sidebar = get_post_meta($id, SHORTNAME . '_sidebar_id', true) != 'none';
	} else {
		if (get_post_type() == 'th_portfolio')
			$sidebar = get_option(SHORTNAME . '_portfolio_single_sidebar') != 'none';
		if (get_post_type() == 'post')
			$sidebar = get_option(SHORTNAME . '_blog_single_sidebar') != 'none';
	}
	
	?>
	
			<div id="slider_box" class="p_fix"><div class="pattern"></div></div>
	<section id="content" class="p_rel <?php echo get_post_meta($id, SHORTNAME . '_page_layout', true);?> <?php echo $sidebar ? 'with_sidebar' : 'without_sidebar';?>">
	