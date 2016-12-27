<?php

/**
 * Social Links Widget. 
 */
class Widget_SocialLinks extends Widget_Default
{
	const TITLE				= 'title';
	const BLACK_COLOR_SCHEME= 'black_color_scheme';
	const TWITTER			= 'twitter_account';
	const FACEBOOK			= 'facebook_account';
	const GOOGLE_PLUS		= 'google_plus_account';
	const RSS				= 'rss_feed';
	const EMAIL				= 'email_to';
	const FLIKER			= 'flicker_account';
	const VIMEO				= 'vimeo_account';
	const YOUTUBE			= 'youtube_account';
	const DRIBBLE			= 'dribble_account';
	const LINKED_IN			= 'linkedin_account';
	const PINTEREST			= 'pinterest_account';
	
	
	const PICASA			= 'picasa_account';
	const DIGG				= 'digg_account';
	const PLURK				= 'plurk_account';
	const TRIPADVISOR		= 'tripadvisor_account';
	const YAHOO				= 'yahoo_account';
	const DELICIOUS			= 'delicious_account';
	const DEVIANART			= 'devianart_account';
	const TUMBLR			= 'tumblr_account';
	const SKYPE				= 'skype_account';
	const APPLE				= 'apple_account';
	const AIM				= 'aim_account';
	const PP				= 'paypal_account';
	const BLOGGER			= 'blogger_account';
	const BEHANCE			= 'behance_account';
	const MYSPACE			= 'myspace_account';
	const STUMBLE 			= 'stumble_account';
	const FORRST 			= 'forrst_account';
	const IMDB				= 'imdb_account';
	const INSTAGRAM			= 'instagram_account';
				
	function __construct()
	{
		$this->setClassName('widget_social_links');
		$this->setName('Social Links');
		$this->setDescription('Show social network links');
		$this->setIdSuffix('social-links');
		$this->setWidth(800);
		parent::__construct();
	}
	
	public function widget($args, $instance)
	{
		$frontend_html = '';
		
		$social_link_list = $this->getFields();
		
		if(isset($instance[self::TITLE]))
		{
			$title = apply_filters( 'widget_title', $instance[self::TITLE] );			
		}	
		
		$frontend_html = $args['before_widget'];
		if ( $title )
		{
			$frontend_html .= $args['before_title'] . $title . $args['after_title'];
		}
		
		$frontend_html .= '<ul class="'.(isset($instance[self::BLACK_COLOR_SCHEME]) && $instance[self::BLACK_COLOR_SCHEME] == 'on' ? 'black_icons':'').'" >';
		foreach($instance as $id=>$account)
		{
			if($id != self::TITLE && $id != self::BLACK_COLOR_SCHEME) // Not show title in link list
			{
				if(strlen($account) && isset($social_link_list[$id]))
				{
					$frontend_html .= '<li>';
					
					$prefix = '//';
					if($id == self::EMAIL)
					{
						$prefix = 'mailto:';
					}
					
					$frontend_html .= sprintf('<a href="%s%s" class="social_links %s"></a>%s',
													$prefix,
													$account,
													$id,
													'</li>');
					
				}
			}
		}
		$frontend_html .= '</ul>';
		$frontend_html .= $args['after_widget'];
		
		echo $frontend_html;
	}
	
	public function form($instance)
	{
		$instance	 = wp_parse_args((array) $instance, $this->getDefaultFieldValues()); ?>
		<?php
		foreach($this->getFields() as $field_id => $details):
			if ($field_id == self::BLACK_COLOR_SCHEME) {?>
				<label for="<?php echo $this->get_field_id(self::BLACK_COLOR_SCHEME); ?>"><?php _e('Use black color scheme:', 'milano'); ?>
					<input id="<?php echo $this->get_field_id(self::BLACK_COLOR_SCHEME); ?>"
						name="<?php echo $this->get_field_name(self::BLACK_COLOR_SCHEME); ?>"
						type="checkbox" <?php echo esc_attr(isset($instance[self::BLACK_COLOR_SCHEME]) && $instance[self::BLACK_COLOR_SCHEME]) ? 'checked="checked"' : ''; ?> />
				</label>
			<?php
			} else {
			?>
				<label for="<?php echo $this->get_field_id($field_id); ?>" style="float: left; width: 30%; margin: 5px"><b><?php echo $details; ?></b>
					<input class="widefat" id="<?php echo $this->get_field_id($field_id); ?>" name="<?php echo $this->get_field_name($field_id); ?>" type="text" value="<?php echo esc_attr($instance[$field_id]); ?>" />
				</label>
			<?php }
			endforeach;?>
		<?php
	}

