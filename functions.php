<?php
defined( 'ABSPATH' ) || die( 'Sorry, but you cannot access this page directly.' );
define( 'REDMONDBASE', __DIR__ );
define( 'RTEXTDOMAIN', 'redmond-inspired' );
define( 'REDMONDURI', get_template_directory_uri() );

function redmond_nr_function( $function, $data = null ) {
	if ( extension_loaded( 'newrelic' ) && substr( $function, 0 , 9 ) == 'newrelic_' ) {
		switch ( true ) {
			case is_array( $data ):
				call_user_func_array( $function , $data );
				break;
			case is_null( $data ):
				call_user_func( $function );
				break;
			default:
				call_user_func( $function , $data );
				break;
		}
	}
}

function redmond_wp_print_r( $ar, $print = false ) {
	$string = '<pre>' . htmlentities( print_r( $ar , true ) ) . '</pre>';
	if ( true == $print ) {
		wp_die( esc_html( $string ) , esc_html__( 'Feedback',RTEXTDOMAIN ) , array(
			'response' => 200,
		) );
	}
	else {
		return $string;
	}
}

if ( extension_loaded( 'newrelic' ) && get_option( 'redmond_use_newrelic_error_logger', false ) == true ) {
	set_error_handler( 'newrelic_notice_error' );
}

$objects = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( REDMONDBASE . '/bin' ), RecursiveIteratorIterator::SELF_FIRST );
foreach ( $objects as $name => $obj ) {
	if ( substr( $name, -4 ) == '.php' && strpos( $name, 'index.php' ) === false ) {
		require_once $name;
	}
}

/**
 * Add and Remove Actions Directly from the Functions Page
 */
add_action( 'after_setup_theme','redmond_remove_admin_bar' );
add_action( 'after_setup_theme','redmond_add_theme_supports' );
add_action( 'customize_register','redmond_customize_register' );
add_action( 'init','redmond_add_menus' );
add_action( 'wp_enqueue_scripts','redmond_theme_add_scripts_and_styles' );
add_filter( 'wp_title','redmond_filter_wp_title',1000,2 );
add_action( 'wp_head','redmond_do_site_icons' );
add_action( 'wp_head','redmond_add_custom_start_menu_styles' );
add_action( 'wp_head','redmond_new_relic_timing_header' );
add_action( 'wp_footer','redmond_new_relic_timing_footer' );
add_action( 'wp_ajax_getpost','redmond_getpost_callback' );
add_action( 'wp_ajax_nopriv_getpost','redmond_getpost_callback' );
add_action( 'wp_ajax_getarchive','redmond_getarchive_callback' );
add_action( 'wp_ajax_nopriv_getarchive','redmond_getarchive_callback' );
add_action( 'wp_ajax_getsearch','redmond_getsearch_callback' );
add_action( 'wp_ajax_nopriv_getsearch','redmond_getsearch_callback' );
add_action( 'wp_footer','redmond_set_info_cookies' );
remove_action( 'wp_head', 'feed_links_extra' );
remove_action( 'wp_head', 'feed_links' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link' );
remove_action( 'wp_head', 'start_post_rel_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'feed_links' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );
?>