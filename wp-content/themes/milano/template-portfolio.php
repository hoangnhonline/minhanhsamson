<?php
/**
 * Template Name: Portfolio
 * @package WordPress
 * @subpackage Restaurant_Theme
 */

get_header(); 
get_template_part('bggallery');
get_template_part('loop', 'portfolio');
get_footer();