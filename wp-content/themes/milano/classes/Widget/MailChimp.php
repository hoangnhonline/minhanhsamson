<?php
class Widget_MailChimp extends Widget_Default {
	private $default_loader_graphic = '/images/ajax-loader.gif';
	private $successful_signup = false;
	private $subscribe_errors;
	private $ns_mc_plugin;

	public function __construct () {
		$this->setClassName('widget_mailchimp');
		$this->setName(__('MailChimp', 'milano'));
		$this->setDescription(__('Show previews from portfolio category', 'milano'));
		$this->setIdSuffix('mailchimp');

		$this->ns_mc_plugin = Widget_MailChimp_Plugin::get_instance();
		$this->default_loader_graphic = get_template_directory_uri() . $this->default_loader_graphic;

		add_action('init', array(&$this, 'add_scripts'));
		add_action('parse_request', array(&$this, 'process_submission'));

		parent::__construct();
	}

	public function add_scripts () {
//		wp_enqueue_script('widget_mailchimp', get_template_directory_uri() . '/js/mailchimp-widget-min.js', array('jquery'), null);
	}

	public function form ($instance) {
		$mcapi = $this->ns_mc_plugin->get_mcapi();
		if (false == $mcapi) {
			echo $this->ns_mc_plugin->get_admin_notices();
		} else {
			$this->lists = $mcapi->lists();

			$vars = wp_parse_args($instance, $this->getDefaults());

			extract($vars);
			?>
					<h3><?php echo  __('General Settings', 'milano'); ?></h3>
					<p>
						<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo  __('Title :', 'milano'); ?></label>
						<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
					</p>
					<p>
						<label for="<?php echo $this->get_field_id('current_mailing_list'); ?>"><?php echo __('Select a Mailing List :', 'milano'); ?></label>
						<select class="widefat" id="<?php echo $this->get_field_id('current_mailing_list');?>" name="<?php echo $this->get_field_name('current_mailing_list'); ?>">
			<?php
			foreach ($this->lists['data'] as $key => $value) {
				$selected = (isset($current_mailing_list) && $current_mailing_list == $value['id']) ? ' selected="selected" ' : '';
				?>
						<option <?php echo $selected; ?>value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
				<?php
			}
			?>
						</select>
					</p>
					<p><strong>N.B.</strong><?php echo  __('This is the list your users will be signing up for in your sidebar.', 'milano'); ?></p>
					<p>
						<label for="<?php echo $this->get_field_id('signup_text'); ?>"><?php echo __('Sign Up Button Text :', 'milano'); ?></label>
						<input class="widefat" id="<?php echo $this->get_field_id('signup_text'); ?>" name="<?php echo $this->get_field_name('signup_text'); ?>" value="<?php echo $signup_text; ?>" />
					</p>
					<h3><?php echo __('Personal Information', 'milano'); ?></h3>
					<p><?php echo __("These fields won't (and shouldn't) be required. Should the widget form collect users' first and last names?", 'milano'); ?></p>
					<p>
						<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('collect_first'); ?>" name="<?php echo $this->get_field_name('collect_first'); ?>" <?php echo  checked($collect_first, true, false); ?> />
						<label for="<?php echo $this->get_field_id('collect_first'); ?>"><?php echo  __('Collect first name.', 'milano'); ?></label>
						<br />
						<input type="checkbox" class="checkbox" id="<?php echo  $this->get_field_id('collect_last'); ?>" name="<?php echo $this->get_field_name('collect_last'); ?>" <?php echo checked($collect_last, true, false); ?> />
						<label><?php echo __('Collect last name.', 'milano'); ?></label>
					</p>
					<h3><?php echo __('Notifications', 'milano'); ?></h3>
					<p><?php echo  __('Use these fields to customize what your visitors see after they submit the form', 'milano'); ?></p>
					<p>
						<label for="<?php echo $this->get_field_id('success_message'); ?>"><?php echo __('Success :', 'milano'); ?></label>
						<textarea class="widefat" id="<?php echo $this->get_field_id('success_message'); ?>" name="<?php echo $this->get_field_name('success_message'); ?>"><?php echo $success_message; ?></textarea>
					</p>
					<p>
						<label for="<?php echo $this->get_field_id('failure_message'); ?>"><?php echo __('Failure :', 'milano'); ?></label>
						<textarea class="widefat" id="<?php echo $this->get_field_id('failure_message'); ?>" name="<?php echo $this->get_field_name('failure_message'); ?>"><?php echo $failure_message; ?></textarea>
					</p>
			<?php

		}
	}

