<?php

header("Content-Type: application/json");

$result = array('status' => 'error', 'code' => 'mailError');

try
{
	$emailto = '';
	$messages = '';

	if (!empty($_POST))
	{
		$headers = "Content-Type: text/html; charset=\"" . get_option('blog_charset') . "\"\r\n";

		if (isset($_POST['subject']))
		{
			$subject = stripslashes($_POST['subject']);
		}
		else
		{
			$subject = stripslashes("[" . get_bloginfo('name') . "]");
		}

		if (isset($_POST['to']))
		{
			$emailto = ml_obfuscate_email(trim($_POST['to']));
		}
		else
		{
			$emailto = get_option('admin_email');
		}

		if (isset($_POST['th-email-from']))
		{
			$from = ((isset($_POST['th-name-from'])) ? trim($_POST['th-name-from']) : stripslashes("[" . get_bloginfo('name') . "]")) . ' <' . trim($_POST['th-email-from']) . '>';

			$headers .= 'From: ' . $from . "\r\n" .
					'Reply-To: ' . $from . "\r\n";
		}


		foreach ($_POST as $field => $text)
		{
			if (!in_array($field, array('to', 'subject', 'th-email-from', 'th-name-from')))
			{
				if ($field != 'action' && $text != 'send_contact_form')
				{
					$field = str_replace('_', ' ', $field);
					$messages .= "<br><strong>{$field}</strong> : {$text}";
				}
			}
		}

		if ($emailto)
		{
			$mail = wp_mail($emailto, $subject, $messages, $headers);

			if ($mail)
			{
				$result = array('status' => 'success', 'code' => 'success');
			}
			else
			{
				throw new Exception('sending mail error');
			}
		}
	}
} catch (Exception $e)
{
	
}

echo json_encode($result);
?>