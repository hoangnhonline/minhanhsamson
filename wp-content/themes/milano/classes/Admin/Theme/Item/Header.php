<?php
/**
 * 'Header' admin menu page
 */
class Admin_Theme_Item_Header extends Admin_Theme_Menu_Item
{

	public function __construct($parent_slug = '')
	{
		
		$this->setPageTitle('Header');
		$this->setMenuTitle('Header');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME . '_header');
		parent::__construct($parent_slug);
		
		$this->init();
	}

	public function init()
	{
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('Header Settings');
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Logo settings:','milano'))
				->setGroup('logo_settings');
		$this->addOption($option);
		$option = null;


		$option = new Admin_Theme_Element_File();
			$option->setName('Use custom logo image')
					->setDescription('An image that will be set as a logo & placed on the top left corner of a site')
					->setId(SHORTNAME."_logo_custom")
					->setGroup('logo_settings')
					->setStd(get_template_directory_uri().'/images/logo.png');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_File();
			$option->setName('Use custom Retina logo image')
					->setDescription('This logo image will be used for retina displays and should 2x larger then the original one')
					->setId(SHORTNAME."_logo_retina_custom")
					->setGroup('logo_settings')
					->setStd(get_template_directory_uri().'/images/retina2x/logo@2x.png');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Checkbox();
			$option->setName('Hide logo')
					->setDescription('This option disables logo area')
					->setId(SHORTNAME."_hidden_logo")
					->setGroup('logo_settings')
					->setStd('');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Checkbox();
			$option->setName('Move logo to side menu area')
					->setDescription('Show logo on top of side menu')
					->setId(SHORTNAME."_menu_logo")
					->setGroup('logo_settings')
					->setStd('');
			$this->addOption($option);
			$option = null;
			
			
			$option = new Admin_Theme_Element_Select_Gfont();
			$option->setName('Choose a Font for logo')
					->setDescription('Helps you set a font for the logo text')
					->setId(SHORTNAME."_logo_gfont")
					->setStd('Open Sans')
					->setGroup('logo_settings')
					->setCustomized();
			$this->addOption($option);
			$option = null;
		
			
			$option = new Admin_Theme_Element_Select();
			$option->setName('Logo font style')
					->setDescription('Sets a logo font style')
					->setId(SHORTNAME."_logo_font_style")
					->setStd('normal')
					->setGroup('logo_settings')
					->setOptions(array("italic", "normal"));;
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Text();
			$option->setName('Logo font weight')
					->setDescription('Sets how thick/thin a logo test should be')
					->setId(SHORTNAME."_logo_font_weight")
					->setGroup('logo_settings')
					->setStd('600');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Text();
			$option->setName('Logo text size')
					->setDescription('Sets logo text size in any units')
					->setId(SHORTNAME."_logo_font_size")
					->setGroup('logo_settings')
					->setStd('48px');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Logo text color')
					->setDescription('Select your custom color for logo text')
					->setId( SHORTNAME."_logo_text_color")
					->setGroup('logo_settings')
					->setStd('#242425');
					
			$this->addOption($option);
		
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Top Line Admin Panel options:','milano'))
				->setGroup('top_line');
		$this->addOption($option);
		$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Top line text color')
					->setDescription('A content color used in the top line')
					->setId( SHORTNAME."_top_line_text_color")
					->setGroup('top_line')
					->setStd('#595b5e');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Top line background color')
					->setDescription('A background color for the top line area')
					->setId( SHORTNAME."_top_line_background_color")
					->setGroup('top_line')
					->setStd('transparent');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Link color')
					->setDescription('A color for content links used in the top line')
					->setId( SHORTNAME."_link_color")
					->setGroup('top_line')
					->setStd('#000');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Link color on hover')
					->setDescription('Top line link color on hover')
					->setId( SHORTNAME."_header_link_color_on_hover")
					->setGroup('top_line')
					->setStd('#363636');
			$this->addOption($option);
			$option = null;
			
		
			$option = new Admin_Theme_Element_Editor();
			$option->setName('Use custom content')
					->setDescription('Here you can add text that will be displayed on the top right corner of the site')
					->setId(SHORTNAME."_header_tinymce");
			$this->addOption($option);
			$option = null;
	}
	
}
?>