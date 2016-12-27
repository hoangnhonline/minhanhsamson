<?php
/**
 * @package WordPress
 * @subpackage Milano_Theme
 */

set_error_handler("error_handler", E_NOTICE);

function error_handler($errno, $errstr) {
    return;
}

define('SHORTNAME', 'ml');   // Required!!
define('THEMENAME', 'Milano'); // Required!!


defined('CLASS_DIR_PATH') || define('CLASS_DIR_PATH', get_template_directory() . '/classes/'); // Path to classes folder in Theme

spl_autoload_register('wp_auto_loader');


// Load metabox
locate_template(array('classes/metaboxes.php'), true, true);
// Load admin options
locate_template(array('classes/setup.php'), true, true);
locate_template(array('wpml-integration.php'), true, true);
locate_template(array('customize.php'), true, true);

locate_template(array('classes/shortcode/shortcodes.php'), true, true);


function wp_auto_loader($class)
{

	$theme_class_path = CLASS_DIR_PATH . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
	if (!class_exists($class))
	{
		if (file_exists($theme_class_path) && is_readable($theme_class_path))
		{
			include_once($theme_class_path);
			return true;
		}
		
	}
	return false;
}

//theme update check
$envato_username = get_option(SHORTNAME."_envato_nick");
$envato_api = get_option(SHORTNAME."_envato_api");

if($envato_username && $envato_api)
{
	Envato_Theme_Updater::init($envato_username,$envato_api,'themoholics');
}

if ( ! function_exists( 'th_register_scripts' ) ) {
	function th_register_scripts()
	{
		$filename = 'sprite.js';

		wp_register_script('youtube_api', '//www.youtube.com/iframe_api', null, null, true);		
		wp_register_script('font_loader', '//ajax.googleapis.com/ajax/libs/webfont/1.5.0/webfont.js', null, null, true);		
		
		wp_register_script('sprite_scripts', get_template_directory_uri() . '/js/' . $filename, array('jquery'), null, true);
		wp_enqueue_script('sprite_scripts');
		if (!get_option(SHORTNAME . "_gfontdisable")) {
			wp_enqueue_script('font_loader');
		}
		
		$ajax_data = array(
			'AJAX_URL' => admin_url('admin-ajax.php'),
		);

		wp_localize_script('sprite_scripts', 'ThemeData', $ajax_data);
		
		global $is_IE;
	
		
		if ($is_IE) {
						wp_register_script('html5', get_template_directory_uri() . '/js/ie/html5.js', array('jquery'), null, false);			
						wp_enqueue_script('html5');			
		}
		
	}
}
add_action('init', 'th_register_scripts');



// CUSTOMIZE ADMIN MENU ORDER
if ( ! function_exists( 'custom_menu_order' ) ) {
	function custom_menu_order($menu_ord)
	{
		if (!$menu_ord)
		{
			return true;
		}
		return array(
			'index.php',
			'separator1',
			'edit.php',
			'upload.php',
			'edit.php?post_type=page',
			'edit-comments.php',
			'edit.php?post_type=' . Custom_Posts_Type_Testimonial::POST_TYPE,
			'edit.php?post_type=' . Custom_Posts_Type_Portfolio::POST_TYPE,
			'edit.php?post_type=' . Custom_Posts_Type_Slideshow::POST_TYPE,
			'separator2',
			SHORTNAME . '_general',
			'separator-last'
		);
	}
}

add_filter('custom_menu_order', 'custom_menu_order');
add_filter('menu_order', 'custom_menu_order');


// Print styles
if ( ! function_exists( 'th_add_styles' ) ) {
	function th_add_styles()
	{
		if (!is_admin())
		{
			wp_enqueue_style('normalize', get_template_directory_uri() . '/css/normalize.css', '', null, 'all');
			wp_enqueue_style('main', get_template_directory_uri() . '/css/main.css', '', null, 'all');
			if (!get_option(SHORTNAME . "_responsive"))
			{
				wp_enqueue_style('media.querias', get_template_directory_uri() . '/css/media.queries.css', '', null, 'all');
			}
			global $wp_styles;
			wp_enqueue_style('ie8', get_template_directory_uri() . '/css/ie.css', '', null, 'all');
			$wp_styles->add_data( 'ie8', 'conditional', 'lt IE 9' );

			$custom_stylesheet = new Custom_CSS_Style();
			$custom_stylesheet->run();
			
			wp_enqueue_style('default', get_stylesheet_directory_uri() . '/style.css', '', null, 'all');
		}
	}
}