	public function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		foreach($this->getFields() as $field_id => $url)
		{
			$instance[$field_id] = strip_tags( trim($new_instance[$field_id] ));
		}
		return $instance;
	}
	
	
	private function getFields()
	{
		$fields = array (
			self::TITLE			=> 'Widget Title',
			self::BLACK_COLOR_SCHEME=> 'Color Scheme',
			self::TWITTER		=> 'Twitter URL',
			self::FACEBOOK		=> 'Facebook URL',
			self::GOOGLE_PLUS	=> 'Google Plus URL',
			self::RSS			=> 'RSS',
			self::EMAIL			=> 'Mailto:',
			self::FLIKER		=> 'Fliker URL',
			self::VIMEO			=> 'Vimeo URL',
			self::YOUTUBE		=> 'YouTUBE URL',
			self::DRIBBLE		=> 'Dribbble URL',
			self::LINKED_IN		=> 'LinkedIn URL',
			self::PINTEREST		=> 'Pinterest URL',
			
			self::PICASA		=> 'Picasa URL',
			self::DIGG			=> 'Digg URL',
			self::PLURK			=> 'Plurk URL',
			self::TRIPADVISOR	=> 'TripAdvisor URL',
			self::YAHOO			=> 'Yahoo! URL',
			self::DELICIOUS		=> 'Delicious URL',
			self::DEVIANART		=> 'deviantART URL',
			self::TUMBLR		=> 'Tumblr URL',
			self::SKYPE			=> 'Skype',
			self::APPLE			=> 'Apple URL',
			self::AIM			=> 'AIM',
			self::PP			=> 'PayPal',
			self::BLOGGER		=> 'Blogger URL',
			self::BEHANCE		=> 'Behance URL',
			self::MYSPACE		=> 'Myspace URL',
			self::STUMBLE 		=> 'StumbleUpon URL',
			self::FORRST 		=> 'Forrest URL',
			self::IMDB			=> 'IMDb URL',
			self::INSTAGRAM		=> 'Instagram URL',
		);
		return $fields;
	}
	
	private function getDefaultFieldValues()
	{
		$list = array (
			self::TITLE				=> 'Follow us',
			self::BLACK_COLOR_SCHEME=> '',
			self::TWITTER			=> 'twitter.com/themoholicsthemes',
			self::FACEBOOK			=> 'http://www.facebook.com/themoholics',
			self::GOOGLE_PLUS		=> 'plus.google.com',
			self::RSS				=> get_site_url().'/feed',
			self::EMAIL				=> get_option('admin_email'),
			self::FLIKER			=> 'flickr.com',
			self::VIMEO				=> 'vimeo.com',
			self::YOUTUBE			=> 'youtube.com',
			self::DRIBBLE			=> 'http://dribbble.com/',
			self::LINKED_IN			=> 'http://www.linkedin.com',
			self::PINTEREST			=> 'http://pinterest.com/',
			
			self::PICASA			=> 'http://picasa.google.com/',
			self::DIGG				=> 'digg.com/',
			self::PLURK				=> 'plurk.com',
			self::TRIPADVISOR		=> 'tripadvisor.com',
			self::YAHOO				=> 'yahoo.com',
			self::DELICIOUS			=> 'delicious.com',
			self::DEVIANART			=> 'deviantart.com',
			self::TUMBLR			=> 'tumblr.com',
			self::SKYPE				=> 'skype.com',
			self::APPLE				=> 'apple.com/',
			self::AIM				=> 'aim.com',
			self::PP				=> 'paypal.com',
			self::BLOGGER			=> 'blogger.com',
			self::BEHANCE			=> 'behance.net',
			self::MYSPACE			=> 'myspace.com',
			self::STUMBLE 			=> 'stumbleupon.com',
			self::FORRST 			=> 'forrst.com',
			self::IMDB				=> 'imdb.com',
			self::INSTAGRAM			=> 'instagram.com',
		);
		
		return $list;
	}
}

?>