<?php 

$id = is_home() ? get_option('page_for_posts') : get_the_ID();

if (is_singular() || is_home()) {
	$bg_options = get_post_meta($id, SHORTNAME . '_slideshow_option', true);
	
}
$pattern = get_option(SHORTNAME.'_bg_slider_image_pattern');
if($bg_options == 'custom') {

	
	$slideshow_terms = get_terms(Custom_Posts_Type_Slideshow::TAXONOMY, array(    'hide_empty' => 0,    'fields' => 'ids') );
	$slideshow_cat = (!is_tax('th_slideshow_cat')) ? get_post_meta($id, SHORTNAME . '_slideshow_cat', true) : $th_slideshow_cat;
	$args = array(
		'post_status' => 'publish',
		'post_type' => Custom_Posts_Type_Slideshow::POST_TYPE,
		'posts_per_page' => '-1',
		'ignore_sticky_posts' => true,
		'order' => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => Custom_Posts_Type_Slideshow::TAXONOMY,
				'field' => 'id',
				'terms' => $slideshow_cat ? $slideshow_cat : $slideshow_terms,
				'include_children' => true,
			)
		)
	);
	$slideshow_list = new WP_Query($args);
	$data = array();

	if ($slideshow_list && $slideshow_list->have_posts()) :
		while ($slideshow_list->have_posts()) : $slideshow_list->the_post();
			$title = get_the_title();
			$data[] = array(
				'type' => 'image',
				'src' => wp_get_attachment_url(get_post_thumbnail_id())
			);
		endwhile;
	endif;
	wp_reset_query();
	?>
	<style>
		#slider_box .slide{
			background-color: <?php echo get_post_meta($id, SHORTNAME . '_custom_color_for_bg_slideshow', true);?>;
		}
	</style>
	<?php
} elseif($bg_options == 'image') {
	$data = array(
		array(
			'type' => 'image',
			'src' => get_post_meta($id, SHORTNAME . '_bg_image', true)
		)
	);
	?>
	<style>
		#slider_box .slide, #slider_box .slide .img{
			background-color: <?php echo get_post_meta($id, SHORTNAME . '_post_custom_bg_color', true);?>;
		}
		#slider_box .slide .img{
			background-position: <?php echo get_post_meta($id, SHORTNAME . '_post_custom_bg_horizontal_position', true).' '.get_post_meta($id, SHORTNAME . '_post_custom_bg_vertical_position', true);?>;
			background-repeat: <?php echo get_post_meta($id, SHORTNAME . '_post_custom_bg_repeat', true);?>;			
			background-size: <?php echo get_post_meta($id, SHORTNAME . '_post_custom_bg_scale', true);?>;
		}
	</style>
	<?php
} elseif($bg_options == 'video') {
	if (get_post_meta($id, SHORTNAME . '_video_overlay_pattern', true)) {
		$pattern = get_post_meta($id, SHORTNAME . '_video_overlay_pattern', true);
	}
	(Theme::getYouTubeID(get_post_meta($id, SHORTNAME . '_video_url', true)))?wp_enqueue_script('youtube_api'):'';	
	
	$data = array(
		array(
			'type' => (Theme::getYouTubeID(get_post_meta($id, SHORTNAME . '_video_url', true)))?'youtube':'vimeo',
			'src' => (Theme::getYouTubeID(get_post_meta($id, SHORTNAME . '_video_url', true)))?Theme::getYouTubeID(get_post_meta($id, SHORTNAME . '_video_url', true)):Theme::getVimeoID(get_post_meta($id, SHORTNAME . '_video_url', true)),
			'loop' => get_post_meta($id, SHORTNAME . '_video_loop', true),
			'poster' => get_post_meta($id, SHORTNAME . '_video_poster', true),
			'custom' => get_post_meta($id, SHORTNAME . '_video_image', true),
		)
	);	
} else {
	$data = get_option(SHORTNAME . "_bg_slider_slides");
}
if($bg_options != 'disable') {
	if (get_post_meta($id, SHORTNAME . '_video_overlay_pattern', true) != 'disable') {
	?>
	<style>
		#slider_box .pattern{
			background: url("<?php echo get_template_directory_uri() ?>/images/<?php echo $pattern?>.png") 50% 50% repeat;
		}
	</style>	
<?php
	}
	$custom_slideshow_options = (get_post_meta($id, SHORTNAME . '_custom_slideshow_options', true) == 'on' && get_post_meta($id, SHORTNAME . '_slideshow_option', true) !== 'global' );

	$effect = $custom_slideshow_options ? get_post_meta($id, SHORTNAME . '_effect', true) : get_option(SHORTNAME . "_bg_slider_effect");
	$zoomEffect = ($effect == 'slide with zoom' || $effect == 'slide with intro');

	$effect = ($effect != 'slide with zoom' && $effect != 'slide with intro') ? $effect : 'slide';
	$timelinePosition = $custom_slideshow_options ? get_post_meta($id, SHORTNAME . '_timeline_position', true) : get_option(SHORTNAME . "_bg_slider_timeline_pos");
	$random = $custom_slideshow_options ? get_post_meta($id, SHORTNAME . '_shuffle_slides', true) : get_option(SHORTNAME . "_bg_slider_shuffle_slides");
	$slideTime = $custom_slideshow_options ? get_post_meta($id, SHORTNAME . '_timeout', true) : get_option(SHORTNAME . "_bg_slider_slide_time");
	$effectTime = $custom_slideshow_options ? get_post_meta($id, SHORTNAME . '_transition_speed', true) : get_option(SHORTNAME . "_bg_slider_effect_time");
	$preloader = $custom_slideshow_options ? (get_post_meta($id, SHORTNAME . '_show_preloader', true) == 'on') : get_option(SHORTNAME . "_bg_slider_show_preloader");
	$direction = $custom_slideshow_options ? (get_post_meta($id, SHORTNAME . '_slide_direction', true) == 'on') : get_option(SHORTNAME . "_slide_direction");
	if( $bg_options != 'video'){
	FrontWidgets::getInstance()->add(array(
		'type' => 'BgSlider',
		'id' => 'bgslider',
		'options' => array(
			'selector' => '#slider_box',
			'timeline' => '.timeline',
			'timelinePosition' => $timelinePosition,
			'random' => ($random == 'on' || $random == '1'),
			'slideTime' => (int)$slideTime,
			'effectTime' => (int)$effectTime,
			'zoomEffect' => $zoomEffect,
			'effect' => $effect,
			'direction' => $direction ? $direction : 'right',
			'autoplay' => 'true',
			'preloader' => !!$preloader
		),
		'data' => $data
	));
	} else {
		FrontWidgets::getInstance()->add(array(
		'type' => 'BgSlider',
		'id' => 'bgslider',
		'options' => array(
			'selector' => '#slider_box',
			'timeline' => '.timeline',
			'timelinePosition' => 'none',
			'random' => ($random == 'on' || $random == '1'),
			'slideTime' => (int)$slideTime,
			'effectTime' => (int)$effectTime,
			'zoomEffect' => false,
			'effect' => 'fade',
			'direction' => $direction ? $direction : 'right',
			'autoplay' => 'true',
			'preloader' => !!$preloader
		),
		'data' => $data
	));
	}
}