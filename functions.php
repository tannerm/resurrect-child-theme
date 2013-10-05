<?php
/**
 * Christ's Community Church Theme functions and definitions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * @package Christ's Community Church Theme
 * @since 0.1.0
 */
 
 // Useful global constants
define( 'CCC_VERSION', '0.1.0' );
 
 /**
  * Set up theme defaults and register supported WordPress features.
  *
  * @uses load_theme_textdomain() For translation/localization support.
  *
  * @since 0.1.0
  */
 function ccc_setup() {
	/**
	 * Makes Christ's Community Church Theme available for translation.
	 *
	 * Translations can be added to the /lang directory.
	 * If you're building a theme based on Christ's Community Church Theme, use a find and replace
	 * to change 'ccc' to the name of your theme in all template files.
	 */
	load_theme_textdomain( 'ccc', get_stylesheet_directory_uri() . '/languages' );
 }
 add_action( 'after_setup_theme', 'ccc_setup' );
 
 /**
  * Enqueue scripts and styles for front-end.
  *
  * @since 0.1.0
  */
 function ccc_scripts_styles() {
	$postfix = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_script( 'ccc', get_stylesheet_directory_uri() . "/assets/js/christ_s_community_church_theme{$postfix}.js", array(), CCC_VERSION, true );
		
	wp_enqueue_style( 'ccc', get_stylesheet_directory_uri() . "/assets/css/christ_s_community_church_theme{$postfix}.css", array(), CCC_VERSION );
 }
 add_action( 'wp_enqueue_scripts', 'ccc_scripts_styles' );
 
 /**
  * Add humans.txt to the <head> element.
  */
 function ccc_header_meta() {
	$humans = '<link type="text/plain" rel="author" href="' . get_stylesheet_directory_uri() . '/humans.txt" />';
	
	echo apply_filters( 'ccc_humans', $humans );
 }
 add_action( 'wp_head', 'ccc_header_meta' );