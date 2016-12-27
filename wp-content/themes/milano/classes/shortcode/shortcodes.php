<?php 
define('SHORTCODE_URL', get_template_directory_uri().'/classes/shortcode/');
add_filter('mce_external_plugins', "th_ed_register");
add_filter('mce_buttons_3', 'th_ed_add_buttons', 0);
add_filter('widget_text', 'do_shortcode');

locate_template( array('/classes/shortcode/contact-form.php'), true, true	);

if ( ! function_exists( 'th_ed_add_buttons' ) ) {
	function th_ed_add_buttons($buttons)
	{
		array_push($buttons, "highlight", "list", "th_table", "notifications", 
				"buttons", "divider", "toggle", "tabs", "contactForm",
				'testimonial', 'social_link', 'social_button', 'columns', 'blog');
		
		if (get_post_type() == 'page') {
			array_push($buttons, "portfolio");
		}
		
		return $buttons;
	}
}

if ( ! function_exists( 'th_ed_register' ) ) {
	function th_ed_register($plugin_array)
	{
		$url = get_template_directory_uri() . "/classes/shortcode/shortcodes.js";

		$plugin_array["th_buttons"] = $url;
		return $plugin_array;
	}
}

if ( ! function_exists( 'th_cleanup_shortcodes' ) ) {
	function th_cleanup_shortcodes($content)
	{
		$array = array(
			'<p>[' => '[',
			']</p>' => ']',
			']<br />' => ']'
		);

		$content = strtr($content, $array);
		return $content;
	}
}
add_filter('the_content', 'th_cleanup_shortcodes');


//Columns
if ( ! function_exists( 'col_one_half' ) ) {
	function col_one_half($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'last' => ''
						), $atts));
		$out = "<div class='one_half " . $last . "' >" . do_shortcode($content) . "</div>";
		return $out;
	}
}
add_shortcode('one_half', 'col_one_half');

if ( ! function_exists( 'col_one_third' ) ) {
	 function col_one_third($atts, $content = null)
	{
		extract(shortcode_atts(array(
								'last' => ''
								), $atts));
		$out = "<div class='one_third " . $last . "' >" . do_shortcode($content) . "</div>";
		return $out;
	}
}
add_shortcode('one_third', 'col_one_third');

if ( ! function_exists( 'col_one_fourth' ) ) {
	function col_one_fourth($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'last' => ''
						), $atts));
		$out = "<div class='one_fourth " . $last . "'>" . do_shortcode($content) . "</div>";
		return $out;
	}
}
add_shortcode('one_fourth', 'col_one_fourth');

if ( ! function_exists( 'col_two_third' ) ) {
	function col_two_third($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'last' => ''
						), $atts));
		$out = "<div class='two_third " . $last . "'>" . do_shortcode($content) . "</div>";
		return $out;
	}
}
add_shortcode('two_third', 'col_two_third');

if ( ! function_exists( 'col_three_fourth' ) ) {
	function col_three_fourth($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'last' => ''
						), $atts));
		$out = "<div class='three_fourth " . $last . "'>" . do_shortcode($content) . "</div>";
		return $out;
	}
}
add_shortcode('three_fourth', 'col_three_fourth');

if ( ! function_exists( 'col_clear' ) ) {
	function col_clear($atts, $content = null)
	{
		return "<div class='clearfix'></div>";
	}
}
add_shortcode('clear', 'col_clear');

///Highlight
if ( ! function_exists( 'highlight' ) ) {
	function highlight($atts, $content = null)
	{
		extract(shortcode_atts(array(
						), $atts));

		$out = "<span class='hdark' >" . do_shortcode($content) . "</span>";

		return $out;
	}
}
add_shortcode('highlight', 'highlight');

