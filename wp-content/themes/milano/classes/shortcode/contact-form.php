<?php

define('CONTACT_FORM_SHORTCODE_DIR', plugin_dir_path(__FILE__));
define('CONTACT_FORM_SHORTCODE_URL', get_template_directory_uri() . '/classes/shortcode/contactForm/');

if (is_admin())
	require_once CONTACT_FORM_SHORTCODE_DIR . '/contactForm/admin.php';

// take the content of a contact-form shortcode and parse it into a list of field types
function th_contact_form_parse($content)
{
	// first parse all the contact-field shortcodes into an array
	global $contact_form_fields;
	$contact_form_fields = array();
	$out = do_shortcode($content);
	return $out;
}

function th_contact_form_render_field($field)
{
	global $contact_form_last_id, $contact_form_fields, $current_user, $user_identity, $js_validation;

	$r = '';

	$field_id = $field['id'];
	if (isset($_POST[$field_id]))
	{
		$field_value = stripslashes($_POST[$field_id]);
	}
	elseif (is_user_logged_in())
	{
		// Special defaults for logged-in users
		switch($field['type'])
		{
			case 'email':
				$field_value = $current_user->data->user_email;
				break;
			case 'name':
				$field_value = $user_identity;
				break;
			case 'url':
				$field_value = $current_user->data->user_url;
				break;
			default :
			$field_value = $field['default'];
				break;
		}
	}
	else
	{
		$field_value = $field['default'];
	}
	
	$field_value = wp_kses($field_value, array());

	$field['label'] = html_entity_decode($field['label']);
	$field['label'] = wp_kses($field['label'], array());
	
	$js_validation[] = get_validation_field_data($field);
	switch ($field['type'])
	{
		case 'email':
			$r .= "\n<div class='form_line'>\n";
			$r .= "\t\t<label for='" . esc_attr($field_id) . "' class='th-field-label " . esc_attr($field['type']) . "' style='display:none;'>" . htmlspecialchars($field['label']) . ( $field['required'] ? '<span>' . __("(required)", 'milano') . '</span>' : '' ) . "</label><input type='text' name='" . esc_attr($field_id) . "' id='" . esc_attr($field_id) . "' value='" . esc_attr($field_value) . "' placeholder='".htmlspecialchars($field['label'])."' class='" . esc_attr($field['type']) . "'/>\n";
			if(isset($field['reply']) && $field['reply'])
			{
				$r .= "\t\t<input type='hidden' class = 'th-email-from' name = 'th-email-from' value='" . esc_attr($field_id) ."'>";
			}
			$r .= "\t</div>\n";
			break;
			
		case 'name':
			$r .= "\n<div class='form_line'>\n";
			$r .= "\t\t<label for='" . esc_attr($field_id) . "' class='th-field-label " . esc_attr($field['type']) . "' style='display:none;'>" . htmlspecialchars($field['label']) . ( $field['required'] ? '<span>' . __("(required)", 'milano') . '</span>' : '' ) . "</label><input type='text' name='" . esc_attr($field_id) . "' id='" . esc_attr($field_id) . "' value='" . esc_attr($field_value) . "' placeholder='".htmlspecialchars($field['label'])."' class='" . esc_attr($field['type']) . "'/>\n";			
				$r .= "\t\t<input type='hidden' class = 'th-name-from' name = 'th-name-from' value='" . esc_attr($field_id) ."'>";			
			$r .= "\t</div>\n";
			break;
		
		case 'textarea':
			$r .= "\n<div class='form_line'>\n";
			$r .= "\t\t<label for='" . esc_attr($field_id) . "' class='" . esc_attr($field['type']). "' style='display:none;'>" . htmlspecialchars(($field['label'])?$field['label']:$field_id) . ( $field['required'] ? '<span>' . __("(required)", 'milano') . '</span>' : '' ) . "</label><textarea name='" . esc_attr($field_id) . "' id='contact-form-comment-" . esc_attr($field_id) . "' placeholder='".htmlspecialchars($field['label'])."' rows='14'>" . htmlspecialchars($field_value) . "</textarea>\n";
			$r .= "\t</div>\n";
			break;
		
		case 'radio':
			$r .= "\t<div class='form_line'><label class='" .  "'>" . htmlspecialchars($field['label']) . ( $field['required'] ? '<span>' . __("(required)", 'milano') . '</span>' : '' ) . "</label>\n";
			foreach ($field['options'] as $option)
			{
				$r .= "\t\t<input type='radio' name='" . esc_attr($field_id) . "' value='" . esc_attr($option) . "' class='" . esc_attr($field['type']) . "' " . ( $option == $field_value ? "checked='checked' " : "") . " /><label for='". esc_attr($field_id) . "' class='" . esc_attr($field['type']) . "'>" . htmlspecialchars($option) . "</label>";
			}
			$r .= "\t\t</div>\n";
			break;
			
		case 'checkbox':
			$r .= "\t<div class='form_line'><input type='checkbox' name='" . esc_attr($field_id) . "' value='" . __('Yes', 'milano') . "' class='" . esc_attr($field['type']) . "' " . ( $field_value ? "checked='checked' " : "") . " /><label for='". esc_attr($field_id) . "' class='" . esc_attr($field['type']) .   "'>" . htmlspecialchars($field['label']) . ( $field['required'] ? '<span>' . __("(required)", 'milano') . '</span>' : '' ) . "</label></div>\n";
			break;
		
		case 'select':
			$r .= "\n<div class='form_line'>\n";
			$r .= "\t\t<label for='" . esc_attr($field_id) . "' class='" . esc_attr($field['type']) .   "'>" . htmlspecialchars($field['label']) . ( $field['required'] ? '<span>' . __("(required)", 'milano') . '</span>' : '' ) . "</label>\n";
			$r .= "\t<select name='" . esc_attr($field_id) . "' id='" . esc_attr($field_id) . "' value='" . esc_attr($field_value) . "' class='" . esc_attr($field['type']) . "'/>\n";
			foreach ($field['options'] as $option)
			{
				$option = html_entity_decode($option);
				$option = wp_kses($option, array());
				$r .= "\t\t<option" . ( $option == $field_value ? " selected='selected'" : "") . ">" . esc_html($option) . "</option>\n";
			}
			$r .= "\t</select>\n";
			$r .= "\t</div>\n";
			break;
			
		default:
			// default: text field
			// note that any unknown types will produce a text input, so we can use arbitrary type names to handle
			// input fields like name, email, url that require special validation or handling at POST
			$r .= "\n<div class='form_line'>\n";
			$r .= "\t\t<label for='" . esc_attr($field_id) . "' class='" . esc_attr($field['type']) .   "' style='display:none;'>" . htmlspecialchars($field['label']) . ( $field['required'] ? '<span>' . __("(required)", 'milano') . '</span>' : '' ) . "</label><input type='text' name='" . esc_attr($field_id) . "' id='" . esc_attr($field_id) . "' value='" . esc_attr($field_value) . "' placeholder='".htmlspecialchars($field['label'])."' class='" . esc_attr($field['type']) . "'/>\n";
			$r .= "\t</div>\n";
			break;
	}
	
	return $r;
}

