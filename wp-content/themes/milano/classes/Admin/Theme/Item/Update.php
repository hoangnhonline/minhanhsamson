<?php
/**
 * 'Update' admin menu page
 */
class Admin_Theme_Item_Update extends Admin_Theme_Menu_Item
{
	public function __construct($parent_slug = '')
	{

		$this->setPageTitle(__('Theme updater','milano'));
		$this->setMenuTitle(__('Theme Updater','milano'));
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME.'_update');
		parent::__construct($parent_slug);

		$this->init();
	}

	public function init()
	{
		$option = null;
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName(__('User Account Information','milano'));
		$this->addOption($option);

		$option = null;

		$option = new Admin_Theme_Element_TextClean();
		$option->setName(__('Marketplace Username','milano'))
				->setDescription(__('Provide Username for theme update','milano'))
				->setId(SHORTNAME."_envato_nick")
				->setStd('');
		$this->addOption($option);
		$option = null;


		$option = new Admin_Theme_Element_TextClean();
		$option->setName(__('Secret API Key','milano'))
				->setDescription(__('Provide API Key for theme update','milano'))
				->setId(SHORTNAME."_envato_api")
				->setStd('');
		$this->addOption($option);
		$option = null;

		$option = new Admin_Theme_Element_Checkbox();
		$option->setDescription ('Check for skipping theme backup before update')
				->setName ('Skip backup theme before update')
				->setId (SHORTNAME."_envato_skip_backup");
		$this->addOption($option);
		$option = null;
	}
}
?>