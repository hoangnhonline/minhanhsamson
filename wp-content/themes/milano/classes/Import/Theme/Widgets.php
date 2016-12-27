<?php

class Import_Theme_Widgets extends Import_Theme_Default
{

	function __construct($type)
	{
		parent::__construct($type);
	}

	public function import_restaraunt()
	{
		$sidebars = get_option("sidebars_widgets");
		$sidebars["default-sidebar"] = array();
		$sidebars["th_sidebar-1"] = array("search-4", "milano-popular-posts-3", "milano-feedburner-2", "milano-testimonials-2", "milano-tagcloud-3");
		$sidebars["th_sidebar-2"] = array();
		$sidebars["th_sidebar-3"] = array("milano-testimonials-6", "milano-twitter-3", "milano-social-links-2");
		$sidebars["th_sidebar-4"] = array("text-2");
		$sidebars["th_sidebar-5"] = array("milano-popular-posts-2", "milano-twitter-2", "milano-tagcloud-2");
		$sidebars["th_sidebar-6"] = array("milano-menu-2");
		$sidebars["th_sidebar-7"] = array("text-3", "milano-testimonials-3");
		$sidebars["th_sidebar-8"] = array("text-4");
		$sidebars["th_sidebar-9"] = array("text-5", "milano-testimonials-5");
		$sidebars["th_sidebar-10"] = array("milano-testimonials-7", "text-6");
		$sidebars["th_sidebar-11"] = array("milano-menu-3");
		update_option("sidebars_widgets", $sidebars);


		// Widget Search
		$search = get_option("widget_search");
		$search[4] = array("title" => "",);
		$search["_multiwidget"] = 1;
		update_option("widget_search", $search);



		// Widget Milano popular posts
		$milano_popular_posts = get_option("widget_milano-popular-posts");
		$milano_popular_posts[2] = array("title" => "Popular Posts", "number" => "3",);
		$milano_popular_posts[3] = array("title" => "Popular posts", "number" => "3",);
		$milano_popular_posts["_multiwidget"] = 1;
		update_option("widget_milano-popular-posts", $milano_popular_posts);



		// Widget Milano feedburner
		$milano_feedburner = get_option("widget_milano-feedburner");
		$milano_feedburner[2] = array("title" => "Newsletter Sign up", "description" => "Stay updated on the latest themes from the Themoholics!", "feedname" => "themoholics", "btntext" => "Submit",);
		$milano_feedburner["_multiwidget"] = 1;
		update_option("widget_milano-feedburner", $milano_feedburner);



		// Widget Milano testimonials
		$milano_testimonials = get_option("widget_milano-testimonials");
		$milano_testimonials[2] = array("category" => "all", "randomize" => "", "time" => "10", "title" => "Testimonials",);
		$milano_testimonials[3] = array("category" => "all", "randomize" => "", "time" => "10", "title" => "What people say",);
		$milano_testimonials[5] = array("category" => "small", "randomize" => "", "time" => "10", "title" => "Testimonials",);
		$milano_testimonials[6] = array("category" => "small", "randomize" => "", "time" => "10", "title" => "Testimonials",);
		$milano_testimonials[7] = array("category" => "reserv", "randomize" => "", "time" => "10", "title" => "",);
		$milano_testimonials["_multiwidget"] = 1;
		update_option("widget_milano-testimonials", $milano_testimonials);



		// Widget Milano tagcloud
		$milano_tagcloud = get_option("widget_milano-tagcloud");
		$milano_tagcloud[2] = array("title" => "Tags", "taxonomy" => "post_tag",);
		$milano_tagcloud[3] = array("title" => "Tags", "taxonomy" => "post_tag",);
		$milano_tagcloud["_multiwidget"] = 1;
		update_option("widget_milano-tagcloud", $milano_tagcloud);



		// Widget Milano twitter
		$milano_twitter = get_option("widget_milano-twitter");
		$milano_twitter[2] = array("title" => "Twitter", "username" => "themoholics", "num" => "2", "update" => "on", "linked" => "", "hyperlinks" => "on", "twitter_users" => "on", "encode_utf8" => "on", "target_blank" => "",);
		$milano_twitter[3] = array("title" => "Twitter", "username" => "themoholics", "num" => "2", "update" => "on", "linked" => "", "hyperlinks" => "on", "twitter_users" => "on", "encode_utf8" => "on", "target_blank" => "",);
		$milano_twitter["_multiwidget"] = 1;
		update_option("widget_milano-twitter", $milano_twitter);



		// Widget Milano social links
		$milano_social_links = get_option("widget_milano-social-links");
		$milano_social_links[2] = array("title" => "Follow us", "twitter_account" => "twitter.com/themoholicsthemes", "facebook_account" => "http://www.facebook.com/themoholics", "google_plus_account" => "plus.google.com", "rss_feed" => "http://milano.themoholics.com/feed", "email_to" => "mail@themoholics.com", "flicker_account" => "flickr.com", "vimeo_account" => "vimeo.com", "youtube_account" => "youtube.com", "dribble_account" => "http://dribbble.com/", "linkedin_account" => "http://www.linkedin.com", "pinterest_account" => "http://pinterest.com/", "picasa_account" => "http://picasa.google.com/", "digg_account" => "digg.com/", "plurk_account" => "plurk.com", "tripadvisor_account" => "tripadvisor.com", "yahoo_account" => "yahoo.com", "delicious_account" => "delicious.com", "devianart_account" => "deviantart.com", "tumblr_account" => "tumblr.com", "skype_account" => "skype.com", "apple_account" => "apple.com/", "aim_account" => "aim.com", "paypal_account" => "paypal.com", "blogger_account" => "blogger.com", "behance_account" => "behance.net", "myspace_account" => "myspace.com", "stumble_account" => "stumbleupon.com", "forrst_account" => "forrst.com", "imdb_account" => "imdb.com", "instagram_account" => "instagram.com",);
		$milano_social_links["_multiwidget"] = 1;
		update_option("widget_milano-social-links", $milano_social_links);



		// Widget Text
		$text = get_option("widget_text");
		$text[2] = array("title" => "How to find us", "text" => "<br/> <h6><span style=\"color: #000;\">Australia</span></h6> The Business Centre<br/> 61 Wellfield Road<br/> Roath Cardiff, CF24 3DG<br/> <br/><br/> <h6><span style=\"color: #000;\">Europe</span></h6> The Business Centre<br/> 61 Wellfield Road<br/> Roath Cardiff, CF24 3DG<br/> <br/><br/> Phone: 1-234-567-89<br/> Fax: 1-234-567-89<br/> <a href=\"mailto:mail@youremail.com\">mail@youremail.com</a> ", "filter" => "",);
		$text[3] = array("title" => "Faq didnâ��t solve your problem?", "text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus est lacus, egestas ut dapibus sit amet, porta at lectus. Aliquam a erat a dui vulputate imperdiet. <br/><br/> [button type=\"btn_middle\" url=\"\" target=\"\" button_color_fon=\"#b8bf37\" hover_color=\"#ffffff\" text_color=\"#ffffff\" text_color_hover=\"#000000\" ]HELP FORUM[/button]", "filter" => "",);
		$text[4] = array("title" => "Overview", "text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas euismod et quam mattis ultricies. Fusce egestas lectus vitae convallis dignissim. Phasellus nec gravida lectus, nec pretium eros. Curabitur condimentum ornare enim et pretium. Proin vel risus justo. Pellentesque lobortis dictum quam non luctus. Praesent eget mi justo. <br/><br/> [button type=\"btn_middle\" url=\"#\" target=\"\" button_color_fon=\"#b8bf37\" hover_color=\"#ffffff\" text_color=\"#ffffff\" text_color_hover=\"#000000\" ] Launch Project[/button]", "filter" => "",);
		$text[5] = array("title" => "Overview", "text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas euismod et quam mattis ultricies. Fusce egestas lectus vitae convallis dignissim. Phasellus nec gravida lectus, nec pretium eros. Curabitur condimentum ornare enim et pretium. Proin vel risus justo. Pellentesque lobortis dictum quam non luctus. Praesent eget mi justo. <br/><br/> [button type=\"btn_middle\" url=\"#\" target=\"\" button_color_fon=\"#b8bf37\" hover_color=\"#ffffff\" text_color=\"#ffffff\" text_color_hover=\"#000000\" ] Preview[/button] [button type=\"btn_middle\" url=\"#\" target=\"\" button_color_fon=\"#ffffff\" hover_color=\"#b8bf37\" text_color=\"#000000\" text_color_hover=\"#ffffff\" ]More Info[/button]", "filter" => "",);
		$text[6] = array("title" => "Opening hours:", "text" => "<br/><span style=\"color:#fff\">Monday to Friday:</span> 07:30 - 10.30 & 12:00 - 15:00 & 18:00 - 23:00 <hr/> <span style=\"color:#fff\">Saturday and Sunday: </span>8.30 - 10.30 & 12:00 - 15:00 & 18:00 - 23:00", "filter" => "1",);
		$text["_multiwidget"] = 1;
		update_option("widget_text", $text);



		// Widget Milano menu
		$milano_menu = get_option("widget_milano-menu");
		$milano_menu[2] = array("title" => "", "menu" => "features",);
		$milano_menu[3] = array("title" => "Menu", "menu" => "menus",);
		$milano_menu["_multiwidget"] = 1;
		update_option("widget_milano-menu", $milano_menu);
	}

