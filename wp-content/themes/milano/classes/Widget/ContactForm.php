<?php
/**
 *  Contact form widget
 */
class Widget_ContactForm extends Widget_Default {

	function __construct()
	{
		$this->setClassName('widget_contactform');
		$this->setName(__('Contact form','milano'));
		$this->setDescription(__('Contact form widget','milano'));
		$this->setIdSuffix('contactform');
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );

		$to = (isset($instance['recipient'])
						&& !empty($instance['recipient'])
						&& filter_var($instance['recipient'], FILTER_VALIDATE_EMAIL))
					? $instance['recipient']
					: get_bloginfo('admin_email');
		$wdescription = $instance['wdescription'];

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;
		
		if ($wdescription)
			echo '<div>'.th_the_content($wdescription).'</div>';

		global $wid;
		$wid = $args['widget_id'];
		global $am_validate; $am_validate = true;

		?><form class="contactformWidget" method="post" action="#contactformWidget">
				<div>
					<input name="name" class="name" type="text" placeholder="<?php _e('Name','milano'); ?>" />
				</div>
				<div>
					<input  name="email" class="email" type="text"  id="email_from" placeholder="<?php _e('E-Mail','milano'); ?>" />
				</div>
				<div>
					<textarea  name="comments"  rows="5" cols="20" placeholder="<?php _e('Type your message here','milano'); ?>"></textarea>
				</div>
				<div>
					<button type="submit"><?php echo $instance['btntext']; ?></button>
				</div>
				<input type="hidden" name="to" value="<?php echo ml_obfuscate_email($to);?>">
				<input type='hidden' class = 'th-email-from' name = 'th-email-from' value='email_from'>
		</form>
		<?php 
		FrontWidgets::getInstance()->add(array(
			'type' => 'ContactForm',
			'id' => 'contact_form_widget',
			'options' => array(
				'selector' => '.contactformWidget'
			)
		));
		echo $after_widget;

		wp_enqueue_script('validate');
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['recipient'] = strip_tags( $new_instance['recipient'] );
		$instance['wdescription'] =  $new_instance['wdescription'] ;
		$instance['btntext'] =  $new_instance['btntext'] ;
		return $instance;
	}


	function form( $instance ) {

		// Defaults
		$defaults = array( 'title' => __( 'Contact us', 'milano' ),
						   'recipient' => get_bloginfo('admin_email'),
							'wdescription'=>'',
							'btntext'=> 'Submit');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'milano' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'wdescription' ); ?>"><?php _e( 'Description:', 'milano' ); ?></label>
			<textarea id="<?php echo $this->get_field_id( 'wdescription' ); ?>" name="<?php echo $this->get_field_name( 'wdescription' ); ?>"   style="width:100%;min-height:120px"><?php echo $instance['wdescription']; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'recipient' ); ?>"><?php _e( 'Recipient email:', 'milano' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'recipient' ); ?>" name="<?php echo $this->get_field_name( 'recipient' ); ?>" type="text" value="<?php echo $instance['recipient']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'btntext' ); ?>"><?php _e( 'Button text:', 'milano' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'btntext' ); ?>" name="<?php echo $this->get_field_name( 'btntext' ); ?>" type="text" value="<?php echo $instance['btntext']; ?>" style="width:100%;" />
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}