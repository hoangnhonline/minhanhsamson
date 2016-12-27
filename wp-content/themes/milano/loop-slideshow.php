<?php

$isTax = is_tax('th_portfolio_cat');

$term = $wp_query->get_queried_object();

$pageId = $isTax ? $term->term_id : get_the_ID();

$getMetaOption = $isTax ? 'get_tax_meta' : 'get_post_meta';

$slideshow_terms = get_terms(Custom_Posts_Type_Slideshow::TAXONOMY, array(    'hide_empty' => 0,    'fields' => 'ids') );
$slideshow_cat = $isTax ? $th_slideshow_cat : get_post_meta($pageId, SHORTNAME . '_slideshow_cat', true);
$args = array(
	'post_status' => 'publish',
	'post_type' => Custom_Posts_Type_Slideshow::POST_TYPE,
	'paged' => '1',
	'posts_per_page' => 1000,
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
	$i = 0;
	$css = '';
	while ($slideshow_list->have_posts()) : $slideshow_list->the_post();
		$title = get_the_title();
		$postId = get_the_ID();
		$url = get_post_meta($postId, SHORTNAME . '_url', true);
		$isIntro = get_post_meta($postId, SHORTNAME . '_use_intro', true) == 'on';
		$contert = do_shortcode(get_the_content());
		$hideTitle = (get_post_meta($postId, SHORTNAME . '_hide_title', true) == 'on');
		$hideDescr = (get_post_meta($postId, SHORTNAME . '_hide_description', true) == 'on');
		$data[] = array(
			'type' => $isIntro ? 'intro' : 'image',

			'src' => wp_get_attachment_url(get_post_thumbnail_id()),
			'thumbnail' => get_the_post_thumbnail($postId, 'slideshow_thumbnail'),
			'title' => $isIntro ? get_post_meta($postId, SHORTNAME . '_intro_title', true) : $title,
			'html' => '	<div class="outer '.(($hideTitle && $hideDescr) ? 'empty' : '').'" id="slide_text_'.$i.'"><div class="inner">'.
							($url ? '<a href="' . $url . '" target="' . get_post_meta($postId, SHORTNAME . '_target', true) . '">' : '').
								'<h2 class="title2">' . $title . '</h2>'.
							($url ? '</a>' : '').
							($contert ? '<div class="banner_content">' . $contert . '</div>' : '')
						.'</div></div>'
		);
		
		$css .= '#slider_box .intro#intro_' . $i . '{ background-color: ' . get_post_meta($postId, SHORTNAME . '_intro_bg_color', true) . '; }
				#slider_box .intro#intro_' . $i . ' .title{ color: ' . get_post_meta($postId, SHORTNAME . '_intro_title_color', true) . '; }
				#slider_box #slide_' . $i . ' .img{background-size: ' . get_post_meta($postId, SHORTNAME . '_bg_scale', true) . '}
				#slide_text_' . $i . ' .title2{display: ' . ($hideTitle ? 'none' : 'block') . '}
				#slide_text_' . $i . ' .banner_content{display: ' . ($hideDescr ? 'none' : 'block') . '}
';
		
		if(get_post_meta($postId, SHORTNAME . '_custom_color_options', true) == 'on') {
			$css .= '
					#slide_text_' . $i . '{ background-color:' . get_post_meta($postId, SHORTNAME . '_background_color', true) . ' !important;}
					@media only screen and (max-width: 802px) {
						#slide_text_' . $i . '{ background-color:' . get_post_meta($postId, SHORTNAME . '_background_color_resp', true) . ' !important;}
						#slide_text_' . $i . ' .title2{ color:' . get_post_meta($postId, SHORTNAME . '_title_color_resp', true) . ' !important;}
					}
					#slide_text_' . $i . ' .title2{ color:' . get_post_meta($postId, SHORTNAME . '_title_color', true) . ';}
					#slide_text_' . $i . ' .banner_content{ color:' . get_post_meta($postId, SHORTNAME . '_content_color', true) . ';}
					.slide__' . $i . ' a.nav_btn{background-color: ' . get_post_meta($postId, SHORTNAME . '_accent_color', true) . '}

					.slide__' . $i . ' ul.thumb_list li a span.loop em,
					.slide__' . $i . ' ul.thumb_list li a:after,
					.slide__' . $i . ' .timeline,
					.page-template-template-slideshow-php.slide__' . $i . ' a.nav_btn:after{background-color: ' . get_post_meta($postId, SHORTNAME . '_accent_color_on_hover', true) . ' !important}
				';
		}
		$i++;
	endwhile;
	?>
	<style><?php echo $css;?></style>
	<div class="p_abs slideshow_banner <?php if((get_post_meta($pageId, SHORTNAME . '_hide_controls', true) != 'on') && count($data) > 1) { echo "with_nav";} ?>"></div>
<?php  
endif; 
wp_reset_query(); 

if((get_post_meta($pageId, SHORTNAME . '_hide_controls', true) != 'on') && count($data) > 1) { ?>
<div class="p_abs slideshow_nav">
	<a href="" class="d_block f_left nav_btn play_pause"></a>
	<a href="" class="d_block f_left nav_btn prev"></a>
	<a href="" class="d_block f_left nav_btn next"></a>
</div>
<?php }

$custom = (get_post_meta($pageId, SHORTNAME . '_custom_slideshow_options', true) == 'on' && get_post_meta($id, SHORTNAME . '_slideshow_option', true) !== 'global' );
$effect = $custom ? get_post_meta($pageId, SHORTNAME . '_effect', true) : get_option(SHORTNAME . "_bg_slider_effect");
$zoomEffect = ($effect == 'slide with zoom' || $effect == 'slide with intro');
$intro = ($effect == 'slide with intro');
$effect = ($effect != 'slide with zoom') ? $effect : 'slide';
$autoplay = $custom ? (get_post_meta($pageId, SHORTNAME . '_autoplay', true) == 'on') : 'true';
$timelinePosition = $custom ? get_post_meta($pageId, SHORTNAME . '_timeline_position', true) : get_option(SHORTNAME . "_bg_slider_timeline_pos");
$random = $custom ? get_post_meta($pageId, SHORTNAME . '_shuffle_slides', true) : get_option(SHORTNAME . "_bg_slider_shuffle_slides");
$slideTime = $custom ? get_post_meta($pageId, SHORTNAME . '_timeout', true) : get_option(SHORTNAME . "_bg_slider_slide_time");
$effectTime = $custom ? get_post_meta($pageId, SHORTNAME . '_transition_speed', true) : get_option(SHORTNAME . "_bg_slider_effect_time");
$preloader = $custom ? get_post_meta($pageId, SHORTNAME . '_show_preloader', true) : get_option(SHORTNAME . "_bg_slider_show_preloader");
$direction = $custom ? get_post_meta($pageId, SHORTNAME . '_slide_direction', true) : get_option(SHORTNAME . "_slide_direction");

// invertion for directions
switch ($direction) {
	case 'left': $direction = 'right';break;
	case 'right': $direction = 'left';break;
	case 'top': $direction = 'bottom';break;
	case 'bottom': $direction = 'top';break;
	default: $direction = 'right';break;
}


FrontWidgets::getInstance()->add(array(
	'type' => 'Slideshow',
	'id' => 'slideshow',
	'options' => array(
		'selector' => '#slider_box',
		'hideThumbnails' => get_post_meta($pageId, SHORTNAME . '_hide_grid', true),
		'slideHtmlCont' => '.slideshow_banner',
		'timeline' => '.timeline',
		'introSlide' => $intro,
		'timelinePosition' => $timelinePosition,
		'random' => ($random == 'on' || $random == '1'),
		'slideTime' => (int)$slideTime,
		'effectTime' => (int)$effectTime,
		'zoomEffect' => $zoomEffect,
		'effect' => $effect,
		'direction' => $direction ? $direction : 'right',
		'autoplay' => $autoplay,
		'sound' => get_option(SHORTNAME . '_sound_thumbnails'),
		'soundOgg' => get_option(SHORTNAME . '_sound_thumbnails_ogg'),
		'preloader' => ($preloader == 'on'),
		'openedThumbnails' => (get_post_meta($pageId, SHORTNAME . '_opened_thumbnails', true) == 'on')
	),
	'data' => $data
));
?>