	public function import_hotel()
	{
		$sidebars = get_option("sidebars_widgets");
		$sidebars["default-sidebar"] = array();
		$sidebars["th_sidebar-1"] = array("search-4", "milano-popular-posts-3", "milano-feedburner-2", "milano-testimonials-2", "milano-tagcloud-3");
		$sidebars["th_sidebar-2"] = array();
		$sidebars["th_sidebar-3"] = array("milano-testimonials-6", "milano-twitter-3");
		$sidebars["th_sidebar-4"] = array("text-2");
		$sidebars["th_sidebar-5"] = array("milano-popular-posts-2", "milano-twitter-2", "milano-tagcloud-2");
		$sidebars["th_sidebar-6"] = array("milano-menu-2");
		$sidebars["th_sidebar-7"] = array("text-3", "milano-testimonials-3");
		$sidebars["th_sidebar-8"] = array("text-4");
		$sidebars["th_sidebar-9"] = array("text-5", "milano-testimonials-5");
		$sidebars["th_sidebar-10"] = array("milano-testimonials-7", "text-6");
		$sidebars["th_sidebar-11"] = array("milano-menu-3");
		$sidebars["th_sidebar-12"] = array("text-7");
		update_option("sidebars_widgets", $sidebars);


// Widget Search
		$search = get_option("widget_search");
		$search[4] = array("title" => "",);
		$search["_multiwidget"] = 1;
		update_option("widget_search", $search);



// Widget Milano popular posts
		$milano_popular_posts = get_option("widget_milano-popular-posts");
		$milano_popular_posts[2] = array("title" => "Popular Posts", "number" => "3",);
		$milano_popular_posts[3] = array("title" => "Popular posts", "number" => "3",);
		$milano_popular_posts["_multiwidget"] = 1;
		update_option("widget_milano-popular-posts", $milano_popular_posts);



// Widget Milano feedburner
		$milano_feedburner = get_option("widget_milano-feedburner");
		$milano_feedburner[2] = array("title" => "Newsletter Sign up", "description" => "Stay updated on the latest themes from the Themoholics!", "feedname" => "themoholics", "btntext" => "Submit",);
		$milano_feedburner["_multiwidget"] = 1;
		update_option("widget_milano-feedburner", $milano_feedburner);



// Widget Milano testimonials
		$milano_testimonials = get_option("widget_milano-testimonials");
		$milano_testimonials[2] = array("category" => "all", "randomize" => "", "time" => "10", "title" => "Testimonials",);
		$milano_testimonials[3] = array("category" => "all", "randomize" => "", "time" => "10", "title" => "What people say",);
		$milano_testimonials[5] = array("category" => "small", "randomize" => "", "time" => "10", "title" => "Testimonials",);
		$milano_testimonials[6] = array("category" => "small", "randomize" => "", "time" => "10", "title" => "Testimonials",);
		$milano_testimonials[7] = array("category" => "reserv", "randomize" => "", "time" => "10", "title" => "",);
		$milano_testimonials["_multiwidget"] = 1;
		update_option("widget_milano-testimonials", $milano_testimonials);



// Widget Milano tagcloud
		$milano_tagcloud = get_option("widget_milano-tagcloud");
		$milano_tagcloud[2] = array("title" => "Tags", "taxonomy" => "post_tag",);
		$milano_tagcloud[3] = array("title" => "Tags", "taxonomy" => "post_tag",);
		$milano_tagcloud["_multiwidget"] = 1;
		update_option("widget_milano-tagcloud", $milano_tagcloud);



// Widget Milano twitter
		$milano_twitter = get_option("widget_milano-twitter");
		$milano_twitter[2] = array("title" => "Twitter", "username" => "themoholics", "num" => "2", "update" => "on", "linked" => "", "hyperlinks" => "on", "twitter_users" => "on", "encode_utf8" => "on", "target_blank" => "",);
		$milano_twitter[3] = array("title" => "Twitter", "username" => "olegnax", "num" => "2", "update" => "on", "linked" => "", "hyperlinks" => "on", "twitter_users" => "on", "encode_utf8" => "on", "target_blank" => "",);
		$milano_twitter["_multiwidget"] = 1;
		update_option("widget_milano-twitter", $milano_twitter);



// Widget Text
		$text = get_option("widget_text");
		$text[2] = array("title" => "", "text" => "<h6>ROOM RESERVATIONS</h6> Phone: 1-234-567-89<br/> Fax: 1-234-567-89<br/> <a href=\"#\">rooms@youremail.com</a> <br/><br/><br/> <h6>CONCIERGE AND FRONT OFFICE</h6> Phone: 1-234-567-89<br/> Fax: 1-234-567-89<br/> <a href=\"#\">office@youremail.com</a> <br/><br/><br/> <h6>RESTAURANT OLIVER GLOWIG</h6> Phone: 1-234-567-89<br/> <a href=\"#\">mail@youremail.com</a> <br/><br/><br/> <h6>CONFERENCE AND BANQUET DEPARTMENT</h6> <a href=\"#\">conference@youremail.com</a> ", "filter" => "",);
		$text[3] = array("title" => "Faq didnt solve your problem?", "text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus est lacus, egestas ut dapibus sit amet, porta at lectus. Aliquam a erat a dui vulputate imperdiet. <br/><br/> [button type=\"btn_middle\" url=\"\" target=\"\" button_color_fon=\"#b8bf37\" hover_color=\"#ffffff\" text_color=\"#ffffff\" text_color_hover=\"#000000\" ]HELP FORUM[/button]", "filter" => "",);
		$text[4] = array("title" => "Overview", "text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas euismod et quam mattis ultricies. Fusce egestas lectus vitae convallis dignissim. Phasellus nec gravida lectus, nec pretium eros. Curabitur condimentum ornare enim et pretium. Proin vel risus justo. Pellentesque lobortis dictum quam non luctus. Praesent eget mi justo. <br/><br/> [button type=\"btn_middle\" url=\"#\" target=\"\" button_color_fon=\"#b8bf37\" hover_color=\"#ffffff\" text_color=\"#ffffff\" text_color_hover=\"#000000\" ] Launch Project[/button]", "filter" => "",);
		$text[5] = array("title" => "Overview", "text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas euismod et quam mattis ultricies. Fusce egestas lectus vitae convallis dignissim. Phasellus nec gravida lectus, nec pretium eros. Curabitur condimentum ornare enim et pretium. Proin vel risus justo. Pellentesque lobortis dictum quam non luctus. Praesent eget mi justo. <br/><br/> [button type=\"btn_middle\" url=\"#\" target=\"\" button_color_fon=\"#b8bf37\" hover_color=\"#ffffff\" text_color=\"#ffffff\" text_color_hover=\"#000000\" ] Preview[/button] [button type=\"btn_middle\" url=\"#\" target=\"\" button_color_fon=\"#ffffff\" hover_color=\"#b8bf37\" text_color=\"#000000\" text_color_hover=\"#ffffff\" ]More Info[/button]", "filter" => "",);
		$text[6] = array("title" => "Opening hours:", "text" => "<br/><span style=\"color:#fff\">Monday to Friday:</span> 07:30 - 10.30 & 12:00 - 15:00 & 18:00 - 23:00 <hr/> <span style=\"color:#fff\">Saturday and Sunday: </span>8.30 - 10.30 & 12:00 - 15:00 & 18:00 - 23:00", "filter" => "1",);
		$text[7] = array("title" => "150 sqm / 1620 sqft", "text" => "<p>Proin volutpat faucibus velit at imperdiet. In dignissim tempus accumsan. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Quisque consectetur malesuada massa, sit amet dapibus nibh. Sed vel bibendum justo. Nunc volutpat velit at urna cursus eleifend.</p> <br/> [button type=\"btn_middle\" url=\"#\" target=\"\" button_color_fon=\"#c1935c\" hover_color=\"#000\" text_color=\"#ffffff\" text_color_hover=\"#fff\" ]Book this room[/button][button type=\"btn_middle\" url=\"#\" target=\"\" button_color_fon=\"#352f31\" hover_color=\"#f0f0f0\" text_color=\"#ffffff\" text_color_hover=\"#352f31\" ]View gallery[/button]", "filter" => "",);
		$text["_multiwidget"] = 1;
		update_option("widget_text", $text);



// Widget Milano menu
		$milano_menu = get_option("widget_milano-menu");
		$milano_menu[2] = array("title" => "", "menu" => "features",);
		$milano_menu[3] = array("title" => "Menu", "menu" => "menus",);
		$milano_menu["_multiwidget"] = 1;
		update_option("widget_milano-menu", $milano_menu);
	}

