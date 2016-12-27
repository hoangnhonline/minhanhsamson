<?php

class Widget_Menu extends Widget_Default
{

	/**
	 * Form fields 
	 */
	const TIME = 'time';
	const TITLE = 'title';
	const MENU = 'menu';
	const RANDOMIZE = 'randomize';
	const TESTIMONIAL_POST_TRANSIENT = 'JkH83gha903';

	public function __construct()
	{
		$this->setClassName('widget_menu');
		$this->setName('Menu');
		$this->setDescription('Show Menu');
		$this->setIdSuffix('menu');
		parent::__construct();
	}

	function widget($args, $instance)
	{
		extract($args);

		$title = apply_filters('widget_title', $instance[self::TITLE]);

		$class = 'side_menu';

		echo $before_widget;
		$rnd = rand(0, 2000);
		wp_nav_menu(array(
			'menu' => $instance['menu'],
			'container_class' => '' . $class,
			'menu_class' => 'custom_menu menu_' . $rnd,
			'fallback_cb' => '',
			'container' => 'nav',
			'link_before' => '',
			'link_after' => '',
			'walker' => new Walker_Nav_Menu_Sub()
		));
		?>
		<script>

			jQuery('.menu_<?php echo $rnd; ?>').find(".sf-sub-indicator").removeClass('unprocessed').click(function(event) {
				event.preventDefault();
				var isOpen = jQuery(this).closest('li').is('.open');

				jQuery(this).closest('ul').find('li.open').removeClass('open').find('>.sub-menu').slideUp("middle");
				if (!isOpen) {
					jQuery(this).closest("li").toggleClass("open")
							.find('>.sub-menu').slideToggle("fast");
				}

			});

		</script>
		<?php
		echo $after_widget;
	}

	function form($instance)
	{
		$defaults = array(
			self::MENU => '');

		$menus = null;
		$instance = wp_parse_args((array) $instance, $defaults);

		$menus = get_terms('nav_menu');
		?>
		<div>			
			<p>
				<label for="<?php echo $this->get_field_id(self::MENU); ?>" >
		<?php _e('Select Menu:', 'milano'); ?>
				</label>
				<select name="<?php echo $this->get_field_name(self::MENU); ?>" id="<?php echo $this->get_field_id(self::MENU); ?>"  style="width:100%;">
		<?php
		if ($menus)
		{
			foreach ($menus as $menu)
			{
				$selected = "";
				if ($instance[self::MENU] == $menu->name)
				{
					$selected = "selected='selected'";
				}
				echo "<option $selected value='" . $menu->name . "'>" . $menu->name . "</option>";
			}
		}
		?>
				</select>
			</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
		<?php
	}

}
?>