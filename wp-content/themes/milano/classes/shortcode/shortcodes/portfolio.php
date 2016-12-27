<?php	
defined('WP_ADMIN') || define('WP_ADMIN', true);
$_SERVER['PHP_SELF'] = '/wp-admin/index.php';
require_once('../../../../../../wp-load.php');

?>
<!doctype html>
<html lang="en">
	<head>
		<title><?php _e('Portfolio','milano'); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/tiny_mce_popup.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/utils/mctabs.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/utils/form_utils.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script language="javascript" type="text/javascript">if(typeof  THEME_URI == 'undefined'){var THEME_URI = '<?php echo get_template_directory_uri(); ?>';}</script>
		<script language="javascript" type="text/javascript" src="<?php echo  get_template_directory_uri() . '/js/backend/mColorPicker/javascripts/mColorPicker.js'?>"></script>
		<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() . '/classes/shortcode/shortcodes/shortcodesUtils.js'?>"></script>


		<base target="_self" />
	</head>
	<body>
		<form name="portfolio" action="#" >
			<div class="tabs">
				<ul>
					<li id="portfolio_tab" class="current"><span><a href="javascript:mcTabs.displayTab('portfolio_tab','portfolio_panel');" onMouseDown="return false;"><?php _e('Portfolio','milano'); ?></a></span></li>
				</ul>
			</div>
			<div class="panel_wrapper">
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend><?php _e('Portfolio category:','milano'); ?></legend>
					<label for="button_type"><?php _e('Choose a category:','milano'); ?></label><br><br>
					<?php th_dropdown_categories(array(
						'taxonomy'		=> 'th_portfolio_cat',
						'id'			=> 'shortcode_portfolio_cat',
						'data_name'		=> 'portfolio_cat',
						'hierarchical'	=> true,

					));?>
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend><?php _e('columns:','milano'); ?></legend>
					<label><?php _e('count:','milano'); ?></label>

					<select data-name="columns" id="columns_count">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3" selected="selected">3</option>
						<option value="4">4</option>
					</select>
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
				<legend>Filterable portfolios:</legend>
					<label for="isotope">Check if you want use filterable portfolios:</label><br><br>
					<input data-name="isotope" type="checkbox" id="isotope"><br/>
					<label for="pagination">Filter link color:</label><br><br>
					<input data-name="filder_color" type="color" data-hex="true" value="#bbbbbb" id="filder_color"><br/>
					<label for="pagination">Filter active link color:</label><br><br>
					<input data-name="filder_color_active" type="color" data-hex="true" value="#b8bf37" id="filder_color_active"><br/>
					<label for="pagination">Title background color:</label><br><br>
					<input data-name="title_bg" type="color" data-hex="true" value="#130d07" id="title_bg"><br/>
					<label for="pagination">Title color:</label><br><br>
					<input data-name="title_color" type="color" data-hex="true" value="#ffffff" id="title_color"><br/>
					<label for="pagination">Accent color:</label><br><br>
					<input data-name="accent" type="color" data-hex="true" value="#b8bf37" id="accent"><br/>
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
				<legend>Show per page:</legend>
					<label for="perpage">Number to show:(only if filters are off)</label><br><br>
					<input data-name="perpage" type="text" id="perpage" style="width:250px">
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
				<legend>Pagination:</legend>
					<label for="pagination">Check if you want show pagination:(only if filters are off)</label><br><br>
					<input data-name="pagination" type="checkbox" id="pagination">
				</fieldset>
				<fieldset style="margin-bottom:10px;padding:10px">
					<legend>Max width</legend>
					<label for="maxwidth">Max width</label><br><br>
					<input data-name="maxwidth" type="text" id="maxwidth" value="500">
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