<?php

/**
 * 'General' admin menu page
 */
class Admin_Theme_Item_Dummy extends Admin_Theme_Menu_Item
{

	public function __construct($parent_slug = '')
	{

		$this->setPageTitle('Dummy content');
		$this->setMenuTitle('Dummy content');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME . '_dummy');
		parent::__construct($parent_slug);
		$this->init();
	}

	public function init()
	{

		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('Dummy content install');
		$this->addOption($option);
		$option = null;

		$option = new Admin_Theme_Element_Radio_Dummy();
		$option->setName('Use type of install')
				->setDescription('You can install different dummy content')
				->setId(SHORTNAME . "_dummy_type")
				->setStd('restaraunt')
				->setOptions(array(Import_Dummy::RESTARAUNT => 'Restaraunt dummy',
					Import_Dummy::HOTEL => 'Hotel dummy',
					Import_Dummy::EXTREME => 'Extreme dummy',
		));
		$this->addOption($option);
		$option = null;


		$option = new Admin_Theme_Element_InstallDummy();
		$this->addOption($option);
	}

}

?>