///Buttons
if ( ! function_exists( 'button' ) ) {
	function button($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'type' => '',
			'url' => '',
			'button_color_fon' => '',
			'hover_color' => '',
			'text_color' => '',
			'text_color_hover' => '',
			'target' => ''
		), $atts));
		
		$target = ($target != '') ? "target='_blank'" : '';
		$id = rand(0, 3000);

		$out = "<a id='btn_" . $id . "' class='" . $type . " '  href='" . $url . "' " . $target . "><span>" . do_shortcode($content) . "</span></a>";

		$out .= '<style>
			#btn_' . $id . '{ background-color: ' . $button_color_fon . '; color: ' . $text_color . ';}
			#btn_' . $id . ':hover{ color: ' . $text_color_hover . ';}
			#btn_' . $id . ':after{ background-color: ' . $hover_color . ';}
		</style>';

		return $out;
	}
}

add_shortcode('button', 'button');

if ( ! function_exists( 'testimonial' ) ) {
	function testimonial($atts, $content = null) {
		extract(shortcode_atts(array(
			'category' => 'all',
			'time' => '10',
			'randomize' => 'off',
		), $atts));
		
		$query	= "post_type=".Custom_Posts_Type_Testimonial::POST_TYPE."&post_status=publish&posts_per_page=-1&order=DESC";
		if($category != 'all')
		{
			$query .="&".Custom_Posts_Type_Testimonial::TAXONOMY."=".$category;
		}
		$testimonials = new WP_Query($query);
		$slides = array();
		while($testimonials->have_posts()) : $testimonials->the_post();
			$slides[] = '<div class="testimonial">
							<div class="quote">' . get_the_content() . '</div>
							<div class="testimonial_meta">
								<div class="testimonial_author">' . get_post_meta(get_the_ID(), SHORTNAME.'_testimonial_author', true) . '</div>
								<div>' . get_post_meta(get_the_ID(), SHORTNAME.'_testimonial_author_job', true) . '</div>
							</div>
						</div>';
		endwhile;
		wp_reset_query();
		$rnd = rand(0, 2000);
		$out = '<div class="testimonials" id="testimonials_' . $rnd . '">'.
					((count($slides) > 1) ? '<div class="controls">
						<a class="prev" href="#">&nbsp;</a>
						<a class="next" href="#">&nbsp;</a>
					</div>' : '').
				'</div>';
		FrontWidgets::getInstance()->add(array(
			'type' => 'Slider',
			'id' => 'shortcode_testimonials',
			'options' => array(
				'selector' => '#testimonials_'.$rnd,
				'next' => '',
				'prev' => '',
				'slideTime' => $time * 1000,
				'autoplay' => true,
				'dinamicHeight' => true,
				'random' => $randomize == 'on'
			),
			'data' => $slides
		));

		return $out;
	}
}

add_shortcode('testimonial', 'testimonial');

function portfolio($atts, $content = null){
	extract(shortcode_atts(array(
		'portfolio_cat' => '',
		'columns' => 3,
		'isotope' => '',
		'perpage' => 12,
		'pagination' => '',
		'filder_color' => '#bbbbbb',
		'filder_color_active' => '#b8bf37',
		'title_bg' => '#130d07',
		'title_color' => '#ffffff',
		'accent' => '#b8bf37',
		'maxwidth' => 500
	), $atts));
	

	
	$portfolioID = rand(0, 3000);

	$portfolio_terms = get_terms(Custom_Posts_Type_Portfolio::TAXONOMY, array(    'hide_empty' => 0,    'fields' => 'ids') );
	$portfolio_cat = $portfolio_cat ? explode(',', $portfolio_cat) : $portfolio_terms;


	
	$permalink_structure = get_option('permalink_structure');
	if (empty($permalink_structure)) {
		$format = is_front_page() ? '?paged=%#%' : '&paged=%#%';
	} else {
		$format = 'page/%#%/';
	}
	$perpage = $isotope ? -1 : $perpage;
	$data = getPortfolioList($portfolio_cat, get_the_ID(), $perpage, false, 'portfolio_thumbnail');

	
	FrontWidgets::getInstance()->add(array(
		'type' => 'Grid',
		'id' => 'portfolio',
		'options' => array(
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'selector' => '#' . SHORTNAME . '_portfolio_' . $portfolioID,
			'ajaxLoadImages' => true,
			'filterable' => $isotope == 'on',
			'maxWidth' => $maxwidth,
			'columns' => ($columns < 5) ? $columns : 4
		),
		'data' => $data['list']
	));

	$html = '<div class="clearfix portfolio_cols cols_num_'.$columns.'" id="' . SHORTNAME . '_portfolio_' . $portfolioID . '" style="width: 100%;margin: 0;">';
	if($isotope) {
		$html .= '<ul class="portfolio_categories"><li><a href="#" class="active">'.__('All','milano').'</a></li>';
				
		foreach($portfolio_cat as $termId){ 
			$term = get_term_by('id', $termId, Custom_Posts_Type_Portfolio::TAXONOMY);
			$parent = $term->term_id;
			$args = array(
				'taxonomy'     => Custom_Posts_Type_Portfolio::TAXONOMY,
				'child_of'      => $parent,
				'title_li'     => '',
				'show_option_none' 		=> '',
				'hierarchical'       => false,
				'hide_empty' => 1
			);

			ob_start();
			wp_list_categories( $args );
			$html .= ob_get_clean();
		}

		$html .= '</ul>';
	}
	$html .= '</div>';
	
	$html .= '<style>
				#' . SHORTNAME . '_portfolio_' . $portfolioID .' .portfolio_categories li a{color: '.$filder_color.'!important;}
				#' . SHORTNAME . '_portfolio_' . $portfolioID .' .portfolio_categories li a.active, .portfolio_categories li a:hover{color: '.$filder_color_active.'!important;}
				#' . SHORTNAME . '_portfolio_' . $portfolioID .' .carousel_list2>li .port_title{ background-color: '. $title_bg .'; color: '. $title_color .'}
				#' . SHORTNAME . '_portfolio_' . $portfolioID .' .carousel_list2>li .port_title:before{ background-color: '. $accent .'}
			</style>';

	if($pagination && !$isotope) {
		$current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if ($data['total'] > 1) {
			$html .= '<div class="pagination clearfix">';
			// structure of вЂњformatвЂќ depends on whether weвЂ™re using pretty permalinks
			$permalink_structure = get_option('permalink_structure');

			if (empty($permalink_structure)) {
				$format = is_front_page() ? '?paged=%#%' : '&paged=%#%';
			} else {
				$format = 'page/%#%/';
			}

			$html .= paginate_links(array(
				'base'		=> get_pagenum_link(1) . '%_%',
				'format'	=> $format,
				'current'	=> $current_page,
				'total'		=> $data['total'],
				'mid_size'	=> 10,
				'type'		=> 'list'
			));
			$html .= '</div>';
		}
	}
	
	return $html;
}

add_shortcode('portfolio', 'portfolio');

if ( ! function_exists( 'contactForm' ) ) {
	function contactForm($atts, $content = null)
	{
		return '';
	}
}
add_shortcode('contactForm', 'contactForm');

///Notifications
if ( ! function_exists( 'notification' ) ) {
	function notification($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'type' => '',
						), $atts));

		$out = "<div class='th_notification " . $type . "' >" . do_shortcode($content) . "</div>";

		return $out;
	}
}

