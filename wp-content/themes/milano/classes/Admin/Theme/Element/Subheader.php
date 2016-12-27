<?php
/**
 * Class for Separator Html
 */
class Admin_Theme_Element_Subheader extends Admin_Theme_Menu_Element
{
	protected $option = array(
							'type' => Admin_Theme_Menu_Element::TYPE_SEPARATOR,
						);

	public function render()
	{
		return '<li data-group="'.$this->group.'" class="subheader "><h3>'. $this->getName() .'</h3></li>';
	}
}
?>