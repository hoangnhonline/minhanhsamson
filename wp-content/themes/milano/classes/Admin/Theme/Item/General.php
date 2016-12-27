<?php
/**
 * 'General' admin menu page
 */
class Admin_Theme_Item_General extends Admin_Theme_Menu_Item
{
	
	public function __construct($parent_slug = '')
	{
		
		$this->setPageTitle('General');
		$this->setMenuTitle('General');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME.'_general');
		parent::__construct($parent_slug);
		$this->init();
	}

	public function init()
	{
		
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('General Settings');
		$this->addOption($option);
		$option = null;		
		
		if (isset($_GET['preview']))
		{
			$option = new Admin_Theme_Element_Checkbox();
			$option->setName('Show preview switcher')
					->setDescription('Check to show preview color switcher')
					->setId(SHORTNAME."_preview")
					->setStd('');
			$this->addOption($option);
			$option = null;
		}
		
		$option = new Admin_Theme_Element_File_Favicon();
		$option->setName('Favicon')
				->setDescription('Click on the Upload button, then choose and submit your favicon file')
				->setId(SHORTNAME."_favicon")
				->setStd(get_template_directory_uri().'/images/favicon.ico');
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Fonts','milano'))
				->setGroup('fonts');
		$this->addOption($option);
		$option = null;
		
			$option = new Admin_Theme_Element_Select_Gfont();
			$option->setName('Choose a Font for title')
					->setDescription('This font is used for the headings throughout a site')
					->setId(SHORTNAME."_gfont_title")
					->setStd('Open Sans')
					->setGroup('fonts')
					->setCustomized();
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Checkbox();
			$option	->setGroup('fonts')
					->setName ('Disable Google fonts')
                                        ->setDescription ('Disables Google fonts & lets you choose a font family for titles')
					->setCustomized()					// Show this element on WP Customize Admin menu
					->setId (SHORTNAME."_gfontdisable");
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Select_Wide();
			$option->setName('Choose a font family for content')
					->setDescription('This is a font that will be used for content throughout a site')
					->setId(SHORTNAME."_fontfamily")
					->setGroup('fonts')
					->setStd("Arial")
					->setOptions(array("Arial, Helvetica, sans-serif", "'Times New Roman', Times, serif",  "'Courier New', Courier, monospace", "Georgia, 'Times New Roman', Times, serif","Verdana, Arial, Helvetica, sans-serif","Geneva, Arial, Helvetica, sans-serif"));
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Select_Wide();
			$option->setName('Choose a font style for content')
					->setDescription('Sets a font style for content')
					->setId(SHORTNAME."_fontstyle")
					->setGroup('fonts')
					->setStd('normal')
					->setOptions(array("italic", "normal"));
			$this->addOption($option);
			$option = null;
		
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Color settings','milano'))
				->setGroup('color_settings');
		$this->addOption($option);
		$option = null;
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Default page background color')
					->setDescription('Page background color that will be used throught a site')
					->setId( SHORTNAME."_page_color")
					->setGroup('color_settings')
					->setStd("#242425");
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Content heading color')
					->setDescription('Sets a default title color')
					->setId( SHORTNAME."_header_textcolor")
					->setGroup('color_settings')
					->setStd("#ffffff");
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Content text color')
					->setDescription('Sets a content color throughout a site.')
					->setId( SHORTNAME."_content_textcolor")
					->setGroup('color_settings')
					->setStd("#79797a");
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Content links color')
					->setDescription('Sets a links color used in content')
					->setId(SHORTNAME."_content_linkscolor")
					->setGroup('color_settings')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Content links hover color')
					->setDescription('Sets a content links color when hovered')
					->setId(SHORTNAME."_content_linkscolor_hover")
					->setGroup('color_settings')
					->setStd('#ffffff');
			$this->addOption($option);		
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Accent color')
					->setDescription('Sets a color for a background slideshow prelopader & buttons used in forms')
					->setId(SHORTNAME . '_accent_color')
					->setGroup('color_settings')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Accent color on hover')
					->setDescription('Sets a color for the accented elements when hovered')
					->setId(SHORTNAME . '_accent_color_on_hover')
					->setGroup('color_settings')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;
			
		
			
		
	}	

}
?>
