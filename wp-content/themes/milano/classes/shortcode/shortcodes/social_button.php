<?php
defined('WP_ADMIN') || define('WP_ADMIN', true);
$_SERVER['PHP_SELF'] = '/wp-admin/index.php';
require_once('../../../../../../wp-load.php');
?>
<!doctype html>
<html lang="en">
	<head>
	<title><?php _e('Insert Share Buttons','milano'); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/jquery/jquery.js?ver=1.4.2"></script>
	<script language="javascript" type="text/javascript">
	function init() {
		
		tinyMCEPopup.resizeToInnerSize();
	}
	function submitData() {				
		var shortcode;
		
		var current_tab = jQuery('div.current');
		switch(current_tab.attr('id'))
		{
			case 'google_panel':
				shortcode = googleShortcode();
				break;
			case 'facebook_panel':
				shortcode = facebookShortcode();
				break;
			case 'twitter_panel':
				shortcode = twitterShortcode();
				break;
			case 'pinterest_panel':
				shortcode = pinterestShortcode();
				break;
			default:
				shortcode ='';
				break;
		}
		
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
	
	function twitterShortcode()
	{
		var url, text, count, size, via, related, shortcode;
		url = jQuery('#t_b_url').val();
		text = jQuery('#t_b_text').val();
		count = jQuery('#t_b_position').val();
		if (jQuery('#t_b_size').is(':checked')) {size = jQuery('#t_b_size:checked').val();} else { size = '';}		
		via = jQuery('#t_b_via').val();
		related = jQuery('#t_b_related').val();
		
		shortcode = '[social_button button="twitter" ';
		
		if(url)
		{
			shortcode += ' turl="'+url+'"';
		}
		if(text)
		{
			shortcode += ' ttext ="'+text+'"';
		}
		if(count)
		{
			shortcode += ' tcount ="'+count+'"';
		}
		if(size)
		{
			shortcode += ' tsize ="'+size+'"';
		}
		if(via)
		{
			shortcode += ' tvia ="'+via+'"';
		}
		if(related)
		{
			shortcode += ' trelated ="'+related+'"';
		}
		shortcode += ']';
		return shortcode;
		
	}
	
	function facebookShortcode()
	{
		var send, url, layout, width, face,action, colorsheme,shortcode;
		url = jQuery('#f_b_url').val();
		
		if (jQuery('#f_b_send').is(':checked')) {send = jQuery('#f_b_send:checked').val();} else { send = '';}			
		
		layout = jQuery('#f_b_layout').val();
		width =  jQuery('#f_b_width').val();
		if (jQuery('#f_b_face').is(':checked')) {face = jQuery('#f_b_face:checked').val();} else { face = '';}			
		action = jQuery('#f_b_verb').val();
		colorsheme = jQuery('#f_b_scheme').val();
		
		shortcode = '[social_button button="facebook"';
		
		if(url)
		{
			shortcode += ' furl="'+url+'"';
		}
		
		if(send)
		{
			shortcode += ' fsend="'+send+'"';
		}
		
		if(layout)
		{
			shortcode += ' flayout="'+layout+'"';
		}
		if(face)
		{
			shortcode += ' fshow_faces="'+face+'"';
		}
		if(width)
		{
			shortcode += ' fwidth="'+parseInt(width,10)+'"';
		}
		if(action)
		{
			shortcode += ' faction="'+action+'"';
		}
		if(colorsheme)
		{
			shortcode += ' fcolorsheme="'+colorsheme+'"';
		}
		shortcode += ']';
		
		return shortcode;
	}
	
	function googleShortcode()
	{
		var size, annatation, html, url, shortcode;
		size = jQuery('#g_b_size').val();
		annatation = jQuery('#g_b_annatation').val();
		if (jQuery('#g_b_html5').is(':checked')) {html = jQuery('#g_b_html5:checked').val();} else { html = '';}			
		url = jQuery('#g_b_url').val();
		
		shortcode = '[social_button button="google"';
		if(size)
		{
			shortcode += ' gsize="'+size+'"';
		}
		if(annatation)
		{
			shortcode += ' gannatation="'+annatation+'"';
		}
		if(html)
		{
			shortcode += ' ghtml5="'+html+'"';
		}
		if(url)
		{
			shortcode += ' gurl="'+url+'"';
		}
			
		shortcode += ']';
		return shortcode;
	}
	
	function pinterestShortcode()
	{
		var shortcode, purl, iurl, count, text;
		purl = jQuery('#p_b_purl').val();
		media = jQuery('#p_b_iurl').val();
		count = jQuery('#p_b_layout').val();
		text = jQuery('#p_b_text').val();
		shortcode = '[social_button button="pinterest"' ;
		if(purl && purl.length)
		{
			shortcode += ' purl="'+purl+'"';
		}
		if(media && media.length)
		{
			shortcode += ' pmedia="'+media+'"';
		}
		if(count && count.length)
		{
			shortcode += ' pcount="'+count+'"';
		}
		if(text && text.length)
		{
			shortcode += ' ptext="'+text+'"';
		}
		
		shortcode += ']';
		
		return shortcode;
	}
	</script>
<!--	Google+-->
<!--	<script type="text/javascript">
	(function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	})();
	</script>-->
	
	
	
	<style type="text/css">
		.panel_wrapper div.current {
			height: 100%;
		}
	</style>
	<base target="_self" />
	</head>
	<body  onload="init();">
	<form name="buttons" action="#" >
		<div class="tabs">
			<ul>
				<li id="google_tab" class="current"><span><a href="javascript:mcTabs.displayTab('google_tab','google_panel');" onMouseDown="return false;">Google+</a></span></li>
				<li id="twitter_tab"><span><a href="javascript:mcTabs.displayTab('twitter_tab','twitter_panel');" onMouseDown="return false;">Twitter</a></span></li>
				<li id="facebook_tab"><span><a href="javascript:mcTabs.displayTab('facebook_tab','facebook_panel');" onMouseDown="return false;">Facebook</a></span></li>
				<li id="pinterest_tab"><span><a href="javascript:mcTabs.displayTab('pinterest_tab','pinterest_panel');" onMouseDown="return false;">Pinterest</a></span></li>
			</ul>
		</div>
		<div class="panel_wrapper">
			<div id="google_panel" class="panel current">
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend><?php _e('Size:','milano'); ?></legend>
					<label for="g_b_size"><?php _e('Choose a size:','milano'); ?></label><br><br>
					<select name="g_b_size" id="g_b_size"  style="width:250px">
						<option value="small"><?php _e('Small (15px)','milano'); ?></option>
						<option value="standard"><?php _e('Standard(24px)','milano'); ?></option> <!-- default  -->
						<option value="medium"><?php _e('Medium(20px)','milano'); ?></option>
						<option value="tall"><?php _e('Tall(60px)','milano'); ?></option>
					</select>					
				</fieldset>
				
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend><?php _e('Type of Annotation:','milano'); ?></legend>
					<label for="g_b_annatation"><?php _e('Choose a Annotation:','milano'); ?></label><br><br>
					<select name="g_b_annatation" id="g_b_annatation"  style="width:250px">
						<option value="inline"><?php _e('Inline','milano'); ?></option>
						<option value="bubble"><?php _e('Bubble','milano'); ?></option>  <!-- default  -->
						<option value="none"><?php _e('None','milano'); ?></option>
					</select>					
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('Advanced options:','milano'); ?></legend>
					<label for="g_b_html5"><?php _e('HTML5 valid syntax:','milano'); ?></label>
					<input name="g_b_html5" type="checkbox" id="g_b_html5"><br><br>	
			
					<label for="g_b_url"><?php _e('URL to +1:','milano'); ?></label><br><br>
					<input name="g_b_url" type="text" id="g_b_url" style="width:250px">
				</fieldset>
			</div>
