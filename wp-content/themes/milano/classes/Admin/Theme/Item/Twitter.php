<?php

class Admin_Theme_Item_Twitter extends Admin_Theme_Menu_Item {

	public function __construct($parent_slug = '')
	{
		$this->setPageTitle(__('Authenticating for Twitter', 'milano'));
		$this->setMenuTitle(__('Twitter OAuth', 'milano'));
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME . '_twitter');
		parent::__construct($parent_slug);
		$this->init();
	}
	public function init()
	{
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName(__('Authenticating a User Timeline for Twitter OAuth API V1.1', 'milano'));
		$this->addOption($option);
		$option = null;


		$option = new Admin_Theme_Element_Info();
		$option->setName(__('Enter a valid Twitter OAuth settings here to get started.','milano'));
		$this->addOption($option);


		$option = new Admin_Theme_Element_Info();
		$option->setName(__('Don\'t know where to get? please visit this link, <a href="http://www.webdevdoor.com/php/authenticating-twitter-feed-timeline-oauth/" target="_blank">Authenticating for Twitter </a>','milano'));
		$this->addOption($option);

		$option = new Admin_Theme_Element_TextClean();
		$option->setName(__('Consumer key', 'milano'))
				->setDescription(__('Consumer key', 'milano'))
				->setId(SHORTNAME . '_consumer_key')
				->setStd('');
		$this->addOption($option);

		$option = new Admin_Theme_Element_TextClean();
		$option->setName(__('Consumer secret', 'milano'))
				->setDescription(__('Consumer secret', 'milano'))
				->setId(SHORTNAME . '_consumer_secret')
				->setStd('');
		$this->addOption($option);

		$option = new Admin_Theme_Element_TextClean();
		$option->setName(__('Access token', 'milano'))
				->setDescription(__('Access token', 'milano'))
				->setId(SHORTNAME . '_access_token')
				->setStd('');
		$this->addOption($option);

		$option = new Admin_Theme_Element_TextClean();
		$option->setName(__('Access token secret', 'milano'))
				->setDescription(__('Access token secret', 'milano'))
				->setId(SHORTNAME . '_access_token_secret')
				->setStd('');
		$this->addOption($option);
		
	}
}
?>
