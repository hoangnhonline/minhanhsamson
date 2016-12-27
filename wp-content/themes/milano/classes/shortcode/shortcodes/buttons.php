<?php	
defined('WP_ADMIN') || define('WP_ADMIN', true);
$_SERVER['PHP_SELF'] = '/wp-admin/index.php';
require_once('../../../../../../wp-load.php');
if( get_option(SHORTNAME."_linkscolor")) { $customcolor = get_option(SHORTNAME."_linkscolor"); } else {$customcolor = "#c62b02"; }
?>
<!doctype html>
<html lang="en">
	<head>
	<title><?php _e('Insert Button','milano'); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/jquery/jquery.js?ver=1.4.2"></script>
	<script language="javascript" type="text/javascript">if(typeof  THEME_URI == 'undefined'){var THEME_URI = '<?php echo get_template_directory_uri(); ?>';}</script>
	<script language="javascript" type="text/javascript" src="<?php echo  get_template_directory_uri() . '/js/backend/mColorPicker/javascripts/mColorPicker.js'?>"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() . '/classes/shortcode/shortcodes/shortcodesUtils.js'?>"></script>
	<script language="javascript" type="text/javascript">
			function init() {
		tinyMCEPopup.resizeToInnerSize();
	}
	function submitData() {				
		var shortcode;
		var selectedContent = tinyMCE.activeEditor.selection.getContent();				
		var button_type = jQuery('#button_type').val();		
		var button_url = jQuery('#button_url').val();
		
		// my adds		
		var button_color = jQuery('#button_color').val();
		var hover_color = jQuery('#button_hover_color').val();
		var text_color = jQuery('#button_text_color').val();
		var text_color_hover = jQuery('#button_text_hover_color').val();
		
		if (jQuery('#button_target').is(':checked')) {
		var button_target = jQuery('#button_target:checked').val();} else {var button_target = '';}			
		shortcode = ' [button type="'+button_type+'" url="'+button_url+'" target="'+button_target+'" button_color_fon="'+button_color+'" hover_color="'+hover_color+'" text_color="'+text_color+'" text_color_hover="'+text_color_hover+'" ]'+selectedContent+'[/button] ';			
			
		if(window.tinyMCE) {
			var id;
			var tmce_ver=window.tinyMCE.majorVersion;
			if(typeof tinyMCE.activeEditor.editorId != 'undefined')
			{
				id =  tinyMCE.activeEditor.editorId;
			}
			else
			{
				id = 'content';
			}
		if (tmce_ver>="4") {
			window.tinyMCE.execCommand('mceInsertContent', false, shortcode);
			} else {
			window.tinyMCE.execInstanceCommand(id, 'mceInsertContent', false, shortcode);
			}

			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
		
		return;
	}
		
		jQuery(document).ready(function() {
			jQuery('#button_color, #button_type').change(function() {
				var type = jQuery("#button_type").val(),
					bgColor = jQuery('#button_color').val(),
					bgColorHover = jQuery('#button_hover_color').val(),
					textColor = jQuery('#button_text_color').val(),
					textColorHover = jQuery('#button_text_hover_color').val(),
					$preview = jQuery('#preview'),


							
					html = "<a class='th_button " + type + "' style='cursor:pointer;'><span>Test button</span></a>";
					
					html += '<style>'+
							'.' + type + '{background-color: ' + bgColor + '; color: ' + textColor + ';}' +  
							'.' + type + ':hover{ color: ' + textColorHover +  ';}'+
							'.' + type + ':hover{ background-color: ' + bgColorHover + ';}'+
							'</style>'

				$preview.html(html);
			});
		});
	</script>

	<style type="text/css">
		/*	Button indent styles: */
		.th_button {
			vertical-align: middle;
			display:inline-block; margin-bottom:4px;
		}
		.btn_small {
			padding: 0 10px; height: 23px;
			text-transform: lowercase;
		}
		.th_button_small {
			vertical-align: middle;
			display:inline-block;
			padding: 0 10px; height: 23px;
			text-transform: lowercase;
		}
		
		.btn_middle {
			padding: 0 14px; height: 34px;
			text-transform: uppercase;
		}
		.btn_large  {
			padding: 0 28px; height: 40px;
			text-transform: uppercase;
		}
		.btn_xlarge  {
			position: relative;
			display: inline-block; overflow: hidden;
			height: 33px;
			text-transform: uppercase;
			-moz-transition: all 0.8s ease-in-out; -webkit-transition: all 0.8s ease-in-out; -o-transition: all 0.8s ease-in-out;
		}
		.btn_xlarge:hover  {	
			-moz-transition: all 0.1s ease-in-out; -webkit-transition: all 0.1s ease-in-out; -o-transition: all 0.1s ease-in-out;
		}
			
			.btn_xlarge span {
				position: relative;	display: block;	padding: 0 15px;
				height: 35px; line-height: 33px; z-index: 2;
			}
			.btn_xlarge b {
				position: absolute; left: 0; top: 0;
				width: 7px; height: 33px;
				z-index: 1;
				-moz-transition: all 0.8s ease; -webkit-transition: all 0.8s ease; -o-transition: all 0.8s ease;
			}
			.btn_xlarge:hover b {
				width:100%;
				-moz-transition: all 0.1s; -webkit-transition: all 0.1s; -o-transition: all 0.1s;
			}
			
		/* Button color styles: */
			
			.btn_small {
				font-size: 11px;
				line-height: 23px;
			}
	
			.th_button_small {
								font-size: 11px;
				line-height: 23px;
			}
			
			.btn_middle {
				font-weight: 500;
				font-size: 14px;
				font-family: 'Open Sans', Arial, serif;
				line-height:34px;
			}
			.btn_large  {
				font-size: 16px;
				font-family: 'Open Sans', Arial, serif;
				line-height: 40px;
			}
			.btn_xlarge {
				box-shadow: 1px 2px 3px 0px rgba(102,102,102, 0.10);
				background: none;
				font-weight: 500;
				font-size: 14px;
				font-family: 'Open Sans', Arial, serif;
				line-height: 33px;
			}
		
	</style>
	<base target="_self" />
	</head>
	<body  onload="init();">
	<form name="button" action="#" >
		<div class="tabs">
			<ul>
				<li id="buttons_tab" class="current"><span><a href="javascript:mcTabs.displayTab('buttons_tab','buttons_panel');" onMouseDown="return false;"><?php _e('Buttons','milano'); ?></a></span></li>
			</ul>
		</div>
		<div class="panel_wrapper">
			<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('Type of button:','milano'); ?></legend>
				<label for="button_type"><?php _e('Choose a type:','milano'); ?></label><br><br>
				<select data-name="type" id="button_type" style="width:250px">
					<option value="" disabled selected><?php _e('Select type','milano'); ?></option>
					<option value="btn_small"><?php _e('small button','milano'); ?></option>
					<option value="btn_middle"><?php _e('middle button black','milano'); ?></option>
					<option value="btn_large"><?php _e('large color button','milano'); ?></option>
<!--					<option value="btn_xlarge"><?php _e('xlarge color button','milano'); ?></option>-->
				</select>					
			</fieldset>
			<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('URL for button:','milano'); ?></legend>
				<label><?php _e('Type your URL here:','milano'); ?></label><br><br>
				<input data-name="url" type="text" id="button_url" style="width:250px">
			</fieldset>
			<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('Link target:','milano'); ?></legend>
				<label><?php _e('Check if you want open in new window:','milano'); ?></label><br><br>
				<input data-name="target" type="checkbox" id="button_target">
			</fieldset>
			<fieldset style="margin-bottom:10px;padding:10px">
				<legend>Change Colors:</legend>
				<label>button background color:</label><br><br>
				<input data-name="button_color_fon" type="color" data-hex="true" id="button_color" style="width:230px" value="#b8bf37"><br/><br/>
				<label>button background color on hover:</label><br><br>
				<input data-name="hover_color" type="color" data-hex="true" id="button_hover_color" style="width:230px" value="#ffffff"><br/><br/>
				<label>button text color:</label><br><br>
				<input data-name="text_color" type="color" data-hex="true" id="button_text_color" style="width:230px" value="#ffffff"><br/><br/>
				<label>button text color on hover:</label><br><br>
				<input data-name="text_color_hover" type="color" data-hex="true" id="button_text_hover_color" style="width:230px" value="#000000"><br/><br/>
			</fieldset>
			<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('Preview:','milano'); ?></legend>
				<div id="preview" style="height:70px"></div>
			</fieldset>
		</div>
		<div class="mceActionPanel">
			<div style="float: right">
				<input type="submit" id="insert" name="insert" value="<?php _e('Insert','milano'); ?>" onClick="submitData(jQuery(this).closest('form'));" />
			</div>
		</div>
	</form>
</body>
</html>