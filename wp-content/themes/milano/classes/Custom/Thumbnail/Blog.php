<?php
/**
 * Resize thumbnail proportionally by width
 */
class Custom_Thumbnail_Blog extends Custom_Thumbnail
{
	const NOT_CROP = false;
	
	static protected $instance = NULL;
	
	function __construct(Custom_Thumbnail $theme_images_size)
	{
		$this->theme_images = $theme_images_size->getThemeSizes();
	}
	
	static function getInstance(Custom_Thumbnail $theme_images_size)
	{
		if (is_null(self::$instance))
		{
			$c = __CLASS__;
			self::$instance = new $c($theme_images_size);
		}
		return self::$instance;
	}

	protected function isSizeChanged($size_name)
	{
		$current_attachment_meta = $this->getCurrentAttachmentMeta();
		if (is_array($current_attachment_meta) && isset($current_attachment_meta['sizes']) && key_exists($size_name, $current_attachment_meta['sizes']))
		{
			
			$size_meta = $current_attachment_meta['sizes'][$size_name];

			if ($theme_size = $this->getThemeSizeDetailsByName($size_name))
			{
				if ($theme_size[self::WIDTH] != $size_meta[self::WIDTH])
				{
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	 * Registers a new image size in global $_wp_additional_image_sizes;
	 * @param string $name size name
	 * @param array $size details 
	 * @return boolean 
	 */
	protected function addToWPImageSizes($name, $size)
	{
		if(isset($size[self::WIDTH]) && isset($size[self::HEIGHT]))
		{
			add_image_size($name, $size[self::WIDTH], $size[self::HEIGHT], self::NOT_CROP);
			return true;
		}
		return false;
	}
}
?>