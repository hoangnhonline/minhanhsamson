<?php
$list_of_post_types_with_multiple_featured_image = array(
	'post',
	Custom_Posts_Type_Portfolio::POST_TYPE,
);

foreach ($list_of_post_types_with_multiple_featured_image as $post_type)
{
	new Custom_Thumbnail_Multi(array(
		'label' => 'Feature image for Retina (x2 size)',
		'id' => Custom_Thumbnail_Retina::META_ID,
		'post_type' => $post_type
			)
	);
}






add_filter('cmb_meta_boxes', 'th_metaboxes');

/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function th_metaboxes(array $meta_boxes)
{

	$meta_boxes[] = array(
		'id' => 'post_layout',
		'title' => __('Layout', 'milano'),
		'pages' => array('page', 'post', Custom_Posts_Type_Portfolio::POST_TYPE), // Page type
		'context' => 'side',
		'priority' => 'low',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Layout', 'milano'),
				'desc' => __('Page Layout', 'milano'),
				'id' => SHORTNAME . '_page_layout',
				'type' => 'select',
				'options' => array(
					array('name' => 'one-third', 'value' => 'one-third'),
					array('name' => 'half', 'value' => 'half'),
					array('name' => 'fullwidth', 'value' => 'fullwidth')
				)
			),
			array(
				'name' => __('Choose sidebar', 'milano'),
				'desc' => 'Choose sidebar',
				'id' => SHORTNAME . '_sidebar_id',
				'type' => 'select',
				'std' => 'global',
				'options' => getSidebars()
			)
		)
	);

	$meta_boxes[] = array(
		'id' => 'page_portfolio_cat',
		'title' => __('Category', 'milano'),
		'pages' => array('page'), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Select a portfolio category', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_portfolio_cat',
				'type' => 'taxonomy_multiselect',
				'taxonomy' => Custom_Posts_Type_Portfolio::TAXONOMY,
				'multiple_size' => 6
			)
		)
	);

	$meta_boxes[] = array(
		'id' => 'bg_options',
		'title' => __('Background options', 'milano'),
		'pages' => array('page', 'post', Custom_Posts_Type_Portfolio::POST_TYPE), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Background slideshow', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_slideshow_option',
				'type' => 'select',
				'options' => array(
					array('name' => 'global', 'value' => 'global'),
					array('name' => 'custom', 'value' => 'custom'),
					array('name' => 'image', 'value' => 'image'),
					array('name' => 'video', 'value' => 'video'),
					array('name' => 'disable', 'value' => 'disable')
				)
			)
		)
	);

	$meta_boxes[] = array(
		'id' => 'bg_video_options',
		'title' => __('Video background options', 'milano'),
		'pages' => array('page', 'post', Custom_Posts_Type_Portfolio::POST_TYPE), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'type' => 'text',
				'name' => __('Video URL', 'milano'),
				'desc' => 'Youtube or Vimeo only',
				'id' => SHORTNAME . '_video_url',
			),
			array(
				'name' => __('Video overlay pattern', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_video_overlay_pattern',
				'type' => 'select',
				'std' => '',
				'options' => array(
					array('name' => 'Global', 'value' => ''),
					array('name' => 'Disable', 'value' => 'disable'),
					array('name' => 'Pattern', 'value' => 'pattern'),
					array('name' => 'Pattern1', 'value' => 'pattern1'),
					array('name' => 'Pattern2', 'value' => 'pattern2'),
					array('name' => 'Pattern3', 'value' => 'pattern3'),
					array('name' => 'Pattern4', 'value' => 'pattern4')
				)
			),
			array(
				'name' => __('Loop video', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_video_loop',
				'type' => 'checkbox'
			),
			array(
				'name' => __('Poster image for mobiles', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_video_poster',
				'type' => 'select',
				'std' => '',
				'options' => array(
					array('name' => 'Disable', 'value' => ''),
					array('name' => 'Video poster', 'value' => 'poster'),
					array('name' => 'Custom image', 'value' => 'custom'),
				)
			),
			array(
				'type' => 'file',
				'name' => __('Custom image for video poster', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_video_image',
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'page_slideshow_controls',
		'title' => __('Controls', 'milano'),
		'pages' => array('page'), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Hide controls', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_hide_controls',
				'type' => 'checkbox'
			),
			array(
				'name' => __('Hide Thumbnails', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_hide_grid',
				'type' => 'checkbox',
				'std' => false
			),
			array(
				'name' => __('Open Thumbnails on page load', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_opened_thumbnails',
				'type' => 'checkbox',
				'std' => false
			)
		)
	);


	$meta_boxes[] = array(
		'id' => 'intro_options',
		'title' => __('Intro slide options', 'milano'),
		'pages' => array(Custom_Posts_Type_Slideshow::POST_TYPE), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Use intro slide', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_use_intro',
				'type' => 'checkbox'
			),
			array(
				'name' => __('Intro title', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_intro_title',
				'type' => 'text_small',
				'std' => false
			),
			array(
				'name' => __('Intro background color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_intro_bg_color',
				'type' => 'colorpicker',
				'std' => '#000000'
			),
			array(
				'name' => __('Intro title color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_intro_title_color',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'page_slideshow_cat',
		'title' => __('Slideshow category options', 'milano'),
		'pages' => array('page', 'post', Custom_Posts_Type_Portfolio::POST_TYPE), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Select a slideshow category', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_slideshow_cat',
				'type' => 'taxonomy_multiselect',
				'taxonomy' => Custom_Posts_Type_Slideshow::TAXONOMY,
				'multiple_size' => 6
			),
			array(
				'name' => __('Background color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_custom_color_for_bg_slideshow',
				'type' => 'colorpicker',
				'std' => '#e9f0f6'
			),
			array(
				'name' => __('Use custom background slideshow options', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_custom_slideshow_options',
				'type' => 'checkbox'
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'page_color_option',
		'title' => __('Page color options', 'milano'),
		'pages' => array('page'), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Use page custom color options', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_page_custom_color_options',
				'type' => 'checkbox'
			),
			array(
				'name' => __('Page background color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_page_custom_color',
				'type' => 'colorpicker',
				'std' => '#242425'
			),
			array(
				'name' => __('Title color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_page_title_color',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
			array(
				'name' => __('Content color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_page_content_color',
				'type' => 'colorpicker',
				'std' => '#79797a'
			),
			array(
				'name' => __('Page link color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_page_link_color',
				'type' => 'colorpicker',
				'std' => '#b8bf37'
			),
			array(
				'name' => __('Page link color on hover', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_page_link_color_on_hover',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
			array(
				'name' => __('Page widget title color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_page_widget_title_color',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
			array(
				'name' => __('Page widget link color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_page_widget_link_color',
				'type' => 'colorpicker',
				'std' => '#b8bf37'
			),
			array(
				'name' => __('Page widget link color on hover', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_page_widget_link_color_on_hover',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
			array(
				'name' => __('Page accent', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_page_accent',
				'type' => 'colorpicker',
				'std' => '#b8bf37'
			),
			array(
				'name' => __('Page accent on hover', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_page_accent_on_hover',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'bg_additional_options',
		'title' => __('Custom background options', 'milano'),
		'pages' => array('page', 'post', Custom_Posts_Type_Portfolio::POST_TYPE), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'type' => 'file',
				'name' => __('Custom image for background', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_bg_image',
			),
			array(
				'name' => __('Background color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_post_custom_bg_color',
				'type' => 'colorpicker',
				'std' => '#e9f0f6'
			),
			array(
				'name' => __('Background repeat ', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_post_custom_bg_repeat',
				'type' => 'select',
				'options' => array(
					array('name' => 'no-repeat', 'value' => 'no-repeat'),
					array('name' => 'repeat-x', 'value' => 'repeat-x'),
					array('name' => 'repeat-y', 'value' => 'repeat-y'),
					array('name' => 'repeat', 'value' => 'repeat')
				)
			),
			array(
				'name' => __('Background horizontal position', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_post_custom_bg_horizontal_position',
				'type' => 'select',
				'options' => array(
					array('name' => 'center', 'value' => 'center'),
					array('name' => 'left', 'value' => 'left'),
					array('name' => 'right', 'value' => 'right')
				)
			),
			array(
				'name' => __('Background vertical position', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_post_custom_bg_vertical_position',
				'type' => 'select',
				'options' => array(
					array('name' => 'center', 'value' => 'center'),
					array('name' => 'top', 'value' => 'top'),
					array('name' => 'bottom', 'value' => 'bottom')
				)
			),
			array(
				'name' => __('Background scale', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_post_custom_bg_scale',
				'type' => 'select',
				'std' => 'cover',
				'options' => array(
					array('name' => 'cover', 'value' => 'cover'),
					array('name' => 'original size', 'value' => 'initial'),
					array('name' => 'contain', 'value' => 'contain')
				)
			),
		)
	);


	$meta_boxes[] = array(
		'id' => 'page_slideshow_settings',
		'title' => __('Slideshow options', 'milano'),
		'pages' => array('page', 'post', Custom_Posts_Type_Portfolio::POST_TYPE), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Timeline position', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_timeline_position',
				'type' => 'select',
				'std' => 'bottom',
				'options' => array(
					array('name' => 'bottom', 'value' => 'bottom'),
					array('name' => 'top', 'value' => 'top'),
					array('name' => 'none', 'value' => 'none')
				)
			),
			array(
				'name' => __('Timeout', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_timeout',
				'std' => '5000',
				'type' => 'text_small'
			),
			array(
				'name' => __('Transition Speed', 'milano'),
				'desc' => '',
				'std' => '1000',
				'id' => SHORTNAME . '_transition_speed',
				'type' => 'text_small'
			),
			array(
				'name' => __('Effect', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_effect',
				'type' => 'select',
				'options' => array(
					array('name' => 'fade', 'value' => 'fade'),
					array('name' => 'slide', 'value' => 'slide'),
					array('name' => 'slide with zoom', 'value' => 'slide with zoom'),
				)
			),
			array(
				'name' => __('Effect direction', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_slide_direction',
				'type' => 'select',
				'options' => array(
					array('name' => 'left', 'value' => 'left'),
					array('name' => 'right', 'value' => 'right'),
					array('name' => 'top', 'value' => 'top'),
					array('name' => 'bottom', 'value' => 'bottom')
				)
			),
			array(
				'name' => __('Shuffle Slides', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_shuffle_slides',
				'type' => 'checkbox'
			),
			array(
				'name' => __('Show Preloader', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_show_preloader',
				'type' => 'checkbox'
			),
			array(
				'name' => __('Autoplay', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_autoplay',
				'type' => 'checkbox'
			)
		)
	);

	$meta_boxes[] = array(
		'id' => 'testimonial_author_info',
		'title' => __('Author info', 'milano'),
		'pages' => array(Custom_Posts_Type_Testimonial::POST_TYPE), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Author name', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_testimonial_author',
				'type' => 'text_small'
			),
			array(
				'name' => __('Author position', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_testimonial_author_job',
				'type' => 'text_small'
			)
		)
	);


	$meta_boxes[] = array(
		'id' => 'page_menu',
		'title' => __('Menu Settings', 'milano'),
		'pages' => array('page'), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Menu', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_page_menu',
				'type' => 'select',
				'options' => getMenus()
			),
			array(
				'name' => __('Fixed Position', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_fixed_menu',
				'type' => 'checkbox',
				'std' => false
			),
			array(
				'name' => __('Menu Color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_center_menu_color',
				'type' => 'colorpicker',
				'std' => '#120c06'
			),
			array(
				'name' => __('Menu Color on hover', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_center_menu_color_on_hover',
				'type' => 'colorpicker',
				'std' => '#b8bf37'
			),
			array(
				'name' => __('Menu text color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_menu_text_color',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
			array(
				'name' => __('Menu text color on hover', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_menu_text_color_on_hover',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
		)
	);


	$meta_boxes[] = array(
		'id' => 'grid_options',
		'title' => __('Grid options', 'milano'),
		'pages' => array('page'), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the 
		'fields' => array(
			array(
				'name' => __('Thumbnail Width (px)', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_portfolio_thumb_width',
				'type' => 'text_small',
				'std' => '306'
			),
			array(
				'name' => __('Thumbnail Height (px)', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_portfolio_thumb_height',
				'type' => 'text_small',
				'std' => '400'
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'map_options',
		'title' => __('Map options', 'milano'),
		'pages' => array('page'), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the 
		'fields' => array(
			array(
				'name' => __('Map type', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_map_type',
				'type' => 'select',
				'std' => 'ROADMAP',
				'options' => array(
					array('name' => 'ROADMAP', 'value' => 'ROADMAP'),
					array('name' => 'SATELLITE', 'value' => 'SATELLITE'),
					array('name' => 'HYBRID', 'value' => 'HYBRID'),
					array('name' => 'TERRAIN', 'value' => 'TERRAIN')
				)
			),
			array(
				'name' => __('Zoom with scroll wheel', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_zoom_with_scroll_wheel',
				'type' => 'checkbox',
				'std' => false
			),
			array(
				'name' => __('Marker image', 'milano'),
				'desc' => 'Custom Google map location image',
				'id' => SHORTNAME . '_marker_img',
				'type' => 'file'
			),
			array(
				'name' => __('Retina marker image', 'milano'),
				'desc' => 'Custom Google map location image for retina',
				'id' => SHORTNAME . '_marker_img_retina',
				'type' => 'file'
			),
			array(
				'name' => __('Markers (double click to add one)', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_markers',
				'type' => 'map'
			)
		)
	);

	$meta_boxes[] = array(
		'id' => 'custom_color_options',
		'title' => __('Custom color options', 'milano'),
		'pages' => array('post', Custom_Posts_Type_Slideshow::POST_TYPE, Custom_Posts_Type_Portfolio::POST_TYPE), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the 
		'fields' => array(
			array(
				'name' => __('Use custom color options', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_custom_color_options',
				'type' => 'checkbox',
				'std' => false
			)
		)
	);

	$meta_boxes[] = array(
		'id' => 'keep_open',
		'title' => __('Keep open', 'milano'),
		'pages' => array('post', Custom_Posts_Type_Portfolio::POST_TYPE), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the 
		'fields' => array(
			array(
				'name' => __('Open post box on load', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_keep_open',
				'type' => 'checkbox',
				'std' => false
			)
		)
	);

	$meta_boxes[] = array(
		'id' => 'date_color_options',
		'title' => __('Date color options', 'milano'),
		'pages' => array('post'), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the 
		'fields' => array(
			array(
				'name' => __('Post date background color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_single_post_date_bg_color',
				'type' => 'colorpicker',
				'std' => '#000000'
			),
			array(
				'name' => __('Post date background color on hover', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_single_post_date_bg_color_on_hover',
				'type' => 'colorpicker',
				'std' => '#b8bf37'
			),
			array(
				'name' => __('Date text color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_date_text_color',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
			array(
				'name' => __('Date text color on hover', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_date_text_color_on_hover',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			)
		)
	);

	$meta_boxes[] = array(
		'id' => 'color_options',
		'title' => __('Color options', 'milano'),
		'pages' => array('post', Custom_Posts_Type_Portfolio::POST_TYPE), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the 
		'fields' => array(
			array(
				'name' => __('Title color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_title_color',
				'type' => 'colorpicker',
				'std' => '#000000'
			),
			array(
				'name' => __('Title color on hover', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_title_color_on_hover',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
			array(
				'name' => __('Content color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_content_color',
				'type' => 'colorpicker',
				'std' => '#79797a'
			),
			array(
				'name' => __('Content color on hover', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_content_color_on_hover',
				'type' => 'colorpicker',
				'std' => '#79797a'
			),
			array(
				'name' => __('Content link color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_content_link_color',
				'type' => 'colorpicker',
				'std' => '#b8bf37'
			),
			array(
				'name' => __('Content link color on hover', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_content_link_color_on_hover',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
			array(
				'name' => __('Background color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_background_color',
				'type' => 'colorpicker',
				'std' => 'transparent'
			),
			array(
				'name' => __('Background color on hover', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_background_color_on_hover',
				'type' => 'colorpicker',
				'std' => '#242425'
			),
			array(
				'name' => __('Accent color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_accent_color',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
			array(
				'name' => __('Accent color on hover', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_accent_color_on_hover',
				'type' => 'colorpicker',
				'std' => '#b8bf37'
			),
			array(
				'name' => __('Sidebar background', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_sidebar_bg',
				'type' => 'colorpicker',
				'std' => '#1d1d1e'
			),
			array(
				'name' => __('Widget title', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_sidebar_widget_title',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
			array(
				'name' => __('Widget content', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_sidebar_widget_content',
				'type' => 'colorpicker',
				'std' => '#79797a'
			),
			array(
				'name' => __('Widget link', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_sidebar_widget_link',
				'type' => 'colorpicker',
				'std' => '#b8bf37'
			),
			array(
				'name' => __('Widget link on hover', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_sidebar_widget_link_on_hover',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
			array(
				'name' => __('Widget accent', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_sidebar_widget_accent',
				'type' => 'colorpicker',
				'std' => '#b8bf37'
			),
			array(
				'name' => __('Widget accent on hover', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_sidebar_widget_accent_on_hover',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'slideshow_color_options',
		'title' => __('Color options', 'milano'),
		'pages' => array(Custom_Posts_Type_Slideshow::POST_TYPE), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the 
		'fields' => array(
			array(
				'name' => __('Title color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_title_color',
				'type' => 'colorpicker',
				'std' => '#000000'
			),
			array(
				'name' => __('Title color for responsive', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_title_color_resp',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
			array(
				'name' => __('Content color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_content_color',
				'type' => 'colorpicker',
				'std' => '#79797a'
			),
			array(
				'name' => __('Background color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_background_color',
				'type' => 'colorpicker',
				'std' => 'transparent'
			),
			array(
				'name' => __('Background color for responsive', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_background_color_resp',
				'type' => 'colorpicker',
				'std' => '#2a241f'
			),
			array(
				'name' => __('Accent color', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_accent_color',
				'type' => 'colorpicker',
				'std' => '#ffffff'
			),
			array(
				'name' => __('Accent color on hover', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_accent_color_on_hover',
				'type' => 'colorpicker',
				'std' => '#b8bf37'
			)
		)
	);

	$meta_boxes[] = array(
		'id' => 'read_more',
		'title' => __('Read more options', 'milano'),
		'pages' => array('post', Custom_Posts_Type_Portfolio::POST_TYPE), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the 
		'fields' => array(
			array(
				'name' => __('Read more text', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_read_more_text',
				'std' => '',
				'type' => 'text_small'
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'custom_url',
		'title' => __('Preview custom URL', 'milano'),
		'pages' => array(Custom_Posts_Type_Portfolio::POST_TYPE), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the 
		'fields' => array(
			array(
				'name' => __('Write your custom URL', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_custom_url',
				'std' => '',
				'type' => 'text'
			),
			array(
				'name' => __('Open in new window', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_custom_url_blank',
				'std' => '',
				'type' => 'checkbox'
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'additional_options',
		'title' => __('Additional options', 'milano'),
		'pages' => array(Custom_Posts_Type_Slideshow::POST_TYPE), // Page type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the 
		'fields' => array(
			array(
				'name' => __('Background scale', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_bg_scale',
				'type' => 'select',
				'std' => 'cover',
				'options' => array(
					array('name' => 'Cover', 'value' => 'cover'),
					array('name' => 'Original size', 'value' => ''),
					array('name' => 'Contain', 'value' => 'contain')
				)
			),
			array(
				'name' => __('Hide Title', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_hide_title',
				'type' => 'checkbox',
				'std' => false
			),
			array(
				'name' => __('Hide Description', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_hide_description',
				'type' => 'checkbox',
				'std' => false
			),
			array(
				'name' => __('URL', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_url',
				'type' => 'text_small'
			),
			array(
				'name' => __('Target', 'milano'),
				'desc' => '',
				'id' => SHORTNAME . '_target',
				'type' => 'select',
				'options' => array(
					array('name' => 'blank', 'value' => '_blank'),
					array('name' => 'self', 'value' => '_self'),
					array('name' => 'parent', 'value' => '_parent'),
					array('name' => 'top', 'value' => '_top')
				)
			)
		)
	);


	return $meta_boxes;
}

function getMenus()
{
	$menusList = array(array('name' => '', 'value' => ''));
	$menus = get_terms('nav_menu');
	if (count($menus) > 0)
	{
		foreach ($menus as $menu)
		{
			$menusList[] = array('name' => $menu->name, 'value' => $menu->name);
		}
	}
	return $menusList;
}

function getSidebars()
{
	$sidebarsList = array(
		array('name' => 'global', 'value' => 'global'),
		array('name' => 'none', 'value' => 'none'),
		array('name' => 'default sidebar', 'value' => 'default-sidebar')
	);
	$sidebars = Sidebar_Generator::get_sidebars();
	if ($sidebars)
	{
		foreach ($sidebars as $sidebar)
		{
			$sidebarsList[] = array('name' => $sidebar, 'value' => $sidebar);
		}
	}
	return $sidebarsList;
}

$meta_boxes = array();
$meta_boxes = apply_filters('cmb_meta_boxes', $meta_boxes);
foreach ($meta_boxes as $meta_box)
{
	$my_box = new cmb_Meta_Box($meta_box);
}

/**
 * Validate value of meta fields
 * Define ALL validation methods inside this class and use the names of these
 * methods in the definition of meta boxes (key 'validate_func' of each field)
 */
class cmb_Meta_Box_Validate
{

	function check_text($text)
	{
		if ($text != 'hello')
		{
			return false;
		}
		return true;
	}

}

/**
 * Defines the url to which is used to load local resources.
 * This may need to be filtered for local Window installations.
 * If resources do not load, please check the wiki for details.
 */
define('CMB_META_BOX_URL', apply_filters('cmb_meta_box_url', trailingslashit(str_replace(WP_CONTENT_DIR, WP_CONTENT_URL, dirname(__FILE__)))));

/**
 * Create meta boxes
 */
class cmb_Meta_Box
{

	protected $_meta_box;

	function __construct($meta_box)
	{
		if (!is_admin())
			return;

		$this->_meta_box = $meta_box;

		$upload = false;
		foreach ($meta_box['fields'] as $field)
		{
			if ($field['type'] == 'file' || $field['type'] == 'file_list')
			{
				$upload = true;
				break;
			}
		}

		global $pagenow;
		if ($upload && in_array($pagenow, array('page.php', 'page-new.php', 'post.php', 'post-new.php')))
		{
			add_action('admin_head', array(&$this, 'add_post_enctype'));
		}

		add_action('admin_menu', array(&$this, 'add'));
		add_action('save_post', array(&$this, 'save'));

		add_filter('cmb_show_on', array(&$this, 'add_for_id'), 10, 2);
		add_filter('cmb_show_on', array(&$this, 'add_for_page_template'), 10, 2);
	}

	function add_post_enctype()
	{
		echo '
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#post").attr("enctype", "multipart/form-data");
			jQuery("#post").attr("encoding", "multipart/form-data");
		});
		</script>';
	}

	// Add metaboxes
	function add()
	{
		$this->_meta_box['context'] = empty($this->_meta_box['context']) ? 'normal' : $this->_meta_box['context'];
		$this->_meta_box['priority'] = empty($this->_meta_box['priority']) ? 'high' : $this->_meta_box['priority'];
		$this->_meta_box['show_on'] = empty($this->_meta_box['show_on']) ? array('key' => false, 'value' => false) : $this->_meta_box['show_on'];

		foreach ($this->_meta_box['pages'] as $page)
		{
			if (apply_filters('cmb_show_on', true, $this->_meta_box))
				add_meta_box($this->_meta_box['id'], $this->_meta_box['title'], array(&$this, 'show'), $page, $this->_meta_box['context'], $this->_meta_box['priority']);
		}
	}

	/**
	 * Show On Filters
	 * Use the 'cmb_show_on' filter to further refine the conditions under which a metabox is displayed.
	 * Below you can limit it by ID and page template
	 */
	// Add for ID
	function add_for_id($display, $meta_box)
	{
		if ('id' !== $meta_box['show_on']['key'])
			return $display;

		// If we're showing it based on ID, get the current ID
		if (isset($_GET['post']))
			$post_id = $_GET['post'];
		elseif (isset($_POST['post_ID']))
			$post_id = $_POST['post_ID'];
		if (!isset($post_id))
			return false;

		// If value isn't an array, turn it into one
		$meta_box['show_on']['value'] = !is_array($meta_box['show_on']['value']) ? array($meta_box['show_on']['value']) : $meta_box['show_on']['value'];

		// If current page id is in the included array, display the metabox

		if (in_array($post_id, $meta_box['show_on']['value']))
			return true;
		else
			return false;
	}

	// Add for Page Template
	function add_for_page_template($display, $meta_box)
	{
		if ('page-template' !== $meta_box['show_on']['key'])
			return $display;

		// Get the current ID
		if (isset($_GET['post']))
			$post_id = $_GET['post'];
		elseif (isset($_POST['post_ID']))
			$post_id = $_POST['post_ID'];
		if (!( isset($post_id) || is_page() ))
			return false;

		// Get current template
		$current_template = get_post_meta($post_id, '_wp_page_template', true);

		// If value isn't an array, turn it into one
		$meta_box['show_on']['value'] = !is_array($meta_box['show_on']['value']) ? array($meta_box['show_on']['value']) : $meta_box['show_on']['value'];

		// See if there's a match
		if (in_array($current_template, $meta_box['show_on']['value']))
			return true;
		else
			return false;
	}

	// Show fields
	function show()
	{

		global $post;

		// Use nonce for verification
		echo '<input type="hidden" name="wp_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		echo '<table class="form-table cmb_metabox">';

		foreach ($this->_meta_box['fields'] as $field)
		{
			// Set up blank or default values for empty ones
			if (!isset($field['name']))
				$field['name'] = '';
			if (!isset($field['desc']))
				$field['desc'] = '';
			if (!isset($field['std']))
				$field['std'] = '';
			if ('file' == $field['type'] && !isset($field['allow']))
				$field['allow'] = array('url', 'attachment');
			if ('file' == $field['type'] && !isset($field['save_id']))
				$field['save_id'] = false;
			if ('multicheck' == $field['type'])
				$field['multiple'] = true;

			$meta = get_post_meta($post->ID, $field['id'], 'multicheck' != $field['type'] /* If multicheck this can be multiple values */);

			echo '<tr>';

			if ($field['type'] == "title")
			{
				echo '<td colspan="2">';
			}
			else
			{
				if (isset($this->_meta_box['show_names']) && $this->_meta_box['show_names'] == true)
				{
					echo '<th style="width:18%"><label for="', $field['id'], '">', $field['name'], '</label></th>';
				}
				echo '<td>';
			}

			switch ($field['type'])
			{

				case 'text':
					echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', '' !== $meta ? $meta : $field['std'], '" />', '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					break;
				case 'text_small':
					echo '<input class="cmb_text_small" type="text" name="', $field['id'], '" id="', $field['id'], '" value="', '' !== $meta ? $meta : $field['std'], '" /><span class="cmb_metabox_description">', $field['desc'], '</span>';
					break;
				case 'text_medium':
					echo '<input class="cmb_text_medium" type="text" name="', $field['id'], '" id="', $field['id'], '" value="', '' !== $meta ? $meta : $field['std'], '" /><span class="cmb_metabox_description">', $field['desc'], '</span>';
					break;
				case 'text_date':
					echo '<input class="cmb_text_small cmb_datepicker" type="text" name="', $field['id'], '" id="', $field['id'], '" value="', '' !== $meta ? $meta : $field['std'], '" /><span class="cmb_metabox_description">', $field['desc'], '</span>';
					break;
				case 'text_date_timestamp':
					echo '<input class="cmb_text_small cmb_datepicker" type="text" name="', $field['id'], '" id="', $field['id'], '" value="', '' !== $meta ? date('m\/d\/Y', $meta) : $field['std'], '" /><span class="cmb_metabox_description">', $field['desc'], '</span>';
					break;

				case 'text_datetime_timestamp':
					echo '<input class="cmb_text_small cmb_datepicker" type="text" name="', $field['id'], '[date]" id="', $field['id'], '_date" value="', '' !== $meta ? date('m\/d\/Y', $meta) : $field['std'], '" />';
					echo '<input class="cmb_timepicker text_time" type="text" name="', $field['id'], '[time]" id="', $field['id'], '_time" value="', '' !== $meta ? date('h:i A', $meta) : $field['std'], '" /><span class="cmb_metabox_description" >', $field['desc'], '</span>';
					break;
				case 'text_time':
					echo '<input class="cmb_timepicker text_time" type="text" name="', $field['id'], '" id="', $field['id'], '" value="', '' !== $meta ? $meta : $field['std'], '" /><span class="cmb_metabox_description">', $field['desc'], '</span>';
					break;
				case 'text_money':
					echo '$ <input class="cmb_text_money" type="text" name="', $field['id'], '" id="', $field['id'], '" value="', '' !== $meta ? $meta : $field['std'], '" /><span class="cmb_metabox_description">', $field['desc'], '</span>';
					break;
				case 'colorpicker':
					$def_color = $field['std'] ? $field['std'] : '#';
					echo '<input class="cmb_colorpicker cmb_text_small" type="text" name="', $field['id'], '" id="', $field['id'], '" value="', '' !== $meta ? $meta : $def_color, '" /><span class="cmb_metabox_description">', $field['desc'], '</span>';
					break;
				case 'textarea':
					echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="10">', '' !== $meta ? $meta : $field['std'], '</textarea>', '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					break;
				case 'textarea_small':
					echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4">', '' !== $meta ? $meta : $field['std'], '</textarea>', '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					break;
				case 'textarea_code':
					echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="10" class="cmb_textarea_code">', '' !== $meta ? $meta : $field['std'], '</textarea>', '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					break;
				case 'select':
					echo '<select name="', $field['id'], '" id="', $field['id'], '">';
					foreach ($field['options'] as $option)
					{
						echo '<option value="', $option['value'], '"', $meta == $option['value'] ? ' selected="selected"' : '', '>', $option['name'], '</option>';
					}
					echo '</select>';
					echo '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					break;
				case 'radio_inline':
					if (empty($meta) && !empty($field['std']))
						$meta = $field['std'];
					echo '<div class="cmb_radio_inline">';
					$i = 1;
					foreach ($field['options'] as $option)
					{
						echo '<div class="cmb_radio_inline_option"><input type="radio" name="', $field['id'], '" id="', $field['id'], $i, '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' /><label for="', $field['id'], $i, '">', $option['name'], '</label></div>';
						$i++;
					}
					echo '</div>';
					echo '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					break;
				case 'radio':
					if (empty($meta) && !empty($field['std']))
						$meta = $field['std'];
					echo '<ul>';
					$i = 1;
					foreach ($field['options'] as $option)
					{
						echo '<li><input type="radio" name="', $field['id'], '" id="', $field['id'], $i, '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' /><label for="', $field['id'], $i, '">', $option['name'] . '</label></li>';
						$i++;
					}
					echo '</ul>';
					echo '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					break;
				case 'checkbox':
					echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
					echo '<span class="cmb_metabox_description">', $field['desc'], '</span>';
					break;
				case 'multicheck':
					echo '<ul>';
					$i = 1;
					foreach ($field['options'] as $value => $name)
					{
						// Append `[]` to the name to get multiple values
						// Use in_array() to check whether the current option should be checked
						echo '<li><input type="checkbox" name="', $field['id'], '[]" id="', $field['id'], $i, '" value="', $value, '"', in_array($value, $meta) ? ' checked="checked"' : '', ' /><label for="', $field['id'], $i, '">', $name, '</label></li>';
						$i++;
					}
					echo '</ul>';
					echo '<span class="cmb_metabox_description">', $field['desc'], '</span>';
					break;
				case 'title':
					echo '<h5 class="cmb_metabox_title">', $field['name'], '</h5>';
					echo '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					break;
				case 'wysiwyg':
					wp_editor($meta ? $meta : $field['std'], $field['id'], isset($field['options']) ? $field['options'] : array() );
					echo '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					break;
				case 'taxonomy_select':
					echo '<select name="', $field['id'], '" id="', $field['id'], '">';
					$names = wp_get_object_terms($post->ID, $field['taxonomy']);
					$terms = get_terms($field['taxonomy'], 'hide_empty=0');
					foreach ($terms as $term)
					{

						echo '<option value="', $term->term_id, '"', $meta == $term->term_id ? ' selected="selected"' : '', '>', $term->name, '</option>';
					}
					echo '</select>';
					echo '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					break;
				case 'taxonomy_radio':
					$names = wp_get_object_terms($post->ID, $field['taxonomy']);
					$terms = get_terms($field['taxonomy'], 'hide_empty=0');
					echo '<ul>';
					foreach ($terms as $term)
					{
						if (!is_wp_error($names) && !empty($names) && !strcmp($term->slug, $names[0]->slug))
						{
							echo '<li><input type="radio" name="', $field['id'], '" value="' . $term->slug . '" checked>' . $term->name . '</li>';
						}
						else
						{
							echo '<li><input type="radio" name="', $field['id'], '" value="' . $term->slug . '  ', $meta == $term->slug ? $meta : ' ', '  ">' . $term->name . '</li>';
						}
					}
					echo '</ul>';
					echo '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					break;
				case 'taxonomy_multicheck':
					echo '<ul>';
					$names = wp_get_object_terms($post->ID, $field['taxonomy']);
					$terms = get_terms($field['taxonomy'], 'hide_empty=0');
					foreach ($terms as $term)
					{
						echo '<li><input type="checkbox" name="', $field['id'], '[]" id="', $field['id'], '" value="', $term->name, '"';
						foreach ($names as $name)
						{
							if ($term->slug == $name->slug)
							{
								echo ' checked="checked" ';
							};
						}
						echo' /><label>', $term->name, '</label></li>';
					}
					break;
				case 'taxonomy_multiselect':
					echo '<ul>';
					$args = array(
						'taxonomy' => $field['taxonomy'],
						'id' => $field['id'],
						'namet' => $field['id'],
						'hierarchical' => true,
						'selected' => $meta,
						'is_multiple' => true
					);

					th_dropdown_categories($args);

					echo '</ul>';
					echo '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					break;
				case 'file_list':
					echo '<input class="cmb_upload_file" type="text" size="36" name="', $field['id'], '" value="" />';
					echo '<input class="cmb_upload_button button" type="button" value="Upload File" />';
					echo '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					$args = array(
						'post_type' => 'attachment',
						'numberposts' => null,
						'post_status' => null,
						'post_parent' => $post->ID
					);
					$attachments = get_posts($args);
					if ($attachments)
					{
						echo '<ul class="attach_list">';
						foreach ($attachments as $attachment)
						{
							echo '<li>' . wp_get_attachment_link($attachment->ID, 'thumbnail', 0, 0, 'Download');
							echo '<span>';
							echo apply_filters('the_title', '&nbsp;' . $attachment->post_title);
							echo '</span></li>';
						}
						echo '</ul>';
					}
					break;
				case 'file':
					$input_type_url = "hidden";
					if ('url' == $field['allow'] || ( is_array($field['allow']) && in_array('url', $field['allow']) ))
						$input_type_url = "text";
					echo '<input class="cmb_upload_file" type="' . $input_type_url . '" size="45" id="', $field['id'], '" name="', $field['id'], '" value="', $meta, '" />';
					echo '<input class="cmb_upload_button button" type="button" value="Upload File" />';
					echo '<input class="cmb_upload_file_id" type="hidden" id="', $field['id'], '_id" name="', $field['id'], '_id" value="', get_post_meta($post->ID, $field['id'] . "_id", true), '" />';
					echo '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					echo '<div id="', $field['id'], '_status" class="cmb_upload_status">';
					if ($meta != '')
					{
						$check_image = preg_match('/(^.*\.jpg|jpeg|png|gif|ico*)/i', $meta);
						if ($check_image)
						{
							echo '<div class="img_status">';
							echo '<img src="', $meta, '" alt="" />';
							echo '<a href="#" class="cmb_remove_file_button" rel="', $field['id'], '">Remove Image</a>';
							echo '</div>';
						}
						else
						{
							$parts = explode('/', $meta);
							for ($i = 0; $i < count($parts); ++$i)
							{
								$title = $parts[$i];
							}
							echo 'File: <strong>', $title, '</strong>&nbsp;&nbsp;&nbsp; (<a href="', $meta, '" target="_blank" rel="external">Download</a> / <a href="#" class="cmb_remove_file_button" rel="', $field['id'], '">Remove</a>)';
						}
					}
					echo '</div>';
					break;
				case 'portfolio':
					$portfolio_slider = $meta;
					$html = '<ul id="portfolio-slider">';

					if ($portfolio_slider)
					{
						foreach ($portfolio_slider as $i => $slide)
						{

							$slide_img_src = isset($slide['slide-img-src']) ? $slide['slide-img-src'] : null;

							$html .= '<li class="slide postbox">
											<div class="handlediv" title="' . __('Click to toggle', 'milano') . '">&nbsp;</div>
											<h3 class="hndle"><span>' . __('Slide', 'milano') . '</span></h3>
											<div class="inside">
												<div>
													<div class="tabs-content">
														<div class="slide-type image">
															<div class="ox-field">
																<div class="image-label">
																	<label>' . __('Image URL', 'milano') . '</label>
																</div>
																<div class="meta-image-input">
																	<input type="text" name="slide-img-src[]" size="30" value="' . $slide_img_src . '">
																	<input type="button" name="upload-image" class="upload-image" value="' . __('Upload Image', 'milano') . '">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div>
												<button class="remove-slide button-secondary">' . __('Remove Slide', 'milano') . '</button>													
												<input type="hidden" name="' . $field['id'] . '[]" size="30" value="">
												</div>	
											</div>
										</li>';
						}
					}
					else
					{
						$html .= '<li class="slide postbox">
										<div class="handlediv" title="' . __('Click to toggle', 'milano') . '">&nbsp;</div>
										<h3 class="hndle"><span>' . __('Slide', 'milano') . '</span></h3>
										<div class="inside">
											<div>
												<div class="tabs-content">
													<div class="slide-type image">
														<div class="ox-field">
															<div class="image-label">
																<label>' . __('Image URL', 'milano') . '</label>
															</div><!-- end .image-label -->
															<div class="meta-image-input">
																<input type="text" name="slide-img-src[]" size="30" value="">
																
																<input type="button" name="upload-image" class="upload-image" value="' . __('Upload Image', 'milano') . '">
																
															</div>
														</div>
													</div>
												</div>
											</div>
											<button class="remove-slide button-secondary">' . __('Remove Slide', 'milano') . '</button>
											<input type="hidden" name="' . $field['id'] . '[]" size="30" value="">
										</div>
									</li>';
					}

					$html .= '</ul>
								  <div class="image-label">
									<p><br><button id="add-slider-slide" class="button-primary">' . __('Add New Slide', 'milano') . '</button></p>
								  </div>
								  <div class="meta-image-input">
									<p id="' . $field['id'] . '_description" class="description">' . $field['desc'] . '</p>
								  </div>
								  <input type="hidden" name="slider-meta-info" value="' . $post->ID . '|' . $field['id'] . '">';
					echo $html;
					break;
				case 'video_url':
					echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', '' !== $meta ? $meta : $field['std'], '" />', '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					echo '<button class="upload_video button">' . __('Upload Video', 'milano') . '</button>';
					break;
				case 'audio_url':
					echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', '' !== $meta ? $meta : $field['std'], '" />', '<p class="cmb_metabox_description">', $field['desc'], '</p>';
					echo '<button class="upload_audio button">' . __('Upload Audio', 'milano') . '</button>';
					break;
				case 'map':

					$markers = (isset($meta['markers'])) ? $meta['markers'] : $meta;
					$zoom = (isset($meta['zoom'])) ? $meta['zoom'] : '2';
					$lat = (isset($meta['lat'])) ? $meta['lat'] : '0';
					$lng = (isset($meta['lng'])) ? $meta['lng'] : '0';

					echo '	<input type="button" id="create_map" value="locate map">
								<div class="map_info" id="', $field['id'], '">
									<input id="target" type="text" placeholder="Search Box" style="width: 90%;" />
									<!--<input class="search_on_map" type="button" value="search" />-->
									<div class="mapAdmin" id="mapAdmin"></div>
									<div id="markers_container">';
					echo '<input name="', $field['id'], '[zoom]" type="hidden" value="', $zoom, '" class="map_zoom" />
							<input name="', $field['id'], '[lat]" type="hidden" value="', $lat, '" class="map_lat" />
								<input name="', $field['id'], '[lng]" type="hidden" value="', $lng, '" class="map_lng" />';
					if ($markers)
					{
						foreach ($markers as $k => $marker)
						{							
							if (!($k == 'zoom' || $k == 'lat' || $k == 'lng'))
							{
								echo '	<div class="marker-data" data-markerid="', $k, '" id="marker_', $k, '">
											<input name="', $field['id'], '[markers][', $k, '][latitude]" type="hidden" value="', $marker['latitude'], '" class="latitude" />
											<input name="', $field['id'], '[markers][', $k, '][longitude]" type="hidden" value="', $marker['longitude'], '" class="longitude" />
											<input name="', $field['id'], '[markers][', $k, '][title]" type="text" value="', $marker['title'], '" class="title" readonly />
											<input name="', $field['id'], '[markers][', $k, '][description]" type="hidden" value="', $marker['description'], '" class="description" />
											<input type="button" value="edit" class="updateInfo" />
											<input type="button" value="delete" class="deleteMarker" />
										</div>';
							}
						}
					}
					echo '		</div>
								</div>
								<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
								<script type="text/javascript" src="' . get_template_directory_uri() . '/js/backend/gmap.js"></script>';
					break;
				default:
					do_action('cmb_render_' . $field['type'], $field, $meta);
			}

			echo '</td>', '</tr>';
		}
		echo '</table>';
	}

	// Save data from metabox
	function save($post_id)
	{

		// verify nonce
		if (!isset($_POST['wp_meta_box_nonce']) || !wp_verify_nonce($_POST['wp_meta_box_nonce'], basename(__FILE__)))
		{
			return $post_id;
		}

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		{
			return $post_id;
		}

		// check permissions
		if ('page' == $_POST['post_type'])
		{
			if (!current_user_can('edit_page', $post_id))
			{
				return $post_id;
			}
		}
		elseif (!current_user_can('edit_post', $post_id))
		{
			return $post_id;
		}

		foreach ($this->_meta_box['fields'] as $field)
		{
			$name = $field['id'];

			if (!isset($field['multiple']))
				$field['multiple'] = ( 'multicheck' == $field['type'] ) ? true : false;

			$old = get_post_meta($post_id, $name, !$field['multiple'] /* If multicheck this can be multiple values */);
			$new = isset($_POST[$field['id']]) ? $_POST[$field['id']] : null;


			if (($field['type'] == 'textarea') || ($field['type'] == 'textarea_small'))
			{
				$new = htmlspecialchars($new);
			}

			if (($field['type'] == 'textarea_code'))
			{
				$new = htmlspecialchars_decode($new);
			}

			if ($field['type'] == 'text_date_timestamp')
			{
				$new = strtotime($new);
			}

			if ($field['type'] == 'text_datetime_timestamp')
			{
				$string = $new['date'] . ' ' . $new['time'];
				$new = strtotime($string);
			}

			$new = apply_filters('cmb_validate_' . $field['type'], $new, $post_id, $field);

			// validate meta value
			if (isset($field['validate_func']))
			{
				$ok = call_user_func(array('cmb_Meta_Box_Validate', $field['validate_func']), $new);
				if ($ok === false)
				{ // pass away when meta value is invalid
					continue;
				}
			}
			elseif ($field['multiple'])
			{
				delete_post_meta($post_id, $name);
				if (!empty($new))
				{
					foreach ($new as $add_new)
					{
						add_post_meta($post_id, $name, $add_new, false);
					}
				}
			}
			elseif ('' !== $new && $new != $old)
			{
				update_post_meta($post_id, $name, $new);
			}
			elseif ('' == $new)
			{
				delete_post_meta($post_id, $name);
			}

			if ('file' == $field['type'])
			{
				$name = $field['id'] . "_id";
				$old = get_post_meta($post_id, $name, !$field['multiple'] /* If multicheck this can be multiple values */);
				if (isset($field['save_id']) && $field['save_id'])
				{
					$new = isset($_POST[$name]) ? $_POST[$name] : null;
				}
				else
				{
					$new = "";
				}

				if ($new && $new != $old)
				{
					update_post_meta($post_id, $name, $new);
				}
				elseif ('' == $new && $old)
				{
					delete_post_meta($post_id, $name, $old);
				}
			}
			elseif ('portfolio' == $field['type'])
			{
				$portfolio_slider = array();
				$name = $field['id'];

				if (isset($_POST[$name]) && is_array($_POST[$name]))
				{
					for ($i = 0; $i < count($_POST[$name]); $i++)
					{
						if (isset($_POST['slide-img-src'][$i]) && $_POST['slide-img-src'][$i] != '')
						{
							$portfolio_slider[] = array(
								'slide-img-src' => $_POST['slide-img-src'][$i],
							);
						}
					}
					$new = $portfolio_slider;
					update_post_meta($post_id, $name, $new);
				}
			}
			elseif ('map' == $field['type'])
			{
				$name = $field['id'];
				if (isset($_POST[$name]) && is_array($_POST[$name]))
				{
					update_post_meta($post_id, $name, $_POST[$name]);
				}
			}
		}
	}

}

/**
 * Adding scripts and styles
 */
function cmb_scripts($hook)
{
	if ($hook == 'post.php' || $hook == 'post-new.php' || $hook == 'page-new.php' || $hook == 'page.php')
	{
		wp_register_script('cmb-timepicker', get_template_directory_uri() . '/js/backend/jquery.timePicker.min.js');
		wp_register_script('cmb-scripts', get_template_directory_uri() . '/js/backend/cmb.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'media-upload', 'thickbox', 'farbtastic'));
		wp_enqueue_script('cmb-timepicker');
		wp_enqueue_script('cmb-scripts');
		wp_register_style('cmb-styles', get_template_directory_uri() . '/js/backend/style.css', array('thickbox', 'farbtastic'));
		wp_enqueue_style('cmb-styles');
	}
}

add_action('admin_enqueue_scripts', 'cmb_scripts', 10);

function cmb_editor_footer_scripts()
{
	?>
	<?php
	if (isset($_GET['cmb_force_send']) && 'true' == $_GET['cmb_force_send'])
	{
		$label = $_GET['cmb_send_label'];
		if (empty($label))
			$label = "Select File";
		?>
		<script type="text/javascript">
			jQuery(function ($) {
				$('td.savesend input').val('<?php echo $label; ?>');
			});
		</script>
		<?php
	}
}

add_action('admin_print_footer_scripts', 'cmb_editor_footer_scripts', 99);

// Force 'Insert into Post' button from Media Library
add_filter('get_media_item_args', 'cmb_force_send');

function cmb_force_send($args)
{

	// if the Gallery tab is opened from a custom meta box field, add Insert Into Post button
	if (isset($_GET['cmb_force_send']) && 'true' == $_GET['cmb_force_send'])
		$args['send'] = true;

	// if the From Computer tab is opened AT ALL, add Insert Into Post button after an image is uploaded
	if (isset($_POST['attachment_id']) && '' != $_POST["attachment_id"])
	{

		$args['send'] = true;
	}

	// change the label of the button on the From Computer tab
	if (isset($_POST['attachment_id']) && '' != $_POST["attachment_id"])
	{

		echo '
			<script type="text/javascript">
				function cmbGetParameterByNameInline(name) {
					name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
					var regexS = "[\\?&]" + name + "=([^&#]*)";
					var regex = new RegExp(regexS);
					var results = regex.exec(window.location.href);
					if(results == null)
						return "";
					else
						return decodeURIComponent(results[1].replace(/\+/g, " "));
				}

				jQuery(function($) {
					if (cmbGetParameterByNameInline("cmb_force_send")=="true") {
						var cmb_send_label = cmbGetParameterByNameInline("cmb_send_label");
						$("td.savesend input").val(cmb_send_label);
					}
				});
			</script>
		';
	}

	return $args;
}
?>