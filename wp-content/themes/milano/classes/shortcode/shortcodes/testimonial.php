<?php
defined('WP_ADMIN') || define('WP_ADMIN', true);
$_SERVER['PHP_SELF'] = '/wp-admin/index.php';
require_once('../../../../../../wp-load.php');
?>
<!doctype html>
<html lang="en">
	<head>
	<title>Insert Testimonial</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="<?php echo  home_url()."/".WPINC;   ?>/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo  home_url()."/".WPINC;   ?>/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo  home_url()."/".WPINC;   ?>/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo  home_url()."/".WPINC;   ?>/js/jquery/jquery.js?ver=1.4.2"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() . '/classes/shortcode/shortcodes/shortcodesUtils.js'?>"></script>
	<base target="_self" />
	</head>
	<body  onload="init();">
	<form name="testimonial" action="#" >
		<div class="tabs">
			<ul>
				<li id="testimonial_tab" class="current"><span><a href="javascript:mcTabs.displayTab('testimonial_tab','testimonial_panel');" onMouseDown="return false;">Testimonial</a></span></li>
			</ul>
		</div>
		<div class="panel_wrapper">
<!--			<fieldset style="margin-bottom:10px;padding:10px">
				<legend><?php _e('Testimonials options:','milano'); ?></legend>
				<label for="testimonial_title"><?php _e('Testimonials title:','milano'); ?></label>
				<br><br>
				<input type="text" data-name="title" value="Testimonials" style="width:250px" />
				<label for="testimonial_cat"><?php _e('Category of testimonials:','milano'); ?></label>
				<br><br>
				<select data-name="category" id="category"  style="width:250px">
					<option value="all"><?php _e('All','milano'); ?></option>
					<?php 
					if($categories = get_terms(Custom_Posts_Type_Testimonial::TAXONOMY, array('taxonomy' => Custom_Posts_Type_Testimonial::TAXONOMY)) )
					{
						foreach($categories as $category)
						{?>
							<option value="<?php echo esc_html($category->slug)?>"><?php echo esc_html($category->name); ?></option>
						<?php }
						}
					?>
				</select>
				<label for="time"><?php _e('Number of second to show:','milano'); ?></label>
				<br><br>
				<input type="text" data-name="time" value="10" style="width:250px" />
			</fieldset>-->


			<fieldset style="margin-bottom:10px;padding:10px">
				<legend>Testimonial Category:</legend>
				<label for="category">Choose testimonial category:</label><br><br>
				<select data-name="category" id="category"  style="width:250px">
					<option value="all">All</option>
					<?php 
					if($categories = get_terms(Custom_Posts_Type_Testimonial::TAXONOMY, array('taxonomy' => Custom_Posts_Type_Testimonial::TAXONOMY)) )
					{
						foreach($categories as $category)
						{?>
							<option value="<?php echo esc_html($category->slug)?>"><?php echo esc_html($category->name); ?></option>
						<?php }
						}
					?>
				</select>					
			</fieldset>
			<fieldset style="margin-bottom:10px;padding:10px">
				<legend>Number of second to show:</legend>
					<label for="time">Second:</label><br><br>
					<input data-name="time" type="text" id="time" style="width:250px" value="10">
			</fieldset>			
			<fieldset style="margin-bottom:10px;padding:10px">
				<legend>Randomize testimonial:</legend>
				<label for="randomize">Randomize:</label>
					<input data-name="randomize" type="checkbox" id="randomize">
			</fieldset>
<!--			<fieldset style="margin-bottom:10px;padding:10px">
				<legend>Transition effect:</legend>
				<label for="effect">Choose effect:</label><br><br>
				<select data-name="effect" id="effect"  style="width:250px">
					<option value="fade" selected="selected">fade</option>
					<option value="slide">slide</option>
				</select>					
			</fieldset>-->
			</div>
		<div class="mceActionPanel">
			<div style="float: right">
				<input type="submit" id="insert" name="insert" value="Insert" onClick="submitData(jQuery(this).closest('form'));" />
			</div>
		</div>
	</form>
</body>
</html>