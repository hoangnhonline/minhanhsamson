<?php

class Custom_Thumbnail_Portfolio extends Custom_Thumbnail_Post
{
	/**
	 * Page width
	 * @var int 
	 */
	private $page_width;
	
	/**
	 * Page height
	 * @var int
	 */
	private $page_height;
	
	private $portfolio_page_id;
	
		
	static function getInstance()
	{
		if (is_null(self::$instance))
		{
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	/**
	 * 
	 * @param type $id Portfolio custom post type ID
	 * @param type $page_w Portfolio Page width
	 * @param type $page_h Portfolio Page height
	 * @param type $portfolio_page_id Portfolio Page ID 
	 */
	public function getThumbnail($id, $page_w, $page_h, $portfolio_page_id = '')
	{
		$this->setPageWidth($page_w);
		$this->setPageHeight($page_h);

		
		parent::getThumbnail($id);
	}
	
	
	
	/**
	 * Set page width
	 * @param int $page_w page width
	 */
	private function setPageWidth($page_w)
	{
		$this->page_width = (int) $page_w;
	}

	/**
	 * Set page height
	 * @param int $page_h page height
	 */
	private function setPageHeight($page_h)
	{
		$this->page_height = (int) $page_h;
	}
	
	/**
	 * Get page width
	 * @param int page width
	 */	
	private function getPageWidth()
	{
		return $this->page_width;
	}
	
	/**
	 * Get page height
	 * @param intpage height
	 */
	private function getPageHeight()
	{
		return $this->page_height;
	}
	

}
?>