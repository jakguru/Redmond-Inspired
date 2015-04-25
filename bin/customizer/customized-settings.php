<?php
	defined( 'ABSPATH' ) || die( 'Sorry, but you cannot access this page directly.' );
	$redmond_customizer_settings = array(
		array(
			'name' => 'redmond_default_icon',
			'default' => REDMONDURI . '/resources/search.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_favicon',
			'default' => REDMONDURI . '/resources/fav.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_start_icon',
			'default' => REDMONDURI . '/resources/search.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_searchfolder_icon',
			'default' => REDMONDURI . '/resources/search.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_login_icon',
			'default' => REDMONDURI . '/resources/switch-user.png',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_logout_icon',
			'default' => REDMONDURI . '/resources/logout.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_register_icon',
			'default' => REDMONDURI . '/resources/register.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_post_icon',
			'default' => REDMONDURI . '/resources/post.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_documents_icon',
			'default' => REDMONDURI . '/resources/docs.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_music_icon',
			'default' => REDMONDURI . '/resources/music.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_pictures_icon',
			'default' => REDMONDURI . '/resources/picturesandvideos.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_archives_icon',
			'default' => REDMONDURI . '/resources/archives.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_sitesearch_icon',
			'default' => REDMONDURI . '/resources/sitesearch.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_info_icon',
			'default' => REDMONDURI . '/resources/info.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_sysinfo_icon',
			'default' => REDMONDURI . '/resources/sysinfo.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_new_icon',
			'default' => REDMONDURI . '/resources/new.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_home_icon',
			'default' => REDMONDURI . '/resources/home.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_control_panel_icon',
			'default' => REDMONDURI . '/resources/register.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_dialog_icon',
			'default' => REDMONDURI . '/resources/dialog.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_error_icon',
			'default' => REDMONDURI . '/resources/error.ico',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_error_sound',
			'default' => REDMONDURI . '/resources/error.wav',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_open_sound',
			'default' => REDMONDURI . '/resources/open.wav',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_default_startup_sound',
			'default' => REDMONDURI . '/resources/logon.wav',
			'transport' => 'refresh',
		),
		array(
			'name' => 'redmond_external_page_icon',
			'default' => REDMONDURI . '/resources/external.ico',
			'transport' => 'refresh',
		),
	);

	function redmond_load_customizer_settings( $wp_customize ) {
		global $redmond_customizer_settings;
		foreach ( $redmond_customizer_settings as $setting ) {
			$wp_customize->add_setting( $setting['name'], array( 'default' => $setting['default'], 'transport' => $setting['transport'] ) );
		}
	}
?>