	public function import_extreme()
	{
		$sidebars = get_option("sidebars_widgets");
		$sidebars["default-sidebar"] = array();
		$sidebars["th_sidebar-1"] = array("search-4", "milano-popular-posts-3", "milano-feedburner-2", "milano-testimonials-2", "milano-tagcloud-3");
		$sidebars["th_sidebar-2"] = array();
		$sidebars["th_sidebar-3"] = array("milano-testimonials-6", "milano-twitter-3");
		$sidebars["th_sidebar-4"] = array("text-2");
		$sidebars["th_sidebar-5"] = array("milano-popular-posts-2", "milano-twitter-2", "milano-tagcloud-2");
		$sidebars["th_sidebar-6"] = array("milano-menu-2");
		$sidebars["th_sidebar-7"] = array("text-3", "milano-testimonials-3");
		$sidebars["th_sidebar-8"] = array("text-4");
		$sidebars["th_sidebar-9"] = array("text-5", "milano-testimonials-5");
		$sidebars["th_sidebar-10"] = array("milano-testimonials-7", "text-6");
		$sidebars["th_sidebar-11"] = array("milano-menu-3");
		$sidebars["th_sidebar-12"] = array("text-7");
		update_option("sidebars_widgets", $sidebars);


// Widget Search
		$search = get_option("widget_search");
		$search[4] = array("title" => "",);
		$search["_multiwidget"] = 1;
		update_option("widget_search", $search);



// Widget Milano popular posts
		$milano_popular_posts = get_option("widget_milano-popular-posts");
		$milano_popular_posts[2] = array("title" => "Popular Posts", "number" => "3",);
		$milano_popular_posts[3] = array("title" => "Popular posts", "number" => "3",);
		$milano_popular_posts["_multiwidget"] = 1;
		update_option("widget_milano-popular-posts", $milano_popular_posts);



// Widget Milano feedburner
		$milano_feedburner = get_option("widget_milano-feedburner");
		$milano_feedburner[2] = array("title" => "Newsletter Sign up", "description" => "Stay updated on the latest themes from the Themoholics!", "feedname" => "themoholics", "btntext" => "Submit",);
		$milano_feedburner["_multiwidget"] = 1;
		update_option("widget_milano-feedburner", $milano_feedburner);



// Widget Milano testimonials
		$milano_testimonials = get_option("widget_milano-testimonials");
		$milano_testimonials[2] = array("category" => "all", "randomize" => "", "time" => "10", "title" => "Testimonials",);
		$milano_testimonials[3] = array("category" => "all", "randomize" => "", "time" => "10", "title" => "What people say",);
		$milano_testimonials[5] = array("category" => "small", "randomize" => "", "time" => "10", "title" => "Testimonials",);
		$milano_testimonials[6] = array("category" => "small", "randomize" => "", "time" => "10", "title" => "Testimonials",);
		$milano_testimonials[7] = array("category" => "reserv", "randomize" => "", "time" => "10", "title" => "",);
		$milano_testimonials["_multiwidget"] = 1;
		update_option("widget_milano-testimonials", $milano_testimonials);



// Widget Milano tagcloud
		$milano_tagcloud = get_option("widget_milano-tagcloud");
		$milano_tagcloud[2] = array("title" => "Tags", "taxonomy" => "post_tag",);
		$milano_tagcloud[3] = array("title" => "Tags", "taxonomy" => "post_tag",);
		$milano_tagcloud["_multiwidget"] = 1;
		update_option("widget_milano-tagcloud", $milano_tagcloud);



// Widget Milano twitter
		$milano_twitter = get_option("widget_milano-twitter");
		$milano_twitter[2] = array("title" => "Twitter", "username" => "themoholics", "num" => "2", "update" => "on", "linked" => "", "hyperlinks" => "on", "twitter_users" => "on", "encode_utf8" => "on", "target_blank" => "",);
		$milano_twitter[3] = array("title" => "Twitter", "username" => "themoholics", "num" => "2", "update" => "on", "linked" => "", "hyperlinks" => "on", "twitter_users" => "on", "encode_utf8" => "on", "target_blank" => "",);
		$milano_twitter["_multiwidget"] = 1;
		update_option("widget_milano-twitter", $milano_twitter);



// Widget Text
		$text = get_option("widget_text");
		$text[2] = array("title" => "How to find us", "text" => "<br/> <h6><span style=\"color: #000;\">Australia</span></h6> The Business Centre<br/> 61 Wellfield Road<br/> Roath Cardiff, CF24 3DG<br/> <br/><br/> <h6><span style=\"color: #000;\">Europe</span></h6> The Business Centre<br/> 61 Wellfield Road<br/> Roath Cardiff, CF24 3DG<br/> <br/><br/> Phone: 1-234-567-89<br/> Fax: 1-234-567-89<br/> <a href=\"mailto:mail@youremail.com\">mail@youremail.com</a> ", "filter" => "",);
		$text[3] = array("title" => "Faq didnt solve your problem?", "text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus est lacus, egestas ut dapibus sit amet, porta at lectus. Aliquam a erat a dui vulputate imperdiet. <br/><br/> [button type=\"btn_middle\" url=\"\" target=\"\" button_color_fon=\"#b8bf37\" hover_color=\"#ffffff\" text_color=\"#ffffff\" text_color_hover=\"#000000\" ]HELP FORUM[/button]", "filter" => "",);
		$text[4] = array("title" => "Overview", "text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas euismod et quam mattis ultricies. Fusce egestas lectus vitae convallis dignissim. Phasellus nec gravida lectus, nec pretium eros. Curabitur condimentum ornare enim et pretium. Proin vel risus justo. Pellentesque lobortis dictum quam non luctus. Praesent eget mi justo. <br/><br/> [button type=\"btn_middle\" url=\"#\" target=\"\" button_color_fon=\"#b8bf37\" hover_color=\"#ffffff\" text_color=\"#ffffff\" text_color_hover=\"#000000\" ] Launch Project[/button]", "filter" => "",);
		$text[5] = array("title" => "Overview", "text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas euismod et quam mattis ultricies. Fusce egestas lectus vitae convallis dignissim. Phasellus nec gravida lectus, nec pretium eros. Curabitur condimentum ornare enim et pretium. Proin vel risus justo. Pellentesque lobortis dictum quam non luctus. Praesent eget mi justo. <br/><br/> [button type=\"btn_middle\" url=\"#\" target=\"\" button_color_fon=\"#b8bf37\" hover_color=\"#ffffff\" text_color=\"#ffffff\" text_color_hover=\"#000000\" ] Preview[/button] [button type=\"btn_middle\" url=\"#\" target=\"\" button_color_fon=\"#ffffff\" hover_color=\"#b8bf37\" text_color=\"#000000\" text_color_hover=\"#ffffff\" ]More Info[/button]", "filter" => "",);
		$text[6] = array("title" => "Opening hours:", "text" => "<br/><span style=\"color:#fff\">Monday to Friday:</span> 07:30 - 10.30 & 12:00 - 15:00 & 18:00 - 23:00 <hr/> <span style=\"color:#fff\">Saturday and Sunday: </span>8.30 - 10.30 & 12:00 - 15:00 & 18:00 - 23:00", "filter" => "1",);
		$text[7] = array("title" => "Additiona Information", "text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas euismod et quam mattis ultricies. Fusce egestas lectus vitae convallis dignissim. Phasellus nec gravida lectus, nec pretium eros. Duis posuere tellus orci, at hendrerit ante euismod id. Mauris porttitor id purus sed gravida. Nunc ac imperdiet nisi. Fusce vel odio venenatis, lacinia nisl tincidunt, porta nunc. Morbi non erat ut sapien tristique ornare. Duis commodo orci ut justo bibendum pretium. <br/><br/> [button type=\"btn_middle\" url=\"http://themoholics.com\" target=\"\" button_color_fon=\"#fff\" hover_color=\"#242424\" text_color=\"#242424\" text_color_hover=\"#fff\" ]Launch project[/button] ", "filter" => "",);
		$text["_multiwidget"] = 1;
		update_option("widget_text", $text);



// Widget Milano menu
		$milano_menu = get_option("widget_milano-menu");
		$milano_menu[2] = array("title" => "", "menu" => "features",);
		$milano_menu[3] = array("title" => "Menu", "menu" => "menus",);
		$milano_menu["_multiwidget"] = 1;
		update_option("widget_milano-menu", $milano_menu);
	}

}

?>