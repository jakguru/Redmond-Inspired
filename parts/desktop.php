<?php
	defined( 'ABSPATH' ) || die( 'Sorry, but you cannot access this page directly.' );
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
	?>
	<div id="post_<?php print $post->ID; ?>_content">
		<article style="padding: 10px;">
			<?php the_content(); ?>
			<?php
				if( comments_open() && get_comments_number() > 0 ) {
					$comments = get_comments( array( 'post_id' => $post->ID , 'status' => 'approve' ) );
			?>
			<hr />
			<h4><?php _e('Comments:',RTEXTDOMAIN); ?></h4>
			<ul class="list-group">
			<?php
				foreach ($comments as $comment) {
			?>
				<li class="list-group-item">
					<a href="<?php print esc_url( $comment->comment_author_url ); ?>">
						<?php get_avatar( $comment->comment_author_email , 64 ); ?>
					</a>
					<h5 class="list-group-item-heading">
						<?php print esc_html( $comment->comment_author ); ?>
						<?php print wpautop( esc_html( $comment->comment_content ) ); ?>
					</h5>
				</li>
			<?php
				}
			?>
			</ul>
			<?php } ?>
		</article>
	</div>
	<script type="text/javascript">
		jQuery(function() {
			redmond_window( 'post_<?php print $post->ID; ?>', '<?php print json_encode($post->post_title); ?>' , jQuery("#post_<?php print $post->ID; ?>_content").html() , <?php print json_encode( get_file_menu_for_post( $post->ID ) ); ?> , false , true , '<?php print redmond_get_post_icon( $post->ID ); ?>' );
			setTimeout(function() {
				checkOpenWindows();
			},1500);
			jQuery("#post_<?php print $post->ID; ?>_content").remove();
		});
	</script>
	<?php
		endwhile;
	endif;
?>