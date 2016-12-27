<?php

class Sidebar_Generator {
	
	function sidebar_generator() {
		add_action('init',array('Sidebar_Generator','init'));		
	}
	
	public static function init(){
		//go through each sidebar and register it
	    $sidebars = Sidebar_Generator::get_sidebars();
	    
		
	    if(is_array($sidebars)){
			$z=1;
			foreach($sidebars as $sidebar_class => $sidebar){
				$sidebar_class = Sidebar_Generator::name_to_class($sidebar);
				register_sidebar(array(
			    	'name'=>$sidebar,
					'id'=> "th_sidebar-$z",
			    	'before_widget' => '<div id="%1$s" class="widget '.$sidebar_class.' %2$s">',
		   			'after_widget' => '</div>',
		   			'before_title' => '<h3 class="widget-title">',
					'after_title' => '</h3>',
		    	));	 $z++;
			}
		}
	}
	
	/**
	 * called by the action get_sidebar. this is what places this into the theme
	*/
	static function get_sidebar($index){
		
			dynamic_sidebar($index);			
		
	}
	
	/**
	 * gets the generated sidebars
	 */
	public static function get_sidebars(){
		return get_option( SHORTNAME. '_sidebar_generator');
	}
	public static function name_to_class($name){
		return sanitize_title($name);
	}
}
$sbg = new Sidebar_Generator;

function generated_dynamic_sidebar_lf($index){
	Sidebar_Generator::get_sidebar($index);	
	return true;
}
?>
