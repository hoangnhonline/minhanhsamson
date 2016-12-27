<?php

class Custom_MetaBox_Item_Tag extends Custom_MetaBox_Item_Default
{
	const TAG_TAX = 'post_tag';
	
	function __construct()
	{
		parent::__construct(self::TAG_TAX);
		$this->setId('tag_post_meta_box')
			->setTitle('Tag Taxonomy Meta Box');
		$this->addFields();
	}
	
	protected function addFields()
	{
		parent::addFields();
		$this->getMetaTaxInstance()->addColor( SHORTNAME . '_cat_color', array('name' => 'Tag color'));		
		$this->getMetaTaxInstance()->addSelect( SHORTNAME . '_post_listing_sidebar', $this->getSidebars(), array('name' => 'Sidebar', 'std' => ''));
		$this->getMetaTaxInstance()->addText( SHORTNAME . '_post_listing_number', array('name' => 'Items per page'));
		
		/**
		 * @todo add paragraph text
		 */
		
	}
}
?>
