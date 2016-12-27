<?php
/**
 * 'Footer' admin menu page
 */
class Admin_Theme_Item_Sidebar extends Admin_Theme_Menu_Item
{
	public function __construct($parent_slug = '')
	{
		
		$this->setPageTitle('Sidebars');
		$this->setMenuTitle('Sidebars');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME . '_sidebars');
		parent::__construct($parent_slug);
		$this->init();
	}

	public function init()
	{
		
		$option = null;
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('Sidebars Settings');
		$this->addOption($option);
		
		
		$option = new Admin_Theme_Element_Colorchooser();
		$option->setName('Sidebar background color')
				->setDescription('Please select your custom color for sidebar background.')
				->setId( SHORTNAME."_sidebar_background_color")
				->setStd('#1d1d1e');
		$this->addOption($option);
		$option = null;
		
		
		
		
		
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Widget heading color')
					->setDescription('Select your custom color for widget headers.')
					->setId(SHORTNAME . '_widget_header_color')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Widget content color')
					->setDescription('Select your custom color for content.')
					->setId(SHORTNAME . '_widget_content_color')
					->setStd('#79797a');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Widget link color')
					->setDescription('Select your custom color for widget links.')
					->setId(SHORTNAME . '_widget_link_color')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Widget link color on hover')
					->setDescription('Select your custom color for widget links on hover.')
					->setId(SHORTNAME . '_widget_link_color_on_hover')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Widget accent color')
					->setDescription('Select your custom accent color for widget.')
					->setId(SHORTNAME . '_widget_accent_color')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Widget accent color on hover')
					->setDescription('Select your custom accent color for widget on hover.')
					->setId(SHORTNAME . '_widget_accent_color_on_hover')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
		
		
		
		$option = null;
		$option = new Admin_Theme_Element_Sidebar();
		$option->setName('Add Sidebar:')
				->setDescription('Enter the name of the new sidebar that you would like to create.')
				->setId('sidebar_generator_0')
				->setSize('70');
		$this->addOption($option);
		
		$option = new Admin_Theme_Element_SidebarDelete();
		$option->setDescription('Below are the Sidebars you have created:')
				->setName('Sidebars created:')
				->setElementListClass('info_top');
		$this->addOption($option);
	}
}
?>