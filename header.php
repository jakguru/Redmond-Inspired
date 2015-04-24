<?php
	defined('ABSPATH') || die('Sorry, but you cannot access this page directly.');
	global $current_user, $wpdb;
	$quick_launch = redmond_get_menu_as_array('quick_launch');
	get_currentuserinfo();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width">
		<title><?php wp_title('',true,'right'); ?> | <?php print(get_bloginfo('name')); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="chrome=1">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<?php
			wp_head();
		?>
	</head>
	<body <?php body_class('custom-background'); ?>>
		<div id="taskbar-outer">
			<div id="taskbar-inner">
				<span class="button-outer">
					<button class="system-button" id="start-button">
						<img src="<?php print get_theme_mod( 'redmond_start_icon' , REDMONDURI . '/resources/search.ico' ); ?>" />
						<span class="button-text"><?php _e('Start',RTEXTDOMAIN); ?></span>
					</button>
				</span>
				<div class="start-menu-seperator-outer">
					<div class="start-menu-seperator-inner"></div>
				</div>
				<ul id="quick-launch-links">
				<?php
					foreach ($quick_launch as $quick) {
				?>
					<li>
						<a href="<?php print $quick->url; ?>" <?php if( $quick->object !== 'custom' ) { ?> class="post-link" data-post-id="<?php print $quick->object_id; ?>" <?php } ?> title="<?php print esc_html( get_the_title( $quick->object_id ) ); ?>">
							<img src="<?php print redmond_get_post_icon( $quick->object_id ); ?>" />
						</a>
					</li>
				<?php
					}
				?>
				</ul>
				<div class="start-menu-seperator-outer">
					<div class="start-menu-seperator-inner"></div>
				</div>
				<ul id="open-processes"></ul>
				<div id="taskbar-clock" class="hidden-xs hidden-sm">Loading Clock</div>
			</div>
		</div>
		<div id="start-menu-wrapper">
			<div id="start-menu-inner">
				<div id="start-menu-user-bar">
					<p class="current-user">
						<?php print get_avatar( $current_user->ID , 32 ); ?>
						<?php print ( is_object( $current_user->data ) && property_exists($current_user->data, 'display_name' ) ) ? $current_user->data->display_name : __('Guest',RTEXTDOMAIN); ?>
					</p>
				</div>
				<div id="start-menu-internal">
					<div class="row">
						<div class="col-xs-6">
							<div id="start-menu-posts">
						<?php
							$latest = wp_get_recent_posts( array(
								'numberposts' => 8,
								'post_status' => 'publish',
								'suppress_filters' => FALSE,
							) , OBJECT );
							foreach ($latest as $post) {
								?>
									<a href="<?php print get_permalink( $post->ID ); ?>" class="post-link" data-post-id="<?php print $post->ID; ?>" title="<?php print esc_html( $post->post_title ); ?>">
										<img src="<?php print redmond_get_post_icon( $post->ID ); ?>" />
										<?php print substr( esc_html( $post->post_title ) , 0 , 20 ); ?>
										<?php if( strlen( esc_html( $post->post_title ) ) > 20 ) { print '...'; } ?>
									</a>
								<?php
							}
						?>
							</div>
						</div>
						<div class="col-xs-6">
							<div id="start-menu-content-links">
								<a id="my-documents-start-menu-link">
									<img src="<?php print get_theme_mod( 'redmond_default_documents_icon' , REDMONDURI . '/resources/docs.ico' ); ?>" />
									<?php _e('Categories',RTEXTDOMAIN); ?>
								</a>
								<?php if( count( get_tags() ) > 0 ) { ?>
								<a id="my-tags-start-menu-link">
									<img src="<?php print get_theme_mod( 'redmond_default_documents_icon' , REDMONDURI . '/resources/docs.ico' ); ?>" />
									<?php _e('Tags',RTEXTDOMAIN); ?>
								</a>
								<?php
								}
								if( current_user_can( 'publish_posts' ) ) {
								?>
								<a class="seperator"></a>
								<a href="<?php print admin_url('customize.php?return=%2F'); ?>" id="system-info-start-menu-link">
									<img src="<?php print get_theme_mod( 'redmond_default_info_icon' , REDMONDURI . '/resources/sysinfo.ico' ); ?>" />
									<?php _e('Site Customization',RTEXTDOMAIN); ?>
								</a>
								<a href="<?php print admin_url(); ?>" id="control-panel-start-menu-link">
									<img src="<?php print get_theme_mod( 'redmond_default_control_panel_icon' , REDMONDURI . '/resources/register.ico' ); ?>" />
									<?php _e('Control Panel',RTEXTDOMAIN); ?>
								</a>
								<?php
								}
								?>
								<a class="seperator"></a>
								<a href="/" title="<?php _e('Home',RTEXTDOMAIN);?>" alt="<?php _e('Home',RTEXTDOMAIN);?>" id="home-start-menu-link">
									<img src="<?php print get_theme_mod( 'redmond_default_home_icon' , REDMONDURI . '/resources/home.ico' ); ?>" />
									<?php _e('Home',RTEXTDOMAIN); ?>
								</a>
								<a id="system-search-start-menu-link">
									<img src="<?php print get_theme_mod( 'redmond_default_search_icon' , REDMONDURI . '/resources/sitesearch.ico' ); ?>" />
									<?php _e('Search',RTEXTDOMAIN); ?>
								</a>
							</div>
						</div>
					</div>
				</div>
				<ul id="start-menu-archive-link-wrapper" class="hidden-xs hidden-sm">
					<li class="seperator"></li>
					<li id="start-menu-archives-link">
						<?php _e('More',RTEXTDOMAIN); ?><span style="margin-left: 20px;" class="glyphicon glyphicon-play pull-right"></span>
						<?php
							$table = $wpdb->prefix . 'posts';
							$query = "SELECT
								MONTH( " . $table . ".post_date_gmt ) as `month`,
								YEAR( " . $table . ".post_date_gmt ) as `year`,
								CONCAT( YEAR( " . $table . ".post_date_gmt ) , '-', MONTH( " . $table . ".post_date_gmt ) , '-01 00:00:00' ) as `timestamp`
							FROM
								" . $table . "
							WHERE
								" . $table . ".post_type = 'post'
							AND
								" . $table . ".post_status = 'publish'
							GROUP BY `timestamp`";
							$archives_month = $wpdb->get_results( $query );
						?>
						<div id="archives-top-level-outer-wrapper" class="archives-outer-wrapper">
							<ul id="archives-top-level-inner" class="archives-inner-wrapper">
							<?php
								if( current_user_can( 'publish_posts' ) ) {
								?>
								<li>
									<a href="<?php print admin_url( 'post-new.php' ); ?>" id="new-post-start-menu-link">
										<img src="<?php print get_theme_mod( 'redmond_default_new_icon' , REDMONDURI . '/resources/new.ico' ); ?>" />
										<?php _e('New Post',RTEXTDOMAIN); ?>
									</a>
								</li>
								<li class="seperator"></li>
								<?php
								}
								foreach ($archives_month as $month) {
									print '<li><img src="' . get_theme_mod( 'redmond_archives_icon' , REDMONDURI . '/resources/archives.ico' ) . '" />' . date_i18n('F Y',strtotime( $month->timestamp ) ) . '<span style="margin-left: 20px;" class="glyphicon glyphicon-play pull-right"></span>';
									$ar_query = "SELECT
										" . $table . ".ID,
										" . $table . ".post_title
									FROM
										" . $table . "
									WHERE
										" . $table . ".post_type = 'post'
									AND
										MONTH( " . $table . ".post_date_gmt ) = %s
									AND
										YEAR( " . $table . ".post_date_gmt ) = %s
									AND
										" . $table . ".post_status = 'publish'";
									$ar_posts = $wpdb->get_results( $wpdb->prepare( $ar_query , array( $month->month , $month->year ) ) );
									?>
									<div class="archives-outer-wrapper">
										<ul class="archives-inner-wrapper">
										<?php
										foreach ($ar_posts as $p) {
										?>
											<li>
												<a href="<?php print get_permalink( $p->ID ); ?>" class="post-link" data-post-id="<?php print $p->ID; ?>" title="<?php print esc_html( $p->post_title ); ?>">
													<img src="<?php print redmond_get_post_icon( $p->ID ); ?>" />
													<?php print substr( esc_html( $p->post_title ) , 0 , 20 ); ?>
													<?php if( strlen( esc_html( $p->post_title ) ) > 20 ) { print '...'; } ?>
												</a>
											</li>
										<?php
										}
										?>
										</ul>
									</div>
									<?php
									print '</li>' . "\r\n";
								}
								$start_menu = redmond_get_menu_as_array('start');
								foreach ($start_menu as $ID => $item) {
								?>
									<li>
										<?php
											if( count( $item->subs ) == 0 ) {
										?>
										<a href="<?php print $item->url; ?>" <?php if( $item->object !== 'custom' ) { ?> class="post-link" data-post-id="<?php print $item->object_id; ?>" <?php } ?> title="<?php print esc_html( get_the_title( $item->object_id ) ); ?>">
										<?php
											}
										?>
											<img src="<?php print redmond_get_post_icon( $item->object_id ); ?>" />
											<?php print substr( esc_html( get_the_title( $item->object_id ) ) , 0 , 20 ); ?>
											<?php if( strlen( esc_html( get_the_title( $item->object_id ) ) ) > 20 ) { print '...'; } ?>
											<?php
												if( count( $item->subs ) > 0 ) {
											?>
											<span style="margin-left: 20px;" class="glyphicon glyphicon-play pull-right"></span>
											<div class="archives-outer-wrapper">
												<ul class="archives-inner-wrapper">
												<?php
													foreach ($item->subs as $ID => $i) {
													?>
														<li>
															<a href="<?php print $item->url; ?>" <?php if( $i->object !== 'custom' ) { ?> class="post-link" data-post-id="<?php print $i->object_id; ?>" <?php } ?> title="<?php print esc_html( get_the_title( $i->object_id ) ); ?>">
																<img src="<?php print redmond_get_post_icon( $i->object_id ); ?>" />
																<?php print substr( esc_html( get_the_title( $i->object_id ) ) , 0 , 20 ); ?>
																<?php if( strlen( esc_html( get_the_title( $i->object_id ) ) ) > 20 ) { print '...'; } ?>
															</a>
														</li>
													<?php
													}
												?>
												</ul>
											</div>
											<?php
												}
											?>
										<?php
											if( count( $item->subs ) == 0 ) {
										?>
										</a>
										<?php
											}
										?>
									</li>
								<?php
								}
							?>
							</ul>
						</div>
					</li>
				</ul>
				<div id="start-menu-login-bar-outer">
					<div id="start-menu-login-bar-inner">
					<?php
						if( is_user_logged_in() ) {
					?>
					<a class="start-menu-bottom-bar-command logout" id="start-menu-bottom-bar-logout" href="<?php print wp_logout_url( home_url() ); ?>">
						<img src="<?php print get_theme_mod( 'redmond_logout_icon' , REDMONDURI . '/resources/logout.ico' ); ?>" />
						<?php _e('Log Off',RTEXTDOMAIN); ?>
					</a>
					<?php
						}
						else {
						if( get_option( 'users_can_register' ) ) {
					?>
					<a class="start-menu-bottom-bar-command register" id="start-menu-bottom-bar-register" href="<?php print wp_registration_url(); ?>">
						<img src="<?php print get_theme_mod( 'redmond_register_icon' , REDMONDURI . '/resources/register.ico' ); ?>" />
						<?php _e('Register',RTEXTDOMAIN); ?>
					</a>
					<?php
						}
					?>
					<a class="start-menu-bottom-bar-command login" id="start-menu-bottom-bar-login" href="<?php print wp_login_url( home_url() ); ?>">
						<img src="<?php print get_theme_mod( 'redmond_logout_icon' , REDMONDURI . '/resources/logout.ico' ); ?>" />
						<?php _e('Log In',RTEXTDOMAIN); ?>
					</a>
					<?php
						}
					?>
					</div>
				</div>
			</div>
		</div>
		<div id="modal-holder"></div>
		<?php
		redmond_generate_folder_shortcuts_from_menu('desktop');
		//print('<pre>');
		//print_r( $current_user );
		//print('</pre>');
		?>