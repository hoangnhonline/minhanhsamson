<?php

$isTax = is_tax('th_portfolio_cat');

$term = get_queried_object();

$pageId = $isTax ? $term->term_id : get_the_ID();

$getMetaOption = $isTax ? 'get_tax_meta' : 'get_post_meta';

$ajaxLoadImages = ($getMetaOption($pageId, '_portfolio_thumb_changed', true) == 'on');
if($ajaxLoadImages){
	$updateMetaOption = $isTax ? 'update_tax_meta' : 'update_post_meta';
	$updateMetaOption($pageId, '_portfolio_thumb_changed', 'off');
}

$portfolio_terms = get_terms(Custom_Posts_Type_Portfolio::TAXONOMY, array(    'hide_empty' => 0,    'fields' => 'ids') );

$portfolio_cat = (!$isTax) ? $getMetaOption($pageId, SHORTNAME . '_portfolio_cat', true) : array($pageId);


$data = getPortfolioList($portfolio_cat ? $portfolio_cat : $portfolio_terms, $pageId, 1000, $ajaxLoadImages);



FrontWidgets::getInstance()->add(array(
	'type' => 'GridSlider',
	'id' => 'portfolio',
	'options' => array(
		'selector' => '#' . SHORTNAME . '_portfolio',
		'ajaxLoadImages' => $ajaxLoadImages,
		'thumbWidth' => (int) $getMetaOption($pageId, SHORTNAME . '_portfolio_thumb_width', true),
		'thumbHeight' => (int) $getMetaOption($pageId, SHORTNAME . '_portfolio_thumb_height', true),
		'sound' => get_option(SHORTNAME . '_rollover_carousel'),
		'soundOgg' => get_option(SHORTNAME . '_rollover_carousel_ogg')
	),
	'data' => $data['list']
));

if (($getMetaOption($pageId, SHORTNAME . '_open_image', true) == 'on')) {
	FrontWidgets::getInstance()->add(array(
		'type' => 'LightBox',
		'id' => 'lightbox',
		'options' => array(
			'selector' => '.lightbox',
			'clickObj' => '#carousel_list a'
		)
	));
}
?>
<style></style>
<div class="carousel portfolio-carousel p_abs align_center" id="<?php echo SHORTNAME; ?>_portfolio"></div>
