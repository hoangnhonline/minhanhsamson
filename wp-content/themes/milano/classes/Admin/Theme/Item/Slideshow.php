<?php
/**
 * 'Footer' admin menu page
 */
class Admin_Theme_Item_Slideshow extends Admin_Theme_Menu_Item
{
	public function __construct($parent_slug = '')
	{
		$this->setPageTitle('Slideshow');
		$this->setMenuTitle('Slideshow');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME . '_slideshow');
		parent::__construct($parent_slug);
		$this->init();
	}

	public function init()
	{
		
		$option = null;
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('Slideshow Settings');
		$this->addOption($option);
		
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Slideshow color settings','milano'))
				->setGroup('slideshow_colors');
		$this->addOption($option);
		$option = null;
		
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Slide title color')
					->setDescription('Sets a title color for a slide')
					->setId( SHORTNAME."_slideshow_title_color")
					->setGroup('slideshow_colors')
					->setStd('#000000');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Slide title color for responsive')
					->setDescription('Sets a title color for a slide for small screens')
					->setId( SHORTNAME."_slideshow_title_color_resp")
					->setGroup('slideshow_colors')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Slide background color')
					->setDescription('Sets slide background color')
					->setId( SHORTNAME."_slideshow_bg_color")
					->setGroup('slideshow_colors')
					->setStd('transparent');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Slide background color for responsive')
					->setDescription('Sets slide background color for small screens')
					->setId( SHORTNAME."_slideshow_bg_color_resp")
					->setGroup('slideshow_colors')
					->setStd('#2a241f');
			$this->addOption($option);
			$option = null;
			
			
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Content text color')
					->setDescription('Sets default slide content color if there is any')
					->setId( SHORTNAME."_slideshow_text_color")
					->setGroup('slideshow_colors')
					->setStd('#79797a');
			$this->addOption($option);
			$option = null;
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Thumbnails background color')
					->setDescription('A color for the background area used to show thumbnails')
					->setId( SHORTNAME."_slideshow_thumb_bgcolor")
					->setGroup('slideshow_colors')
					->setStd('#1c1c1c');
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Timeline color')
					->setId( SHORTNAME."_slideshow_timeline_color")
					->setGroup('slideshow_colors')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Accent color')
					->setDescription('Slideshow navigation controls color')
					->setGroup('slideshow_colors')
					->setId( SHORTNAME."_slideshow_nav_color")
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Accent color on hover')
					->setDescription('Slideshow navigation controls color on hover')
					->setId( SHORTNAME."_slideshow_nav_color_on_hover")
					->setGroup('slideshow_colors')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;
			
		$custom_page = new Custom_Posts_Type_Slideshow();
		$option = new Admin_Theme_Element_Text();
		$option->setName(__('Slideshow post slug', 'milano'))
				->setDescription(__('Write custom slug for slideshow post', 'milano'))
				->setId($custom_page->getPostSlugOptionName())
				->setStd($custom_page->getDefaultPostSlug());
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Text();
		$option->setName(__('Slideshow category slug', 'milano'))
				->setDescription(__('Write custom slug for slideshow category', 'milano'))
				->setId($custom_page->getTaxSlugOptionName())
				->setStd($custom_page->getDefaultTaxSlug());
		$this->addOption($option);
	}
	
	/**
	 * Save form and set option-flag for reinit rewrite rules on init
	 */
	public function saveForm()
	{
		parent::saveForm();
		$this->setNeedReinitRulesFlag();
	}
	
	/**
	 * Reset form and set option-flag for reinit rewrite rules on init
	 */
	public function resetForm()
	{
		parent::resetForm();
		$this->setNeedReinitRulesFlag();
	}
	
	/**
	 * save to DB flag of need do flush_rewrite_rules on next init
	 */
	private function setNeedReinitRulesFlag()
	{
		update_option(SHORTNAME.'_need_flush_rewrite_rules', '1');
	}
}