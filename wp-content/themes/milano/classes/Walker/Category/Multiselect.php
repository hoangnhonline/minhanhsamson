<?php
class Walker_Category_Multiselect extends Walker_CategoryDropdown
{
	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		$pad = str_repeat('&nbsp;', $depth * 3);
		
		$cat_name = apply_filters('list_cats', $category->name, $category);
		
		$output .= "\t<option class=\"level-$depth\" value=\"".$category->term_id."\"";
		
		if ( in_array($category->term_id, $args['selected'] ))
			$output .= ' selected="selected"';
		$output .= '>';
		$output .= $pad.$cat_name;
		if ( $args['show_count'] )
			$output .= '&nbsp;&nbsp;('. $category->count .')';
		$output .= "</option>\n";
	}
}
?>