function get_validation_field_data($field)
{
	$data		= array();
	$message	= array();
	$rules		= array();
	
	if(!is_null($field))
	{
		if(isset($field['type']))
		{
			switch($field['type'])
			{
				case 'email':
					$rules[] = 'email';
					$message['email'] = sprintf(__('%s requires a valid email address', 'milano'), $field['label']);
					break;
				case 'url':
					$rules[] = 'url';
					$message['url'] = sprintf(__('%s requires a valid url', 'milano'), $field['label']);
					break;
				default:
					break;
			}
		}
		if( isset($field['required']) && $field['required'] )
		{
			$rules[] = 'required';
			$message['required'] = sprintf(__('%s is required', 'milano'), $field['label']);
		}
	}
	
	$data[esc_attr($field['id'])] = array(
								'rules'		=> $rules,
								'message'	=> $message,);
	return $data;
}

function get_js_validation_rules()
{
	global $js_validation;
	$rules = array();
	if(is_array($js_validation)&& count($js_validation)) {
		foreach($js_validation as $element) {
			foreach($element as $name => $data) {
				if(isset($data['rules']) && is_array($data['rules']) && count($data['rules'])) {
					$rules[$name] = implode(' ', $data['rules']);
				}
			}
		}
	}
	return $rules;
}

