<?php
defined('WP_ADMIN') || define('WP_ADMIN', true);
$_SERVER['PHP_SELF'] = '/wp-admin/index.php';
require_once('../../../../../../wp-load.php');
?>
<!doctype html>
<html lang="en">
	<head>
	<title>Insert list</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="<?php echo  home_url()."/".WPINC;   ?>/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo  home_url()."/".WPINC;   ?>/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo  home_url()."/".WPINC;   ?>/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo  home_url()."/".WPINC;   ?>/js/jquery/jquery.js?ver=1.4.2"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() . '/classes/shortcode/shortcodes/shortcodesUtils.js'?>"></script>
	<base target="_self" />
	</head>
	<body  onload="init();">
	<form name="th_list" action="#" >
		<div class="tabs">
			<ul>
				<li id="list_tab" class="current"><span><a href="javascript:mcTabs.displayTab('list_tab','list_panel');" onMouseDown="return false;">List</a></span></li>
			</ul>
		</div>
		<div class="panel_wrapper">
			<fieldset style="margin-bottom:10px;padding:10px">
				<legend>Change Color:</legend>
				<label>list colors:</label><br><br>
				<input data-name="color" type="color" data-hex="true" id="list_color" style="width:230px" value="#b8bf37">
			</fieldset>
			<fieldset style="margin-bottom:10px;padding:10px">
				<legend>Type of list:</legend>
				<label for="list_type">Choose a type:</label><br><br>
				<select data-name="list_type" id="list_type"  style="width:250px">						
					<option value="th_list_simple" selected>Simple dots</option>
					<option value="th_list_animated">Animated</option>			
				</select>					
			</fieldset>	
		</div>
		<div class="mceActionPanel">
			<div style="float: right">
				<input type="submit" id="insert" name="insert" value="Insert" onClick="submitData(jQuery(this).closest('form'), '<ul><li>Item #1</li><li>Item #2</li><li>Item #3</li></ul>');" />
			</div>
		</div>
	</form>
</body>
</html>