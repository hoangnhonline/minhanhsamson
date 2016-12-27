<?php


class Custom_Thumbnail_Retina extends Custom_Thumbnail
{
	/**
	 * Custom_Thumbnail_Multi id argument<br/>
	 * Used to build the CSS class for the admin meta box.<br/>
	 * Needs to be unique and valid in a CSS class selector.
	 */
	const META_ID = 'retina';
	
	/**
	 * Image ratio 
	 */
	const RATIO = 2;
	
	protected $theme_images = array();
	
	
	public function __construct($sizes = array())
	{
		$this->theme_images = $sizes;
	}
	
	protected function getThemeSizeDetailsByName($size_name)
	{
		if(isset($this->theme_images[$size_name]))
		{
			return $this->theme_images[$size_name];
		}
		return false;
	}
	
	/**
	 * Check has post "retina" image
	 * @param int $post_id post id for check
	 * @return boolean
	 */
	public static function isRetinaThumbnail($post_id)
	{
		if($post_type = get_post_type($post_id))
		{
			return Custom_Thumbnail_Multi::has_post_thumbnail($post_type, self::META_ID, $post_id);
		}
		
		return false;
	}


	/**
	 * get Retina thumbnail id for this post
	 * @param int $post_id post ID
	 * @return int
	 */
	protected function getPostThumbnailId($post_id)
	{
		if($post_type = get_post_type($post_id))
		{
			return Custom_Thumbnail_Multi::get_post_thumbnail_id($post_type, self::META_ID, $post_id);
		}
		return false;
	}
	
	/**
	 * Getting retina image src 
	 * @param int $post_id post Id
	 * @param string $size_name image size name
	 * @return string
	 */
	public function getRetinaImageSrc($post_id, $size_name)
	{
		ob_start();
		$this->getThumbnail($post_id, $size_name);
		
		$html =  ob_get_clean();
		if($html)
		{
			if(class_exists('DOMDocument'))
			{
				$dom = new DOMDocument();
				$dom->loadHTML($html);
				$tags = $dom->getElementsByTagName('img');

				foreach ($tags as $tag) {
					return $tag->getAttribute('src');
				}
			}
			else
			{
				preg_match( '@src="([^"]+)"@' , $html , $match );
				if(isset($match[1]))
				{
					return $match[1];
				}
			}
		}
		return false;
		
	}
	
	protected function getClearedHTML($id, $size_name)
	{
		$html = Custom_Thumbnail_Multi::get_the_post_thumbnail(get_post_type($id), self::META_ID, $id, $size_name);
		$cleaned_html = preg_replace(array('/\swidth="\d+"/', '/\sheight="\d+"/'), '', $html);
		
		return $cleaned_html;
	}


	protected function isSizeChanged($size_name)
	{
		$current_attachment_meta = $this->getCurrentAttachmentMeta();
		if(is_array($current_attachment_meta) && isset($current_attachment_meta['sizes']) && key_exists($size_name, $current_attachment_meta['sizes']))
		{
			/**
			 * i.e. :
					array (
					'file' => 'v1-287x300.jpg',
					'width' => '287',
					'height' => '300',
					),
			 */
			$size_meta = $current_attachment_meta['sizes'][$size_name];
			
			if($theme_size = $this->getThemeSizeDetailsByName($size_name))
			{
				if($theme_size[self::WIDTH]  * self::RATIO != $size_meta[self::WIDTH]
					|| $theme_size[self::HEIGHT]  * self::RATIO != $size_meta[self::HEIGHT])
				{
					return true;
				}
			}
		}
		return false;
	}
	
	protected function addToWPImageSizes($name, $size)
	{
		if(isset($size[self::WIDTH]) && isset($size[self::HEIGHT]))
		{
			
			add_image_size($name, $size[self::WIDTH] * self::RATIO, $size[self::HEIGHT] * self::RATIO, true);
			return true;
		}
		return false;
	}
}
?>
