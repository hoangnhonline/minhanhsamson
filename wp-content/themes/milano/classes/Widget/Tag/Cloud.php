<?php

class Widget_Tag_Cloud extends Widget_Default {

	function __construct() {
		
		$this->setClassName('widget_tag_cloud');
		$this->setName('Tag Cloud');
		$this->setDescription('Your most used tags in cloud format');
		$this->setIdSuffix('tagcloud');
		parent::__construct();
		
	}

	function widget( $args, $instance ) {
		extract($args);
		$current_taxonomy = $this->_get_current_taxonomy($instance);
		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			if ( 'post_tag' == $current_taxonomy ) {
				$title = __('Tags','milano');
			} else {
				$tax = get_taxonomy($current_taxonomy);
				$title = $tax->labels->name;
			}
		}
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		
		$tags_array  = wp_tag_cloud( apply_filters('widget_tag_cloud_args', array(  'taxonomy' => $current_taxonomy ,
																					'format'=>'array',
																					'smallest' => 12,
																					'largest' => 12,
																					'unit' => 'px', )) );
		
		echo '<div class="tagcloud">';
		if($tags_array && is_array($tags_array) && count($tags_array))
		{
			if(class_exists('DOMDocument'))
			{
				$doc = new DOMDocument();
				$charset = get_bloginfo('charset');
				
				foreach ($tags_array as $tag_link)
				{
					$doc->loadHTML('<?xml version="1.0" encoding="'.$charset.'"?>'.$tag_link);
					$node = $doc->getElementsByTagName('a')->item(0);
					if($node && $node->hasAttribute('class'))
					{
						$class = $node->getAttribute( 'class' );
						if($class)
						{
							preg_match('/\-(\d+)$/', $class, $matches);
							
							if($matches && isset($matches[1]))
							{
								$tag = get_term_by('id', $matches[1], $current_taxonomy);
								if($tag && isset($tag->term_id))
								{
									$color = get_tax_meta($tag->term_id, SHORTNAME . '_cat_color');
									if(th_empty_color($color))
									{
										$color = get_option(SHORTNAME . '_accent_color');
									}
									$node->setAttribute('data-color', $color);
								}
							}
						}	
					}	
					echo preg_replace(array('/^<!DOCTYPE.+?>/', '/\<\?xml version="1\.0" encoding="'.$charset.'"\?\>/'), array('', ''), str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $doc->saveHTML()));
				}
			}
			else
			{
				foreach($tags_array as $tag_link)
				{
					echo $tag_link;
				}
			}
		}
		echo "</div>\n";
		
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['taxonomy'] = stripslashes($new_instance['taxonomy']);
		return $instance;
	}

	function form( $instance ) {
		$current_taxonomy = $this->_get_current_taxonomy($instance);
?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','milano') ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Taxonomy:','milano') ?></label>
	<select class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
	<?php foreach ( get_taxonomies() as $taxonomy ) :
				$tax = get_taxonomy($taxonomy);
				if ( !$tax->show_tagcloud || empty($tax->labels->name) )
					continue;
	?>
		<option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy) ?>><?php echo $tax->labels->name; ?></option>
	<?php endforeach; ?>
	</select></p><?php
	}

	function _get_current_taxonomy($instance) {
		if ( !empty($instance['taxonomy']) && taxonomy_exists($instance['taxonomy']) )
			return $instance['taxonomy'];

		return 'post_tag';
	}
}
?>
