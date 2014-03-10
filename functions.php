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
define( 'CCC_VERSION', '0.1.1' );
 
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

function ccc_if_menu_member( $conditions ) {
	$conditions[] = array(
		'name' => 'User is Member',
		'condition' => 'ccc_is_member',
	);
	return $conditions;
}
add_filter( 'if_menu_conditions', 'ccc_if_menu_member' );

/**
 * if user is logged in and is not a subscriber
 * @return bool
 */
function ccc_is_member() {
	return current_user_can( 'edit_posts' );
}

new CCC_Setup;
class CCC_Setup {

	var $bp_templates = array( 'bp_group', 'bp_members', 'bp_register', 'bp_activity', 'bp_blogs' );

	function __construct() {
		add_filter( 'resurrect_sidebar_enabled', array( $this, 'sidebar_enabled'     ) );
		add_filter( 'ctfw_make_friendly',        array( $this, 'bp_templates' ), 10, 2 );
	}

	function sidebar_enabled( $enabled ) {
		if ( in_array( get_post_type(), $this->bp_templates ) ) {
			return false;
		}
		return $enabled;
	}

	function bp_templates( $rewrite, $template ) {
		if ( in_array( $template, $this->bp_templates ) ) {
			return 'bp';
		}
		return $rewrite;
	}
}
