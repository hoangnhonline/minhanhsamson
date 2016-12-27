<?php
/**
 * Class for Upload Images Html element
 */
class Admin_Theme_Element_ImageUploader extends Admin_Theme_Menu_Element
{
	protected $is_customized = Admin_Theme_Menu_Element::CUSTOMIZED; // file element is customized by default
	
	protected $option = array(
		'type' => Admin_Theme_Menu_Element::TYPE_FILE,
	);
	
	public function save()
	{
		$data = array();
		if($this->getRequestValue()) {
			foreach($this->getRequestValue() as $val) {
				$data[] = $val;
			}
		}
		if($this->getId()) {
			update_option($this->getId(), $data);
		}
	}
	
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
		?><div class="images_cont"><?php
		$meta_images = get_option($this->id);

		if (is_array($meta_images)) { 
			foreach($meta_images as $k=>$image) { ?>
				<div class="slide" data-id="<?php echo $k;?>">
					<div class="float-left image_wrap">
						<img src="<?php echo $image['src'] ?>" class="ml_img" title="<img src='<?php echo $image['src']; ?>' alt='' />"  />
					</div>
					<input type="hidden" name="<?php echo $this->id; ?>[<?php echo $k?>][src]" value="<?php echo $image['src'];?>" />
					<input type="hidden" name="<?php echo $this->id; ?>[<?php echo $k?>][type]" value="<?php echo $image['type'];?>" />
					<input type="button" class="button slide_rm" value="Delete" />
					<div style="clear: both;"></div>
				</div>
			<?php }
		} ?>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('.Slides .images_cont').sortable();
			});
		</script>
			<!--<div class="image-label">-->
				<input type="button" data-option="<?php echo $this->id; ?>" id="file_up_<?php echo $this->id; ?>" class="button" value="<?php _e('Add', 'milano') ?>" data-type="multiple" />
			<!--</div>-->
		<?php
		echo $this->getElementFooter();
		$html = ob_get_clean();
		return $html;
		
	}
}