add_action('wp_print_styles', 'th_add_styles');

// Custom menus
add_theme_support('menus');
add_theme_support('widgets');

if (!isset($content_width)) {$content_width = 912;}

//
load_theme_textdomain('milano', get_template_directory());

//

add_theme_support('automatic-feed-links');

/**
 * Register all theme widgets
 */
add_action('widgets_init', array('Widget', 'run'));


/**
 * adding custom page type
 */
$testimonial = new Custom_Posts_Type_Testimonial();
$testimonial->run();
$portfolio = new Custom_Posts_Type_Portfolio();
$portfolio->run();
$slideshow = new Custom_Posts_Type_Slideshow();
$slideshow->run();


// Sidebars
register_sidebar(array(
	'id' => 'default-sidebar',
	'description' => __('The default sidebar!', 'milano'),
	'name' => 'Default sidebar',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h5 class="title5 widget-title">',
	'after_title' => '</h5>',
));

// custom sidebars
$sbg = new Sidebar_Generator;

if ( ! function_exists( 'th_register_menus' ) ) {
	function th_register_menus()
	{
		register_nav_menus(
				array(
					'main-menu' => __('Main Menu', 'milano'),
					'footer-menu' => __('Footer Menu', 'milano'),
				)
		);
	}
}
add_action('init', 'th_register_menus');

wpml_register_string('milano', 'copyright', stripslashes(get_option(SHORTNAME . "_copyright")));
wpml_register_string('milano', 'copyright', stripslashes(get_option(SHORTNAME . "_header_tinymce")));
wpml_register_string('milano', 'copyright', stripslashes(get_option(SHORTNAME . "_blog_read_more_text")));
wpml_register_string('milano', 'copyright', stripslashes(get_option(SHORTNAME . "_portfolio_read_more_text")));
wpml_register_string('milano', 'copyright', stripslashes(get_option(SHORTNAME . "_footer_tinymce")));



if ( ! function_exists( 'th_copyright' ) ) {
	function th_copyright($post_id = null)
	{

		$current_copyright = get_option(SHORTNAME . '_copyright_text');
		if ($post_id && !is_null($post_id))
		{
			if (htmlentities($current_copyright, ENT_NOQUOTES, 'UTF-8', false) == htmlentities(Admin_Theme_Item_Footer::DEFAULT_COPYRIGHT, ENT_NOQUOTES, 'UTF-8', false))
			{
				if ($post_copyright = get_post_meta($post_id, SHORTNAME . '_custom_copyright', true))
				{
					$current_copyright = $post_copyright;
				}
			}
		}

		return wpml_t('milano', 'copyright', stripslashes($current_copyright));
	}
}
//get term meta field
if (!function_exists('get_tax_meta')) {
	function get_tax_meta($term_id, $key, $multi = false) {
		$t_id = (is_object($term_id)) ? $term_id->term_id : $term_id;
		$m = get_option('tax_meta_' . $t_id);
		return (isset($m[$key])) ? $m[$key] : '';
	}
}

if (!function_exists('update_tax_meta')) {
	function update_tax_meta($term_id, $key, $value, $multi = false) {
		$t_id = (is_object($term_id)) ? $term_id->term_id : $term_id;
		$m = get_option('tax_meta_' . $t_id);
		$m[$key] = $value;
		update_option('tax_meta_' . $t_id, $m);
	}
}
/**
 * Check is value exist and not "#"
 * @param string $value
 * @return boolean
 */
if ( ! function_exists( 'th_empty_color' ) ) {
	function th_empty_color($value)
	{
		return !$value || $value == '#';
	}
}


add_theme_support('post-thumbnails');
add_image_size('listing_thumbnail_one-third', 573, 193, true);
add_image_size('listing_thumbnail_half', 891, 300, true);
add_image_size('listing_thumbnail_fullwidth', 1781, 600, true);
add_image_size('carousel_thumbnail', (get_option(SHORTNAME . "_blog_carousel_w"))?get_option(SHORTNAME . "_blog_carousel_w"):300, (get_option(SHORTNAME . "_blog_carousel_w"))?get_option(SHORTNAME . "_blog_carousel_h"):400, true);
add_image_size('slideshow_thumbnail', 240, 200, true);
add_image_size('recent_posts', 122, 122, true);

