<?php
/**
 * 'Blog' admin menu page
 */
class Admin_Theme_Item_Blog extends Admin_Theme_Menu_Item
{
	
	public function __construct($parent_slug = '')
	{
		
		$this->setPageTitle('Blog');
		$this->setMenuTitle('Blog');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME.'_blog');
		parent::__construct($parent_slug);
		
		$this->init();
	}

	public function init()
	{
		
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('Blog Settings');
		$this->addOption($option);
		$option = null;
		
			$option = new Admin_Theme_Element_Select();
			$option->setName('Page layout')
					->setDescription('Sets how much space a classic blog listing will occupy')
					->setId(SHORTNAME."_blog_page_layout")
					->setStd('one-third')
					->setCustomized()					// Show this element on WP Customize Admin menu
					->setOptions(array('one-third', 'half', 'fullwidth'));
			$this->addOption($option);
			$option = null;

			$sidebars = Sidebar_Generator::get_sidebars();
			
			$option = new Admin_Theme_Element_Select();
			$option->setName ('Choose blog listing sidebar')
					->setDescription ('Sets a sidebar that will be used on a classic blog listing page')
					->setCustomized()
					->setStd('default-sidebar')
					->setId (SHORTNAME."_blog_listing_sidebar")
					->setOptions(
						is_array($sidebars) ? array_merge(array('none', 'default-sidebar'), $sidebars) : array('none', 'default-sidebar')
					);
			$this->addOption($option);
			$option = null;
			
			
			$option = new Admin_Theme_Element_Select();
			$option->setName ('Sidebar for single blog post')
					->setDescription ('Sets a sidebar that will be used on all of the blog posts by default')
					->setCustomized()
					->setStd('none')
					->setId (SHORTNAME."_blog_single_sidebar")
					->setOptions(
						is_array($sidebars) ? array_merge(array('none', 'default-sidebar'), $sidebars) : array('none', 'default-sidebar')
					);
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Checkbox();
			$option->setName ('Disable navigation controls')
					->setDescription ('Disables navigation controls from a single blog post')
					->setCustomized()					
					->setId (SHORTNAME."_single_post_disable_nav");
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Checkbox();
			$option->setName ('Disable "Back to Blog" button')
                                        ->setDescription ('Disables /Back to Blog/ button from a single blog post')
            				->setCustomized()					
					->setId (SHORTNAME."_back_to_blog_disable");
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Checkbox();
			$option->setDescription (__('Disables excerpts from a blog listing page','milano'))
					->setName (__('Check to disable excerpts on blog listing','milano'))
					->setId (SHORTNAME."_excerpt");
			$this->addOption($option);
			$option = null;
			
			
			$option = new Admin_Theme_Element_Select();
			$option->setName ('Blog template')
					->setDescription ('Sets the way how blog posts will be rendered')
					->setCustomized()
					->setStd('classic')
					->setId (SHORTNAME."_blog_template")
					->setOptions(array('classic', 'carousel'));
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Text();
			$option->setName('Carousel item width')
					->setDescription('Sets a carousel item width of blog posts')
					->setId(SHORTNAME."_blog_carousel_w")
					->setStd('300');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Text();
			$option->setName('Carousel item height')
					->setDescription('Sets a carousel item height of blog posts')
					->setId(SHORTNAME."_blog_carousel_h")
					->setStd('400');
			$this->addOption($option);
			$option = null;
			
			
			$option = new Admin_Theme_Element_Text();
			$option->setName('Read more text')
					->setDescription('Sets a text for a Read More link used on all blog posts')
					->setId(SHORTNAME."_blog_read_more_text")
					->setStd('Read more &rarr;');
			$this->addOption($option);
			$option = null;
			
			
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Single post color settings','milano'))
				->setGroup('single_color_settings');
		$this->addOption($option);
		$option = null;
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Background color')
					->setDescription('Sets a single post background color when it is closed')
					->setId( SHORTNAME."_blog_single_content_bgcolor")
					->setGroup('single_color_settings')
					->setStd("transparent");
			$this->addOption($option);
			$option = null;
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Background color on hover and open post')
					->setDescription('Sets a single post background color when it is hovered and opened')
					->setId( SHORTNAME."_blog_single_content_bgcolor_on_hover")
					->setGroup('single_color_settings')
					->setStd("#242425");
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Title color')
					->setDescription('A title color for closed posts')
					->setId(SHORTNAME."_blog_single_title_color")
					->setGroup('single_color_settings')
					->setStd('#000000');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Title color on hover and open post')
					->setDescription('A single post title color when hovered and opened')
					->setId(SHORTNAME."_blog_single_title_color_on_hover")
					->setGroup('single_color_settings')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Content color')
					->setDescription('A color for a post content when it is closed')
					->setId(SHORTNAME."_blog_single_content_color")
					->setGroup('single_color_settings')
					->setStd('#79797a');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Content color on hover and open post')
					->setDescription('A color for a post content when it is hovered and opened')
					->setId(SHORTNAME."_blog_single_content_color_on_hover")
					->setGroup('single_color_settings')
					->setStd('#79797a');
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Link color')
					->setDescription('')
					->setId(SHORTNAME."_blog_single_link_color")
					->setGroup('single_color_settings')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Link color on hover and open post')
					->setDescription('')
					->setId(SHORTNAME."_blog_single_link_color_on_hover")
					->setGroup('single_color_settings')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Date color')
					->setDescription('Sets a date background color when a post is closed')
					->setId(SHORTNAME."_blog_single_date_color")
					->setGroup('single_color_settings')
					->setStd('#000000');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Date color on hover and open post')
					->setDescription('Sets a date background color when a post is hovered and opened')
					->setId(SHORTNAME."_blog_single_date_color_on_hover")
					->setGroup('single_color_settings')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Date text color')
					->setDescription('Sets a color for a date text when a post is closed')
					->setId(SHORTNAME."_blog_single_content_date_color")
					->setGroup('single_color_settings')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Date text color on hover and open post')
					->setDescription('Sets a color for a date text when a post is hovered & opened')
					->setId(SHORTNAME."_blog_single_content_date_color_on_hover")
					->setGroup('single_color_settings')
					->setStd('#000000');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Accent color')
					->setDescription('A color used for navigation controls, "Close" & "Back to blog" buttons')
					->setId(SHORTNAME."_blog_single_post_accent_color")
					->setGroup('single_color_settings')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Accent color on hover')
					->setDescription('A color used for navigation controls, "Close" & "Back to blog" buttons on hover')
					->setId(SHORTNAME."_blog_single_post_accent_color_on_hover")
					->setGroup('single_color_settings')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;
		
			
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Color options for classic template','milano'))
				->setGroup('classic_blog_colors');
		$this->addOption($option);
		$option = null;
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Title color')
					->setId(SHORTNAME."_classic_blog_title_color")
					->setGroup('classic_blog_colors')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Title color on hover')
					->setId(SHORTNAME."_classic_blog_title_color_on_hover")
					->setGroup('classic_blog_colors')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Content color')
					->setId(SHORTNAME."_classic_blog_content_color")
					->setGroup('classic_blog_colors')
					->setStd('#79797a');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Read more color')
					->setId(SHORTNAME."_classic_blog_read_more_color")
					->setGroup('classic_blog_colors')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Read more color on hover')
					->setId(SHORTNAME."_classic_blog_read_more_color_on_hover")
					->setGroup('classic_blog_colors')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Date color')
					->setId(SHORTNAME."_classic_blog_date_color")
					->setGroup('classic_blog_colors')
					->setStd('#b8bf37');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Date color on hover')
					->setId(SHORTNAME."_classic_blog_date_color_on_hover")
					->setGroup('classic_blog_colors')
					->setStd('#000000');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Date text color')
					->setId(SHORTNAME."_classic_blog_date_text_color")
					->setGroup('classic_blog_colors')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Date text color on hover')
					->setId(SHORTNAME."_classic_blog_date_text_color_on_hover")
					->setGroup('classic_blog_colors')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;
		
		$option = new Admin_Theme_Element_Subheader();
		$option->setName(__('Color options for carousel template','milano'))
				->setGroup('carousel_colors');
		$this->addOption($option);
		$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Post background color')
					->setId(SHORTNAME."_carousel_post_bg_color")
					->setGroup('carousel_colors')
					->setStd('#000000');
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Post background color on hover')
					->setId(SHORTNAME."_carousel_post_bg_color_on_hover")
					->setGroup('carousel_colors')
					->setStd('#b0b823');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Date background color')
					->setId(SHORTNAME."_carousel_date_bg_color")
					->setGroup('carousel_colors')
					->setStd('#b0b823');
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Date background color on hover')
					->setId(SHORTNAME."_carousel_date_bg_color_on_hover")
					->setGroup('carousel_colors')
					->setStd('#000000');
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Date text color')
					->setId(SHORTNAME."_carousel_date_text_color")
					->setGroup('carousel_colors')
					->setStd('#000000');
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Date text color on hover')
					->setId(SHORTNAME."_carousel_date_text_color_on_hover")
					->setGroup('carousel_colors')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Title color')
					->setId(SHORTNAME."_carousel_post_title_color")
					->setGroup('carousel_colors')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Title color on hover')
					->setId(SHORTNAME."_carousel_post_title_color_on_hover")
					->setGroup('carousel_colors')
					->setStd('#ffffff');
			$this->addOption($option);
			$option = null;

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Content color on hover')
					->setId(SHORTNAME."_carousel_post_content_color_on_hover")
					->setGroup('carousel_colors')
					->setStd('#33350a');
			$this->addOption($option);
			$option = null;
	}
	
	
}
?>