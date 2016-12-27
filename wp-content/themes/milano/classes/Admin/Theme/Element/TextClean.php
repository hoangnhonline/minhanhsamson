<?php
/**
 * Class for Text Html element 
 */
class Admin_Theme_Element_TextClean extends Admin_Theme_Menu_Element
{
	protected $option = array(
							'type' => Admin_Theme_Menu_Element::TYPE_TEXT_CLEAN,
						);
	
	public function render()
	{
		ob_start();
		echo $this->getElementHeader();
		?>
			<input  name="<?php echo $this->getId(); ?>" id="<?php echo $this->getId(); ?>" type="<?php echo $this->type; ?>" value="<?php echo get_option( $this->getId() ) ?>" />
		<?php
		echo $this->getElementFooter();
		
		$html = ob_get_clean();
		return $html;
	}
	
	/**
	 * Get value after form submit 
	 */
	public function getRequestValue()
	{
		
		if(isset($_REQUEST[$this->getId()]))
		{
			return str_replace(' ', '', $_REQUEST[$this->getId()]);
		}
		return '';
	}
	
}
?>