if ( ! function_exists( 'get_excerpt' ) ) {
	function get_excerpt($num, $readMoreText = null, $hideReadMore = false, $hardReadMore = false) {
		$readMoreText = ($readMoreText) ? $readMoreText :  __('Read more &rarr;', 'milano');
		$limit = $num + 1;
		$original_excerpt = get_the_excerpt();

		$cleaned = $text = preg_replace('|\[(.+?)\](.+?\[/\\1\])?|s', '', $original_excerpt);
		$excerpt = mb_substr($cleaned, 0, $limit);

		if(!$hideReadMore){
			$excerpt .= '...<br/><br/><a href="'.get_permalink().'" class="more_info more-link link1">' . $readMoreText . '</a>';
		}

		return $excerpt;
	}
}

if ( ! function_exists( 'ml_obfuscate_email' ) ) {
	function ml_obfuscate_email($emails)
	{
		$pattern = '/(.+)@(.+)/';
		$list = explode(',', $emails);
		$reverted_list = array();
		foreach ($list as $email)
		{
			preg_match($pattern, $email, $matches);
			if (isset($matches[1]) && isset($matches[2]))
			{
				$reverted_list[] = strrev($matches[1]) . '@' . strrev($matches[2]);
			}
		}

		return implode(',', $reverted_list);
	}
}

add_action('wp_ajax_send_contact_form', 'th_ajax_send_contact_form');
add_action('wp_ajax_nopriv_send_contact_form', 'th_ajax_send_contact_form');

if ( ! function_exists( 'th_ajax_send_contact_form' ) ) {
	function th_ajax_send_contact_form() {
		require_once CLASS_DIR_PATH . 'shortcode/contactForm/contactsend.php';
		die();
	}
}

add_action('wp_ajax_portfolio_thumbnail', 'th_ajax_portfolio_thumbnail');
add_action('wp_ajax_nopriv_portfolio_thumbnail', 'th_ajax_portfolio_thumbnail');

if ( ! function_exists( 'th_ajax_portfolio_thumbnail' ) ) {
	function th_ajax_portfolio_thumbnail() {
		echo Custom_Thumbnail_Post::getInstance()->getThumbnail($_GET['post_id'], $_GET['page_id'], $_GET['width'], $_GET['height']);
	}
}

// uglehack to catch save taxonomy event
if(isset($_POST['taxonomy']) && $_POST['taxonomy'] == 'th_portfolio_cat') {
	
	
	if(isset($_POST['tag_ID'])) {
		update_tax_meta($_POST['tag_ID'], '_portfolio_thumb_changed', 'on');
	}
}

add_action( 'save_post', 'set_hidden_options', 99);

if ( ! function_exists( 'set_hidden_options' ) ) {
	function set_hidden_options($id) {
		update_post_meta($id, '_portfolio_thumb_changed', 'on');
	}
}