<!--	 ----------------------------------------------------------------------		-->
			<div id="twitter_panel" class="panel">
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend><?php _e('Count box position:','milano'); ?></legend>
					<label for="t_b_position"><?php _e('Choose a Position:','milano'); ?></label><br><br>
					<select name="t_b_position" id="t_b_position"  style="width:250px">
						<option value="none"><?php _e('None','milano'); ?></option>
						<option value="horizontal"><?php _e('Horizontal','milano'); ?></option>  <!-- default  -->
						<option value="vertical"><?php _e('Vertical','milano'); ?></option>
					</select>					
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend><?php _e('Button size:','milano'); ?></legend>
					<label for="t_b_size"><?php _e('Large:','milano'); ?></label>
					<input name="t_b_size" type="checkbox" id="t_b_size" value="large"><br><br>	
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('URL of the page to share:','milano'); ?></legend>
					<label for="t_b_url"><?php _e('URL(default: URL of the webpage):','milano'); ?></label><br><br>
					<input name="t_b_url" type="text" id="t_b_url" style="width:250px">
				</fieldset>
				
				<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('Recommended accounts:','milano'); ?></legend>
					<label for="t_b_related">@</label>
					<input name="t_b_related" type="text" id="t_b_related" style="width:236px"><br><br>
				</fieldset>
				
				<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('Via user:','milano'); ?></legend>
					<label for="t_b_via">@</label>
					<input name="t_b_via" type="text" id="t_b_via" style="width:236px">
				</fieldset>
				
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend><?php _e('Default Tweet text:','milano'); ?></legend>
				<label for="t_b_text"><?php _e('Text:','milano'); ?></label><br>
					<textarea name="t_b_text" type="text" id="t_b_text" style="width:250px"></textarea>
				</fieldset>
				
				
			</div>
