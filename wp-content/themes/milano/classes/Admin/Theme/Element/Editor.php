<?php
/**
 * Class for Text Html element 
 */
class Admin_Theme_Element_Editor extends Admin_Theme_Menu_Element
{
	protected $option = array(
							'type' => Admin_Theme_Menu_Element::TYPE_TEXT,
						);
	
	public function render()
	{
		ob_start();
		echo $this->getElementHeader();
		wp_editor($this->getCurrentValue(), $this->getId(),  array('media_buttons' => false,
																	'tinymce' => array( 
																		'theme_advanced_buttons1' => 'formatselect,forecolor,|,bold,italic,underline,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,spellchecker,wp_fullscreen,wp_adv' ,
																		'theme_advanced_buttons3' =>  "highlight,notifications,buttons,social_link,social_button",
																		)
			) );
		echo $this->getElementFooter();
		
		$html = ob_get_clean();
		return $html;
	}

	/**
	 * Get element HTML header
	 * @return string
	 */
	protected function getElementHeader()
	{
		ob_start();
		?>
		<li class="info_top">
			<label for="<?php echo $this->id; ?>">
				<?php echo $this->name; ?>
			</label>
				<a href="#" title="<?php echo $this->desc; ?>" class="ml_help">
					<img src="<?php echo get_template_directory_uri() . '/images/img/help.png'; ?>"  alt="" />
				</a><br /><br />
		<?php
		$html = ob_get_clean();
		
		return $html;
	}
	
	private function getCurrentValue()
	{
		return get_option($this->getId());
	}
}
?>
