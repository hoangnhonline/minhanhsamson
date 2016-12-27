<?php

class Import_Theme_Menus extends Import_Theme_Default
{

	function __construct($type)
	{
		parent::__construct($type);
	}

	public function import_restaraunt()
	{
		global $wpdb;

		$table_db_name = $wpdb->prefix . "terms";
		$rows = $wpdb->get_results("SELECT * FROM $table_db_name where  name='Side menu' OR name='Footer'", ARRAY_A);
		$menu_ids = array();

		foreach ($rows as $row)
		{
			$menu_ids[$row["name"]] = $row["term_id"];
		}

		$items = wp_get_nav_menu_items($menu_ids['Side menu']);

		foreach ($items as $item)
		{
			if ($item->title == "Home")
			{
				update_post_meta($item->ID, '_menu_item_url', home_url());
			}
		}

		set_theme_mod('nav_menu_locations', array_map('absint', array('main-menu' => $menu_ids['Side menu'], 'footer-menu' => $menu_ids['Footer'])));
	}

	public function import_extreme()
	{
		global $wpdb;

		$table_db_name = $wpdb->prefix . "terms";
		$rows = $wpdb->get_results("SELECT * FROM $table_db_name where  name='Footer'", ARRAY_A);
		$menu_ids = array();

		foreach ($rows as $row)
		{
			$menu_ids[$row["name"]] = $row["term_id"];
		}

		$items = wp_get_nav_menu_items($menu_ids['Footer']);

		foreach ($items as $item)
		{
			if ($item->title == "Home")
			{
				update_post_meta($item->ID, '_menu_item_url', home_url());
			}
		}

		set_theme_mod('nav_menu_locations', array_map('absint', array('footer-menu' => $menu_ids['Footer'])));
	}

	public function import_hotel()
	{
		global $wpdb;

		$table_db_name = $wpdb->prefix . "terms";
		$rows = $wpdb->get_results("SELECT * FROM $table_db_name where  name='hotel' OR name='Footer'", ARRAY_A);
		$menu_ids = array();

		foreach ($rows as $row)
		{
			$menu_ids[$row["name"]] = $row["term_id"];
		}

		$items = wp_get_nav_menu_items($menu_ids['Footer']);

		foreach ($items as $item)
		{
			if ($item->title == "Home")
			{
				update_post_meta($item->ID, '_menu_item_url', home_url());
			}
		}

		set_theme_mod('nav_menu_locations', array_map('absint', array('main-menu' => $menu_ids['hotel'], 'footer-menu' => $menu_ids['Footer'])));
	}

}

?>