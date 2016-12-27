<?php

class Import_Theme_Media extends Import_Theme_Default
{

	function __construct($type)
	{
		parent::__construct($type);
	}

	public function import_restaraunt()
	{
		/**
		 * Slideshow
		 * Portfolio
		 */
		$uploads = wp_upload_dir();
		$filepath = $uploads['path'];
		$attach_ids = array();
		$default_images = array('chicken.jpg',
			'desert.jpg',
			'glasses.jpg',
			'nuggets_bg.jpg',
			'salad.jpg',
			'snack.jpg',
			'steak.jpg',
			'wedding-table.jpg'
		);


		foreach ($default_images as $filename)
		{

			$file = $filepath . "/" . $filename;
			if (file_exists(get_template_directory() . "/classes/Import/images/" . $filename))
			{
				copy(get_template_directory() . "/classes/Import/images/" . $filename, $file);

				$wp_filetype = wp_check_filetype(basename($file), null);
				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', basename($file)),
					'post_content' => '',
					'post_status' => 'inherit'
				);


				$attach_id = wp_insert_attachment($attachment, $file);

				$imagesize = getimagesize($file);

				$metadata = array();
				$metadata['width'] = $imagesize[0];
				$metadata['height'] = $imagesize[1];
				list($uwidth, $uheight) = wp_constrain_dimensions($metadata['width'], $metadata['height'], 128, 96);
				$metadata['hwstring_small'] = "height='$uheight' width='$uwidth'";
				$metadata['file'] = _wp_relative_upload_path($file);

				global $_wp_additional_image_sizes;

				foreach (get_intermediate_image_sizes() as $s)
				{
					$sizes[$s] = array('name' => '', 'width' => '', 'height' => '', 'crop' => FALSE);
					$sizes[$s]['name'] = $s;

					if (isset($_wp_additional_image_sizes[$s]['width']))
						$sizes[$s]['width'] = intval($_wp_additional_image_sizes[$s]['width']);
					else
						$sizes[$s]['width'] = get_option("{$s}_size_w");

					if (isset($_wp_additional_image_sizes[$s]['height']))
						$sizes[$s]['height'] = intval($_wp_additional_image_sizes[$s]['height']);
					else
						$sizes[$s]['height'] = get_option("{$s}_size_h");

					if (isset($_wp_additional_image_sizes[$s]['crop']))
						$sizes[$s]['crop'] = intval($_wp_additional_image_sizes[$s]['crop']);
					else
						$sizes[$s]['crop'] = get_option("{$s}_crop");
				}

				$sizes = apply_filters('intermediate_image_sizes_advanced', $sizes);
				set_time_limit(30);
				foreach ($sizes as $size => $size_data)
				{
					$metadata['sizes'][$size] = image_make_intermediate_size($file, $size_data['width'], $size_data['height'], $size_data['crop']);
				}

				apply_filters('wp_generate_attachment_metadata', $metadata, $attach_id);
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				$att_data = wp_generate_attachment_metadata($attach_id, $file);

				wp_update_attachment_metadata($attach_id, $att_data);

				$attach_ids[] = $attach_id;
			}
		}
		//set default image for all posts	 
		$args = array(
			"post_type" => array('post', Custom_Posts_Type_Slideshow::POST_TYPE, Custom_Posts_Type_Portfolio::POST_TYPE),
			"posts_per_page" => "-1"
		);

