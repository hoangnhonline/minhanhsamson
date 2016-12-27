<?php
class Admin_Theme_Item_MailChimp extends Admin_Theme_Menu_Item {

	public function __construct($parent_slug = '')
	{
		$this->setPageTitle(__('MailChimp', 'milano'));
		$this->setMenuTitle(__('MailChimp', 'milano'));
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME . '_mailchimp');
		parent::__construct($parent_slug);
		$this->init();
	}
	
	public function init()
	{
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName(__('MailChimp API key', 'milano'));
		$this->addOption($option);
		$option = null;


		$option = new Admin_Theme_Element_Info();
		$option->setName(__('Enter a valid MailChimp API key here to get started. Once you\'ve done that, you can use the MailChimp Widget from the Widgets menu. You will need to have at least MailChimp list set up before the using the widget.','milano'));
		$this->addOption($option);


		$option = new Admin_Theme_Element_Info();
		$option->setName(__('Don\'t know where to get? please visit this link, <a href="//kb.mailchimp.com/article/how-do-i-log-in-to-the-mailchimp-iphone-app-through-google-apps" target="_blank">Get API Key</a>','milano'));
		$this->addOption($option);
		
		$option = new Admin_Theme_Element_TextClean();
		$option->setName(__('MailChimp API key', 'milano'))
				->setDescription(__('MailChimp API key', 'milano'))
				->setId(SHORTNAME . '_mailchimp_key')
				->setStd('');
		$this->addOption($option);
	}
}
?>
