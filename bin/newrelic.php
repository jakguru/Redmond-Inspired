<?php
	defined( 'ABSPATH' ) || die( 'Sorry, but you cannot access this page directly.' );

	$tracedFunctions = array(
		'wp_die',
		'get_option',
		'update_option',
		'add_action',
		'add_filter',
		'apply_filter',
		'apply_filters',
		'do_action',
		'remove_action',
		'get_template_part',
	);
	$tracedClasses = array(
		'wpdb',
		'Memcache',
		'Memcached',
		'WP',
		'WP_http',
		'WP_Query',
		'WP_Rewrite',
		'WP_Ajax_Response',
	);
	foreach ( $tracedClasses as $class ) {
		if ( class_exists( $class ) ) {
			$methods = get_class_methods( $class );
			foreach ( $methods as $method ) {
				redmond_nr_function( 'newrelic_add_custom_tracer', $class.'::'.$method );
			}
		}
	}
	foreach ( $tracedFunctions as $function ) {
		if ( function_exists( $function ) ) {
			redmond_nr_function( 'newrelic_add_custom_tracer', $function );
		}
	}

	function redmond_new_relic_timing_header() {
		if ( extension_loaded( 'newrelic' ) ) {
			print wp_kses( "<script type='text/javascript'>" , array(
				'script' => array(
					'type' => true,
				),
			) );
			print esc_js( newrelic_get_browser_timing_header( false ) );
			print wp_kses( '</script>' . "\r\n" , array(
				'script' => array(
					'type' => true,
				),
			) );
		}
	}

	function redmond_new_relic_timing_footer() {
		if ( extension_loaded( 'newrelic' ) ) {
			print wp_kses( "<script type='text/javascript'>" , array(
				'script' => array(
					'type' => true,
				),
			) );
			print esc_js( newrelic_get_browser_timing_footer( false ) );
			print wp_kses( '</script>' . "\r\n" , array(
				'script' => array(
					'type' => true,
				),
			) );
		}
	}
?>