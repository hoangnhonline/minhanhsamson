<?php

class Import_Theme_Meta extends Import_Theme_Default
{

	function __construct($type)
	{
		parent::__construct($type);
	}

	public function import_restaraunt()
	{
		$path = get_template_directory_uri() . "/classes/Import/images/";

		$meta_images = array(
			$path . 'chicken.jpg',
			$path . 'desert.jpg',
			$path . 'glasses.jpg',
			$path . 'nuggets_bg.jpg',
			$path . 'salad.jpg',
			$path . 'snack.jpg',
			$path . 'steak.jpg',
			$path . 'wedding-table.jpg'
		);

//set default image for all posts
		$args = array(
			"post_type" => array('post', 'page', Custom_Posts_Type_Slideshow::POST_TYPE, Custom_Posts_Type_Portfolio::POST_TYPE),
			"posts_per_page" => "-1",
		);

		$all_posts = new WP_Query($args);
		while ($all_posts->have_posts()) :
			$all_posts->the_post();
			$option = get_post_meta(get_the_ID(), SHORTNAME . '_slideshow_option');
			if (isset($option[0]) && $option[0] == 'image')
			{
				$image = $meta_images[array_rand($meta_images)];
				update_post_meta(get_the_ID(), SHORTNAME . '_bg_image', $image);
			}
		endwhile;

		update_post_meta(19, SHORTNAME . '_slideshow_cat', unserialize('a:1:{i:0;s:1:"5";}'));
	}

	public function import_hotel()
	{
		$path = get_template_directory_uri() . "/classes/Import/images/";

		$meta_images = array(
			$path . 'ho_1.jpg',
			$path . 'ho_2.jpg',
			$path . 'ho_3.jpg',
			$path . 'ho_4.jpg',
			$path . 'ho_5.jpg',
			$path . 'ho_6.jpg'			
		);

//set default image for all posts
		$args = array(
			"post_type" => array('post', 'page', Custom_Posts_Type_Slideshow::POST_TYPE, Custom_Posts_Type_Portfolio::POST_TYPE),
			"posts_per_page" => "-1",
		);

		$all_posts = new WP_Query($args);
		while ($all_posts->have_posts()) :
			$all_posts->the_post();
			$option = get_post_meta(get_the_ID(), SHORTNAME . '_slideshow_option');
			if (isset($option[0]) && $option[0] == 'image')
			{
				$image = $meta_images[array_rand($meta_images)];
				update_post_meta(get_the_ID(), SHORTNAME . '_bg_image', $image);
			}
		endwhile;

		update_post_meta(19, SHORTNAME . '_slideshow_cat', unserialize('a:1:{i:0;s:2:"30";}'));
	}

	public function import_extreme()
	{
		$path = get_template_directory_uri() . "/classes/Import/images/";

		$meta_images = array(
			$path . 'ex_1.jpg'
		);

//set default image for all posts
		$args = array(
			"post_type" => array('post', 'page', Custom_Posts_Type_Slideshow::POST_TYPE, Custom_Posts_Type_Portfolio::POST_TYPE),
			"posts_per_page" => "-1",
		);

		$all_posts = new WP_Query($args);
		while ($all_posts->have_posts()) :
			$all_posts->the_post();
			$option = get_post_meta(get_the_ID(), SHORTNAME . '_slideshow_option');
			if (isset($option[0]) && $option[0] == 'image')
			{
				$image = $meta_images[array_rand($meta_images)];
				update_post_meta(get_the_ID(), SHORTNAME . '_bg_image', $image);
			}
		endwhile;

		update_post_meta(19, SHORTNAME . '_slideshow_cat', unserialize('a:1:{i:0;s:2:"16";}'));
	}

}

?>