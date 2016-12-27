<?php
defined('WP_ADMIN') || define('WP_ADMIN', true);
$_SERVER['PHP_SELF'] = '/wp-admin/index.php';
require_once('../../../../../../wp-load.php');
if( get_option(SHORTNAME."_linkscolor")) { $customcolor = get_option(SHORTNAME."_linkscolor"); } else {$customcolor = "#c62b02"; }
?>
<!doctype html>
<html lang="en">
	<head>
	<title><?php _e('Insert Social Link','milano'); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url(); ?>/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url();?>/js/tinymce/utils/form_utils.js"></script>
<!--	<script language="javascript" type="text/javascript" src="<?php echo includes_url(); ?>/js/jquery/jquery.js?ver=1.4.2"></script>-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() . '/classes/shortcode/shortcodes/shortcodesUtils.js'?>"></script>
	<script language="javascript" type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#button_type").change(function() {
				var type = jQuery(this).val();
				jQuery("#preview").html(type ? "<a class='social_links "+type+"' style='cursor:pointer'><span> </span></a>"  : "");
			});
		});
	</script>
		<?php
		/**
		 * @todo add  correct classes
		 */
		?>
	<style>
		.social_links{
			display: inline-block;
			width: 26px;
			height: 26px;
			overflow: hidden;
			position: relative;
			background-position: 50% 50%;
			background-repeat: no-repeat;
		}
		.social_links:hover{
			background-color: #b8bf37;
		}
		.social_links:after{
			display: block;
			position: absolute;
			left: 0;
			top: 0;
			z-index: -1;
			right: 0;
			bottom: 0;
			background: #000;
			opacity: 0.6;
			content: "";
		}

		.social_links:after{
			display: block;
			position: absolute;
			left: 0;
			top: 0;
			z-index: -1;
			right: 0;
			bottom: 0;
			background: #000;
			opacity: 0.6;
			content: "";
		}
		.social_links.rss_feed{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/rss_b.png");
		}
		.social_links.rss_feed:hover{
			background-color: #ffb400;
		}

		.social_links.facebook_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/facebook_b.png");
		}
		.social_links.facebook_account:hover{
			background-color: #3b5998;
		}

		.social_links.twitter_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/twitter_b.png");
		}
		.social_links.twitter_account:hover{
			background-color: #00c3f4;
		}

		.social_links.dribble_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/dribble_b.png");
		}
		.social_links.dribble_account:hover{
			background-color: #f977a6;
		}

		.social_links.email_to{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/email_to_b.png");
		}
		.social_links.email_to:hover{
			background-color: #a8c000;
		}

		.social_links.google_plus_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/google_p_b.png");
		}
		.social_links.google_plus_account:hover{
			background-color: #4b8df7;
		}

		.social_links.flicker_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/flickr_b.png");
		}
		.social_links.flicker_account:hover{
			background-color: #ff0084;
		}

		.social_links.vimeo_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/vimeo_b.png");
		}
		.social_links.vimeo_account:hover{
			background-color: #1ab7ea;
		}

		.social_links.linkedin_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/linkedin_b.png");
		}
		.social_links.linkedin_account:hover{
			background-color: #4b8df7;	
		}

		.social_links.youtube_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/youtube_b.png");
		}
		.social_links.youtube_account:hover{
			background-color: #b72d28;
		}

		.social_links.pinterest_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/pinterest_b.png");
		}
		.social_links.pinterest_account:hover{
			background-color: #cb2027;
		}

		.social_links.picasa_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/picasa_b.png");
		}
		.social_links.picasa_account:hover{
			background-color: #4b8df8;
		}

		.social_links.digg_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/digg_b.png");
		}
		.social_links.digg_account:hover{
			background-color: #1b5891;
		}

		.social_links.plurk_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/plurk_b.png");
		}
		.social_links.plurk_account:hover{
			background-color: #cf682f;
		}

		.social_links.tripadvisor_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/tripadvisor_b.png");
		}
		.social_links.tripadvisor_account:hover{
			background-color: #589642;
		}

		.social_links.yahoo_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/yahoo_b.png");
		}
		.social_links.yahoo_account:hover{
			background-color: #ab64bc;
		}

		.social_links.delicious_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/delicious_b.png");
		}
		.social_links.delicious_account:hover{
			background-color: #004795;
		}

		.social_links.devianart_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/devianart_b.png");
		}
		.social_links.devianart_account:hover{
			background-color: #54675a;
		}

		.social_links.tumblr_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/tumblr_b.png");
		}
		.social_links.tumblr_account:hover{
			background-color: #34526f;
		}

		.social_links.skype_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/skype_b.png");
		}
		.social_links.skype_account:hover{
			background-color: #33bff3;
		}

		.social_links.apple_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/apple_b.png");
		}
		.social_links.apple_account:hover{
			background-color: #4c4c4c;
		}

		.social_links.aim_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/aim_b.png");
		}
		.social_links.aim_account:hover{
			background-color: #ffb400;
		}

		.social_links.paypal_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/paypal_b.png");
		}
		.social_links.paypal_account:hover{
			background-color: #0079c1;
		}

		.social_links.blogger_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/blogger_b.png");
		}
		.social_links.blogger_account:hover{
			background-color: #ff6403;
		}

		.social_links.behance_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/behance_b.png");
		}
		.social_links.behance_account:hover{
			background-color: #1769ff;
		}

		.social_links.myspace_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/myspace_b.png");
		}
		.social_links.myspace_account:hover{
			background-color: #003399;	
		}

		.social_links.stumble_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/stumble_b.png");
		}
		.social_links.stumble_account:hover{
			background-color: #cc492b;
		}

		.social_links.forrst_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/forrst_b.png");
		}
		.social_links.forrst_account:hover{
			background-color: #176023;
		}

		.social_links.imdb_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/imdb_b.png");
		}
		.social_links.imdb_account:hover{
			background-color: #f4c118;
		}

		.social_links.instagram_account{
			background-image: url("<?php echo  get_template_directory_uri()?>/images/instagram_b.png");
		}
		.social_links.instagram_account:hover{
			background-color: #99654d;
		}
	</style>
	<base target="_self" />
	</head>
	<body  onload="init();">
	<form name="social_link" action="#" >
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
					<option value="rss_feed">RSS</option>
					<option value="facebook_account">Facebook</option>
					<option value="twitter_account">Twitter</option>
					<option value="dribble_account">Dribbble</option>
					<option value="email_to">Email to</option>
					<option value="google_plus_account">Google+</option>
					<option value="flicker_account">Flickr</option>
					<option value="vimeo_account">Vimeo</option>
					<option value="linkedin_account">LinkedIn</option>
					<option value="youtube_account">Youtube</option>
					<option value="pinterest_account">Pinterest</option>
					<option value="picasa_account">Picasa</option>
					<option value="digg_account">Digg</option>
					<option value="plurk_account">Plurk</option>
					<option value="tripadvisor_account">TripAdvisor</option>
					<option value="yahoo_account">Yahoo!</option>
					<option value="delicious_account">Delicious</option>
					<option value="devianart_account">deviantART</option>
					<option value="tumblr_account">Tumblr</option>
					<option value="skype_account">Skype</option>
					<option value="apple_account">Apple</option>
					<option value="aim_account">AIM</option>
					<option value="paypal_account">PayPal</option>
					<option value="blogger_account">Blogger</option>
					<option value="behance_account">Behance</option>
					<option value="myspace_account">Myspace</option>
					<option value="stumble_account">Stumble</option>
					<option value="forrst_account">Forrst</option>
					<option value="imdb_account">IMDb</option>
					<option value="instagram_account">Instagram</option>
				</select>					
			</fieldset>

			<fieldset style="margin-bottom:10px;padding:10px">
			<legend><?php _e('URL for button:','milano'); ?></legend>
				<label for="button_url"><?php _e('Type your URL here:','milano'); ?></label><br><br>
				<input data-name="url" type="text" style="width:250px">
			</fieldset>
			<fieldset style="margin-bottom:10px;padding:10px">
			<legend><?php _e('Link target:','milano'); ?></legend>
				<label for="button_target"><?php _e('Check if you want open in new window1:','milano'); ?></label><br><br>
				<input data-name="target" type="checkbox">
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