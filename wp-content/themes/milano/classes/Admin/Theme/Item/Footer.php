<?php
/**
 * 'Footer' admin menu page
 */
class Admin_Theme_Item_Footer extends Admin_Theme_Menu_Item
{
	const DEFAULT_COPYRIGHT = "<a href='http://themoholics.com'>PREMIUM WORDPRESS THEMES</a> BY THEMOHOLICS";
	public function __construct($parent_slug = '')
	{
		
		$this->setPageTitle('Footer');
		$this->setMenuTitle('Footer');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME.'_footer');
		parent::__construct($parent_slug);
		
		$this->init();
	}

	public function init()
	{
		$option = null;
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('Footer Settings');
		$this->addOption($option);
		
		$option = null;
		
		$option = new Admin_Theme_Element_Checkbox();
		$option->setName('Footer fixed')
				->setDescription('When enabled, a footer will be always displayed on the bottom of the screen')
				->setId(SHORTNAME."_footer_fixed")
				->setStd('');
		$this->addOption($option);
		$option = null;
		
		
		$option = new Admin_Theme_Element_Colorchooser();
		$option->setName('Footer background color')
				->setDescription('Sets a footer background color')
				->setId( SHORTNAME."_footer_background_color")
				->setStd('#0c0c0d');
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Footer Menu:','milano'))
				->setGroup('footer_menu');
		$this->addOption($option);
		$option = null;
		
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Footer menu item background color on hover')
					->setDescription('Sets a background color for the footer menu items on hover')
					->setId( SHORTNAME."_footer_menu_background_color_on_hover")
					->setGroup('footer_menu')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Footer menu text color')
					->setDescription('Sets a text color for the footer menu items')
					->setId( SHORTNAME."_footer_menu_text_color")
					->setGroup('footer_menu')
					->setStd('#b4b4b4');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Footer menu text color on hover')
					->setDescription('Sets a text color for the footer menu items on hover')
					->setId( SHORTNAME."_footer_menu_text_color_on_hover")
					->setGroup('footer_menu')
					->setStd('#e9ebc1');
			$this->addOption($option);
			$option = null;
		
			
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Footer text:','milano'))
				->setGroup('footer_text');
		$this->addOption($option);
		$option = null;
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Footer text color')
					->setDescription('Sets a footer content color')
					->setId( SHORTNAME."_footer_text_color")
					->setGroup('footer_text')
					->setStd('#79797a');
			$this->addOption($option);
			$option = null;
			
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Footer link color')
					->setDescription('Sets a link color placed in the footer area')
					->setId( SHORTNAME."_footer_link_color")
					->setGroup('footer_text')
					->setStd('#79797a');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Footer link color on hover')
					->setDescription('Sets a link color on hover')
					->setId( SHORTNAME."_footer_link_color_on_hover")
					->setGroup('footer_text')
					->setStd('#79797a');
			$this->addOption($option);
			$option = null;
			
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Copyright settings:','milano'))
				->setGroup('copyright');
		$this->addOption($option);
		$option = null;
		
			$option = new Admin_Theme_Element_Text();
			$option->setName('Copyright text')
					->setDescription('A text that appears on botttom right corner of a site')
					->setId(SHORTNAME."_copyright_text")
					->setGroup('copyright')
					->setStd(self::DEFAULT_COPYRIGHT);
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Copyright text color')
					->setDescription('A text color for a copyright message')
					->setId( SHORTNAME."_copyright_text_color")
					->setGroup('copyright')
					->setStd('#79797a');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Copyright link color')
					->setDescription('A link color used in a copyright message')
					->setId( SHORTNAME."_copyright_link_color")
					->setGroup('copyright')
					->setStd('#79797a');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Copyright link color on hover')
					->setDescription('A link color on hover used in a copyright message')
					->setId( SHORTNAME."_copyright_link_color_on_hover")
					->setGroup('copyright')
					->setStd('#79797a');
			$this->addOption($option);
			$option = null;
			
		$option = new Admin_Theme_Element_Editor();
		$option->setName('Use custom content')
				->setDescription('Here you can add custom content for the footer area. This text will be placed next to the copyright mesage')
				->setId(SHORTNAME."_footer_tinymce");
		$this->addOption($option);
		$option = null;
		
			
		$option = new Admin_Theme_Element_Textarea();
		$option->setName('Google Analytics')
				->setDescription('Helps you add a Google Analytics (or other) code')
				->setId(SHORTNAME."_GA")
				->setStd("")
				->setElementListClass('info_top');
		$this->addOption($option);
		$option = null;
		
	
	
	}
}
?>