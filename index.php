<?php
	defined( 'ABSPATH' ) || die( 'Sorry, but you cannot access this page directly.' );
	global $wp_query;
	get_header();
	switch ( true ) {
		//case is_front_page():
		//	get_template_part( 'parts/home' );
		//	break;

		default:
			get_template_part( 'parts/desktop' );
			break;
	}
	get_footer();
?>