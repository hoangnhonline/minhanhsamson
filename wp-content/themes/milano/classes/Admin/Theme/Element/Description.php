<?php
/**
 * Class for Separator Html
 */
class Admin_Theme_Element_Description extends Admin_Theme_Menu_Element
{
	protected $option = array(
							'type' => Admin_Theme_Menu_Element::TYPE_SEPARATOR,
						);

	public function render()
	{
		return '<div class="description"><div>'.  $this->getName() .'</div></div>';
	}
}
?>