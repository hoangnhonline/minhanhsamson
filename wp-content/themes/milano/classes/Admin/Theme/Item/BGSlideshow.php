<?php
/**
 * 'Header' admin menu page
 */
class Admin_Theme_Item_BGSlideshow extends Admin_Theme_Menu_Item
{

	public function __construct($parent_slug = '')
	{
		
		$this->setPageTitle('BGSlideshow');
		$this->setMenuTitle('BGSlideshow');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME . '_bgslideshow');
		parent::__construct($parent_slug);
		
		$this->init();
	}

	public function init()
	{
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('Background Slider Settings');
		$this->addOption($option);
		$option = null;
		
//		bgsettings
		
		$option = new Admin_Theme_Element_Colorchooser();
		$option->setName('Timeline color')
				->setDescription('Sets a timeline color')
				->setId(SHORTNAME."_bg_slideshow_timeline_color")
				->setStd('#b8bf37');
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Colorchooser();
		$option->setName('Preloader color')
				->setDescription('Sets a preloader color')
				->setId(SHORTNAME."_bg_slideshow_preloader_color")
				->setStd('#b8bf37');
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Background settings(for all images):','milano'))
				->setGroup('background_settings');
		$this->addOption($option);
		$option = null;
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Background color')
					->setDescription('Sets a global background color')
					->setId(SHORTNAME."_bg_slider_color")
					->setGroup('background_settings')
					->setStd('#e9f0f6');
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Select();
			$option->setName('Background repeat')
					->setDescription('Sets how global background images should be repeated')
					->setId(SHORTNAME."_bg_slider_background_repeat")
					->setStd('no-repeat')
					->setGroup('background_settings')
					->setOptions(array("no-repeat", "repeat-x", "repeat-y", "repeat"));
			$this->addOption($option);
			$option = null;


			$option = new Admin_Theme_Element_Select();
			$option->setName('Background horizontal position')
					->setDescription('Sets the starting horizontal position of a background image')
					->setId(SHORTNAME."_bg_slider_background_horizontal_position")
					->setStd('center')
					->setGroup('background_settings')
					->setOptions(array("center", "left", "right"));
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Select();
			$option->setName('Background vertical position')
					->setDescription('Sets the starting vertical point of a background image')
					->setId(SHORTNAME."_bg_slider_background_vertical_position")
					->setStd('center')
					->setGroup('background_settings')
					->setOptions(array("center", "top", "bottom"));
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Select();
			$option->setName('Background Scale')
					->setDescription('Sets how a background images should be displayed')
					->setId(SHORTNAME."_bg_slider_background_scale")
					->setStd('cover')
					->setGroup('background_settings')
					->setOptions(array("Original size", "cover", "contain"));
			$this->addOption($option);
			$option = null;
		
//		slides
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Slides:','milano'))
				->setGroup('Slides');
		$this->addOption($option);
		$option = null;
		
			$option = new Admin_Theme_Element_ImageUploader();
			$option->setName(__('Drag & drop to change slides order','milano'))
					->setDescription('You can upload custom images to slides.')
					->setId(SHORTNAME."_bg_slider_slides")
					->setGroup('Slides');
			$this->addOption($option);
			$option = null;
			
		
//		slideshow settings
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Slideshow settings:','milano'))
				->setGroup('slideshow_settings');
		$this->addOption($option);
		$option = null;
		
			
			$option = new Admin_Theme_Element_Select();
			$option->setName('Timeline Position')
					->setDescription('Sets where to display a timeline')
					->setId(SHORTNAME."_bg_slider_timeline_pos")
					->setStd('bottom')
					->setGroup('slideshow_settings')
					->setOptions(array("top", "bottom", "none"));
			$this->addOption($option);
			$option = null;
		
			$option = new Admin_Theme_Element_Text();
			$option->setName('Timeout (for images only)')
					->setDescription('Specifies how long an image will be shown')
					->setId(SHORTNAME."_bg_slider_slide_time")
					->setGroup('slideshow_settings')
					->setStd('5000');
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Text();
			$option->setName('Transition Speed')
					->setDescription('Time used to perform a transition from one slide to another')
					->setId(SHORTNAME."_bg_slider_effect_time")
					->setGroup('slideshow_settings')
					->setStd('1500');
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Select();
			$option->setName('Effect')
					->setDescription('A transition effect used to switch slides')
					->setId(SHORTNAME."_bg_slider_effect")
					->setStd('fade')
					->setGroup('slideshow_settings')
					->setOptions(array("fade", "slide", "slide with zoom"));
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Select();
			$option->setName('Effect direction')
					->setDescription('Choose change slide effect')
					->setId(SHORTNAME."_slide_direction")
					->setStd('left')
					->setGroup('slideshow_settings')
					->setOptions(array("left", "right", "top", "bottom"));
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Checkbox();
			$option->setDescription ('Switch to ON to show images randomly')
					->setName ('Shuffle Slides')
					->setCustomized()					// Show this element on WP Customize Admin menu
					->setGroup('slideshow_settings')
					->setId (SHORTNAME."_bg_slider_shuffle_slides");
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Select();
			$option->setDescription ('An image that covers the slides to create a visual effect')
					->setName ('Image Pattern')
					->setStd('none')
					->setGroup('slideshow_settings')
					->setId (SHORTNAME . "_bg_slider_image_pattern")
					->setOptions(array("none", "pattern", "pattern1", "pattern2", "pattern3", "pattern4"));
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Checkbox();
			$option->setDescription ('Shows a small circle next to a cursor when slides are loading')
					->setName ('Show Preloader')
					->setGroup('slideshow_settings')
					->setId (SHORTNAME."_bg_slider_show_preloader");
			$this->addOption($option);
			$option = null;
	}
}
?>