<?php
/**
 * Class for Separator Html
 */
class Admin_Theme_Element_Separator extends Admin_Theme_Menu_Element
{
	protected $option = array(
							'type' => Admin_Theme_Menu_Element::TYPE_SEPARATOR,
						);	
	
	public function render()
	{
		return '<a href="#ml_top" class="ml_top"><span>top</span></a>';
	}
}
?>
