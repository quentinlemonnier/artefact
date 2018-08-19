<?php
/**
 * The default template for displaying content
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

<div class="col s12 m6 l4">
 <div class="card" id="post-<?php the_ID(); ?>">
    <div class="card-image waves-effect waves-block waves-light">
      <img class="activator" src="<?php echo esc_url( $attachment_image_src ); ?>">
      <div class="fixed-action-btn" style="top:-0.5em;right:0.5em"><span class="btn-floating waves-effect waves-light grey darken-1"><i class="material-icons right activator">expand_more</i></span></div>
     </div>
    <div class="card-content">
    <a href="<?PHP echo esc_url( get_permalink() ); ?>" class="chip grey darken-1"><?PHP if ( has_post_thumbnail() ) {
    echo '<img src="'. esc_url( wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) ) .'" alt="'.the_title( '<strong class="white-text">', '</strong>' ).'picture">';
} ?></a>
        <?PHP
        if(get_post_type() == "artist"){
            $artistTag = get_the_terms( $post->ID, 'artistTag' );
            //print_r( $artistTag);
            foreach($artistTag as $tag){
                $tag_url =  get_term_link ( $tag->term_id, 'artistTag' );
                echo '<a href="'.$tag_url.'" class="chip"><i class="tiny material-icons">bookmark_border</i>'. ucfirst( $tag->name ) .'</a> ';
            }
        }

        ?>
    </div>
    <div class="card-reveal">
      <span class="card-title grey-text text-darken-4"><?PHP the_title(); ?><i class="material-icons right">close</i></span>
      <?PHP echo "<p>".get_the_excerpt()."</p>"; ?>
      <a href="<?PHP echo esc_url( get_permalink() ); ?>" class="waves-effect waves-light btn red"><i class="material-icons right">art_track</i>Lire la suite</a>
    </div>
  </div>
</div>

	<footer class="entry-footer">
		<?php //twentyfifteen_entry_meta(); ?>
		<?php //edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->