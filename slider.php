<?php
/**
 * The default template for displaying slider
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>
<!--/content.php-->
	<?php
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

	?>
    <li id="slideEl_<?php the_ID(); ?>" style="width:100%;height:100%;overflow:hidden;" class="grey darken-4">
      <img src="<?php echo esc_url( $attachment_image_src ); ?>" width="100%" style="opacity:0.2;">
      <div class="caption center-align">
        <div class="row">
            <div class="col m6">
                <img src="<?php echo esc_url( $attachment_image_src ); ?>" width="300px" height="auto">
            </div>
            <div class="col m6">
                <h3><?PHP the_title(); ?></h3>
            </div>
        </div>
        <!--<h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>-->
        <!--<div class="row"><a href="<?PHP echo esc_url( get_permalink() ); ?>" class="chip grey darken-1" ><?PHP if ( has_post_thumbnail() ) {
    echo '<img src="'. esc_url( wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) ) .'" alt="'.the_title( '<strong class="white-text">', '</strong>' ).'picture">';
} ?></a></div>-->
      </div>
    </li>