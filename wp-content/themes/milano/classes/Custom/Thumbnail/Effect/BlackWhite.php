<?php

defined('MEMORY_LIMIT') || define('MEMORY_LIMIT', '30M');	   // Set PHP memory limit
defined('FILE_CACHE_TIME_BETWEEN_CLEANS') || define('FILE_CACHE_TIME_BETWEEN_CLEANS', 86400);	// How often the cache is cleaned
defined('FILE_CACHE_MAX_FILE_AGE') || define('FILE_CACHE_MAX_FILE_AGE', 86400);					// How old does a file have to be to be deleted from the cache
defined('FILE_CACHE_SUFFIX') || define('FILE_CACHE_SUFFIX', '.bweffect.txt');					// What to put at the end of all files in the cache directory so we can identify them
defined('FILE_CACHE_PREFIX') || define('FILE_CACHE_PREFIX', 'bweffect');						// What to put at the beg of all files in the cache directory so we can identify them
defined('MAX_FILE_SIZE') || define('MAX_FILE_SIZE', 10485760);									// 10 Megs is 10485760. This is the max internal or external file size that we'll process.
defined('BROWSER_CACHE_DISABLE') ||	define('BROWSER_CACHE_DISABLE', false);						// Use for testing if you want to disable all browser caching
defined('MAX_WIDTH') || define('MAX_WIDTH', 2500);						// Maximum image width
defined('MAX_HEIGHT') || define('MAX_HEIGHT', 2500);					// Maximum image height
defined('PNG_IS_TRANSPARENT') || define('PNG_IS_TRANSPARENT', FALSE);	// 42 Define if a png image should have a transparent background color. Use False value if you want to display a custom coloured canvas_colour
defined('DEFAULT_Q') || define('DEFAULT_Q', 90);						
defined('DEFAULT_F') || define('DEFAULT_F', '2|4,-15');			
defined('DEFAULT_S') || define('DEFAULT_S', 0);							
defined('DEFAULT_CC') || define('DEFAULT_CC', 'ffffff');				
defined('OPTIPNG_ENABLED') || define('OPTIPNG_ENABLED', false);
defined('OPTIPNG_PATH') || define('OPTIPNG_PATH', '/usr/bin/optipng');		//This will run first because it gives better compression than pngcrush.
defined('PNGCRUSH_ENABLED') || define('PNGCRUSH_ENABLED', false);
defined('PNGCRUSH_PATH') || define('PNGCRUSH_PATH', '/usr/bin/pngcrush');	//This will only run if OPTIPNG_PATH is not set or is not valid

//=============================================================================



class Custom_Thumbnail_Effect_BlackWhite
{
	const FILE_PREFFIX = 'black_';
	protected $src = "";
	protected $is404 = false;
	protected $localImage = "";
	protected $localImageMTime = 0;
	protected $url = false;
	protected $cachefile = '';
	protected $errors = array();
	protected $toDeletes = array();
	protected $cacheDirectory = '';
	protected $cropTop = false;
	protected $salt = "";
	protected $fileCacheVersion = 1; 
	protected $new_width;
	protected $new_height;
	private static $instance = null;

	public function __construct()
	{
		$this->salt = @filemtime(__FILE__) . '-' . @fileinode(__FILE__);
		$this->setTempDir();
		$this->cleanCache();
	}
	
