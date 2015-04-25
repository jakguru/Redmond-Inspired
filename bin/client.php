<?php
	defined( 'ABSPATH' ) || die( 'Sorry, but you cannot access this page directly.' );

	$redmond_scripts = array(
		array(
			'handle' => 'bootstrap',
			'src' => '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js',
			'deps' => array('jquery'),
			'ver' => null,
			'in_footer' => true,
		),
		array(
			'handle' => 'validate',
			'src' => '//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js',
			'deps' => array('jquery'),
			'ver' => null,
			'in_footer' => true,
		),
		array(
			'handle' => 'validate-additional',
			'src' => '//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.min.js',
			'deps' => array('jquery'),
			'ver' => null,
			'in_footer' => true,
		),
		array(
			'handle' => 'chosen',
			'src' => '//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js',
			'deps' => array('jquery'),
			'ver' => null,
			'in_footer' => true,
		),
		array(
			'handle' => 'redmond-dialogs',
			'src' => REDMONDURI . '/resources/redmond-dialogs.js',
			'deps' => array(
				'jquery',
				'jquery-ui-dialog',
				'jquery-ui-core',
			),
			'ver' => '0.0.1',
			'in_footer' => true,
			'needsTranslation' => true,
		),
		array(
			'handle' => 'redmond',
			'src' => REDMONDURI . '/functions.js',
			'deps' => array(
				'jquery',
				'redmond-dialogs',
				'chosen',
				'bootstrap',
				'wp-ajax-response',
				'validate',
				'validate-additional',
			),
			'ver' => '0.0.1',
			'in_footer' => true,
			'needsTranslation' => true,
		),
	);
	$redmond_styles = array(
		array(
			'handle' => 'chosen',
			'src' => '//cdnjs.cloudflare.com/ajax/libs/chosen/1.4.1/chosen.min.css',
			'deps' => array(),
			'ver' => null,
			'media' => 'all',
		),
		array(
			'handle' => 'bootstrap',
			'src' => '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css',
			'deps' => array(),
			'ver' => null,
			'media' => 'all',
		),
		array(
			'handle' => 'redmond',
			'src' => REDMONDURI . '/style.css',
			'deps' => array('chosen', 'bootstrap'),
			'ver' => '0.0.1',
			'media' => 'all',
		),
	);
	$redmond_js_translations = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'searchIcon' => get_theme_mod( 'redmond_default_search_icon' , REDMONDURI . '/resources/sitesearch.ico' ),
		'windowIcon' => get_theme_mod( 'redmond_default_dialog_icon' , REDMONDURI . '/resources/dialog.ico' ),
		'errorIcon' => get_theme_mod( 'redmond_default_error_icon' , REDMONDURI . '/resources/error.ico' ),
		'externalPageIcon' => get_theme_mod( 'redmond_external_page_icon' , REDMONDURI . '/resources/external.ico' ),
		'errorSound' => get_theme_mod( 'redmond_default_error_sound' , REDMONDURI . '/resources/error.wav' ),
		'openSound' => get_theme_mod( 'redmond_default_open_sound' , REDMONDURI . '/resources/open.wav' ),
		'loginSound' => get_theme_mod( 'redmond_default_startup_sound' , REDMONDURI . '/resources/logon.wav' ),
		'playLoginSounds' => ( isset( $_COOKIE['returning_visit'] ) ) ? false : true,
		'file' => __( 'File', RTEXTDOMAIN ),
		'close' => __( 'Exit', RTEXTDOMAIN ),
		'closetext' => __( 'Close', RTEXTDOMAIN ),
		'errTitle' => __( 'Error', RTEXTDOMAIN ),
		'ajaxerror' => __( 'An error has occured while attempting to retrieve the requested information. Please check the error console for more information.', RTEXTDOMAIN ),
		'default_file_menu' => array(
				'close' => array(
					'title' => __( 'Close', RTEXTDOMAIN ),
					'onclick' => 'redmond_close_this(this)',
				),
			),
		'search' => __( 'Search', RTEXTDOMAIN ),
		'search_for' => __( 'Search for ', RTEXTDOMAIN ),
	);

	function redmond_theme_add_scripts_and_styles() {
		global $redmond_scripts, $redmond_styles, $redmond_js_translations;
		foreach ( $redmond_scripts as $script ) {
			wp_deregister_script( $script['handle'] );
			wp_register_script( $script['handle'], $script['src'], $script['deps'], $script['ver'], $script['in_footer'] );
			if ( array_key_exists( 'needsTranslation', $script ) && true == $script['needsTranslation'] ) {
				wp_localize_script( $script['handle'] , 'redmond_terms' , $redmond_js_translations );
			}
			wp_enqueue_script( $script['handle'] );
		}
		foreach ( $redmond_styles as $style ) {
			wp_deregister_style( $style['handle'] );
			wp_register_style( $style['handle'], $style['src'], $style['deps'], ( array_key_exists( 'ver', $style ) ) ? $style['ver'] : null, $style['media'] );
			wp_enqueue_style( $style['handle'] );
		}
	}

	function redmond_add_menus() {
		$menus = array(
			'quick_launch' => __( 'Quick Launch Menu', RTEXTDOMAIN ),
			'desktop' => __( 'Desktop Menu', RTEXTDOMAIN ),
			'start' => __( 'Start Menu', RTEXTDOMAIN ),
		);
		register_nav_menus( $menus );
	}

	function redmond_add_theme_supports() {
		$redmond_background_defaults = array(
			'default-color' => '3a6ea5',
			'wp-head-callback' => 'redmond_custom_background_printer',
		);
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'custom-background' ,$redmond_background_defaults );
	}

	function redmond_user_gravatar( $email, $size = 64 ) {
		return '//www.gravatar.com/avatar/' . md5( strtolower( $email ) ) . '?d=mm&s=' . intval( $size ) . '&r=g';
	}

	function redmond_filter_wp_title( $title, $sep ) {
		global $wp_query;
		switch ( true ) {
			case is_front_page():
				$title = get_bloginfo( 'description' );
				break;

			default:
				$title = str_replace( ' - ' . get_bloginfo( 'name' ), '', $title );
				break;
		}
		return $title;
	}

	function redmond_remove_admin_bar() {
		show_admin_bar( false );
	}

	function redmond_custom_background_printer() {
		$color = get_theme_mod( 'background_color', get_theme_support( 'custom-background', 'default-color' ) );
		$background = set_url_scheme( get_background_image() );
		if ( ! $background && ! $color ) {
			return null;
		}
		$style = $color ? "background-color: #$color;" : '';
		if ( $background ) {
			$image = " background-image: url('$background');";
			$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );
			if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) ) {
			  $repeat = 'repeat';
			}
			$repeat = " background-repeat: $repeat;";
			$position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
			if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) ) {
			  $position = 'left';
			}
			$position = " background-position: top $position;";
			$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );
			if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) ) {
			  $attachment = 'scroll';
			}
			$attachment = " background-attachment: $attachment;";
			$style .= $image . $repeat . $position . $attachment;
		}
		$html = '<style type="text/css" id="custom-background-css">' . "\r\n";
		$html .= '	body.custom-background {' . trim( $style ) . '}' . "\r\n";
		$html .= '</style>' . "\r\n";
		print wp_kses( $html , array(
			'style' => array(
				'type' => true,
				'id' => true,
			),
		) );
	}

	function redmond_get_menu_as_array( $menu_name ) {
		$items = array();
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
			$menu_items = wp_get_nav_menu_items( $menu->term_id );
			foreach ( $menu_items as $item ) {
				if ( $item->menu_item_parent == 0 ) {
					$items[ $item->ID ] = $item;
					$items[ $item->ID ]->subs = array();
				}
				else {
					$items[ $item->menu_item_parent ]->subs[ $item->ID ] = $item;
				}
			}
		}
		return $items;
	}

	function get_file_menu_for_post( $post_id ) {
		$fileMenu = array();
		if ( current_user_can( 'publish_posts' ) ) {
			$fileMenu['new'] = array(
				'title' => __( 'New', RTEXTDOMAIN ),
				'onclick' => 'window.location.href=\'' . admin_url( 'post-new.php' ) . '\'',
			);
		}
		if ( current_user_can( 'edit_post' , $post_id ) ) {
			$fileMenu['edit'] = array(
				'title' => __( 'Edit', RTEXTDOMAIN ),
				'onclick' => 'window.location.href=\'' . get_edit_post_link( $post_id ) . '\'',
			);
		}
		if ( comments_open( $post_id ) ) {
			$fileMenu['comment'] = array(
				'title' => __( 'Comment', RTEXTDOMAIN ),
				'onclick' => 'redmond_comment_field(' . intval( $post_id ) . ')',
			);
		}
		$fileMenu['share'] = array(
				'title' => __( 'Share', RTEXTDOMAIN ),
				'onclick' => 'redmond_share_post(' . intval( $post_id ) . ')',
			);
		$fileMenu['close'] = array(
			'title' => __( 'Close', RTEXTDOMAIN ),
			'onclick' => 'redmond_close_this(this)',
		);
		return $fileMenu;
	}

	function redmond_set_info_cookies() {
		setcookie( 'returning_visit', true, time() + 2592000, '/', COOKIE_DOMAIN, false, true );
	}

	function redmond_generate_folder_shortcuts_from_menu( $menu, $max_rows = 5 ) {
		$items = redmond_get_menu_as_array( $menu );
		$tdata = array();
		$row = 1;
		while ( $row <= $max_rows ) {
			$tdata[ 'row_' . $row ] = array();
			$row ++;
		}
		$count = 1;
		foreach ( $items as $item ) {
			$link = array(
				'url' => $item->url,
				'type' => ( $item->object == 'custom' ) ? 'custom' : 'regular',
				'id' => $item->object_id,
				'title' => substr( esc_html( get_the_title( $item->object_id ) ) , 0 , 20 ),
				'fulltitle' => esc_html( get_the_title( $item->object_id ) ),
				'icon' => redmond_get_post_icon( $item->object_id ),
			);
			array_push( $tdata[ 'row_' . $count ], $link );
			if ( $count >= $max_rows ) {
				$count = 1;
			}
			else {
				$count ++;
			}
		}
		redmond_make_folder_list_into_table( $tdata , $menu . '_menu' , true );
	}

	function redmond_generate_folder_shortcuts_from_category( $category, $max_cols = 10 ) {
		$tdata = array();
		$row = 1;
		$count = 1;
		$colcount = 0;
		$html = '';
		if ( 'all' == $category ) {
			$cats = get_categories();
			$rows_needed = ceil( count( $cats ) / $max_cols );
			while ( $row <= $rows_needed ) {
				$tdata[ 'row_' . $row ] = array();
				$row ++;
			}
			foreach ( $cats as $cat ) {
				$link = array(
					'url' => get_category_link( $cat->cat_ID ),
					'type' => 'category',
					'id' => $cat->cat_ID,
					'title' => substr( $cat->cat_name, 0,20 ),
					'fulltitle' => $cat->cat_name,
					'icon' => get_theme_mod( 'redmond_default_documents_icon' , REDMONDURI . '/resources/docs.ico' ),
				);
				array_push( $tdata[ 'row_' . $count ], $link );
				if ( $colcount < $max_cols ) {
					$colcount ++;
				}
				else {
					$colcount = 0;
					$count ++;
				}
			}
		}
		else {
			$posts = get_posts(array(
				'cat' => $category,
				'posts_per_page' => 50,
			));
			$rows_needed = ceil( count( $posts ) / $max_cols );
			while ( $row <= $rows_needed ) {
				$tdata[ 'row_' . $row ] = array();
				$row ++;
			}
			foreach ( $posts as $post ) {
				$link = array(
					'url' => get_permalink( $post->ID ),
					'type' => 'regular',
					'id' => $post->ID,
					'title' => substr( esc_html( get_the_title( $post->ID ) ) , 0 , 20 ),
					'fulltitle' => esc_html( get_the_title( $post->ID ) ),
					'icon' => redmond_get_post_icon( $post->ID ),
				);
				array_push( $tdata[ 'row_' . $count ], $link );
				if ( $colcount < $max_cols ) {
					$colcount ++;
				}
				else {
					$colcount = 0;
					$count ++;
				}
			}
		}
		$html .= redmond_make_folder_list_into_table( $tdata , 'cat_' . $category . '_table' , false );
		return $html;
	}

	function redmond_generate_folder_shortcuts_from_tag( $tag, $max_cols = 10 ) {
		$html = '';
		$tdata = array();
		$row = 1;
		$count = 1;
		$colcount = 0;
		if ( 'all' == $tag ) {
			$cats = get_tags();
			$rows_needed = ceil( count( $cats ) / $max_cols );
			while ( $row <= $rows_needed ) {
				$tdata[ 'row_' . $row ] = array();
				$row ++;
			}
			foreach ( $cats as $cat ) {
				$link = array(
					'url' => get_term_link( $cat->term_id , 'post_tag' ),
					'type' => 'tags',
					'id' => $cat->term_id,
					'title' => substr( $cat->name, 0,20 ),
					'fulltitle' => $cat->name,
					'icon' => get_theme_mod( 'redmond_default_documents_icon' , REDMONDURI . '/resources/docs.ico' ),
				);
				array_push( $tdata[ 'row_' . $count ], $link );
				if ( $colcount < $max_cols ) {
					$colcount ++;
				}
				else {
					$colcount = 0;
					$count ++;
				}
			}
		}
		else {
			$posts = get_posts(array(
				'tag_id' => $tag,
				'posts_per_page' => 50,
			));
			$rows_needed = ceil( count( $posts ) / $max_cols );
			while ( $row <= $rows_needed ) {
				$tdata[ 'row_' . $row ] = array();
				$row ++;
			}
			foreach ( $posts as $post ) {
				$link = array(
					'url' => get_permalink( $post->ID ),
					'type' => 'regular',
					'id' => $post->ID,
					'title' => substr( esc_html( get_the_title( $post->ID ) ) , 0 , 20 ),
					'fulltitle' => esc_html( get_the_title( $post->ID ) ),
					'icon' => redmond_get_post_icon( $post->ID ),
				);
				array_push( $tdata[ 'row_' . $count ], $link );
				if ( $colcount < $max_cols ) {
					$colcount ++;
				}
				else {
					$colcount = 0;
					$count ++;
				}
			}
		}
		$html .= redmond_make_folder_list_into_table( $tdata , 'tag_' . $tag . '_table' , false );
		return $html;
	}

	function redmond_generate_search_results( $search, $max_cols = 10 ) {
		$html = '';
		$html .= '<div class="search-panel">' . "\r\n";
		$html .= '	<div class="row">' . "\r\n";
		$html .= '		<div class="col-md-3">' . "\r\n";
		$html .= '			<div>' . "\r\n";
		$html .= '				<div class="row">' . "\r\n";
		$html .= '					<div class="col-xs-12">' . "\r\n";
		$html .= '						<h4>' . "\r\n";
		$html .= '							<img src="' . get_theme_mod( 'redmond_searchfolder_icon' , REDMONDURI . '/resources/search.ico' ) . '" title="' . __( 'Search for Posts',RTEXTDOMAIN ) . '" alt="' . __( 'Search for Posts',RTEXTDOMAIN ) . '" />' . "\r\n";
		$html .= '							' . __( 'Search for Posts',RTEXTDOMAIN ) . "\r\n";
		$html .= '						</h4>' . "\r\n";
		$html .= '						<hr />' . "\r\n";
		$html .= '					</div>' . "\r\n";
		$html .= '				</div>' . "\r\n";
		$html .= '				<div class="form-group">' . "\r\n";
		$html .= '					<label>' . __( 'Search for posts containing:',RTEXTDOMAIN ) . '</label>' . "\r\n";
		$html .= '					<input type="text" class="system-field" placeholder="' . __( 'Search for...',RTEXTDOMAIN ) . '" value="' . esc_html( $search ) . '" />' . "\r\n";
		$html .= '				</div>' . "\r\n";
		$html .= '				<div class="form-group">' . "\r\n";
		$html .= '					<span class="button-outer"><button class="system-button" type="button">' . __( 'Search Now',RTEXTDOMAIN ) . '</button></span>' . "\r\n";
		$html .= '				</div>' . "\r\n";
		$html .= '			</div>' . "\r\n";
		$html .= '		</div>' . "\r\n";
		$html .= '		<div class="col-md-9">' . "\r\n";
		$html .= '			<div>' . "\r\n";
		$html .= '				<h2>' . __( 'Search Results',RTEXTDOMAIN ) . '</h2>' . "\r\n";
		$html .= '				<hr />' . "\r\n";
		if ( strlen( $search ) > 0 ) {
			$query = new WP_Query(array(
				's' => $search,
				'posts_per_page' => 50,
			));
			if ( intval( $query->found_posts ) > 0 ) {
				$tdata = array();
				$row = 1;
				$count = 1;
				$colcount = 0;
				$rows_needed = ceil( count( $query->posts ) / $max_cols );
				while ( $row <= $rows_needed ) {
					$tdata[ 'row_' . $row ] = array();
					$row ++;
				}
				foreach ( $query->posts as $post ) {
					$link = array(
						'url' => get_permalink( $post->ID ),
						'type' => 'regular',
						'id' => $post->ID,
						'title' => substr( esc_html( get_the_title( $post->ID ) ) , 0 , 20 ),
						'fulltitle' => esc_html( get_the_title( $post->ID ) ),
						'icon' => redmond_get_post_icon( $post->ID ),
					);
					array_push( $tdata[ 'row_' . $count ], $link );
					if ( $colcount < $max_cols ) {
						$colcount ++;
					}
					else {
						$colcount = 0;
						$count ++;
					}
				}
				$html .= redmond_make_folder_list_into_table( $tdata , 'search' , false );
			}
			else {
				$html .= '<p>' . sprintf( __( 'No Results for %s found',RTEXTDOMAIN ) , '<code>'.esc_html( $search ).'</code>' ) . '</p>' . "\r\n";
				$html .= '<div class="filler"></div>' . "\r\n";
			}
		}
		else {
			$html .= '<p>' . __( 'Enter your search criteria to begin',RTEXTDOMAIN ) . '</p>' . "\r\n";
			$html .= '<div class="filler"></div>' . "\r\n";
		}
		$html .= '			</div>' . "\r\n";
		$html .= '		</div>' . "\r\n";
		$html .= '	</div>' . "\r\n";
		$html .= '</div>' . "\r\n";
		return $html;
	}

	function redmond_make_folder_list_into_table( $list, $id, $print = true ) {
		$maxCells = 0;
		foreach ( $list as $row => $cells ) {
			if ( count( $cells ) > $maxCells ) {
				$maxCells = count( $cells );
			}
		}
		$html .= '<table class="icon-table" id="' . $id . '">' . "\r\n";
		foreach ( $list as $row => $cells ) {
		$html .= '	<tr>' . "\r\n";
		foreach ( $cells as $cell ) {
		$type = $cell['type'];
		$html .= '		<td>' . "\r\n";
		$html .= '			<a href="' . esc_url( $cell['url'] ) . '" data-type="' . esc_html( $type ) . '" title="' . $cell['fulltitle'] . '"';
		switch ( $type ) {
			case 'regular':
				$html .= ' data-post-id="' . intval( $cell['id'] ) . '"';
				break;

			case 'category':
				$html .= ' data-category-id="' . intval( $cell['id'] ) . '"';
				break;

			case 'tags':
				$html .= ' data-category-id="' . intval( $cell['id'] ) . '"';
				break;
		}
		$html .= '>' . "\r\n";
		$html .= '				<img src="' . esc_url( $cell['icon'] ) . '" />' . "\r\n";
		$html .= '				' . esc_html( $cell['title'] ) . "\r\n";
		$html .= '			</a>' . "\r\n";
		$html .= '		</td>' . "\r\n";
		}
		$html .= '	</tr>' . "\r\n";
		}
		$html .= '</table>' . "\r\n";
		if ( true == $print ) {
			print wp_kses( $html, array(
				'table' => array(
					'class' => true,
					'id' => true,
				),
				'thead' => array(),
				'tbody' => array(),
				'tr' => array(),
				'td' => array(),
				'a' => array(
					'href' => true,
					'data-type' => true,
					'title' => true,
					'data-post-id' => true,
					'data-category-id' => true,
				),
				'img' => array(
					'src' => true,
				),
			) );
		}
		else {
			return $html;
		}
	}
?>