add_shortcode('notification', 'notification');

//Toggles
if ( ! function_exists( 'toggle_shortcode' ) ) {
	function toggle_shortcode($atts, $content = null)
	{
		wp_enqueue_script('jquery-ui-core');
		extract(shortcode_atts(array('title' => '', 'color' => '#b8bf37', 'open' => false), $atts));
		return '<div class="toggle">
					<h4 class="trigger hendlToggle ' . ($open ? 'active' : '') . '">
						<span class="t_ico" style="background-color: ' . $color . '"></span>
						<a href="#">' . $title . '</a>
					</h4>
					<div class="toggle_container" style="display: ' . ($open ? 'block' : 'none') . ';">' . do_shortcode($content) . '</div>
					<script>
					jQuery(document).ready(function(){
						jQuery("h4.hendlToggle").removeClass("hendlToggle").on("click", function() {
							jQuery(this).toggleClass("active").next().slideToggle("normal");
							return false;
						});
					});
				</script>
				</div>';
	}
}
add_shortcode('toggle', 'toggle_shortcode');

///Tabs

if ( ! function_exists( 'jquery_tab_group' ) ) {
	function jquery_tab_group($atts, $content)
	{
		wp_enqueue_script('jquery-ui-tabs');

		extract(shortcode_atts(array(
			'type' => ''
						), $atts));

		$GLOBALS['tab_count'] = 0;

		do_shortcode($content);

		if (is_array($GLOBALS['tabs']))
		{
			$int = '1';
			foreach ($GLOBALS['tabs'] as $tab)
			{
				$tabs[] = '

  <li><a href="#tabs-' . $int . '">' . $tab['title'] . '</a></li>

';
				$panes[] = '
<div id="tabs-' . $int . '">
' . $tab['content'] . '

</div>
';
				$int++;
			}
			$return = "\n" . '
<div class="tabgroup ' . $type . '" data-script="jquery-ui-core,jquery-ui-widget,jquery-ui-tabs">
<ul class="tabs">' . implode("\n", $tabs) . '</ul>
' . "\n" . ' ' . implode("\n", $panes) . '

</div><script>jQuery(document).ready(function(){
	jQuery(".tabgroup").tabs().show();
});</script>
' . "\n";
		}
		return $return;
	}
}
add_shortcode('tabgroup', 'jquery_tab_group');



