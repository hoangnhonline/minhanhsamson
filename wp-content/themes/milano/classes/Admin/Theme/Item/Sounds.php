<?php
/**
 * 'General' admin menu page
 */
class Admin_Theme_Item_Sounds extends Admin_Theme_Menu_Item
{
	public function __construct($parent_slug = '')
	{
		$this->setPageTitle('Sounds');
		$this->setMenuTitle('Sounds');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME.'_sounds');
		parent::__construct($parent_slug);
		$this->init();
	}

	public function init()
	{
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('Sounds Settings');
		$this->addOption($option);
		$option = null;		
		
		
		
		
		$option = new Admin_Theme_Element_Checkbox();
		$option->setName (__('Check to disable sounds.','milano'))
				->setDescription('When turned to ON, all of the theme sounds will be muted')
				->setCustomized()					// Show this element on WP Customize Admin menu
				->setId (SHORTNAME."_sound_disable");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Background sound(mp3):','milano'))
				->setDescription('Background music used throughout a site')
				->setId(SHORTNAME."_bg_sound");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Background sound(ogg):','milano'))
				->setDescription('Background music used throughout a site (file format OGG)')
				->setId(SHORTNAME."_bg_sound_ogg");
		$this->addOption($option);
		$option = null;

		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Left Menu sound(mp3):','milano'))
				->setDescription('A sound used to open/close the main site menu')
				->setId(SHORTNAME."_sound_menu");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Left Menu sound(ogg):','milano'))
				->setDescription('A sound used to open/close the main site menu (file format OGG)')
				->setId(SHORTNAME."_sound_menu_ogg");
		$this->addOption($option);
		$option = null;

		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Left Menu item hover(mp3):','milano'))
				->setDescription('A sound used when main menu items are hovered')
				->setId(SHORTNAME."_left_menu_item_sound");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Left Menu item hover(ogg):','milano'))
				->setDescription('A sound used when main menu items are hovered (file format OGG)')
				->setId(SHORTNAME."_left_menu_item_sound_ogg");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Post hover sound(mp3):','milano'))
				->setDescription('A sound used when a post is hovered')
				->setId(SHORTNAME."_sound_post_hover");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Post hover sound(ogg):','milano'))
				->setDescription('A sound used when a post is hovered (file format OGG)')
				->setId(SHORTNAME."_sound_post_hover_ogg");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Sidebar sound(mp3):','milano'))
				->setDescription('A sound used when a sidebar is opened & closed')
				->setId(SHORTNAME."_sound_sidebar");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Sidebar sound(ogg):','milano'))
				->setDescription('A sound used when a sidebar is opened & closed (file format OGG)')
				->setId(SHORTNAME."_sound_sidebar_ogg");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Slideshow thumbnails sound(mp3):','milano'))
				->setDescription('A sound used when slideshow thumbnails are hovered')
				->setId(SHORTNAME."_sound_thumbnails");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Slideshow thumbnails sound(ogg):','milano'))
				->setDescription('A sound used when slideshow thumbnails are hovered (file format OGG)')
				->setId(SHORTNAME."_sound_thumbnails_ogg");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Rollover carousel(mp3):','milano'))
				->setDescription('A sound used when posts in carousel are hovered')
				->setId(SHORTNAME."_rollover_carousel");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Rollover carousel(ogg):','milano'))
				->setDescription('A sound used when posts in carousel are hovered (file format OGG)')
				->setId(SHORTNAME."_rollover_carousel_ogg");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Menu page template hover sound(mp3):','milano'))
				->setDescription('A sound used when menu items are hovered. Work for "Center Menu" page template')
				->setId(SHORTNAME."_center_menu_sound");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Menu page template hover sound(ogg):','milano'))
				->setDescription('A sound used when menu items are hovered. Work for "Center Menu" page template (file format OGG)')
				->setId(SHORTNAME."_center_menu_sound_ogg");
		$this->addOption($option);
		$option = null;
		
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Accent sound(mp3):','milano'))
				->setDescription('A sound used on a "Close" button and on social icons hover.')
				->setId(SHORTNAME."_accent_sound");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_AudioUploader();
		$option->setName(__('Accent sound(ogg):','milano'))
				->setDescription('A sound used on a "Close" button and on social icons hover. (file format OGG)')
				->setId(SHORTNAME."_accent_sound_ogg");
		$this->addOption($option);
		$option = null;
	}
}