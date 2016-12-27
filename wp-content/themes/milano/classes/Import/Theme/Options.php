<?php

class Import_Theme_Options extends Import_Theme_Default
{

	function __construct($type)
	{
		parent::__construct($type);
	}

	public function import_restaraunt()
	{
		update_option('ml_sidebar_generator', unserialize('a:11:{s:4:"blog";s:4:"blog";s:5:"pages";s:5:"pages";s:9:"portfolio";s:9:"portfolio";s:8:"contacts";s:8:"contacts";s:4:"post";s:4:"post";s:8:"features";s:8:"features";s:3:"faq";s:3:"faq";s:3:"pp1";s:3:"pp1";s:3:"pp2";s:3:"pp2";s:6:"reserv";s:6:"reserv";s:5:"menus";s:5:"menus";}'));

		update_option('tax_meta_25', unserialize('a:3:{s:24:"_portfolio_thumb_changed";s:3:"off";s:24:"ml_portfolio_thumb_width";s:3:"306";s:25:"ml_portfolio_thumb_height";s:3:"400";}'));
		update_option('ml_bg_slider_slides', unserialize('a:5:{i:0;a:2:{s:3:"src";s:59:"/wp-content/themes/milano/classes/Import/images/chicken.jpg";s:4:"type";s:5:"image";}i:1;a:2:{s:3:"src";s:58:"/wp-content/themes/milano/classes/Import/images/desert.jpg";s:4:"type";s:5:"image";}i:2;a:2:{s:3:"src";s:59:"/wp-content/themes/milano/classes/Import/images/glasses.jpg";s:4:"type";s:5:"image";}i:3;a:2:{s:3:"src";s:57:"/wp-content/themes/milano/classes/Import/images/salad.jpg";s:4:"type";s:5:"image";}i:4;a:2:{s:3:"src";s:57:"/wp-content/themes/milano/classes/Import/images/steak.jpg";s:4:"type";s:5:"image";}}'));

		update_option("show_on_front", "page");
		$blog = get_page_by_title('Blog');
		update_option("page_for_posts", $blog->ID);
		$home = get_page_by_title('Home');
		update_option("page_on_front", $home->ID);
	}

