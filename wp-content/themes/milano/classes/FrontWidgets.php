<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FrontWidgets
 *
 * @author lnr
 */
class FrontWidgets
{
	//put your code here
	protected static $_instance;
	private $widgets = array();
	
	public function add($widget) {
		$this->widgets[] = $widget;
	}
	
	public function getJson() {
		return json_encode($this->widgets);
	}
	
	public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

?>