	public function process_submission () {

		if (isset($_GET[$this->id_base . '_email'])) {

			header("Content-Type: application/json");

			//Assume the worst.
			$response = '';
			$result = array('success' => false, 'error' => $this->get_failure_message($_GET['ns_mc_number']));

			$merge_vars = array();

			if (! is_email($_GET[$this->id_base . '_email'])) { //Use WordPress's built-in is_email function to validate input.

				$response = json_encode($result); //If it's not a valid email address, just encode the defaults.

			} else {

				$mcapi = $this->ns_mc_plugin->get_mcapi();

				if (false == $this->ns_mc_plugin) {

					$response = json_encode($result);

				} else {

					if (isset($_GET[$this->id_base . '_first_name']) && is_string($_GET[$this->id_base . '_first_name'])) {

						$merge_vars['FNAME'] = $_GET[$this->id_base . '_first_name'];

					}

					if (isset($_GET[$this->id_base . '_last_name']) && is_string($_GET[$this->id_base . '_last_name'])) {

						$merge_vars['LNAME'] = $_GET[$this->id_base . '_last_name'];

					}

					$subscribed = $mcapi->listSubscribe($this->get_current_mailing_list_id($_GET['ns_mc_number']), $_GET[$this->id_base . '_email'], $merge_vars);

					if (false == $subscribed) {

						$response = json_encode($result);

					} else {

						$result['success'] = true;
						$result['error'] = '';
						$result['success_message'] =  $this->get_success_message($_GET['ns_mc_number']);
						$response = json_encode($result);

					}

				}

			}

			exit($response);

		} elseif (isset($_POST[$this->id_base . '_email'])) {

			$this->subscribe_errors = '<div class="error">'  . $this->get_failure_message($_POST['ns_mc_number']) .  '</div>';

			if (! is_email($_POST[$this->id_base . '_email'])) {

				return false;

			}

			$mcapi = $this->ns_mc_plugin->get_mcapi();

			if (false == $mcapi) {

				return false;

			}

			if (is_string($_POST[$this->id_base . '_first_name'])  && '' != $_POST[$this->id_base . '_first_name']) {

				$merge_vars['FNAME'] = strip_tags($_POST[$this->id_base . '_first_name']);

			}

			if (is_string($_POST[$this->id_base . '_last_name']) && '' != $_POST[$this->id_base . '_last_name']) {

				$merge_vars['LNAME'] = strip_tags($_POST[$this->id_base . '_last_name']);

			}

			$subscribed = $mcapi->listSubscribe($this->get_current_mailing_list_id($_POST['ns_mc_number']), $_POST[$this->id_base . '_email'], $merge_vars);

			if (false == $subscribed) {

				return false;

			} else {

				$this->subscribe_errors = '';

				setcookie($this->id_base . '-' . $this->number, $this->hash_mailing_list_id(), time() + 31556926);

				$this->successful_signup = true;

				$this->signup_success_message = '<p>' . $this->get_success_message($_POST['ns_mc_number']) . '</p>';

				return true;
			}
		}
	}

	public function update ($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['collect_first'] = ! empty($new_instance['collect_first']);

		$instance['collect_last'] = ! empty($new_instance['collect_last']);

		$instance['current_mailing_list'] = esc_attr($new_instance['current_mailing_list']);

		$instance['failure_message'] = esc_attr($new_instance['failure_message']);

		$instance['signup_text'] = esc_attr($new_instance['signup_text']);

		$instance['success_message'] = esc_attr($new_instance['success_message']);

		$instance['title'] = esc_attr($new_instance['title']);

		return $instance;

	}

	public function widget ($args, $instance) {

		extract($args);

		if ((isset($_COOKIE[$this->id_base . '-' . $this->number]) && $this->hash_mailing_list_id($this->number) == $_COOKIE[$this->id_base . '-' . $this->number]) || false == $this->ns_mc_plugin->get_mcapi()) {

			return 0;

		} else {

			echo $before_widget . $before_title . $instance['title'] . $after_title;

			if ($this->successful_signup) {
				echo $this->signup_success_message;
			} else {
				?>
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="<?php echo $this->id_base . '_form-' . $this->number; ?>" method="post">
					<div class="preloader"></div>
					<?php echo $this->subscribe_errors;?>
						<input type="hidden" name="ns_mc_number" value="<?php echo $this->number; ?>" />
						<label for="<?php echo $this->id_base; ?>-email-<?php echo $this->number; ?>"><?php echo __('Email Address :', 'milano'); ?></label>
						<input id="<?php echo $this->id_base; ?>-email-<?php echo $this->number; ?>" type="text" name="<?php echo $this->id_base; ?>_email" />
						<input class="button" type="submit" name="<?php echo $instance['signup_text']; ?>" value="<?php echo $instance['signup_text']; ?>" />
					</form>
						<script>jQuery('#<?php echo $this->id_base; ?>_form-<?php echo $this->number; ?>').ns_mc_widget({"url" : "<?php echo $_SERVER['PHP_SELF']; ?>", "cookie_id" : "<?php echo $this->id_base; ?>-<?php echo $this->number; ?>", "cookie_value" : "<?php echo $this->hash_mailing_list_id(); ?>", "loader_graphic" : "<?php echo $this->default_loader_graphic; ?>"}); </script>
				<?php
			}
			echo $after_widget;
		}

	}

	private function hash_mailing_list_id () {

		$options = get_option($this->option_name);

		$hash = md5($options[$this->number]['current_mailing_list']);

		return $hash;

	}

	private function get_current_mailing_list_id ($number = null) {

		$options = get_option($this->option_name);

		return $options[$number]['current_mailing_list'];

	}

	private function get_failure_message ($number = null) {

		$options = get_option($this->option_name);

		return $options[$number]['failure_message'];

	}

	private function get_success_message ($number = null) {

		$options = get_option($this->option_name);

		return $options[$number]['success_message'];

	}
	 private function getDefaults() {
		 return array(
				'failure_message'	=> __('There was a problem processing your submission.', 'milano'),
				'title'				=> __('Sign up for our mailing list.', 'milano'),
				'signup_text'		=> __('Join now!', 'milano'),
				'success_message'	=> __('Thank you for joining our mailing list. Please check your email for a confirmation link.', 'milano'),
				'collect_first'		=> false,
				'collect_last'		=> false,
				'old_markup'		=> false
			);
	 }
}
?>