	public function import_hotel()
	{

		update_option('ml_sidebar_generator', unserialize('a:12:{s:4:"blog";s:4:"blog";s:5:"pages";s:5:"pages";s:9:"portfolio";s:9:"portfolio";s:8:"contacts";s:8:"contacts";s:4:"post";s:4:"post";s:8:"features";s:8:"features";s:3:"faq";s:3:"faq";s:3:"pp1";s:3:"pp1";s:3:"pp2";s:3:"pp2";s:6:"reserv";s:6:"reserv";s:5:"menus";s:5:"menus";s:12:"luxury-suite";s:12:"luxury suite";}'));

		update_option('tax_meta_25', unserialize('a:3:{s:24:"_portfolio_thumb_changed";s:3:"off";s:24:"ml_portfolio_thumb_width";s:3:"306";s:25:"ml_portfolio_thumb_height";s:3:"400";}'));

		update_option('ml_slideshow_bg_color_resp', '#2a241f');


		update_option('ml_slug_portfolio', 'th_portfolio');

		update_option('ml_slug_slideshow_cat', 'th_slideshow_cat');

		update_option('ml_widget_content_color', '#79797a');

		update_option('ml_footer_fixed', '1');

		update_option('ml_carousel_date_text_color', '#000000');

		update_option('ml_carousel_date_text_color_on_hover', '#ffffff');


		update_option('ml_favicon', 'http://milano.themoholics.com/v1/wp-content/themes/milano/images/favicon.ico');

		update_option('ml_gfont_title', 'Vollkorn');

		update_option('ml_fontfamily', 'Georgia, "Times New Roman", Times, serif');

		update_option('ml_fontstyle', 'normal');

		update_option('ml_page_color', '#221d1f');

		update_option('ml_header_textcolor', '#ffffff');

		update_option('ml_content_textcolor', '#79797a');

		update_option('ml_content_linkscolor', '#ad8d54');

		update_option('ml_content_linkscolor_hover', '#ffffff');

		update_option('ml_accent_color', '#ffffff');

		update_option('ml_accent_color_on_hover', '#d1b16e');

		update_option('ml_bg_slider_color', '#292325');

		update_option('ml_bg_slider_background_repeat', 'no-repeat');

		update_option('ml_bg_slider_background_attachment', 'scroll');

		update_option('ml_bg_slider_background_horizontal_position', 'center');

		update_option('ml_bg_slider_background_vertical_position', 'center');

		update_option('ml_bg_slider_background_scale', 'cover');

		update_option('ml_bg_slider_timeline_pos', 'bottom');

		update_option('ml_bg_slider_slide_time', '5000');

		update_option('ml_bg_slider_effect_time', '1500');

		update_option('ml_bg_slider_effect', 'slide with zoom');

		update_option('ml_bg_slider_image_pattern', 'none');

		update_option('ml_main_menu_text_alignment', 'center');

		update_option('ml_main_menu_top_padding', '27px');

		update_option('ml_menu_background_color', '#352f31');

		update_option('ml_1st_level_menu_background_color_on_hover', '#2a2526');

		update_option('ml_1st_level_menu_text_color', '#f4f0f0');

		update_option('ml_1st_level_menu_text_color_on_hover', '#d1b16e');

		update_option('ml_2st_level_menu_background_color_on_hover', '#2f2a2b');

		update_option('ml_2st_level_menu_text_color', '#d8c6bc');

		update_option('ml_2st_level_menu_text_color_on_hover', '#d1b16e');

		update_option('ml_3st_level_menu_text_color', '#9f9f9f');

		update_option('ml_3st_level_menu_text_color_on_hover', '#ffffff');

		update_option('ml_logo_custom', 'http://milano.themoholics.com/v1/wp-content/uploads/2013/11/hotel_milano.png');

		update_option('ml_logo_retina_custom', 'http://milano.themoholics.com/v1/wp-content/uploads/2013/11/hotel_milano2x.png');

		update_option('ml_logo_gfont', 'Open Sans');

		update_option('ml_logo_font_style', 'normal');

		update_option('ml_logo_font_weight', '600');

		update_option('ml_logo_font_size', '48px');

		update_option('ml_logo_text_color', '#242425');

		update_option('ml_top_line_text_color', '#595b5e');

		update_option('ml_top_line_background_color', 'transparent');

		update_option('ml_link_color', '#000');

		update_option('ml_header_link_color_on_hover', '#363636');

		update_option('ml_blog_page_layout', 'one-third');

		update_option('ml_blog_listing_sidebar', 'blog');

		update_option('ml_listing_disable_sidebar', '');

		update_option('ml_blog_template', 'carousel');

		update_option('ml_single_content_bgcolor', 'transparent');

		update_option('ml_single_content_bgcolor_on_hover', '#242425');

		update_option('ml_single_title_color', '#000000');

		update_option('ml_single_title_color_on_hover', '#ffffff');

		update_option('ml_single_content_color', '#79797a');

		update_option('ml_single_content_color_on_hover', '#79797a');

		update_option('ml_single_content_date_color', '#ffffff');

		update_option('ml_single_content_date_color_on_hover', '#ffffff');

		update_option('ml_single_post_color', '#000000');

		update_option('ml_single_post_color_on_hover', '#b8bf37');

		update_option('ml_single_post_accent_color', '#ffffff');

		update_option('ml_single_post_accent_color_on_hover', '#b8bf37');

		update_option('ml_carousel_post_bg_color', '#352f31');

		update_option('ml_carousel_post_bg_color_on_hover', '#352f31');

		update_option('ml_carousel_post_title_color', '#ffffff');

		update_option('ml_carousel_post_title_color_on_hover', '#d1b16e');

		update_option('ml_carousel_post_content_color_on_hover', '#fff');

		update_option('ml_portfolio_post_bgcolor', '#fff');

		update_option('ml_portfolio_post_bgcolor_on_hover', '#352f31');

		update_option('ml_portfolio_post_title_color', '#352f31');

		update_option('ml_portfolio_post_title_color_on_hover', '#d1b16e');

		update_option('ml_portfolio_single_post_bgcolor', '#fff');

		update_option('ml_portfolio_single_post_bgcolor_on_hover', '#fff');

		update_option('ml_portfolio_single_post_title_color', '#352f31');

		update_option('ml_portfolio_single_post_title_color_on_hover', '#c1935c');

		update_option('ml_portfolio_single_post_content_color', '#79797a');

		update_option('ml_portfolio_single_post_content_color_on_hover', '#79797a');

		update_option('ml_portfolio_buttons_color', '#ffffff');

		update_option('ml_portfolio_buttons_color_on_hover', '#b8bf37');

		update_option('ml_slideshow_thumb_bgcolor', '#e3e3e3');

		update_option('ml_slideshow_timeline_color', '#d1b16e');

		update_option('ml_slideshow_nav_color', '#ffffff');

		update_option('ml_slideshow_nav_color_on_hover', '#d1b16e');

		update_option('ml_sidebar_background_color', '#f7f7f7');

		update_option('ml_widget_header_color', '#352f31');

		update_option('ml_widget_link_color', '#ad8d54');

		update_option('ml_widget_link_color_on_hover', '#000');

		update_option('ml_widget_accent_color', '#d8c6bc');

		update_option('ml_widget_accent_color_on_hover', '#efefef');

		update_option('ml_footer_background_color', '#ffffff');

		update_option('ml_footer_menu_background_color', 'transparent');

		update_option('ml_footer_menu_background_color_on_hover', '#ad8d54');

		update_option('ml_footer_menu_text_color', '#ad8d54');

		update_option('ml_footer_menu_text_color_on_hover', '#fff');

		update_option('ml_footer_text_color', '#242424');

		update_option('ml_footer_content_background_color', '#0c0c0d');

		update_option('ml_footer_link_color', '#000');

		update_option('ml_footer_link_color_on_hover', '#ad8d54');

		update_option('ml_copyright_text', 'PREMIUM WORDPRESS THEMES BY <a href="http://themoholics.com">THEMOHOLICS</a>');

		update_option('ml_copyright_text_color', '#878787');

		update_option('ml_copyright_link_color', '#ad8d54');

		update_option('ml_copyright_link_color_on_hover', '#070707');

		update_option('ml_mailchimp_key', '');

		update_option('ml_envato_nick', '');

		update_option('ml_envato_api', '');

		update_option('ml_envato_skip_backup', '');

		update_option('ml_is_writable_style_file', '1');

		update_option('ml_portfolio_single_sidebar_disable', '');

		update_option('ml_portfolio_single_sidebar', 'none');

		update_option('ml_blog_single_sidebar', 'post');

		update_option('ml_blog_single_title_color', '#352f31');

		update_option('ml_blog_single_title_color_on_hover', '#d1b16e');

		update_option('ml_blog_single_content_color', '#79797a');

		update_option('ml_blog_single_content_color_on_hover', '#79797a');

		update_option('ml_blog_single_link_color', '#d1b16e');

		update_option('ml_blog_single_link_color_on_hover', '#352f31');

		update_option('ml_blog_single_date_color', '#2a2526');

		update_option('ml_carousel_date_bg_color', '#d1b16e');

		update_option('ml_header_tinymce', '<img alt="award" src="http://milano.themoholics.com/v1/wp-content/uploads/2013/11/award.png" width="109" height="50" />');

		update_option('ml_slide_direction', 'right');

		update_option('ml_carousel_date_bg_color_on_hover', '#d1b16e');

		update_option('ml_slug_portfolio_cat', 'th_portfolio_cat');

		update_option('ml_slug_slideshow', 'th_slideshow');

		update_option('ml_bg_slideshow_timeline_color', '#d1b16e');

		update_option('ml_bg_slideshow_preloader_color', '#d1b16e');

		update_option('ml_blog_single_date_color_on_hover', '#d1b16e');

		update_option('ml_blog_single_content_date_color', '#ffffff');

		update_option('ml_blog_single_content_date_color_on_hover', '#000');

		update_option('ml_blog_single_post_accent_color', '#ffffff');

		update_option('ml_blog_single_post_accent_color_on_hover', '#d1b16e');

		update_option('ml_classic_blog_title_color', '#ffffff');

		update_option('ml_classic_blog_title_color_on_hover', '#b8bf37');

		update_option('ml_classic_blog_content_color', '#79797a');

		update_option('ml_classic_blog_read_more_color', '#ffffff');

		update_option('ml_classic_blog_read_more_color_on_hover', '#b8bf37');

		update_option('ml_classic_blog_date_color', '#b8bf37');

		update_option('ml_classic_blog_date_color_on_hover', '#000000');

		update_option('ml_classic_blog_date_text_color', '#ffffff');

		update_option('ml_classic_blog_date_text_color_on_hover', '#ffffff');

		update_option('ml_portfolio_single_post_link_color', '#c1935c');

		update_option('ml_portfolio_single_post_link_color_on_hover', '#000');

		update_option('ml_portfolio_single_accent_color', '#d8c6bc');

		update_option('ml_portfolio_single_accent_color_on_hover', '#efefef');

		update_option('ml_slideshow_title_color', '#fff');

		update_option('ml_slideshow_bg_color', 'transparent');

		update_option('ml_slideshow_text_color', '#fff');

		update_option('ml_blog_single_content_bgcolor', '#fff');

		update_option('ml_blog_single_content_bgcolor_on_hover', '#fff');

		update_option('ml_blog_read_more_text', 'Read more →');

		update_option('ml_portfolio_read_more_text', 'Read more →');

		update_option('ml_footer_tinymce', '<span style="font-size:13px;">T +1 800 123 6543 - F +1 800 123 6543</span>');


		update_option('ml_bg_slider_show_preloader', '1');

		update_option('ml_bg_slider_slides', 'a:0:{}');

		update_option('ml_menu_logo', '1');

		update_option('ml_left_menu_opened', '1');

		update_option('ml_gfontdisable', '');

		update_option('ml_slideshow_title_color_resp', '#ffffff');

		update_option('ml_customcss', '.banner_content { font-style: italic; } footer .footer_menu a { color: #000; } p { font-style: italic; } .single .post_description, .contact_box .post_description{ font-style: italic; } .th_list { font-style: italic; } .carousel_list .title .postmetadata strong { font-size: 14px; line-height: 28px; margin-bottom: -4px; margin-top: -9px; } .post_box .postmetadata strong, .carousel_list li .title_rollover .postmetadata strong { font-size: 24px; line-height: 43px; margin-bottom: -4px; margin-top: -9px; } #commentform #submit, .feedback input[type="submit"], .content_btn { font-weight: normal; } ');
		
		update_option("show_on_front", "page");
		$blog = get_page_by_title('News / Events');
		update_option("page_for_posts", $blog->ID);
		$home = get_page_by_title('Slideshow');
		update_option("page_on_front", $home->ID);
	}

