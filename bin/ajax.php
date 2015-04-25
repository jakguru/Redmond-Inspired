<?php
	defined('ABSPATH') || die( 'Sorry, but you cannot access this page directly.' );

	function redmond_getpost_callback() {
		$POST = stripslashes_deep( $_POST );
		$postId = intval( $POST['post'] );
		$postData = get_post( $postId );
		$postData->post_content = apply_filters( 'the_content' , $postData->post_content );
		$comments = get_comments( array( 'post_id' => $postData->ID, 'status' => 'approve' ) );
		$res_data = array(
			'ID' => $postData->ID,
			'post_title' => $postData->post_title,
			'post_content' => redmond_add_comments_to_content( $postData->post_content, $postData->ID ),
			'post_icon' => redmond_get_post_icon( $postData->ID ),
			'task_name' => 'post_' . $postData->ID,
			'comments' => $comments,
			'fileMenu' => get_file_menu_for_post( $postData->ID ),
		);
		$response = array(
			'what' => 'login',
			'action' => 'login',
			'id' => '1',
			'data' => json_encode( $res_data ),
		);
		$xmlResponse = new WP_Ajax_Response($response);
		$xmlResponse->send();
	}

	function redmond_add_comments_to_content( $content , $post_id ) {
		$content = '<article>' . $content . "\r\n";
		if ( comments_open( $post_id ) && get_comments_number( $post_id ) > 0 ) {
			$comments = get_comments( array( 'post_id' => $post_id, 'status' => 'approve' ) );
			$content .= '<hr />' . "\r\n";
			$content .= '<h4>' . __('Comments:',RTEXTDOMAIN) . '</h4>' . "\r\n";
			$content .= '<ul class="list-group">' . "\r\n";
			foreach ($comments as $comment) {
				$content .= '<li class="list-group-item">' . "\r\n";
				$content .= '<a href="' . esc_url( $comment->comment_author_url ) . '" target="_blank">' . get_avatar( $comment->comment_author_email , 64 ) . '</a>' . "\r\n";
				$content .= '<h5 class="list-group-item-heading">' . esc_html( $comment->comment_author ) . '</h5>' . "\r\n";
				$content .= wpautop( esc_html( $comment->comment_content ) );
				$content .= '</li>' . "\r\n";
			}
			$content .= '</ul>' . "\r\n";
		}
		$content .= '</article>' . "\r\n";
		return $content;
	}

	function redmond_getarchive_callback() {
		$_POST = stripslashes_deep( $_POST );
		$response = array(
			'what' => 'login',
			'action' => 'login',
			'id' => '1',
			'data' => json_encode( $_POST ),
		);
		$data = array(
			'html' => '',
			'breadcrumbs' => '',
			'menu' => array(),
			'title' => __('Archive',RTEXTDOMAIN),
			'icon' => get_theme_mod( 'redmond_default_documents_icon' , REDMONDURI . '/resources/docs.ico' ),
			'taskname' => NULL,
		);
		switch ($_POST['taxonomy']) {
			case 'tags':
				$data['html'] = redmond_generate_folder_shortcuts_from_tag( $_POST['archive'] );
				$data['menu']['close'] = array(
					'title' => __('Close',RTEXTDOMAIN),
					'onclick' => 'redmond_close_this(this)',
				);
				$data['taskname'] = 'tag_archive_' . esc_html( $_POST['archive'] );
				$data['title'] = ( $_POST['archive'] !== 'all' ) ? get_tag( $_POST['archive'] )->name : __('All Tags',RTEXTDOMAIN);
				break;

			default:
				$data['html'] = redmond_generate_folder_shortcuts_from_category( $_POST['archive'] );
				$data['menu']['close'] = array(
					'title' => __('Close',RTEXTDOMAIN),
					'onclick' => 'redmond_close_this(this)',
				);
				$data['title'] = ( $_POST['archive'] !== 'all' ) ? get_the_category_by_ID( $_POST['archive'] ) : __('All Categories',RTEXTDOMAIN);
				$data['taskname'] = 'cat_archive_' . esc_html( $_POST['archive'] );
				break;
		}
		$response['data'] = json_encode( $data );
		$xmlResponse = new WP_Ajax_Response($response);
		$xmlResponse->send();
	}

	function redmond_getsearch_callback() {
		$_POST = stripslashes_deep( $_POST );
		$search = (array_key_exists('search', $_POST)) ? $_POST['search']:'';
		$response = array(
			'what' => 'login',
			'action' => 'login',
			'id' => '1',
			'data' => json_encode(array('html'=>redmond_generate_search_results( $search ))),
		);
		$xmlResponse = new WP_Ajax_Response($response);
		$xmlResponse->send();
	}
?>