	static function getInstance()
	{
		if (is_null(self::$instance))
		{
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	public function __destruct()
	{
		foreach ($this->toDeletes as $del)
		{
			@unlink($del);
		}
	}

	public function run()
	{
		return $this->serveInternalImage();
	}

	protected function error($err)
	{
		$this->errors[] = $err;
		return false;
	}

	protected function haveErrors()
	{
		if (sizeof($this->errors) > 0)
		{
			return true;
		}
		return false;
	}

	protected function serveInternalImage()
	{
		if (!$this->localImage)
		{
			$this->sanityFail("localImage not set after verifying it earlier in the code.");
			return false;
		}
		$fileSize = filesize($this->localImage);
		if ($fileSize > MAX_FILE_SIZE)
		{
			$this->error("The file you specified is greater than the maximum allowed file size.");
			return false;
		}
		if ($fileSize <= 0)
		{
			$this->error("The file you specified is <= 0 bytes.");
			return false;
		}
		if ($this->processImageAndWriteToCache($this->localImage))
		{
			return $this->saveCachedFile();

		}
		else
		{
			return false;
		}
	}

	protected function cleanCache()
	{
		if (FILE_CACHE_TIME_BETWEEN_CLEANS < 0)
		{
			return;
		}
		$lastCleanFile = $this->cacheDirectory . '/bweffect_cacheLastCleanTime.touch';

		
		if (!is_file($lastCleanFile))
		{
			if (!touch($lastCleanFile))
			{
				$this->error("Could not create cache clean timestamp file.");
			}
			return;
		}
		if (@filemtime($lastCleanFile) < (time() - FILE_CACHE_TIME_BETWEEN_CLEANS))
		{ //Cache was last cleaned more than 1 day ago
			// Very slight race condition here, but worst case we'll have 2 or 3 servers cleaning the cache simultaneously once a day.
			if (!touch($lastCleanFile))
			{
				$this->error("Could not create cache clean timestamp file.");
			}
			$files = glob($this->cacheDirectory . '/*' . FILE_CACHE_SUFFIX);
			if ($files)
			{
				$timeAgo = time() - FILE_CACHE_MAX_FILE_AGE;
				foreach ($files as $file)
				{
					if (@filemtime($file) < $timeAgo)
					{
						@unlink($file);
					}
				}
			}
			return true;
		}
		else
		{
		}
		return false;
	}

	protected function processImageAndWriteToCache($localImage)
	{
		$sData = getimagesize($localImage);
		$origType = $sData[2];
		$mimeType = $sData['mime'];

		if (!preg_match('/^image\/(?:gif|jpg|jpeg|png)$/i', $mimeType))
		{
			return $this->error("The image being resized is not a valid gif, jpg or png.");
		}

		if (!function_exists('imagecreatetruecolor'))
		{
			return $this->error('GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library');
		}

		if (function_exists('imagefilter') && defined('IMG_FILTER_NEGATE'))
		{
			$imageFilters = array(
				1 => array(IMG_FILTER_NEGATE, 0),
				2 => array(IMG_FILTER_GRAYSCALE, 0),
				3 => array(IMG_FILTER_BRIGHTNESS, 1),
				4 => array(IMG_FILTER_CONTRAST, 1),
				5 => array(IMG_FILTER_COLORIZE, 4),
				6 => array(IMG_FILTER_EDGEDETECT, 0),
				7 => array(IMG_FILTER_EMBOSS, 0),
				8 => array(IMG_FILTER_GAUSSIAN_BLUR, 0),
				9 => array(IMG_FILTER_SELECTIVE_BLUR, 0),
				10 => array(IMG_FILTER_MEAN_REMOVAL, 0),
				11 => array(IMG_FILTER_SMOOTH, 0),
			);
		}

		// get standard input properties
		$new_width = (int) abs($this->param('w', $this->getWidth()));
		$new_height = (int) abs($this->param('h', $this->getHeight()));
		$zoom_crop = (int) $this->param('zc', 0);
		$quality = (int) abs($this->param('q', DEFAULT_Q));
		$align = $this->cropTop ? 't' : $this->param('a', 'c');
		$filters = $this->param('f', DEFAULT_F);
		$sharpen = (bool) $this->param('s', DEFAULT_S);
		$canvas_color = $this->param('cc', DEFAULT_CC);
		$canvas_trans = (bool) $this->param('ct', '1');

		// set default width and height if neither are set already
		if ($new_width == 0 && $new_height == 0)
		{
			$new_width = Custom_Thumbnail_Post::DEFAULT_WIDTH;
			$new_height = Custom_Thumbnail_Post::DEFAULT_HEIGHT;
		}

		// ensure size limits can not be abused
		$new_width = min($new_width, MAX_WIDTH);
		$new_height = min($new_height, MAX_HEIGHT);

		// set memory limit to be able to have enough space to resize larger images
		$this->setMemoryLimit();

		// open the existing image
		$image = $this->openImage($mimeType, $localImage);
		if ($image === false)
		{
			return $this->error('Unable to open image.');
		}

		// Get original width and height
		$width = imagesx($image);
		$height = imagesy($image);

		$origin_x = 0;
		$origin_y = 0;

		// generate new w/h if not provided
		if ($new_width && !$new_height)
		{
			$new_height = floor($height * ($new_width / $width));
		}
		else if ($new_height && !$new_width)
		{
			$new_width = floor($width * ($new_height / $height));
		}

		// scale down and add borders
		if ($zoom_crop == 3)
		{

			$final_height = $height * ($new_width / $width);

			if ($final_height > $new_height)
			{
				$new_width = $width * ($new_height / $height);
			}
			else
			{
				$new_height = $final_height;
			}
		}

		// create a new true color image
		$canvas = imagecreatetruecolor($new_width, $new_height);
		imagealphablending($canvas, false);

		if (strlen($canvas_color) == 3)
		{ //if is 3-char notation, edit string into 6-char notation
			$canvas_color = str_repeat(substr($canvas_color, 0, 1), 2) . str_repeat(substr($canvas_color, 1, 1), 2) . str_repeat(substr($canvas_color, 2, 1), 2);
		}
		else if (strlen($canvas_color) != 6)
		{
			$canvas_color = DEFAULT_CC; // on error return default canvas color
		}

		$canvas_color_R = hexdec(substr($canvas_color, 0, 2));
		$canvas_color_G = hexdec(substr($canvas_color, 2, 2));
		$canvas_color_B = hexdec(substr($canvas_color, 4, 2));

		// Create a new transparent color for image
		// If is a png and PNG_IS_TRANSPARENT is false then remove the alpha transparency
		// (and if is set a canvas color show it in the background)
		if (preg_match('/^image\/png$/i', $mimeType) && !PNG_IS_TRANSPARENT && $canvas_trans)
		{
			$color = imagecolorallocatealpha($canvas, $canvas_color_R, $canvas_color_G, $canvas_color_B, 127);
		}
		else
		{
			$color = imagecolorallocatealpha($canvas, $canvas_color_R, $canvas_color_G, $canvas_color_B, 0);
		}


		// Completely fill the background of the new image with allocated color.
		imagefill($canvas, 0, 0, $color);

		// scale down and add borders
		if ($zoom_crop == 2)
		{

			$final_height = $height * ($new_width / $width);

			if ($final_height > $new_height)
			{

				$origin_x = $new_width / 2;
				$new_width = $width * ($new_height / $height);
				$origin_x = round($origin_x - ($new_width / 2));
			}
			else
			{

				$origin_y = $new_height / 2;
				$new_height = $final_height;
				$origin_y = round($origin_y - ($new_height / 2));
			}
		}

		// Restore transparency blending
		imagesavealpha($canvas, true);

		if ($zoom_crop > 0)
		{

			$src_x = $src_y = 0;
			$src_w = $width;
			$src_h = $height;

			$cmp_x = $width / $new_width;
			$cmp_y = $height / $new_height;

			// calculate x or y coordinate and width or height of source
			if ($cmp_x > $cmp_y)
			{

				$src_w = round($width / $cmp_x * $cmp_y);
				$src_x = round(($width - ($width / $cmp_x * $cmp_y)) / 2);
			}
			else if ($cmp_y > $cmp_x)
			{

				$src_h = round($height / $cmp_y * $cmp_x);
				$src_y = round(($height - ($height / $cmp_y * $cmp_x)) / 2);
			}

			// positional cropping!
			if ($align)
			{
				if (strpos($align, 't') !== false)
				{
					$src_y = 0;
				}
				if (strpos($align, 'b') !== false)
				{
					$src_y = $height - $src_h;
				}
				if (strpos($align, 'l') !== false)
				{
					$src_x = 0;
				}
				if (strpos($align, 'r') !== false)
				{
					$src_x = $width - $src_w;
				}
			}

			imagecopyresampled($canvas, $image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);
		}
		else
		{

			// copy and resize part of an image with resampling
			imagecopyresampled($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		}

		if ($filters != '' && function_exists('imagefilter') && defined('IMG_FILTER_NEGATE'))
		{
			// apply filters to image
			$filterList = explode('|', $filters);
			foreach ($filterList as $fl)
			{

				$filterSettings = explode(',', $fl);
				if (isset($imageFilters[$filterSettings[0]]))
				{

					for ($i = 0; $i < 4; $i++)
					{
						if (!isset($filterSettings[$i]))
						{
							$filterSettings[$i] = null;
						}
						else
						{
							$filterSettings[$i] = (int) $filterSettings[$i];
						}
					}

					switch ($imageFilters[$filterSettings[0]][1])
					{

						case 1:

							imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1]);
							break;

						case 2:

							imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2]);
							break;

						case 3:

							imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2], $filterSettings[3]);
							break;

						case 4:

							imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2], $filterSettings[3], $filterSettings[4]);
							break;

