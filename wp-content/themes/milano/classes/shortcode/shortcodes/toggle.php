<?php
defined('WP_ADMIN') || define('WP_ADMIN', true);
$_SERVER['PHP_SELF'] = '/wp-admin/index.php';
require_once('../../../../../../wp-load.php');
?>
<!doctype html>
<html lang="en">
	<head>
	<title>Insert Toggle</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="<?php echo  home_url()."/".WPINC;   ?>/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo  home_url()."/".WPINC;   ?>/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo  home_url()."/".WPINC;   ?>/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo  home_url()."/".WPINC;   ?>/js/jquery/jquery.js?ver=1.4.2"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() . '/classes/shortcode/shortcodes/shortcodesUtils.js'?>"></script>
	<base target="_self" />
	</head>
	<body  onload="init();">
	<form name="toggle" action="#" >
		<div class="tabs">
			<ul>
				<li id="toggle_tab" class="current"><span><a href="javascript:mcTabs.displayTab('toggle_tab','toggle_panel');" onMouseDown="return false;">Toggle</a></span></li>
			</ul>
		</div>
		<div class="panel_wrapper">
			<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('Title of toggle:','milano'); ?></legend>
				<label for="toggle_title"><?php _e('Type toggle title:','milano'); ?></label>
				<br><br>
				<input type="text" data-name="title"  style="width:250px" />			
			</fieldset>
			<fieldset style="margin-bottom:10px;padding:10px">
				<legend>Change Color:</legend>
				<label>toggle background colors:</label><br><br>
				<input data-name="color" type="color" data-hex="true" id="toggle_color" style="width:230px" value="#363636">
			</fieldset>
			<fieldset style="margin-bottom:10px;padding:10px">
				<legend>Keep open:</legend>
				<label>Opened by default::</label><br><br>
				<input data-name="open" type="checkbox" data-hex="true" id="toggle_open" />
			</fieldset>
		</div>
		<div class="mceActionPanel">
			<div style="float: right">
				<input type="submit" id="insert" name="insert" value="Insert" onClick="submitData(jQuery(this).closest('form'));" />
			</div>
		</div>
	</form>
</body>
</html>