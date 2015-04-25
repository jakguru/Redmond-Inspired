<?php
	defined( 'ABSPATH' ) || die( 'Sorry, but you cannot access this page directly.' );
	$redmond_customizer_controls = array(
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_default_icon',
			'args' => array(
				'label' => __('Default Icon',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_default_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_favicon',
			'args' => array(
				'label' => __('Favicon',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_favicon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_start_icon',
			'args' => array(
				'label' => __('Start Icon',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_start_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_login_icon',
			'args' => array(
				'label' => __('Log In Icon',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_login_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_logout_icon',
			'args' => array(
				'label' => __('Log Out Icon',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_logout_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_register_icon',
			'args' => array(
				'label' => __('Register Icon',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_register_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_default_post_icon',
			'args' => array(
				'label' => __('Default Post Icon',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_default_post_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_default_documents_icon',
			'args' => array(
				'label' => __('Icon for My Documents',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_default_documents_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_default_music_icon',
			'args' => array(
				'label' => __('Icon for My Images',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_default_music_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_default_pictures_icon',
			'args' => array(
				'label' => __('Icon for My Music',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_default_pictures_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_default_archives_icon',
			'args' => array(
				'label' => __('Icon for Archives',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_default_archives_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_default_sitesearch_icon',
			'args' => array(
				'label' => __('Icon for Site Search',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_default_sitesearch_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_searchfolder_icon',
			'args' => array(
				'label' => __('Icon for Site Search Panel',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_searchfolder_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_default_info_icon',
			'args' => array(
				'label' => __('Icon for Info',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_default_info_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_default_new_icon',
			'args' => array(
				'label' => __('Icon for New Post',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_default_new_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_default_home_icon',
			'args' => array(
				'label' => __('Home Icon',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_default_home_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_default_control_panel_icon',
			'args' => array(
				'label' => __('Control Panel Icon',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_default_control_panel_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_default_sysinfo_icon',
			'args' => array(
				'label' => __('System Information Icon',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_default_sysinfo_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_default_dialog_icon',
			'args' => array(
				'label' => __('System Information Icon',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_default_dialog_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_default_error_icon',
			'args' => array(
				'label' => __('System Error Icon',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_default_error_icon',
			),
		),
		array(
			'type' => 'WP_Customize_Upload_Control',
			'id' => 'redmond_default_error_sound',
			'args' => array(
				'label' => __('System Error Sound',RTEXTDOMAIN),
				'section' => 'redmond_sounds',
				'settings' => 'redmond_default_error_sound',
			),
		),
		array(
			'type' => 'WP_Customize_Upload_Control',
			'id' => 'redmond_default_open_sound',
			'args' => array(
				'label' => __('Open Event Sound',RTEXTDOMAIN),
				'section' => 'redmond_sounds',
				'settings' => 'redmond_default_open_sound',
			),
		),
		array(
			'type' => 'WP_Customize_Upload_Control',
			'id' => 'redmond_default_startup_sound',
			'args' => array(
				'label' => __('First Time View Sound',RTEXTDOMAIN),
				'section' => 'redmond_sounds',
				'settings' => 'redmond_default_startup_sound',
			),
		),
		array(
			'type' => 'WP_Customize_Image_Control',
			'id' => 'redmond_external_page_icon',
			'args' => array(
				'label' => __('External Page Icon',RTEXTDOMAIN),
				'section' => 'redmond_images',
				'settings' => 'redmond_external_page_icon',
			),
		),
	);

	function redmond_load_customizer_controls( $wp_customize ) {
		global $redmond_customizer_controls;
		foreach ($redmond_customizer_controls as $control) {
			$wp_customize->add_control( new $control['type']( $wp_customize , $control['id'] , $control['args'] ) );
		}
	}
?>