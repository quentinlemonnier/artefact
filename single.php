<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>
<!--<h1 class="alert">/single.php</h1>-->
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

		// Post thumbnail.
		//twentyfifteen_post_thumbnail();

if ( $post->post_type == 'artist' && $post->post_status == 'publish' ) {
		$attachments = get_posts( array(
			'post_type' => 'attachment',
			'posts_per_page' => -1,
			'post_parent' => $post->ID,
			'exclude'     => get_post_thumbnail_id()
		) );
    
        $attachment_image_src = " ";

		if ( $attachments ) {
			foreach ( $attachments as $attachment ) {
				//$class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
				//$thumbimg = wp_get_attachment_link( $attachment->ID, 'thumbnail-size', false );
                //print_r($attachment);
                $attachment_image_src = $attachment->guid;//wp_get_attachment_image_src ($attachment->ID)[0];
				//echo '<li class="' . $class . ' data-design-thumbnail">' . $thumbimg . '</li>';
			}
			
		}
	}
       the_title( '<header style="min-height:400px;line-height:400px;vertical-align:middle;background:url('. esc_url( $attachment_image_src ) .') no-repeat; background-size:cover;margin-bottom:2em;text-align:center"><h1 class="entry-title" style="line-height:1;background: #FFF;display:inline;"><img src="'. esc_url( wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) ) .'" class="circle">', '</h1></header>' );
        ?>
	<div id="primary" class="content-area">
		<main id="main" class="container" role="main">
            <?
			/*
			 * Include the post format-specific template for the content. If you want to
			 * use this in a child theme, then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */

            the_content();

			// If comments are open or we have at least one comment, load up the comment template.
			/*if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;*/

			// Previous/next post navigation.
			/*the_post_navigation( array(
				'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'twentyfifteen' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Next post:', 'twentyfifteen' ) . '</span> ' .
					'<span class="post-title">%title</span>',
				'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'twentyfifteen' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Previous post:', 'twentyfifteen' ) . '</span> ' .
					'<span class="post-title">%title</span>',
			) );*/

		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