if ( ! function_exists( 'th_dropdown_categories' ) ) {
	function th_dropdown_categories($args = '')
	{
		$defaults = array(
			'show_option_all' => '', 'show_option_none' => '',
			'orderby' => 'id', 'order' => 'ASC',
			'show_count' => 0,
			'hide_empty' => 1, 'child_of' => 0,
			'exclude' => '', 'echo' => 1,
			'selected' => array(0), 'hierarchical' => 0,
			'namet' => 'cat', 'id' => '',
			'data_name' => '',
			'class' => 'taxonomy_multiselect', 'depth' => 0,
			'tab_index' => 0, 'taxonomy' => 'category',
			'hide_if_empty' => false,
			'is_multiple' => false,
			'multiple_size' => 6
		);

		if (isset($args['namet']) && $args['namet'])
		{
			$args['namet'] = $args['namet'] . '[]';
		}

		if (isset($args['selected']))
		{
			if (is_array($args['selected']))
			{
				$defaults['selected'] = $args['selected'];
			}
			elseif (is_string($args['selected']))
			{
				$defaults['selected'] = explode(',', $args['selected']);
			}
			elseif (is_integer($args['selected']))
			{
				$defaults['selected'] = array($args['selected']);
			}
			else
			{
				$defaults['selected'] = array();
			}
		}

		if (isset($args['is_multiple']) && $args['is_multiple'])
		{
			$multiple = 'multiple="multiple"';
			if (isset($args['multiple_size']))
			{
				$multiple .= ' size="' . $args['multiple_size'] . '"';
			}
			else
			{
				$multiple .= ' size="' . $defaults['multiple_size'] . '" ';
			}
		}
		else
		{
			$multiple = '';
		}

		// Back compat.
		if (isset($args['type']) && 'link' == $args['type'])
		{
			_deprecated_argument(__FUNCTION__, '3.0', '');
			$args['taxonomy'] = 'link_category';
		}

		$r = wp_parse_args($args, $defaults);
		if ($r['selected'] === '')
		{
			$r['selected'] = array();
		}

		if (!isset($r['pad_counts']) && $r['show_count'] && $r['hierarchical'])
		{
			$r['pad_counts'] = true;
		}

		extract($r);

		$tab_index_attribute = '';
		if ((int) $tab_index > 0)
			$tab_index_attribute = " tabindex=\"$tab_index\"";

		$categories = get_terms($taxonomy, $r);
		$namet = esc_attr($namet);
		$class = esc_attr($class);
		$data_name = esc_attr($data_name);
		$id = $id ? esc_attr($id) : $namet;

		if (!$r['hide_if_empty'] || !empty($categories))
			$output = "<select data-name='$data_name' name='$namet' id='$id' class='$class' $tab_index_attribute $multiple>\n";
		else
			$output = '';

		if (empty($categories) && !$r['hide_if_empty'] && !empty($show_option_none))
		{
			$show_option_none = apply_filters('list_cats', $show_option_none);
			$output .= "\t<option value='-1' selected='selected'>$show_option_none</option>\n";
		}

		if (!empty($categories))
		{

			if ($show_option_all)
			{
				$show_option_all = apply_filters('list_cats', $show_option_all);
				$selected = ( in_array(0, $r['selected'])  ) ? " selected='selected'" : '';
				$output .= "\t<option value='0'$selected>$show_option_all</option>\n";
			}

			if ($show_option_none)
			{
				$show_option_none = apply_filters('list_cats', $show_option_none);
				$selected = ( in_array(-1, $r['selected']) ) ? " selected='selected'" : '';
				$output .= "\t<option value='-1'$selected>$show_option_none</option>\n";
			}

			if ($hierarchical)
				$depth = $r['depth'];  // Walk the full depth.
			else
				$depth = -1; // Flat.

			$r['walker'] = new Walker_Category_Multiselect();
			$output .= walk_category_dropdown_tree($categories, $depth, $r);
		}

		if (!$r['hide_if_empty'] || !empty($categories))
			$output .= "</select>\n";

		$output = apply_filters('wp_dropdown_cats', $output);

		if ($echo)
			echo $output;

		return $output;
	}
}

if ( ! function_exists( 'get_theme_post_thumbnail' ) ) {
	function get_theme_post_thumbnail($id, $size = 'thumbnail')
	{
		global $theme_images_size;
		if ($theme_images_size instanceof Custom_Thumbnail)
		{
			$theme_images_size->getThumbnail($id, $size);
		}
		else
		{
			return get_the_post_thumbnail(null, $size);
		}
	}
}

