<?php
/**
 * Class for Select sidebar Html element
 * @todo No page using this element
 * @uses NO
 */
class Admin_Theme_Element_SelectSidebar extends Admin_Theme_Menu_Element
{
	protected $option = array(
							'type' => Admin_Theme_Menu_Element::TYPE_SELECT_SIDEBAR,
						);
	
	/**
	 * @return string 
	 */
	public function render()
	{
		ob_start();
			echo $this->getElementHeader();
			?>
				<select name="<?php echo $this->id; ?>">
					<?php
					$cur = get_option($this->id);
					
					$sidebars = Sidebar_Generator::get_sidebars();
					
					if(is_array($sidebars) && !empty($sidebars))
					{
						foreach($sidebars as $sidebar_class => $sidebar)
						{
							if($cur == $sidebar_class)
							{
								echo "<option value='$sidebar_class' selected>$sidebar</option>\n";
							}
							else
							{
								echo "<option value='$sidebar_class'>$sidebar</option>\n";
							}
						}
					}
					?>
				</select>
			<?php
			echo $this->getElementFooter();
		$html = ob_get_clean();
		
		return $html;
	}
}
?>
