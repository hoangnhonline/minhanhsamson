</section>
<footer class="<?php echo (get_option(SHORTNAME . "_footer_fixed")) ? 'p_fix' : 'p_rel' ?>" id="footer">
	<div class="p_abs slideshow_settings">
		<?php if (get_option(SHORTNAME . "_bg_slider_show_preloader") === '1')
		{
			?>
			<div class="preloader"></div>
			<?php
		}
		if (is_single() && get_post_type() == 'post' && !get_option(SHORTNAME . "_back_to_blog_disable"))
		{
			$blog_url = (get_option('show_on_front') == 'page') ? get_permalink(get_option('page_for_posts')) : get_bloginfo('url', 'display');
			?>
			<a href="<?php echo $blog_url; ?>" class="p_abs d_block nav_btn show_thumb"></a>
<?php } ?>

	</div>
	<div class="p_rel inner">
		<?php
		ob_start();
		wp_nav_menu(array(
			'theme_location' => 'footer-menu',
			'container_class' => 'f_menu',
			'menu_class' => 'footer_menu wrapper',
			'fallback_cb' => '',
			'container' => 'nav',
			'link_before' => '',
			'link_after' => ''
		));
		$footer_menu = ob_get_contents();
		ob_end_clean();

		if ($footer_menu)
		{
			echo '<ul class="footer_left">
							<li class="d_in-block">
								' . $footer_menu . '	
							</li>
						</ul>';
		}
		?>
		<ul class="footer_right">
			<li class="footer_content">
				<?php
				$footerText = do_shortcode(get_option(SHORTNAME . "_footer_tinymce"));
				$copyText = th_copyright((is_singular() ? get_the_ID() : null));
				?>
				<?php
				if ($footerText)
				{
					echo '<span class="d_in-block footer_text"> ' . $footerText . ' </span>';
				}
				if ($copyText)
				{
					echo '<span class="d_in-block privacy">' . $copyText . '</span>';
				}
				if (!get_option(SHORTNAME . "_sound_disable"))
				{
					?>
					<span class="sound_icon music_on"></span>
<?php } ?>
			</li>
		</ul>

	</div>
<?php wp_footer(); ?>
</footer>		
<script type="text/javascript">
	jQuery(function () {
		core.init(<?php echo FrontWidgets::getInstance()->getJson(); ?>, {
			'themePath': '<?php echo get_template_directory_uri(); ?>',
			'origin': '<?php echo 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST']; ?>',
			'prefix': '<?php echo SHORTNAME; ?>',
			'preloaderColor': '<?php echo get_option(SHORTNAME . "_bg_slideshow_preloader_color"); ?>',
			'disableSound': <?php echo get_option(SHORTNAME . "_sound_disable") ? 'true' : 'false'; ?>,
			'menu_opened': <?php
global $menu;
echo (get_option(SHORTNAME . '_left_menu_opened') && $menu) ? 'true' : 'false';
?>
		});
	});
</script>
<?php echo get_option(SHORTNAME . "_GA") ?>	
<?php
if (!get_option(SHORTNAME . "_gfontdisable"))
{
	$gfont = $families = array();

	$gfont[] = get_option(SHORTNAME . '_gfont_title');
	$gfont[] = get_option(SHORTNAME . '_logo_gfont');


	foreach ($gfont as $font)
	{
		$font = Admin_Theme_Element_Select_Gfont::compatibility($font);
		$families[] = $font[0]['family'];
	}
	?>

	<link href="//fonts.googleapis.com/css?family=<?php echo Admin_Theme_Element_Select_Gfont::font_queue($gfont); ?>" rel="stylesheet" type="text/css">
	<script>		
			WebFont.load({
				google: {
					families: <?php echo json_encode(array_unique($families)) ?>
				},
				active: function () {
					var width = 0;
					jQuery('.middle_menu li').each(function () {
						width += jQuery(this).width();

					});
					jQuery('.middle_menu').width(width + 2);
				}
			});		
	</script>
<?php } ?>
</div>

<div id="sound"></div>
<canvas id="circleC" width="100" height="100" style="z-index:1000;"></canvas>		
</body>
</html>