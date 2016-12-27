<?php
/**
 * 'General' admin menu page
 */
class Admin_Theme_Item_Portfolio extends Admin_Theme_Menu_Item
{
	
	public function __construct($parent_slug = '')
	{
		
		$this->setPageTitle('Portfolio');
		$this->setMenuTitle('Portfolio');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME.'_portfolio');
		parent::__construct($parent_slug);
		$this->init();
	}

	public function init()
	{
		
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('Portfolio Settings');
		$this->addOption($option);
		$option = null;		
		
		
		$sidebars = Sidebar_Generator::get_sidebars();
			
		$option = new Admin_Theme_Element_Select();
		$option->setName ('Sidebar for single portfolio post')
				->setDescription ('Sets a sidebar that will be used on all of the portfolio posts by default')
				->setCustomized()
				->setStd('none')
				->setId (SHORTNAME."_portfolio_single_sidebar")
				->setOptions(
					is_array($sidebars) ? array_merge(array('none', 'default-sidebar'), $sidebars) : array('none', 'default-sidebar')
				);
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Checkbox();
		$option->setDescription (__('Disable excerpts','milano'))
				->setName (__('Check to disable excerpts on portfolio posts','milano'))
				->setId (SHORTNAME."_portfolio_excerpt");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Checkbox();
			$option->setName ('Disable navigation controls')
					->setDescription ('Disables navigation controls from a single portfolio post')
					->setCustomized()					
					->setId (SHORTNAME."_single_portfolio_disable_nav");
			$this->addOption($option);
			$option = null;
		
		$option = new Admin_Theme_Element_Text();
		$option->setName('Read more text')
				->setDescription('Sets a Read More text used on all portfolio posts')
				->setId(SHORTNAME."_portfolio_read_more_text")
				->setStd('Read more &rarr;');
		$this->addOption($option);
		$option = null;
			
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Single color settings','milano'))
				->setGroup('single_colors');
		$this->addOption($option);
		$option = null;
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Portfolio post background color')
					->setDescription('A post background applied to a single portfolio post')
					->setId( SHORTNAME."_portfolio_single_post_bgcolor")
					->setGroup('single_colors')
					->setStd("transparent");
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Portfolio post background color on hover and open post')
					->setDescription('A background color applied when a post is hovered and opened')
					->setId( SHORTNAME."_portfolio_single_post_bgcolor_on_hover")
					->setGroup('single_colors')
					->setStd("#242425");
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Portfolio single post title color')
					->setId(SHORTNAME."_portfolio_single_post_title_color")
					->setGroup('single_colors')
					->setStd('#000000');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Portfolio single post title color on hover and open post')
					->setDescription('')
					->setId(SHORTNAME."_portfolio_single_post_title_color_on_hover")
					->setGroup('single_colors')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Portfolio single post content color')
					->setDescription('')
					->setId(SHORTNAME."_portfolio_single_post_content_color")
					->setGroup('single_colors')
					->setStd('#79797a');
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Portfolio single post link color')
					->setDescription('')
					->setId(SHORTNAME."_portfolio_single_post_link_color")
					->setGroup('single_colors')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Portfolio single post link color on hover')
					->setDescription('')
					->setId(SHORTNAME."_portfolio_single_post_link_color_on_hover")
					->setGroup('single_colors')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Portfolio single post content color on hover and open post')
					->setDescription('')
					->setId(SHORTNAME."_portfolio_single_post_content_color_on_hover")
					->setGroup('single_colors')
					->setStd('#79797a');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Accent color')
					->setDescription('A color applied to navigation controls and Close button')
					->setId(SHORTNAME."_portfolio_single_accent_color")
					->setGroup('single_colors')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName(__('Accent color on hover', 'milano'))
					->setDescription('A color applied to navigation controls and Close button on hover')
					->setId(__(SHORTNAME."_portfolio_single_accent_color_on_hover", 'milano'))
					->setGroup('single_colors')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;
			
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Carousel listing color settings','milano'))
				->setGroup('listing_colors');
		$this->addOption($option);
		$option = null;
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Portfolio post background color')
					->setDescription('A background color used for portfolio posts in carousel')
					->setId( SHORTNAME."_portfolio_post_bgcolor")
					->setGroup('listing_colors')
					->setStd("#000000");
			$this->addOption($option);
			$option = null;
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Portfolio post background color on hover')
					->setDescription('A background color used for portfolio posts when they are hovered')
					->setId( SHORTNAME."_portfolio_post_bgcolor_on_hover")
					->setGroup('listing_colors')
					->setStd("#b0b823");
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Portfolio post title color')
					->setDescription('A title color for posts in carousel')
					->setId(SHORTNAME."_portfolio_post_title_color")
					->setGroup('listing_colors')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Portfolio post title color on hover')
					->setDescription('A post title color when posts are hovered')
					->setId(SHORTNAME."_portfolio_post_title_color_on_hover")
					->setGroup('listing_colors')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
		$custom_page = new Custom_Posts_Type_Portfolio();
		$option = new Admin_Theme_Element_Text();
		$option->setName(__('Portfolio post slug', 'milano'))
				->setDescription(__('Write custom slug for portfolio post', 'milano'))
				->setId($custom_page->getPostSlugOptionName())
				->setStd($custom_page->getDefaultPostSlug());
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Text();
		$option->setName(__('Portfolio category slug', 'milano'))
				->setDescription(__('Write custom slug for portfolio category', 'milano'))
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
?>