		$all_posts = new WP_Query($args);
		while ($all_posts->have_posts()) :
			$all_posts->the_post();
			set_post_thumbnail(get_the_ID(), $attach_ids[array_rand($attach_ids)]);
		endwhile;
	}

	public function import_hotel()
	{
		/**
		 * Slideshow
		 * Portfolio
		 */
		$uploads = wp_upload_dir();
		$filepath = $uploads['path'];
		$attach_ids = array();
		$default_images = array(
			'ho_1.jpg',
			'ho_2.jpg',
			'ho_3.jpg',
			'ho_4.jpg',
			'ho_5.jpg',
			'ho_6.jpg'
		);


		foreach ($default_images as $filename)
		{

			$file = $filepath . "/" . $filename;
			if (file_exists(get_template_directory() . "/classes/Import/images/" . $filename))
			{
				copy(get_template_directory() . "/classes/Import/images/" . $filename, $file);

				$wp_filetype = wp_check_filetype(basename($file), null);
				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', basename($file)),
					'post_content' => '',
					'post_status' => 'inherit'
				);


				$attach_id = wp_insert_attachment($attachment, $file);

				$imagesize = getimagesize($file);

				$metadata = array();
				$metadata['width'] = $imagesize[0];
				$metadata['height'] = $imagesize[1];
				list($uwidth, $uheight) = wp_constrain_dimensions($metadata['width'], $metadata['height'], 128, 96);
				$metadata['hwstring_small'] = "height='$uheight' width='$uwidth'";
				$metadata['file'] = _wp_relative_upload_path($file);

				global $_wp_additional_image_sizes;

				foreach (get_intermediate_image_sizes() as $s)
				{
					$sizes[$s] = array('name' => '', 'width' => '', 'height' => '', 'crop' => FALSE);
					$sizes[$s]['name'] = $s;

					if (isset($_wp_additional_image_sizes[$s]['width']))
						$sizes[$s]['width'] = intval($_wp_additional_image_sizes[$s]['width']);
					else
						$sizes[$s]['width'] = get_option("{$s}_size_w");

					if (isset($_wp_additional_image_sizes[$s]['height']))
						$sizes[$s]['height'] = intval($_wp_additional_image_sizes[$s]['height']);
					else
						$sizes[$s]['height'] = get_option("{$s}_size_h");

					if (isset($_wp_additional_image_sizes[$s]['crop']))
						$sizes[$s]['crop'] = intval($_wp_additional_image_sizes[$s]['crop']);
					else
						$sizes[$s]['crop'] = get_option("{$s}_crop");
				}

				$sizes = apply_filters('intermediate_image_sizes_advanced', $sizes);
				set_time_limit(30);
				foreach ($sizes as $size => $size_data)
				{
					$metadata['sizes'][$size] = image_make_intermediate_size($file, $size_data['width'], $size_data['height'], $size_data['crop']);
				}

				apply_filters('wp_generate_attachment_metadata', $metadata, $attach_id);
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				$att_data = wp_generate_attachment_metadata($attach_id, $file);

				wp_update_attachment_metadata($attach_id, $att_data);

				$attach_ids[] = $attach_id;
			}
		}
		//set default image for all posts	 
		$args = array(
			"post_type" => array('post', Custom_Posts_Type_Slideshow::POST_TYPE, Custom_Posts_Type_Portfolio::POST_TYPE),
			"posts_per_page" => "-1"
		);

		$all_posts = new WP_Query($args);
		while ($all_posts->have_posts()) :
			$all_posts->the_post();
			set_post_thumbnail(get_the_ID(), $attach_ids[array_rand($attach_ids)]);
		endwhile;
	}

	public function import_extreme()
	{
		$uploads = wp_upload_dir();
		$filepath = $uploads['path'];
		$attach_ids = array();
		$default_images = array('ex_2.jpg',
			'ex_3.jpg',
			'ex_4.jpg',
			'ex_5.jpg',
			'ex_6.jpg'
		);


		foreach ($default_images as $filename)
		{

			$file = $filepath . "/" . $filename;
			if (file_exists(get_template_directory() . "/classes/Import/images/" . $filename))
			{
				copy(get_template_directory() . "/classes/Import/images/" . $filename, $file);

				$wp_filetype = wp_check_filetype(basename($file), null);
				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', basename($file)),
					'post_content' => '',
					'post_status' => 'inherit'
				);


				$attach_id = wp_insert_attachment($attachment, $file);

				$imagesize = getimagesize($file);

				$metadata = array();
				$metadata['width'] = $imagesize[0];
				$metadata['height'] = $imagesize[1];
				list($uwidth, $uheight) = wp_constrain_dimensions($metadata['width'], $metadata['height'], 128, 96);
				$metadata['hwstring_small'] = "height='$uheight' width='$uwidth'";
				$metadata['file'] = _wp_relative_upload_path($file);

				global $_wp_additional_image_sizes;

				foreach (get_intermediate_image_sizes() as $s)
				{
					$sizes[$s] = array('name' => '', 'width' => '', 'height' => '', 'crop' => FALSE);
					$sizes[$s]['name'] = $s;

					if (isset($_wp_additional_image_sizes[$s]['width']))
						$sizes[$s]['width'] = intval($_wp_additional_image_sizes[$s]['width']);
					else
						$sizes[$s]['width'] = get_option("{$s}_size_w");

					if (isset($_wp_additional_image_sizes[$s]['height']))
						$sizes[$s]['height'] = intval($_wp_additional_image_sizes[$s]['height']);
					else
						$sizes[$s]['height'] = get_option("{$s}_size_h");

					if (isset($_wp_additional_image_sizes[$s]['crop']))
						$sizes[$s]['crop'] = intval($_wp_additional_image_sizes[$s]['crop']);
					else
						$sizes[$s]['crop'] = get_option("{$s}_crop");
				}

				$sizes = apply_filters('intermediate_image_sizes_advanced', $sizes);
				set_time_limit(30);
				foreach ($sizes as $size => $size_data)
				{
					$metadata['sizes'][$size] = image_make_intermediate_size($file, $size_data['width'], $size_data['height'], $size_data['crop']);
				}

				apply_filters('wp_generate_attachment_metadata', $metadata, $attach_id);
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				$att_data = wp_generate_attachment_metadata($attach_id, $file);

				wp_update_attachment_metadata($attach_id, $att_data);

				$attach_ids[] = $attach_id;
			}
		}
		//set default image for all posts	 
		$args = array(
			"post_type" => array('post', Custom_Posts_Type_Slideshow::POST_TYPE),
			"posts_per_page" => "-1"
		);

		$all_posts = new WP_Query($args);
		$newimages = $attach_ids;
		unset($newimages[4]);
		while ($all_posts->have_posts()) :
			$all_posts->the_post();
			set_post_thumbnail(get_the_ID(), $newimages[array_rand($newimages)]);
		endwhile;


		$args = array(
			"post_type" => array(Custom_Posts_Type_Portfolio::POST_TYPE),
			"posts_per_page" => "-1"
		);

		$all_posts = new WP_Query($args);
		while ($all_posts->have_posts()) :
			$all_posts->the_post();
			set_post_thumbnail(get_the_ID(), $attach_ids[4]);
		endwhile;
	}

}

?>