/**
 * validation rules for implement it for ajac contact form content
 * @global type $js_validation
 * @param int $form_code
 * @return \stdClass
 */
function get_js_validation_object($form_code) {
	global $js_validation;
	$rules		= new stdClass();
	$message	= new stdClass();
	$code		= new stdClass();
	foreach($js_validation as $element)
		{
			foreach($element as $name => $info)
			{
				$element_message = new stdClass();
				if(isset($info['rules']) && is_array($info['rules']) && count($info['rules']))
				{
					$rules->$name =  implode(' ', $info['rules']);
				}

				if(isset($info['message']) && is_array($info['message']) && count($info['message']))
				{

					foreach($info['message'] as $rule => $text)
					{
						$element_message->$rule = $text;
					}

					if($element_message)
					{
						$message->$name = $element_message;
					}
				}
			}
		}

		if($rules)
		{
			$code->rules = $rules;
		}

		if($message)
		{
			$code->message = $message;
		}

		return json_encode($code);
}

// generic shortcode that handles all of the major input types
// this parses the field attributes into an array that is used by other functions for rendering, validation etc
function th_contact_form_field($atts, $content, $tag)
{
	global $contact_form_fields, $contact_form_last_id, $js_validation;
	
	$field = shortcode_atts(array(
		'label'		=> null,
		'type'		=> 'text',
		'reply'		=> false,
		'required'	=> false,
		'options'	=> array(),
		'id'		=> null,
		'default'	=> null,
			), $atts);

	// special default for subject field
	if ($field['type'] == 'subject' && is_null($field['default']))
		$field['default'] = '';

	// allow required=1 or required=true
	if ($field['required'] == '1' || strtolower($field['required']) == 'true')
		$field['required'] = true;
	else
		$field['required'] = false;

	// allow reply=1 or reply=true
	if ($field['reply'] == '1' || strtolower($field['reply']) == 'true')
		$field['reply'] = true;
	else
		$field['reply'] = false;

	// parse out comma-separated options list
	if (!empty($field['options']) && is_string($field['options']))
		$field['options'] = array_map('trim', explode(',', $field['options']));

	// make a unique field ID based on the label, with an incrementing number if needed to avoid clashes
	$id = $field['id'];
	if (empty($id))
	{
		
		$label = $field['type'].'-'.mt_rand(6000,10000); 
		
		$id = sanitize_title_with_dashes($label. '-' . $contact_form_last_id);
		$i = 0;
		while (isset($contact_form_fields[$id]))
		{
			$i++;
			$id = sanitize_title_with_dashes($label . '-' . $contact_form_last_id . '-' . $i);
		}
		$field['id'] = $id;
	}

	$contact_form_fields[$id] = $field;

	return th_contact_form_render_field($field);
}

add_shortcode('contact-field', 'th_contact_form_field');
add_shortcode('th-contact-field', 'th_contact_form_field');

