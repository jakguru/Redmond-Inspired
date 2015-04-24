<?php
	defined('ABSPATH') || die('Sorry, but you cannot access this page directly.');
	$redmond_customizer_sections = array(
		array(
			'name' => 'redmond_images',
			'title' => __('Images and Icons',RTEXTDOMAIN),
			'priority' => 30,
		),
		array(
			'name' => 'redmond_sounds',
			'title' => __('Sounds',RTEXTDOMAIN),
			'priority' => 31,
		),
	);

	function redmond_load_customizer_sections( $wp_customize ) {
		global $redmond_customizer_sections;
		foreach ($redmond_customizer_sections as $section) {
			$wp_customize->add_section( $section['name'] , array( 'title' => $section['title'] , 'priority' => $section['priority'] ) );
		}
	}
?>