						default:

							imagefilter($canvas, $imageFilters[$filterSettings[0]][0]);
							break;
					}
				}
			}
		}

		// sharpen image
		if ($sharpen && function_exists('imageconvolution'))
		{

			$sharpenMatrix = array(
				array(-1, -1, -1),
				array(-1, 16, -1),
				array(-1, -1, -1),
			);

			$divisor = 8;
			$offset = 0;

			imageconvolution($canvas, $sharpenMatrix, $divisor, $offset);
		}
		//Straight from Wordpress core code. Reduces filesize by up to 70% for PNG's
		if ((IMAGETYPE_PNG == $origType || IMAGETYPE_GIF == $origType) && function_exists('imageistruecolor') && !imageistruecolor($image) && imagecolortransparent($image) > 0)
		{
			imagetruecolortopalette($canvas, false, imagecolorstotal($image));
		}

		$imgType = "";
		$tempfile = tempnam($this->cacheDirectory, 'bweffect_tmpimg_');
		if (preg_match('/^image\/(?:jpg|jpeg)$/i', $mimeType))
		{
			$imgType = 'jpg';
			imagejpeg($canvas, $tempfile, $quality);
		}
		else if (preg_match('/^image\/png$/i', $mimeType))
		{
			$imgType = 'png';
			imagepng($canvas, $tempfile, floor($quality * 0.09));
		}
		else if (preg_match('/^image\/gif$/i', $mimeType))
		{
			$imgType = 'gif';
			imagegif($canvas, $tempfile);
		}
		else
		{
			return $this->sanityFail("Could not match mime type after verifying it previously.");
		}

		if ($imgType == 'png' && OPTIPNG_ENABLED && OPTIPNG_PATH && @is_file(OPTIPNG_PATH))
		{
			$exec = OPTIPNG_PATH;
			$presize = filesize($tempfile);
			$out = `$exec -o1 $tempfile`; //you can use up to -o7 but it really slows things down
			clearstatcache();
			$aftersize = filesize($tempfile);
			$sizeDrop = $presize - $aftersize;
			if ($sizeDrop > 0)
			{
			}
			else if ($sizeDrop < 0)
			{
			}
			else
			{
			}
		}
		else if ($imgType == 'png' && PNGCRUSH_ENABLED && PNGCRUSH_PATH && @is_file(PNGCRUSH_PATH))
		{
			$exec = PNGCRUSH_PATH;
			$tempfile2 = tempnam($this->cacheDirectory, 'bweffect_tmpimg_');
			$out = `$exec $tempfile $tempfile2`;
			$todel = "";
			if (is_file($tempfile2))
			{
				$sizeDrop = filesize($tempfile) - filesize($tempfile2);
				if ($sizeDrop > 0)
				{
					$todel = $tempfile;
					$tempfile = $tempfile2;
				}
				else
				{
					$todel = $tempfile2;
				}
			}
			else
			{
				$todel = $tempfile2;
			}
			@unlink($todel);
		}

		$tempfile4 = tempnam($this->cacheDirectory, 'bweffect_tmpimg_');
		$context = stream_context_create();
		$fp = fopen($tempfile, 'r', 0, $context);
		file_put_contents($tempfile4, $fp, FILE_APPEND);
		fclose($fp);
		@unlink($tempfile);
		$lockFile = $this->cachefile . '.lock';
		$fh = fopen($lockFile, 'w');
		if (!$fh)
		{
			return $this->error("Could not open the lockfile for writing an image.");
		}
		if (flock($fh, LOCK_EX))
		{
			@unlink($this->cachefile); //rename generally overwrites, but doing this in case of platform specific quirks. File might not exist yet.
			@rename($tempfile4, $this->cachefile);
			flock($fh, LOCK_UN);
			fclose($fh);
			@unlink($lockFile);
		}
		else
		{
			fclose($fh);
			@unlink($lockFile);
			@unlink($tempfile4);
			return $this->error("Could not get a lock for writing.");
		}
		imagedestroy($canvas);
		imagedestroy($image);
		return true;
	}

	protected function getLocalImagePath($src)
	{

		$src = ltrim($src, '/'); //strip off the leading '/'
//		//Try src under docRoot
		if (file_exists($src))
		{
			$real = $this->realpath($src);
			return $real;
		}
		//Check absolute paths and then verify the real path is under doc root
		$absolute = $this->realpath('/' . $src);
		if ($absolute && file_exists($absolute))
		{
			//realpath does file_exists check, so can probably skip the exists check here
			return $absolute;
		}
		return false;
	}

	protected function realpath($path)
	{
		//try to remove any relative paths
		$remove_relatives = '/\w+\/\.\.\//';
		while (preg_match($remove_relatives, $path))
		{
			$path = preg_replace($remove_relatives, '', $path);
		}
		//if any remain use PHP realpath to strip them out, otherwise return $path
		//if using realpath, any symlinks will also be resolved
		return preg_match('#^\.\./|/\.\./#', $path) ? realpath($path) : $path;
	}

	protected function toDelete($name)
	{
		$this->toDeletes[] = $name;
	}

	protected function saveCachedFile()
	{
		if(is_file($this->cachefile))
		{
			$pathinfo = pathinfo($this->src);

			$path = $pathinfo['dirname'];
			$filename = $pathinfo['basename'];
			if( is_writable($path) )
			{
				$new_file_name = self::FILE_PREFFIX . $filename;
				$copy =  @copy($this->cachefile, $path .DIRECTORY_SEPARATOR. $new_file_name);
				
				$this->unlink($this->cachefile);
				return $copy;
			}
		}
		return false;
	}
	
	protected function unlink($path)
	{
		if(file_exists($path))
			@unlink($path);
	}


	protected function param($property, $default = '')
	{
		if (isset($_GET[$property]))
		{
			return $_GET[$property];
		}
		else
		{
			return $default;
		}
	}

	protected function openImage($mimeType, $src)
	{
		switch ($mimeType)
		{
			case 'image/jpeg':
				$image = imagecreatefromjpeg($src);
				break;

			case 'image/png':
				$image = imagecreatefrompng($src);
				break;

			case 'image/gif':
				$image = imagecreatefromgif($src);
				break;

			default:
				$this->error("Unrecognised mimeType");
		}

		return $image;
	}

	protected function sanityFail($msg)
	{
		return $this->error("There is a problem in the  code: $msg");
	}

	protected function getMimeType($file)
	{
		$info = getimagesize($file);
		if (is_array($info) && $info['mime'])
		{
			return $info['mime'];
		}
		return '';
	}

	protected function setMemoryLimit()
	{
		$inimem = ini_get('memory_limit');
		$inibytes = Custom_Thumbnail_Effect_BlackWhite::returnBytes($inimem);
		$ourbytes = Custom_Thumbnail_Effect_BlackWhite::returnBytes(MEMORY_LIMIT);
		if ($inibytes < $ourbytes)
		{
			ini_set('memory_limit', MEMORY_LIMIT);
		}
	}

	protected static function returnBytes($size_str)
	{
		switch (substr($size_str, -1))
		{
			case 'M': case 'm': return (int) $size_str * 1048576;
			case 'K': case 'k': return (int) $size_str * 1024;
			case 'G': case 'g': return (int) $size_str * 1073741824;
			default: return $size_str;
		}
	}

	protected function set404()
	{
		$this->is404 = true;
	}

	/**
	 * path to file
	 * @param type $src
	 * @return \Custom_Thumbnail_Effect_BlackWhite
	 */
	public function setSRC($src)
	{
		$this->src = $src;
		$this->setURL();
		$this->localImage = $this->getLocalImagePath($this->src);

		$this->localImageMTime = @filemtime($this->localImage);
		$this->cachefile = $this->cacheDirectory . '/' . FILE_CACHE_PREFIX . '_int_' . md5($this->salt . $this->localImageMTime . $_SERVER ['QUERY_STRING'] . $this->fileCacheVersion) . FILE_CACHE_SUFFIX;
		return $this;
	}

	protected function setTempDir()
	{
		$uploads = wp_upload_dir();
		if($uploads && $uploads['error'] === false)
		{
			$this->cacheDirectory = $uploads['basedir'] . DIRECTORY_SEPARATOR . 'tempThumbnails';
			
			if(!is_dir($this->cacheDirectory))
			{
				if(!mkdir($this->cacheDirectory))
				{
					$this->cacheDirectory = sys_get_temp_dir();
				}
			}
		}
		else
		{
			$this->cacheDirectory = sys_get_temp_dir();
		}
	}

	protected function setURL()
	{
		$this->url = parse_url($this->src);
	}

	protected function getSRC()
	{
		return $this->src;
	}

	public function setWidth($width)
	{
		$this->new_width = (int) $width;
		return $this;
	}

	public function setHeight($height)
	{
		$this->new_height = (int) $height;
		return $this;
	}
	public function getWidth()
	{
		return $this->new_width;
	}

	public function getHeight()
	{
		return $this->new_height;
	}
}