if ( ! function_exists( 'getPortfolioList' ) ) {
	function getPortfolioList($terms, $pageId = 0, $perPage = -1, $ajaxLoadImages = false, $thumb = false) {
		
		$args = array(
			'post_status' => 'publish',
			'post_type' => Custom_Posts_Type_Portfolio::POST_TYPE,
			'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1,
			'posts_per_page' => $perPage,
			'ignore_sticky_posts' => true,
			'order' => 'DESC',
			'tax_query' => array(array(
					'taxonomy' => Custom_Posts_Type_Portfolio::TAXONOMY,
					'field' => is_array($terms) ? 'id' : 'slug',
					'terms' => $terms,
					'include_children' => true
			))
		);

		$catNums = array($terms);			
		$carousel_list = new WP_Query($args);
		$total = $carousel_list->max_num_pages;
		$data = array();
		$css = '';
		if ($carousel_list && $carousel_list->have_posts()) :
			$i = 0;
			while ($carousel_list->have_posts()) : $carousel_list->the_post();
				$post_id = get_the_ID();
				$categories = '';
				$terms = wp_get_post_terms($post_id, Custom_Posts_Type_Portfolio::TAXONOMY);
				foreach($terms as $term){
					$categories .= ' cat-item-'. $term->term_id.' ';
				}
				$thumbnail = $thumb 
						? get_theme_post_thumbnail($post_id, $thumb) 
						: (!$ajaxLoadImages ? Custom_Thumbnail_Post::getInstance()->getThumbnail($post_id, $pageId) : '');

				
				$retina = Custom_Thumbnail_Multi::get_the_post_thumbnail_src(get_post_type($post_id), 'retina', $post_id);
				$retina = $retina ? '<img src="' . $retina . '"/>' : false;

				$data[] = array(
					'post_id' => $post_id,
					'page_id' => $pageId,
					'thumbnail' => $thumbnail,
					'categories' => $categories,
					'retina' => $retina,
					'original' => wp_get_attachment_url(get_post_thumbnail_id()),
					'title' => get_the_title(),
					'blank' => get_post_meta($post_id, SHORTNAME . '_custom_url_blank', true),
					'url' => (get_post_meta($post_id, SHORTNAME . '_custom_url', true))?get_post_meta($post_id, SHORTNAME . '_custom_url', true) :esc_url_raw(add_query_arg(array('cats' => implode(',', $catNums[0])), get_permalink()))
				);
				$css .= '.carousel #elem_' . $i . ' .title .inner{ background-color:' . get_post_meta($post_id, SHORTNAME . '_background_color', true) . ';
										color: ' . get_post_meta($post_id, SHORTNAME . '_title_color', true) . ';
										opacity: ' . get_post_meta($post_id, SHORTNAME . '_opacity', true) . '}
				.carousel #elem_' . $i . ':hover{ background-color:' . get_post_meta($post_id, SHORTNAME . '_background_color_on_hover', true) . '; }
				.carousel #elem_' . $i . ' .title.rollover .inner{ color:' . get_post_meta($post_id, SHORTNAME . '_title_color_on_hover', true) . ';
												display: ' . ((get_post_meta($post_id, SHORTNAME . '_hide_title', true) == 'on') ? 'none' : 'block') . '}';
				$i++;
			endwhile;
		endif; 
		wp_reset_query(); 
		return array('list'=>$data, 'css'=>$css, 'total'=>$total);
	}
}

if ( ! function_exists( 'theme_post_thumbnail' ) ) {
	function theme_post_thumbnail($size = 'thumbnail')
	{
		global $theme_images_size;
		if ($theme_images_size instanceof Custom_Thumbnail)
		{
			$theme_images_size->getThumbnail(null, $size);
		}
		else
		{
			the_post_thumbnail($size);
		}
	}
}

if ( ! function_exists( 'add_theme_favicon' ) ) {
	function add_theme_favicon()
	{
		if (get_option(SHORTNAME . "_favicon")) { ?>
				<link rel="shortcut icon" href="<?php echo get_option(SHORTNAME . "_favicon"); ?>" /><?php
		}
	}
}
add_action('wp_head', 'add_theme_favicon');

if ( ! function_exists( 'th_the_content' ) ) {
	function th_the_content($content)
	{
		/**
		 * @see http://wordpress.stackexchange.com/questions/9667/get-wordpress-post-content-by-post-id
		 */
		$content = wpautop($content);
		$content = do_shortcode($content);
		$content = str_replace(']]>', ']]&gt;', $content);
		return $content;
	}
}

/**
 * Do flush_rewrite_rules if slug of custom post type was changed.
 */
if ( ! function_exists( 'th_flush_rewrite_rules' ) ) {
	function th_flush_rewrite_rules()
	{
		if (get_option(SHORTNAME . '_need_flush_rewrite_rules'))
		{
			flush_rewrite_rules();
			delete_option(SHORTNAME . '_need_flush_rewrite_rules');
		}
	}
}
add_action('init', 'th_flush_rewrite_rules');

//Searchbox placeholder
if ( ! function_exists( 'ml_search_form' ) ) {
	function ml_search_form($form)
	{
		return '<form role="search" method="get" id="searchform" action="' . esc_url(home_url()) . '">
	 <div><label class="screen-reader-text" for="s">' . __('Search for:', 'milano') . '</label>
	 <input type="text" value="' . ( is_search() ? get_search_query() : '' ) . '" name="s" id="s" placeholder="' . __('Search', 'milano') . '">
	 <input type="submit" id="searchsubmit" value="' . __('Search', 'milano') . '">
	 </div>
	 </form>';
	}
}
add_filter( 'get_search_form', 'ml_search_form', 99999 );
?>