if ( ! function_exists( 'jquery_tab' ) ) {
	function jquery_tab($atts, $content)
	{
		extract(shortcode_atts(array(
			'title' => 'Tab %d'
						), $atts));

		$x = $GLOBALS['tab_count'];
		$GLOBALS['tabs'][$x] = array('title' => sprintf($title, $GLOBALS['tab_count']), 'content' => do_shortcode($content));

		$GLOBALS['tab_count']++;
	}
}
add_shortcode('tab', 'jquery_tab');
///
if ( ! function_exists( 'refresh_mce' ) ) {
	function refresh_mce($ver)
	{
		$ver += 3;
		return $ver;
	}
}
add_filter('tiny_mce_version', 'refresh_mce');

if ( ! function_exists( 'html_editor' ) ) {
	function html_editor()
	{

		if (basename($_SERVER['SCRIPT_FILENAME']) == 'post-new.php' || basename($_SERVER['SCRIPT_FILENAME']) == 'post.php')
		{

			echo "<style type='text/css'>#ed_toolbar input#one_half, #ed_toolbar input#one_third, #ed_toolbar input#one_fourth, #ed_toolbar input#two_third, #ed_toolbar input#one_half_last, #ed_toolbar input#one_third_last, #ed_toolbar input#one_fourth_last, #ed_toolbar input#two_third_last, #ed_toolbar input#clear {font-weight:700;color:#2EA2C8;text-shadow:1px 1px white}
#ed_toolbar input#one_half_last, #ed_toolbar input#one_third_last, #ed_toolbar input#one_fourth_last, #ed_toolbar input#two_third_last, #ed_toolbar input#three_fourth, #ed_toolbar input#three+fourth_last {color:#888;text-shadow:1px 1px white}
#ed_toolbar input#raw {color:red;text-shadow:1px 1px white;font-weight:700;}</style>";
		}
	}
}
add_action('admin_head', 'html_editor');

if ( ! function_exists( 'custom_quicktags' ) ) {
	function custom_quicktags()
	{
		if (basename($_SERVER['SCRIPT_FILENAME']) == 'post-new.php' || basename($_SERVER['SCRIPT_FILENAME']) == 'post.php')
		{
			wp_enqueue_script('custom_quicktags', get_template_directory_uri() . '/classes/shortcode/shortcodes/quicktags.js', array('quicktags'), '1.0.0');
		}
	}
}
add_action('admin_print_scripts', 'custom_quicktags');



if ( ! function_exists( 'th_social_link' ) ) {
	function th_social_link($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'url' => '#',
			'type' => '',
			'target' => '',
						), $atts));

		if ($target)
		{
			$target = 'target="_blank"';
		}
		/**
		 * @todo add  correct classes
		 */
		return '<a class="social_links ' . $type . '" href="' . $url . '" ' . $target . '><span>' . $type . '</span></a>';
	}
}
add_shortcode('social_link', 'th_social_link');

/**
 * Insert social buttons(google+, facebook, twitter)
 */
