<?php


class Widget_Testimonial extends Widget_Default implements Widget_Interface_Cache
{
	/**
	 * Form fields 
	 */
	const TIME			= 'time';
	const TITLE			= 'title';
	const CATEGORY		= 'category';
	const RANDOMIZE		= 'randomize';
	const TESTIMONIAL_POST_TRANSIENT = 'JkH83gha903';
	
	
	
	public function __construct()
	{
		$this->setClassName('widget_testimonial');
		$this->setName('Testimonials');
		$this->setDescription('Show Testimonials');
		$this->setIdSuffix('testimonials');
		parent::__construct();
		add_action('save_post', array(&$this, 'action_clear_widget_cache'));
	}
	
	function action_clear_widget_cache($postID)
	{
		if(get_post_type($postID) == Custom_Posts_Type_Testimonial::POST_TYPE)
		{
			$temp_number = $this->number;

			$settings = $this->get_settings();
			
			if ( is_array($settings) ) {
				foreach ( array_keys($settings) as $number ) {
					if ( is_numeric($number) ) {
						$this->number = $number;
						$this->deleteWidgetCache();
					}
				}
			}
			$this->number = $temp_number;
		}
	}
	
	function widget($args, $instance)
	{
		extract( $args );

		$title		= apply_filters( 'widget_title', $instance[self::TITLE] );		
		$time		= (int) $instance[self::TIME];
		
		$wport = $this->getTestimonials($instance);	
		$have_posts = $wport->have_posts();
		/////////////////////////////////html 
		echo $before_widget;
		if ( $title )
		{
			echo $before_title . $title . $after_title;
		}
		if ($have_posts ) : ?>
			<?php if($wport->post_count > 1):				
			endif;
			$rnd = rand(0, 2000);
			?>
				<div class="testimonials" id="testimonials_<?php echo $rnd;?>">
					<div class="controls">
						<a class="prev" href="#">&nbsp;</a>
						<a class="next" href="#">&nbsp;</a>
					</div>
					<?php  while($wport->have_posts()) : $wport->the_post();
					$slides[] = '<div class="testimonial">
									<div class="quote">' . get_the_content() . '</div>
									<div class="testimonial_meta">
										<div class="testimonial_author">' . get_post_meta(get_the_ID(), SHORTNAME.'_testimonial_author', true) . '</div>
										<div>' . get_post_meta(get_the_ID(), SHORTNAME.'_testimonial_author_job', true) . '</div>
									</div>
								</div>';
					endwhile; 
					FrontWidgets::getInstance()->add(array(
						'type' => 'Slider',
						'id' => 'sidebar_testimonials',
						'options' => array(
							'selector' => '#testimonials_'.$rnd,
							'next' => '',
							'prev' => '',
							'slideTime' => $time * 1000,
							'autoplay' => true,
							'dinamicHeight' => true,
							'random' => $instance[self::RANDOMIZE]
						),
						'data' => $slides
					));
					
					// Reset Post Data
					wp_reset_postdata();
					?>
				</div>
			
		<?php endif;
		echo $after_widget;
		wp_reset_postdata();
	}
	
	function form($instance)
	{
		$defaults = array( 
			self::TITLE		=> __( 'Testimonials', 'milano' ),
			self::TIME		=> '10',
			self::CATEGORY	=> 'all',
			self::RANDOMIZE => '');
		
		$testimonial_category = null;
		$instance = wp_parse_args( (array) $instance, $defaults ); 

		$testimonial_category = get_terms(Custom_Posts_Type_Testimonial::TAXONOMY);
		?>
		<div>
			<p>
				<label for="<?php echo $this->get_field_id( self::TITLE ); ?>">
					<?php _e( 'Title:', 'milano' ); ?>
				</label>
				<input id="<?php echo $this->get_field_id( self::TITLE ); ?>" name="<?php echo $this->get_field_name( self::TITLE ); ?>" type="text" value="<?php echo $instance[self::TITLE]; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( self::CATEGORY ); ?>" >
					<?php _e( 'Category of testimonials:', 'milano' ); ?>
				</label>
				<select name="<?php echo $this->get_field_name( self::CATEGORY ); ?>" id="<?php echo $this->get_field_id( self::CATEGORY ); ?>"  style="width:100%;">
					<option value="all">All</option>
					<?php
					if($testimonial_category)
					{
						foreach ($testimonial_category as $cat)
						{
							$selected = "";
							if ($instance[self::CATEGORY] == $cat->slug)
							{
								$selected = "selected='selected'";
							}
							echo "<option $selected value='" . $cat->slug . "'>" . $cat->name . "</option>";
						}
					}?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( self::TIME ); ?>"><?php _e( 'Number of second to show:', 'milano' ); ?></label>
				<input id="<?php echo $this->get_field_id( self::TIME ); ?>" name="<?php echo $this->get_field_name( self::TIME ); ?>" type="text" value="<?php echo $instance[self::TIME]; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id(self::RANDOMIZE); ?>"><?php _e('Randomize testimonial:', 'milano'); ?>
					<input id="<?php echo $this->get_field_id(self::RANDOMIZE); ?>"
					   name="<?php echo $this->get_field_name(self::RANDOMIZE); ?>"
					   type="checkbox" <?php echo esc_attr(isset($instance[self::RANDOMIZE]) && $instance[self::RANDOMIZE]) ? 'checked="checked"' : ''; ?> />
				</label>
			</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance[self::CATEGORY]	= strip_tags( $new_instance[self::CATEGORY] );
		$instance[self::RANDOMIZE]	= strip_tags( $new_instance[self::RANDOMIZE] );
		$instance[self::TIME]		= strip_tags( $new_instance[self::TIME] );
		$instance[self::TITLE]		= strip_tags( $new_instance[self::TITLE] );
		$this->deleteWidgetCache();
		return $instance;
	}
	
	private function getTestimonials($instance)
	{
		if( false === ($testimonials = $this->getCachedWidgetData()))
		{
			$this->reinitWidgetCache($instance);
		}
		else
		{
			return $testimonials;
		}
		return $this->getCachedWidgetData();
	}

	public function deleteWidgetCache()
	{
		global $sitepress;

		if($sitepress && is_object($sitepress) &&  method_exists($sitepress, 'get_active_languages'))
		{
			foreach($sitepress->get_active_languages() as $lang)
			{

				if(isset($lang['code']))
				{
					delete_site_transient($this->getTransientId($lang['code']));
				}
			}
		}
		delete_site_transient($this->getTransientId()); // clear cache
	}

	public function getCachedWidgetData()
	{
		return  get_site_transient($this->getTransientId());
	}

	public function getExparationTime()
	{
		return self::EXPIRATION_HOUR;
	}

	public function getTransientId($code = '')
	{
		$key = self::TESTIMONIAL_POST_TRANSIENT;
		if($code)
		{
			$key .= '_' . $code;
		}
		elseif($this->isWPML_PluginActive()) // wpml
		{
			$key .= '_' . ICL_LANGUAGE_CODE;
		}
		
		return $this->get_field_id( $key );
	}

	public function reinitWidgetCache($instance)
	{
		$query		= "post_type=".Custom_Posts_Type_Testimonial::POST_TYPE."&post_status=publish&posts_per_page=100&order=DESC";
		$category	= $instance[self::CATEGORY];
		
		
		if($category != 'all')
		{
			$query .="&".Custom_Posts_Type_Testimonial::TAXONOMY."=".$category;
		}
		$wport = new WP_Query($query);
		
		set_site_transient($this->getTransientId(), $wport, $this->getExparationTime());
	}
}?>