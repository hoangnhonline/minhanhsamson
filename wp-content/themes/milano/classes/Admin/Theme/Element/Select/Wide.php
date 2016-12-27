<?php

/**
 * Class for Select Html element with short background
 */
class Admin_Theme_Element_Select_Wide extends Admin_Theme_Element_Select
{
	public function render()
	{
		ob_start();
		echo $this->getElementHeader();
		$cur = false;
		?>
		<select name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>" class="select_wide">
				<?php foreach ($this->options as $option) { ?>
					<option 
						<?php if ( get_option( $this->id ) == $option) 
						{
							echo ' selected="selected"';
							$cur = true; 
						}
						elseif($option == $this->std && !$cur)
						{
							echo ' selected="selected"'; 
							
						}
						?>>
							<?php echo $option; ?>
					</option>
				<?php } ?>
		</select>
		<?php
		echo $this->getElementFooter();
		 
		 $html = ob_get_clean();
		 return $html;
	}
	
	/**
	 * array of values for WP customizing Select 'value'=>'value'
	 * @return array
	 */
	protected function getSelectOptionForCustomizing()
	{
		$result = array();
		if($this->options && is_array($this->options))
		{
			foreach($this->options as $option)
			{
				$result[$option] = $option;
			}
		}
		return $result;
	}
	
}
?>