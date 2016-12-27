<?php

class Custom_MetaBox_Item_Category extends Custom_MetaBox_Item_Default
{
	const CATEGORY_TAX = 'category';
	
	function __construct()
	{
		parent::__construct(self::CATEGORY_TAX);
		$this->setId('category_post_meta_box')
			->setTitle('Category Taxonomy Meta Box');
		$this->addFields();
	}
	
	protected function addFields()
	{
		parent::addFields();
		
		$this->getMetaTaxInstance()->addColor( SHORTNAME . '_cat_color', array('name' => 'Category color'));		
		$this->getMetaTaxInstance()->addSelect( SHORTNAME . '_post_listing_sidebar', $this->getSidebars(), array('name' => 'Sidebar', 'std' => ''));
		$this->getMetaTaxInstance()->addText( SHORTNAME . '_post_listing_number', array('name' => 'Items per page'));
	
		/**
		 * @todo add paragraph text
		 */
	
	}
}
?>