if ( ! function_exists( 'th_social_button' ) ) {
	function th_social_button($atts, $content = null)
	{
		$default_values = array(
			'button' => '',
			'gurl' => in_the_loop() ? get_permalink() : '', // google
			'gsize' => '',
			'gannatation' => '',
			'ghtml5' => '',
			'turl' => in_the_loop() ? get_permalink() : '', //twitter
			'ttext' => in_the_loop() ? get_the_title() : '',
			'tcount' => '',
			'tsize' => '',
			'tvia' => '',
			'trelated' => '',
			'furl' => in_the_loop() ? get_permalink() : '', //facebook
			'flayout' => '',
			'fsend' => '',
			'fshow_faces' => '',
			'fwidth' => 450,
			'faction' => '',
			'fcolorsheme' => '',
			'purl' => in_the_loop() ? get_permalink() : '', // pinterest
			'pmedia' => wp_get_attachment_url(get_post_thumbnail_id()),
			'ptext' => in_the_loop() ? get_the_title() : '',
			'pcount' => '',
		);

		$shortcode_html = $shortcode_js = '';
		extract(shortcode_atts($default_values, $atts));

		switch ($button)
		{
			/**
			 * insert google+ button
			 */
			case 'google':
				$shortcode_js = "<script type='text/javascript'>(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true; po.src = 'https://apis.google.com/js/plusone.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();</script>";
				if ($ghtml5)
				{
					$shortcode_html = sprintf('<div class="g-plusone" data-size="%s" data-annotation="%s" data-href="%s"></div>', $gsize, $gannatation, $gurl);
				}
				else
				{
					$shortcode_html = sprintf('<g:plusone size="%s" annotation="%s" href="%url"></g:plusone>', $gsize, $gannatation, $gurl);
				}
				break;
			/**
			 * Insert Twitter follow button
			 */
			case 'twitter':
				$shortcode_js = '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
				$template = '<a href="https://twitter.com/share" class="twitter-share-button"  data-url="%s"	data-text="%s" data-count="%s" data-size="%s" data-via="%s" data-related="%s" data-lang="">Tweet</a>';
				$shortcode_html = sprintf($template, $turl, $ttext, $tcount, $tsize, $tvia, $trelated);
				break;
			/**
			 * Insert facebook button.
			 */
			case 'facebook':
				$shortcode_js = <<<JS
					<div id="fb-root"></div>
				  <script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
					fjs.parentNode.insertBefore(js, fjs);
				  }(document, 'script', 'facebook-jssdk'));</script>
JS;
				$template = <<<HTML
				<div class="fb-like" data-href="%s" data-send="%s" data-layout="%s" data-width="%d" data-show-faces="%s" data-action="%s" data-colorscheme="%s"></div>
HTML;
				$shortcode_html = sprintf($template, $furl, ($fsend) ? 'true' : 'false', $flayout, $fwidth, ($fshow_faces) ? 'true' : 'false', $faction, $fcolorsheme
				);
				break;
			case 'pinterest':
				$query_params = $template = '';
				$filtered_params = array();

				$params = array('url' => $purl,
					'media' => $pmedia,
					'description' => $ptext);

				$filtered_params = array_filter($params);


				$query_params = http_build_query($filtered_params);

				if (strlen($query_params))
				{
					$query_params = '?' . $query_params;
				}

				$template = '<a href="http://pinterest.com/pin/create/button/%s" class="pin-it-button" count-layout="%s"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>';

				$shortcode_html = sprintf($template, $query_params, $pcount);
				$shortcode_js = '<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>';

				break;
		}
		return $shortcode_html . $shortcode_js;
	}
}
add_shortcode('social_button', 'th_social_button');


