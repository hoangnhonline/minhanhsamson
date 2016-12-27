<?php
/**
 * Class collection with all theme widgets 
 */
final class Widget 
{
	/**
	 * Unrigister widgets exception AND Register all theme widgets.
	 */
	public static function run()
	{
//		unregister_widget('WP_Widget_Recent_Posts' );
//		unregister_widget('WP_Widget_Tag_Cloud');
//		unregister_widget('WP_Nav_Menu_Widget');
		
		register_widget('Widget_Menu');
		register_widget('Widget_Flickr');
		register_widget('Widget_FeedburnerEmail');
		register_widget('Widget_ContactForm');		
		register_widget('Widget_RecentPosts');
		register_widget('Widget_Twitter');
		register_widget('Widget_SocialLinks');
		register_widget('Widget_PopularPosts');
		register_widget('Widget_Tag_Cloud');
		register_widget('Widget_Testimonial');
		register_widget('Widget_MailChimp');
	
	}
}
?>