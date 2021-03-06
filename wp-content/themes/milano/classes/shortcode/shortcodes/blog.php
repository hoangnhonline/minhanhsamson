<?php
defined('WP_ADMIN') || define('WP_ADMIN', true);
$_SERVER['PHP_SELF'] = '/wp-admin/index.php';
require_once('../../../../../../wp-load.php');
if (get_option(SHORTNAME . "_customcolor") != '')
{
	$customcolor = get_option(SHORTNAME . "_customcolor");
}
else
{
	$customcolor = "#00a0c6";
}
if (get_option(SHORTNAME . "_gfont") != '')
{
	$gfont = get_option(SHORTNAME . "_gfont");
}
else
{
	$gfont = "Open Sans";
}
?>
<!doctype html>
<html lang="en">
	<head>
		<title>Blog</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<script> var THEME_URI = '<?php echo get_template_directory_uri(); ?>';</script>
		<script language="javascript" type="text/javascript" src="<?php echo home_url() . "/" . WPINC; ?>/js/tinymce/tiny_mce_popup.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo includes_url(); ?>/js/tinymce/utils/mctabs.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo includes_url(); ?>/js/tinymce/utils/form_utils.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo includes_url(); ?>/js/jquery/jquery.js?ver=1.4.2"></script>
		<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/backend/mColorPicker/javascripts/mColorPicker.js' ?>"></script>
		<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() . '/classes/shortcode/shortcodes/shortcodesUtils.js' ?>"></script>
		<script language="javascript" type="text/javascript">
			function init() {

				tinyMCEPopup.resizeToInnerSize();
			}
			function submitData() {
				var shortcode = '';
				var pagination = '';
	//		var selectedContent = tinyMCE.activeEditor.selection.getContent();				
				var blog_category = jQuery('#blog_category').val();
				var perpage = jQuery('#perpage').val();
				var read_more_color = jQuery('#read_more_color').val();
				var read_more_color_on_hover = jQuery('#read_more_color_on_hover').val();
				var date_color = jQuery('#date_color').val();
				var date_color_on_hover = jQuery('#date_color_on_hover').val();

				if (jQuery('#pagination').is(':checked'))
				{
					pagination = jQuery('#pagination:checked').val();
				}

				if (blog_category)
				{
					shortcode = ' [blog category="' + blog_category.join(',') + '" perpage="' + perpage + '" pagination="' + pagination + '" read_more_color="' + read_more_color + '" read_more_color_on_hover="' + read_more_color_on_hover + '" date_color="' + date_color + '" date_color_on_hover="' + date_color_on_hover + '"]';
				}

				if (window.tinyMCE) {
					var id;
					var tmce_ver = window.tinyMCE.majorVersion;
					if (typeof tinyMCE.activeEditor.editorId != 'undefined')
					{
						id = tinyMCE.activeEditor.editorId;
					}
					else
					{
						id = 'content';
					}
					if (tmce_ver >= "4") {
						window.tinyMCE.execCommand('mceInsertContent', false, shortcode);
					} else {
						window.tinyMCE.execInstanceCommand(id, 'mceInsertContent', false, shortcode);
					}

					tinyMCEPopup.editor.execCommand('mceRepaint');
					tinyMCEPopup.close();
				}

				return;
			}
		</script>
		<link href='http://fonts.googleapis.com/css?family=<?php echo str_replace(" ", "+", $gfont); ?>:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
		<base target="_self" />
	</head>
	<body  onload="init();">
		<form name="blog" action="#" >
			<div class="tabs">
				<ul>
					<li id="blog_tab" class="current"><span><a href="javascript:mcTabs.displayTab('blog_tab','blog_panel');" onMouseDown="return false;">Blog</a></span></li>
				</ul>
			</div>
			<div class="panel_wrapper">

				<fieldset style="margin-bottom:10px;padding:10px">
					<legend>Category of blog:</legend>
					<label for="blog_category">Choose a category:</label><br><br>
					<select data-name="blog_category" id="blog_category"  style="width:250px" MULTIPLE SIZE=5>
<?php
$categories = get_categories();
foreach ($categories as $category)
{
	$option = '<option value="' . $category->term_id . '">';
	$option .= $category->cat_name;
	$option .= ' (' . $category->category_count . ')';
	$option .= '</option>';
	echo $option;
}
?>

					</select>					
				</fieldset>

				<fieldset style="margin-bottom:10px;padding:10px">
					<legend>Show per page:</legend>
					<label for="perpage">Number to show:</label><br><br>
					<input data-name="perpage" type="text" id="perpage" style="width:250px">
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend>Pagination:</legend>
					<label for="pagination">Check if you want show pagination:</label><br><br>
					<input data-name="pagination" type="checkbox" id="pagination">
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend>Date color:</legend>
					<input data-name="date_color" type="color" data-hex="true" id="date_color" style="width:230px" value="#b8bf37"><br/><br/>
					<legend>Date color on hover:</legend>
					<input data-name="date_color_on_hover" type="color" data-hex="true" id="date_color_on_hover" style="width:230px" value="#000000"><br/><br/>
					<!--					<legend>Title color:</legend>
										<input data-name="title_color" type="color" data-hex="true" id="title_color" style="width:230px" value="#ffffff"><br/><br/>
										<legend>Title color on hover:</legend>
										<input data-name="title_color_on_hover" type="color" data-hex="true" id="title_color_on_hover" style="width:230px" value="#b8bf37"><br/><br/>-->
					<legend>Read more link color:</legend>
					<input data-name="read_more_color" type="color" data-hex="true" id="read_more_color" style="width:230px" value="#ffffff"><br/><br/>
					<legend>Read more link color on hover:</legend>
					<input data-name="read_more_color_on_hover" type="color" data-hex="true" id="read_more_color_on_hover" style="width:230px" value="#b8bf37"><br/><br/>
				</fieldset>
			</div>
			<div class="mceActionPanel">
				<div style="float: right">
					<input type="submit" id="insert" name="insert" value="Insert" onClick="submitData();" />
				</div>
			</div>
		</form>
	</body>
</html>