if ( ! function_exists( 'th_audio' ) ) {
	function th_audio($atts, $title = null)
	{
		if (!isset($GLOBALS['audio_iterator']))
		{
			$GLOBALS['audio_iterator'] = 1;
		}

		extract(shortcode_atts(array(
			'href' => '',
			'hide_title' => '',
						), $atts));

		if (filter_var($href, FILTER_VALIDATE_URL))
		{
			wp_enqueue_script('jplayer');

			switch (pathinfo($href, PATHINFO_EXTENSION))
			{
				case 'mp3':  //mp3
					$media = "{mp3: '$href'}";
					$supplied = 'supplied: "mp3",';
					break;
				case 'm4a':  //mp4
					$media = "{m4a: '$href'}";
					$supplied = 'supplied: "m4a, mp3",';
					break;
				case 'ogg': //ogg
					$media = "{oga: '$href'}";
					$supplied = 'supplied: "oga, ogg, mp3",';
					break;
				case 'oga': //oga
					$media = "{oga: '$href'}";
					$supplied = 'supplied: "oga, ogg, mp3",';
					break;
				case 'webma': //webma
					$media = "{webma: '$href'}";
					$supplied = 'supplied: "webma, mp3",';
					break;
				case 'webm': //webma
					$media = "{webma: '$href'}";
					$supplied = 'supplied: "webma, mp3",';
					break;
				case 'wav':
					$media = "{wav: '$href'}";
					$supplied = 'supplied: "wav, mp3",';
					break;
				default:
					// not supporteg audio format
					return;
					break;
			}


			$html = <<<HTML
			<div id="jquery_jplayer_{$GLOBALS['audio_iterator']}" class="jp-jplayer"></div>
			<div id="jp_container_{$GLOBALS['audio_iterator']}" class="jp-audio">
            <div class="jp-type-single"><div class="jp-control"><a href="javascript:;" class="jp-play" tabindex="1">play</a><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></div> <div class="jp-gui jp-interface"><div class="jp-progress"><div class="jp-seek-bar"><div class="jp-play-bar"></div></div></div><div class="jp-volume"><div class="jp-volume-bar"><div class="jp-volume-bar-value"></div></div></div>
                </div>
HTML;
			if (!$hide_title)
			{
				$html .= <<<HTML
                <div class="jp-title"><strong>{$title}</strong> -  <span class="jp-current-time"></span> / <span class="jp-duration"></span></div>
HTML;
			}
			$uri = get_template_directory_uri();
			$html .= <<<HTML
                <div class="jp-no-solution"><span>Update Required</span>To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.</div></div></div>
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				jQuery.jPlayer.timeFormat.showHour = true;
				jQuery("#jquery_jplayer_{$GLOBALS['audio_iterator']}").jPlayer({
					ready: function(event) {
						jQuery(this).jPlayer("setMedia", {$media});
					},
					play: function() {
						core.dispatcher.fire('play-content-media');
						jQuery(this).jPlayer("pauseOthers");
					},
					pause: function() {
						core.dispatcher.fire('pause-content-media');
					},
					swfPath: "{$uri}/swf",
					solution: "html, flash",
					preload: "metadata",
					wmode: "window",
					{$supplied}
					cssSelectorAncestor: '#jp_container_{$GLOBALS['audio_iterator']}'
				});
			});
		</script>
HTML;
			$GLOBALS['audio_iterator'] = $GLOBALS['audio_iterator'] + 1;
			return $html;
		}
	}
}
add_shortcode('thaudio', 'th_audio');

//List

if ( ! function_exists( 'th_list' ) ) {
	function th_list($atts, $content = null)
	{

		extract(shortcode_atts(array(
			'color' => '#b8bf37',
			'list_type' => 'th_list_simple'
						), $atts));

		$content = str_replace('<ul>', '<ul class="th_list '.$list_type.'">', do_shortcode($content));
		$content = str_replace('<li>', '<li> <span style="background:' . $color . '"></span>', do_shortcode($content));
		return $content;
	}
}
add_shortcode('th_list', 'th_list');
//Table
if ( ! function_exists( 'th_table' ) ) {
	function th_table($atts, $content = null)
	{
		$content = str_replace('<table>', '<table class="th_table">', do_shortcode($content));
		return $content;
	}
}
add_shortcode('th_table', 'th_table');