function th_contact_form_shortcode($atts, $content)
{
	global $post, $js_validation;
	$js_validation = '';

	$default_to = get_option('admin_email');
	$default_subject = "[" . get_option('blogname') . "]";

	if (!empty($atts['widget']) && $atts['widget'])
	{
		$default_subject .= __(" Sidebar","milano");
	}
	elseif (isset($post) && $post->ID)
	{
		$default_subject .= " " . wp_kses($post->post_title, array());
		$post_author = get_userdata($post->post_author);
		$default_to = $post_author->user_email;
	}
// default values
	extract(shortcode_atts(array(
				'to' => '',
				'subject' => '',
				'button_text' => __('Send','milano'),
				'show_subject' => 'no', 
				'widget' => 0 
					), $atts));

	$widget = esc_attr($widget);

	if (( function_exists('faux_faux') && faux_faux() ) || is_feed())
		return '[th-contact-form]';

	global $wp_query,  $contact_form_values, $user_identity, $contact_form_last_id, $contact_form_message;

	// used to store attributes, configuration etc for access by contact-field shortcodes

	if ($widget)
		$id = 'widget-' . $widget;
	elseif (is_singular())
		$id = $wp_query->get_queried_object_id();
	elseif(isset($GLOBALS['post']))
		$id = $GLOBALS['post']->ID;
	else
		$id = mt_rand (6000, 10000);
	
	
	if (!$id) // something terrible has happened
		return '[th-contact-form]';
//
//	
	$contact_form_last_id = $id;
	

	ob_start();
	wp_nonce_field('contact-form_' . $id);
	$nonce = ob_get_contents();
	ob_end_clean();


	$body = th_contact_form_parse($content);

	$r = "<div id='contact-form-$id' data-script='validate'>\n";

	$errors = array();
	$random_form_id = mt_rand();
	$r .= "<form action='#contact-form-$id' method='post' class='feedback wrapper th_contact-form' id='id-$random_form_id' >\n";
	$r .= $body;
	$r .= "\t<div class='th_contact-submit'>\n";
	$r .= "\t\t<input type='submit' name='send_button' value='" . htmlspecialchars($button_text) . "' class='d_in-block button skin1' />";
	$r .= "$nonce";
	$r .= "<input type='hidden' name='contact-form-id' value='$id' />";
	$r .= "</div>";
	$emails = str_replace(' ', '', $to);
	$emails = explode(',', $emails);
	$valid_emails = array();
	foreach ((array) $emails as $email)
	{
		if (is_email($email) && (!function_exists('is_email_address_unsafe') || !is_email_address_unsafe($email) ))
			$valid_emails[] = ml_obfuscate_email($email);
	}

	$to = ( $valid_emails ) ? $valid_emails : $default_to;
	if(is_array($to))
	{
		$to_string = implode(',', $to);
	}
	else
	{
		$to_string = ml_obfuscate_email($to);	
	}
	
	
	if($to_string)
	{
		$r .= "<input type='hidden' name='to' value='$to_string' />";
	}
	if($subject)
	{
		$r .= "<input type='hidden' name='subject' value='$subject' />";
	}
	$r .= "<input type='hidden' name='validate_rules' value='" . htmlentities(get_js_validation_object($random_form_id)). "' />";
	$r .= "</form>\n";
	$r .= "</div>";
	FrontWidgets::getInstance()->add(array(
		'type' => 'ContactForm',
		'id' => 'contact_form',
		'options' => array(
			'selector' => '#id-'.$random_form_id,
			'rules' => get_js_validation_rules(),
			'messages' => array(
				'success' => __('Your message has been successfully sent to us!', 'milano'),
				'mailError' => __('Something going wrong with sending mail...', 'milano'),
				'connecionError' => __('Something going wrong with connection...', 'milano')
			)
		)
	));
	return $r; 
}

add_shortcode('contact-form', 'th_contact_form_shortcode');
add_shortcode('th-contact-form', 'th_contact_form_shortcode');

function th_contact_form_widget_atts($text)
{
	static $widget = 0;

	$widget++;

	return str_replace('[th-contact-form', '[th-contact-form widget="' . $widget . '"', $text);
}

add_filter('widget_text', 'th_contact_form_widget_atts', 0);
?>