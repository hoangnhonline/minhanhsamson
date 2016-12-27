<?php
/**
 * Class for Upload Images Html element
 */
class Admin_Theme_Element_AudioUploader extends Admin_Theme_Menu_Element
{
	protected $is_customized = Admin_Theme_Menu_Element::CUSTOMIZED; // file element is customized by default
	
	protected $option = array(
		'type' => Admin_Theme_Menu_Element::TYPE_FILE,
	);
	
	public function render()
	{
		if(function_exists( 'wp_enqueue_media' )) {
			wp_enqueue_media();
		} else {
			wp_enqueue_style('thickbox');
			wp_enqueue_script('thickbox');
		}
		ob_start();
		echo $this->getElementHeader();
		$meta_audio = get_option($this->id); 
		?>
		<input type="text" value="<?php echo $meta_audio ?>" id="sound_<?php echo $this->id; ?>" name="<?php echo $this->id; ?>" />
		<input type="button" data-option="<?php echo $this->id; ?>" id="file_up_<?php echo $this->id; ?>" class="button" value="<?php _e('Upload', 'milano') ?>" data-type="sound" />
		<?php
		echo $this->getElementFooter();
		$html = ob_get_clean();
		return $html;
		
	}
}