// Blog
if ( ! function_exists( 'blog_shortcode' ) ) {
	function blog_shortcode($atts, $content = null)
	{
		$out = '';
		// get the current page
		if (is_front_page()) {
			$current_page = (get_query_var('page')) ? get_query_var('page') : 1;
		} else {
			$current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}

		extract(shortcode_atts(array(
					'category' => '',
					'perpage' => '1',
					'pagination' => '',
					'read_more_color' => '#ffffff',
					'read_more_color_on_hover' => '#b8bf37',
					'date_color' => '#b8bf37',
					'date_color_on_hover' => '#000000'
						), $atts));

		$args = array('posts_per_page'	=> $perpage,
			'post_status'		=> 'publish',
			'cat'				=> $category,
			'post_type'			=> 'post',
			'paged'				=> $current_page,
			'ignore_sticky_posts' => true,
			'order'				=> 'DESC',
		);
		$post_list = new WP_Query($args);
		$layout = get_post_meta(get_the_ID(), SHORTNAME . '_page_layout', true);

		ob_start();
		if ($post_list && $post_list->have_posts()) : 
			while ($post_list->have_posts()) : $post_list->the_post();
				global $more;
				$more = 0;
				$thumbnail = get_the_post_thumbnail(get_the_ID(), 'listing_thumbnail_' . $layout );
				$listClass = $thumbnail ? 'with_thumb' : 'without_thumb';
				?>
					<li class="wrapper <?php echo $listClass;?>">
						<?php if($thumbnail){?>
							<figure class="post_img">
								<a href="<?php the_permalink()?>"><?php echo $thumbnail; ?></a>
							</figure>
						<?php }?>
						<div class="post">
							<div class="f_left postmetadata">
								<div class="inner reg">
									<strong><?php echo get_the_date('d');?></strong>
									<?php echo get_the_date('M');?>
								</div>
								<div class="postdata_rollover">
									<div class="inner reg">
										<strong><?php echo get_the_date('d');?></strong>
										<?php echo get_the_date('M');?>
									</div>
								</div>
							</div>
							<div class="wrapper post_content">
								<h3 class="title6"><a href="<?php the_permalink()?>"><?php the_title();?></a></h3>
								<p class="p2">								
									<?php if (get_option(SHORTNAME . "_excerpt")) { 
										the_content(__('Read more &rarr;','milano')); 
									} else { 
										$readMoreText = ( get_post_meta(get_the_ID(), SHORTNAME.'_read_more_text', true) != '') 
														? get_post_meta(get_the_ID(), SHORTNAME.'_read_more_text', true)
														: get_option(SHORTNAME . "_blog_read_more_text");
										echo get_excerpt(300, $readMoreText); 
									}?>
									<style>
										.solid_box .blog_box .more-link{
											color: <?php echo $read_more_color; ?>;
										}
										.solid_box .blog_box .more-link:hover{
											color: <?php echo $read_more_color_on_hover; ?>;
										}
										.solid_box .blog_box .postmetadata>.inner{
											background-color: <?php echo $date_color; ?>;
										}
										.solid_box .blog_box .posts_list li:hover .postdata_rollover{
											background-color: <?php echo $date_color_on_hover; ?>;
										}
									</style>
								</p> 
							</div>
						</div>
					</li>
				<?php endwhile;?>


			<?php
			$total = $post_list->max_num_pages;
			if ($pagination && $total > 1) {?>
				<div class="pagination clearfix">
					<?php
					// structure of вЂњformatвЂќ depends on whether weвЂ™re using pretty permalinks
					$permalink_structure = get_option('permalink_structure');
					if (empty($permalink_structure))
					{
						if (is_front_page())
						{
							$format = '?paged=%#%';
						}
						else
						{
							$format = '&paged=%#%';
						}
					}
					else
					{
						$format = 'page/%#%/';
					}

					echo paginate_links(array(
						'base'		=> get_pagenum_link(1) . '%_%',
						'format'	=> $format,
						'current'	=> $current_page,
						'total'		=> $total,
						'mid_size'	=> 10,
						'type'		=> 'list',
						'prev_text'    => __('&larr; Previous','milano'),
						'next_text'    => __('Next &rarr;','milano')
					));?>
				</div><?php
			}
		endif;
		$out = ob_get_clean();

		wp_reset_postdata();

		return $out;
	}
}
add_shortcode('blog', 'blog_shortcode');


?>