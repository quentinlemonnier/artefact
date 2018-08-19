<?php get_header(); ?>

<?php
    if ( is_single() ) :
?>
    <div id="primary" class="content-area">
        <main id="main" class="container" role="main">
            <ul class="gallery-content">   
<?php
    endif;
    // Start the loop.
    while ( have_posts() ) : the_post();

         $args = array(
           'post_type' => 'attachment',
           'numberposts' => -1,
           'post_status' => null,
           'post_parent' => $post->ID
          );

          $attachments = get_posts( $args );
             if ( $attachments ) {
                foreach ( $attachments as $attachment ) {
                   echo '<li id="'.get_the_ID().'">';
                   echo '<figure>';
                   echo "<img src='".wp_get_attachment_url( $attachment->ID, 'full' )."'>";
?>
<?PHP
                   echo '<figurecaption><p>';
                   echo apply_filters( 'the_title', $attachment->post_title );
                   echo '</p></figurecaption>';
                   echo '</figure>';
                   echo '</li>';
                  }
             }
?>
                </figure> 
        <?php
		// End the loop.
		endwhile;
		?> 
                                
<?php
    if ( is_single() ) :
?>
           </ul>
                <footer class="entry-footer">
                    <?php //twentyfifteen_entry_meta(); ?>
                    <?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); ?>
                </footer><!-- .entry-footer -->
		</main><!-- .site-main -->
	</div><!-- .content-area -->
<?php endif; ?>

<?php get_footer(); ?>