	public function import_extreme()
	{
		update_option('ml_sidebar_generator', unserialize('a:12:{s:4:"blog";s:4:"blog";s:5:"pages";s:5:"pages";s:9:"portfolio";s:9:"portfolio";s:8:"contacts";s:8:"contacts";s:4:"post";s:4:"post";s:8:"features";s:8:"features";s:3:"faq";s:3:"faq";s:3:"pp1";s:3:"pp1";s:3:"pp2";s:3:"pp2";s:6:"reserv";s:6:"reserv";s:5:"menus";s:5:"menus";s:12:"snowboarding";s:12:"snowboarding";}'));

		update_option('tax_meta_25', unserialize('a:3:{s:24:"_portfolio_thumb_changed";s:3:"off";s:24:"ml_portfolio_thumb_width";s:3:"306";s:25:"ml_portfolio_thumb_height";s:3:"400";}'));

		update_option('ml_slideshow_bg_color_resp', '#2a241f');

		update_option('ml_bg_sound', '');

		update_option('ml_slug_portfolio', 'th_portfolio');

		update_option('ml_slug_slideshow_cat', 'th_slideshow_cat');

		update_option('ml_widget_content_color', '#fff');

		update_option('ml_footer_fixed', '1');

		update_option('ml_carousel_date_text_color', '#000000');

		update_option('ml_carousel_date_text_color_on_hover', '#ffffff');


		update_option('ml_favicon', 'http://milano.themoholics.com/v2/wp-content/themes/milano/images/favicon.ico');

		update_option('ml_gfont_title', 'Francois One');

		update_option('ml_fontfamily', 'Arial, Helvetica, sans-serif');

		update_option('ml_fontstyle', 'normal');

		update_option('ml_page_color', '#f9f9f9');

		update_option('ml_header_textcolor', '#242424');

		update_option('ml_content_textcolor', '#79797a');

		update_option('ml_content_linkscolor', '#e2001a');

		update_option('ml_content_linkscolor_hover', '#242424');

		update_option('ml_accent_color', '#ffffff');

		update_option('ml_accent_color_on_hover', '#e2001a');

		update_option('ml_bg_slider_color', '#000');

		update_option('ml_bg_slider_background_repeat', 'no-repeat');

		update_option('ml_bg_slider_background_attachment', 'scroll');

		update_option('ml_bg_slider_background_horizontal_position', 'center');

		update_option('ml_bg_slider_background_vertical_position', 'center');

		update_option('ml_bg_slider_background_scale', 'cover');

		update_option('ml_bg_slider_timeline_pos', 'bottom');

		update_option('ml_bg_slider_slide_time', '5000');

		update_option('ml_bg_slider_effect_time', '1500');

		update_option('ml_bg_slider_effect', 'fade');

		update_option('ml_bg_slider_image_pattern', 'none');

		update_option('ml_main_menu_text_alignment', 'center');

		update_option('ml_main_menu_top_padding', '27px');

		update_option('ml_menu_background_color', '#ffffff');

		update_option('ml_1st_level_menu_background_color_on_hover', '#e2001a');

		update_option('ml_1st_level_menu_text_color', '#f4f0f0');

		update_option('ml_1st_level_menu_text_color_on_hover', '#f4f0f0');

		update_option('ml_2st_level_menu_background_color_on_hover', '#383839');

		update_option('ml_2st_level_menu_text_color', '#9f9f9f');

		update_option('ml_2st_level_menu_text_color_on_hover', '#ffffff');

		update_option('ml_3st_level_menu_text_color', '#9f9f9f');

		update_option('ml_3st_level_menu_text_color_on_hover', '#ffffff');

		update_option('ml_logo_retina_custom', 'http://milano.themoholics.com/v2/wp-content/uploads/2013/11/logo_extreme2x1.png');

		update_option('ml_logo_gfont', 'Open Sans');

		update_option('ml_logo_font_style', 'normal');

		update_option('ml_logo_font_weight', '600');

		update_option('ml_logo_font_size', '48px');

		update_option('ml_logo_text_color', '#242425');

		update_option('ml_top_line_text_color', '#595b5e');

		update_option('ml_top_line_background_color', 'transparent');

		update_option('ml_link_color', '#000');

		update_option('ml_header_link_color_on_hover', '#363636');

		update_option('ml_blog_page_layout', 'one-third');

		update_option('ml_blog_listing_sidebar', 'blog');

		update_option('ml_listing_disable_sidebar', '');

		update_option('ml_blog_template', 'classic');

		update_option('ml_single_content_bgcolor', 'transparent');

		update_option('ml_single_content_bgcolor_on_hover', '#242425');

		update_option('ml_single_title_color', '#000000');

		update_option('ml_single_title_color_on_hover', '#ffffff');

		update_option('ml_single_content_color', '#79797a');

		update_option('ml_single_content_color_on_hover', '#79797a');

		update_option('ml_single_content_date_color', '#ffffff');

		update_option('ml_single_content_date_color_on_hover', '#ffffff');

		update_option('ml_single_post_color', '#000000');

		update_option('ml_single_post_color_on_hover', '#b8bf37');

		update_option('ml_single_post_accent_color', '#ffffff');

		update_option('ml_single_post_accent_color_on_hover', '#b8bf37');

		update_option('ml_carousel_post_bg_color', '#000000');

		update_option('ml_carousel_post_bg_color_on_hover', '#b0b823');

		update_option('ml_carousel_post_title_color', '#ffffff');

		update_option('ml_carousel_post_title_color_on_hover', '#ffffff');

		update_option('ml_carousel_post_content_color_on_hover', '#33350a');

		update_option('ml_portfolio_post_bgcolor', '#e2001a');

		update_option('ml_portfolio_post_bgcolor_on_hover', '#e2001a');

		update_option('ml_portfolio_post_title_color', '#ffffff');

		update_option('ml_portfolio_post_title_color_on_hover', '#ffffff');

		update_option('ml_portfolio_single_post_bgcolor', 'transparent');

		update_option('ml_portfolio_single_post_bgcolor_on_hover', '#242425');

		update_option('ml_portfolio_single_post_title_color', '#000000');

		update_option('ml_portfolio_single_post_title_color_on_hover', '#ffffff');

		update_option('ml_portfolio_single_post_content_color', '#79797a');

		update_option('ml_portfolio_single_post_content_color_on_hover', '#79797a');

		update_option('ml_portfolio_buttons_color', '#ffffff');

		update_option('ml_portfolio_buttons_color_on_hover', '#b8bf37');

		update_option('ml_slideshow_thumb_bgcolor', '#1c1c1c');

		update_option('ml_slideshow_timeline_color', '#b8bf37');

		update_option('ml_slideshow_nav_color', '#ffffff');

		update_option('ml_slideshow_nav_color_on_hover', '#b8bf37');

		update_option('ml_sidebar_background_color', '#e2001a');

		update_option('ml_widget_header_color', '#ffffff');

		update_option('ml_widget_link_color', '#fff');

		update_option('ml_widget_link_color_on_hover', '#242424');

		update_option('ml_widget_accent_color', '#fff');

		update_option('ml_widget_accent_color_on_hover', '#ededed');

		update_option('ml_footer_background_color', '#fff');

		update_option('ml_footer_menu_background_color', 'transparent');

		update_option('ml_footer_menu_background_color_on_hover', '#e2001a');

		update_option('ml_footer_menu_text_color', '#242424');

		update_option('ml_footer_menu_text_color_on_hover', '#fff');

		update_option('ml_footer_text_color', '#79797a');

		update_option('ml_footer_content_background_color', '#0c0c0d');

		update_option('ml_footer_link_color', '#242424');

		update_option('ml_footer_link_color_on_hover', '#79797a');

		update_option('ml_copyright_text', 'PREMIUM WORDPRESS THEMES BY <a href="http://themoholics.com/">THEMOHOLICS</a>');

		update_option('ml_copyright_text_color', '#79797a');

		update_option('ml_copyright_link_color', '#242424');

		update_option('ml_copyright_link_color_on_hover', '#e2001a');

		update_option('ml_mailchimp_key', '');

		update_option('ml_envato_nick', '');

		update_option('ml_envato_api', '');

		update_option('ml_envato_skip_backup', '');

		update_option('ml_is_writable_style_file', '1');

		update_option('ml_portfolio_single_sidebar_disable', '');

		update_option('ml_portfolio_single_sidebar', 'none');

		update_option('ml_blog_single_sidebar', 'post');

		update_option('ml_blog_single_title_color', '#242424');

		update_option('ml_blog_single_title_color_on_hover', '#242424');

		update_option('ml_blog_single_content_color', '#79797a');

		update_option('ml_blog_single_content_color_on_hover', '#79797a');

		update_option('ml_blog_single_link_color', '#e2001a');

		update_option('ml_blog_single_link_color_on_hover', '#242424');

		update_option('ml_blog_single_date_color', '#000000');

		update_option('ml_carousel_date_bg_color', '#b0b823');


		update_option("show_on_front", "page");
		$blog = get_page_by_title('Blog');
		update_option("page_for_posts", $blog->ID);
		$home = get_page_by_title('Home');
		update_option("page_on_front", $home->ID);

		$philosophy = get_page_by_title('Our Philosophy');
		$discover = get_page_by_title('Portfolio');
		$news = get_page_by_title('Blog Light, Half Width');
		$contacts = get_page_by_title('Contacts');



		update_option('ml_header_tinymce', '[button type="btn_small" url="' . get_permalink($philosophy->ID) . '" target="" button_color_fon="#e2001a" hover_color="#fff" text_color="#ffffff" text_color_hover="#242424" ]Philosophy[/button] [button type="btn_small" url="' . get_permalink($discover->ID) . '" target="" button_color_fon="#e2001a" hover_color="#fff" text_color="#ffffff" text_color_hover="#242424" ]Discover[/button] [button type="btn_small" url="' . get_permalink($news->ID) . '" target="" button_color_fon="#e2001a" hover_color="#fff" text_color="#ffffff" text_color_hover="#242424" ]News[/button] [button type="btn_small" url="' . get_permalink($contacts->ID) . '" target="" button_color_fon="#e2001a" hover_color="#fff" text_color="#ffffff" text_color_hover="#242424" ]Get in Touch[/button] [button type="btn_small" url="http://themeforest.net/item/milano-portfolio-photography-hotel-restaurant/5939980?ref=themoholics" target="" button_color_fon="#242424" hover_color="#fff" text_color="#ffffff" text_color_hover="#242424" ]Purchase[/button]');

		update_option('ml_gfontdisable', '');

		update_option('ml_customcss', '.middle_menu .menu-item>a { letter-spacing: 1px; } footer { font-size: 11px; } footer .footer_menu a { color: #353535; } ');

		update_option('ml_logo_custom', 'http://milano.themoholics.com/v2/wp-content/uploads/2013/11/logo_extreme1.png');

		update_option('ml_slide_direction', 'left');

		update_option('ml_carousel_date_bg_color_on_hover', '#000000');

		update_option('ml_slug_portfolio_cat', 'th_portfolio_cat');

		update_option('ml_slug_slideshow', 'th_slideshow');

		update_option('ml_bg_slideshow_timeline_color', '#e2001a');

		update_option('ml_bg_slideshow_preloader_color', '#e2001a');

		update_option('ml_blog_single_date_color_on_hover', '#e2001a');

		update_option('ml_blog_single_content_date_color', '#ffffff');

		update_option('ml_blog_single_content_date_color_on_hover', '#fff');

		update_option('ml_blog_single_post_accent_color', '#fff');

		update_option('ml_blog_single_post_accent_color_on_hover', '#e2001a');

		update_option('ml_classic_blog_title_color', '#e2001a');

		update_option('ml_classic_blog_title_color_on_hover', '#e2001a');

		update_option('ml_classic_blog_content_color', '#79797a');

		update_option('ml_classic_blog_read_more_color', '#242424');

		update_option('ml_classic_blog_read_more_color_on_hover', '#e2001a');

		update_option('ml_classic_blog_date_color', '#e2001a');

		update_option('ml_classic_blog_date_color_on_hover', '#000000');

		update_option('ml_classic_blog_date_text_color', '#ffffff');

		update_option('ml_classic_blog_date_text_color_on_hover', '#ffffff');

		update_option('ml_portfolio_single_post_link_color', '#e2001a');

		update_option('ml_portfolio_single_post_link_color_on_hover', '#ffffff');

		update_option('ml_portfolio_single_accent_color', '#ffffff');

		update_option('ml_portfolio_single_accent_color_on_hover', '#e2001a');

		update_option('ml_slideshow_title_color', '#000000');

		update_option('ml_slideshow_bg_color', 'transparent');

		update_option('ml_slideshow_text_color', '#79797a');

		update_option('ml_blog_single_content_bgcolor', '#ffffff');

		update_option('ml_blog_single_content_bgcolor_on_hover', '#fff');

		update_option('ml_blog_read_more_text', 'Read more →');

		update_option('ml_portfolio_read_more_text', 'Read Full Story →');

		update_option('ml_footer_tinymce', '[social_link type="facebook_account" url="" target="" ][/social_link][social_link type="twitter_account" url="" target="" ][/social_link][social_link type="dribble_account" url="" target="" ][/social_link][social_link type="email_to" url="" target="" ][/social_link][social_link type="google_plus_account" url="" target="" ][/social_link][social_link type="skype_account" url="" target="" ][/social_link]');

		update_option('ml_bg_slider_show_preloader', '1');


		update_option('ml_bg_slider_slides', unserialize('a:4:{i:0;a:2:{s:3:"src";s:56:"/wp-content/themes/milano/classes/Import/images/ex_2.jpg";s:4:"type";s:5:"image";}i:1;a:2:{s:3:"src";s:56:"/wp-content/themes/milano/classes/Import/images/ex_3.jpg";s:4:"type";s:5:"image";}i:2;a:2:{s:3:"src";s:56:"/wp-content/themes/milano/classes/Import/images/ex_4.jpg";s:4:"type";s:5:"image";}i:3;a:2:{s:3:"src";s:56:"/wp-content/themes/milano/classes/Import/images/ex_5.jpg";s:4:"type";s:5:"image";}}'));
	}

}

?>