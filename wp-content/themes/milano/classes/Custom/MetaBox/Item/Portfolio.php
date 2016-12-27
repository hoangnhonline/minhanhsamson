<?php

class Custom_MetaBox_Item_Portfolio extends Custom_MetaBox_Item_Default
{
	
	function __construct($taxonomy)
	{
		parent::__construct($taxonomy);
		$this->setId('gallery_meta_box')
			->setTitle('Gallery Taxonomy Meta Box');
		$this->addFields();
	}
	
	protected function addFields()
	{
		parent::addFields();
		
		
		$this->getMetaTaxInstance()->addText( SHORTNAME . '_portfolio_thumb_width',  array('name' => 'Thumbnail width (px)', 'std' => '306'));
		$this->getMetaTaxInstance()->addText( SHORTNAME . '_portfolio_thumb_height',  array('name' => 'Thumbnail height (px)', 'std' => '400'));


	}
}
?>