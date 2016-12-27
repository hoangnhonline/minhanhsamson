<?php
/**
 * 'Main Menu' admin menu page
 */
class Admin_Theme_Item_MainMenu extends Admin_Theme_Menu_Item
{

	public function __construct($parent_slug = '')
	{
		
		$this->setPageTitle('Main Menu');
		$this->setMenuTitle('Main Menu');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME . '_mainmenu');
		parent::__construct($parent_slug);
		
		$this->init();
	}

	public function init()
	{
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('Main Menu Settings');
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Checkbox();
			$option->setName('Open menu by default')
					->setDescription('Check to make menu always open')
					->setId(SHORTNAME."_left_menu_opened")
					->setStd('');
			$this->addOption($option);
			$option = null;
		
		
		$option = new Admin_Theme_Element_Select();
		$option->setName('Menu text alignment')
				->setDescription('Sets how to align menu items')
				->setId(SHORTNAME."_main_menu_text_alignment")
				->setStd('center')
				->setCustomized()					// Show this element on WP Customize Admin menu
				->setOptions(array('center', 'left'));
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Text();
		$option->setName('Menu top padding')
				->setDescription('A padding used to align menu items vertically')
				->setId(SHORTNAME."_main_menu_top_padding")
				->setStd('27px');
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Colorchooser();
		$option->setName('Menu background color')
				->setDescription('Sets a background color for the main menu items')
				->setId( SHORTNAME."_menu_background_color")
				->setStd('#1d1d1e');
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('1st level color settings:','milano'))
				->setGroup('1color_settings');
		$this->addOption($option);
		$option = null;
			

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('1st level menu background color on hover')
					->setDescription('Sets a background color when 1st level items are hovered')
					->setId( SHORTNAME."_1st_level_menu_background_color_on_hover")
					->setGroup('1color_settings')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('1st level menu text color')
					->setDescription('Sets a text color for the 1st level menu items')
					->setId( SHORTNAME."_1st_level_menu_text_color")
					->setGroup('1color_settings')
					->setStd('#f4f0f0');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('1st level menu text color on hover')
					->setDescription('Sets a text color for the 1st level menu items on hover')
					->setId( SHORTNAME."_1st_level_menu_text_color_on_hover")
					->setGroup('1color_settings')
					->setStd('#f4f0f0');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('1st level sub menu link color on hover')
					->setDescription('Sets a sub menu link for the 1st level menu items on hover')
					->setId( SHORTNAME."_1st_level_menu_submenu_color_on_hover")
					->setGroup('1color_settings')
					->setStd('#242425');
			$this->addOption($option);
			$option = null;
		
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('2nd level color settings:','milano'))
				->setGroup('2color_settings');
		$this->addOption($option);
		$option = null;
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('2nd level menu background color on hover')
					->setDescription('Sets a background color when 2nd level items are hovered')
					->setId( SHORTNAME."_2st_level_menu_background_color_on_hover")
					->setGroup('2color_settings')
					->setStd('#383839');
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('2nd level menu text color')
					->setDescription('Sets a text color for the 2nd level menu items')
					->setId( SHORTNAME."_2st_level_menu_text_color")
					->setGroup('2color_settings')
					->setStd('#9f9f9f');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('2nd level menu text color on hover')
					->setDescription('Sets a text color for the 2nd level menu items on hover')
					->setId( SHORTNAME."_2st_level_menu_text_color_on_hover")
					->setGroup('2color_settings')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('2nd level sub menu link color on hover')
					->setDescription('Sets a sub menu link for the 2nd level menu items on hover')
					->setId( SHORTNAME."_2st_level_menu_submenu_color_on_hover")
					->setGroup('2color_settings')
					->setStd('#242425');
			$this->addOption($option);
			$option = null;

		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('3rd level color settings:','milano'))
				->setGroup('3color_settings');
		$this->addOption($option);
		$option = null;


			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('3rd level menu text color')
					->setDescription('Sets a text color for the 3rd level menu items (and lower)')
					->setId( SHORTNAME."_3st_level_menu_text_color")
					->setGroup('3color_settings')
					->setStd('#9f9f9f');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('3rd level menu text color on hover')
					->setDescription('Sets a text color for the 3rd level menu items on hover (and lower)')
					->setId( SHORTNAME."_3st_level_menu_text_color_on_hover")
					->setGroup('3color_settings')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
	}

}
?>