<!--	 -----------------------------URL to -----------------------------------------		-->
			<div id="facebook_panel" class="panel">
				<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('URL to Like:','milano'); ?></legend>
					<label for="f_b_url"><?php _e('URL:','milano'); ?></label><br><br>
					<input name="f_b_url" type="text" id="f_b_url" style="width:250px">
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('Send Button:','milano'); ?></legend>
					<label for="f_b_send"><?php _e('Send Button:','milano'); ?></label>
					<input name="f_b_send" type="checkbox" id="f_b_send"><br><br>	
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend><?php _e('Layout Style:','milano'); ?></legend>
					<label for="f_b_layout"><?php _e('Choose a Layout:','milano'); ?></label><br><br>
					<select name="f_b_layout" id="f_b_layout"  style="width:250px">
						<option value="standard"><?php _e('Standard','milano'); ?></option>
						<option value="button_count"><?php _e('Button Count','milano'); ?></option>  <!-- default  -->
						<option value="box_count"><?php _e('Box Count','milano'); ?></option>
					</select>					
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('Width:','milano'); ?></legend>
					<label for="f_b_width"><?php _e('Width:','milano'); ?></label><br><br>
					<input name="f_b_width" type="text" id="f_b_width" style="width:250px" value="450">
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('Show profile picture:','milano'); ?></legend>
					<label for="f_b_face"><?php _e('Show Faces:','milano'); ?></label>
					<input name="f_b_face" type="checkbox" id="f_b_face"><br><br>	
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend><?php _e('Verb to display','milano'); ?></legend>
					<label for="f_b_verb"><?php _e('Choose a Verb:','milano'); ?></label><br><br>
					<select name="f_b_verb" id="f_b_verb"  style="width:250px">
						<option value="like"><?php _e('Like','milano'); ?></option>
						<option value="recommend"><?php _e('Recommend','milano'); ?></option>  <!-- default  -->
					</select>					
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend><?php _e('Color Scheme ','milano'); ?></legend>
					<label for="f_b_scheme"><?php _e('Choose a Scheme:','milano'); ?></label><br><br>
					<select name="f_b_scheme" id="f_b_scheme"  style="width:250px">
						<option value="light"><?php _e('Light','milano'); ?></option>
						<option value="dark"><?php _e('Dark','milano'); ?></option>  <!-- default  -->
					</select>					
				</fieldset>
			</div>
			<div id="pinterest_panel" class="panel">
				<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('Page the pin is on:','milano'); ?></legend>
					<label for="p_b_purl"><?php _e('URL:','milano'); ?></label><br><br>
					<input name="p_b_purl" type="text" id="p_b_purl" style="width:250px">
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('Image to be pinned:','milano'); ?></legend>
					<label for="p_b_iurl"><?php _e('URL:','milano'); ?></label><br><br>
					<input name="p_b_iurl" type="text" id="p_b_iurl" style="width:250px">
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend><?php _e('Pin Count:','milano'); ?></legend>
					<label for="p_b_layout"><?php _e('Choose a Layout:','milano'); ?></label><br><br>
					<select name="p_b_layout" id="p_b_layout"  style="width:250px">
						<option value="horizontal"><?php _e('Horizontal','milano'); ?></option>
						<option value="vertical "><?php _e('Vertical','milano'); ?></option>
						<option value="none"><?php _e('No Count','milano'); ?></option>
					</select>					
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend><?php _e("What they're pinning:","milano"); ?></legend>
					<label for="p_b_text"><?php _e('Text:','milano'); ?></label><br>
					<textarea name="p_b_text" type="text" id="p_b_text" style="width:250px"></textarea>
				</fieldset>
			</div>
		</div>
		<div class="mceActionPanel">
			<div style="float: right">
				<input type="submit" id="insert" name="insert" value="<?php _e('Insert','milano'); ?>" onClick="submitData();" />
			</div>
		</div>
	</form>
</body>
</html>