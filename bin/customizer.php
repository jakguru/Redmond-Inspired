<?php
	defined( 'ABSPATH' ) || die( 'Sorry, but you cannot access this page directly.' );

	function redmond_customize_register( $wp_customize ) {
		redmond_load_customizer_sections( $wp_customize );
		redmond_load_customizer_settings( $wp_customize );
		redmond_load_customizer_controls( $wp_customize );
	}

	function redmond_add_custom_start_menu_styles() {
		$html = '<style type="text/css">' . "\r\n";
		$html .= '	#start-menu-internal {' . "\r\n";
		$html .= '		background-image: url(' . REDMONDURI . '/resources/startbg.png);' . "\r\n";
		$html .= '		background-repeat: repeat-y;' . "\r\n";
		$html .= '		background-position: center;' . "\r\n";
		$html .= '	}' . "\r\n";
		$html .= '</style>' . "\r\n";
		print wp_kses( $html , array(
			'style' => array(
				'type' => true,
				'id' => true,
			),
		) );
	}

	function redmond_get_post_icon( $post_id ) {
		global $wpdb;
		if ( has_post_thumbnail( $post_id ) ) {
			$thumb_id = get_post_thumbnail_id( $post_id );
			$img_src = wp_get_attachment_image_src( $thumb_id , 'thumbnail' );
			return $img_src[0];
		}
		else {
			$postType = $wpdb->get_var( $wpdb->prepare( 'SELECT post_type FROM ' . $wpdb->prefix . 'posts WHERE ID = %d', $post_id ) );
			if ( 'nav_menu_item' == $postType ) {
				return get_theme_mod( 'redmond_external_page_icon' , REDMONDURI . '/resources/external.ico' );
			}
			else {
				return get_theme_mod( 'redmond_default_post_icon' , REDMONDURI . '/resources/post.ico' );
			}
		}
	}

	function redmond_do_site_icons() {
		$icons = array(
			array(
				'rel' => 'icon',
				'sizes' => '16x16',
				'type' => 'image/png',
				'href' => get_theme_mod( 'redmond_favicon' , REDMONDURI . '/resources/fav.ico' ),
			),
			array(
				'rel' => 'shortcut icon',
				'sizes' => '16x16',
				'type' => 'image/png',
				'href' => get_theme_mod( 'redmond_favicon' , REDMONDURI . '/resources/fav.ico' ),
			),
			array(
				'rel' => 'icon',
				'sizes' => '32x32',
				'type' => 'image/png',
				'href' => get_theme_mod( 'redmond_favicon' , REDMONDURI . '/resources/fav.ico' ),
			),
			array(
				'rel' => 'icon',
				'sizes' => '64x64',
				'type' => 'image/png',
				'href' => get_theme_mod( 'redmond_favicon' , REDMONDURI . '/resources/fav.ico' ),
			),
			array(
				'rel' => 'icon',
				'sizes' => '96x96',
				'type' => 'image/png',
				'href' => get_theme_mod( 'redmond_favicon' , REDMONDURI . '/resources/fav.ico' ),
			),
			array(
				'rel' => 'icon',
				'sizes' => '160x160',
				'type' => 'image/png',
				'href' => get_theme_mod( 'redmond_favicon' , REDMONDURI . '/resources/fav.ico' ),
			),
			array(
				'rel' => 'icon',
				'sizes' => '196x196',
				'type' => 'image/png',
				'href' => get_theme_mod( 'redmond_favicon' , REDMONDURI . '/resources/fav.ico' ),
			),
			array(
				'rel' => 'apple-touch-icon',
				'sizes' => '57x57',
				'type' => 'image/png',
				'href' => get_theme_mod( 'redmond_favicon' , REDMONDURI . '/resources/fav.ico' ),
			),
			array(
				'rel' => 'apple-touch-icon',
				'sizes' => '114x114',
				'type' => 'image/png',
				'href' => get_theme_mod( 'redmond_favicon' , REDMONDURI . '/resources/fav.ico' ),
			),
			array(
				'rel' => 'apple-touch-icon',
				'sizes' => '72x72',
				'type' => 'image/png',
				'href' => get_theme_mod( 'redmond_favicon' , REDMONDURI . '/resources/fav.ico' ),
			),
			array(
				'rel' => 'apple-touch-icon',
				'sizes' => '144x144',
				'type' => 'image/png',
				'href' => get_theme_mod( 'redmond_favicon' , REDMONDURI . '/resources/fav.ico' ),
			),
			array(
				'rel' => 'apple-touch-icon',
				'sizes' => '60x60',
				'type' => 'image/png',
				'href' => get_theme_mod( 'redmond_favicon' , REDMONDURI . '/resources/fav.ico' ),
			),
			array(
				'rel' => 'apple-touch-icon',
				'sizes' => '120x120',
				'type' => 'image/png',
				'href' => get_theme_mod( 'redmond_favicon' , REDMONDURI . '/resources/fav.ico' ),
			),
			array(
				'rel' => 'apple-touch-icon',
				'sizes' => '76x76',
				'type' => 'image/png',
				'href' => get_theme_mod( 'redmond_favicon' , REDMONDURI . '/resources/fav.ico' ),
			),
			array(
				'rel' => 'apple-touch-icon',
				'sizes' => '152x152',
				'type' => 'image/png',
				'href' => get_theme_mod( 'redmond_favicon' , REDMONDURI . '/resources/fav.ico' ),
			),
		);
		$html = '';
		foreach ( $icons as $icon ) {
			$html .= '<link rel="' . $icon['rel'] . '" sizes="' . $icon['sizes'] . '" type="' . $icon['type'] . '" href="' . $icon['href'] . '" />' . "\r\n";
		}
		print wp_kses( $html, array( 'link' ) );
	}
?>