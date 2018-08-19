<?php
/**
 * /front-page.php
 * @package WordPress
 * @subpackage artefact
 * 
 */
    get_header();
?>
<?php
    global $post;
    $args = array(
        'posts_per_page'   => 1000,
        'offset'           => 0,
        'category'         => '',
        'category_name'    => '',
        'orderby'          => 'post_title',
        'order'            => 'ASC',
        'include'          => '',
        'exclude'          => '',
        'meta_key'         => '',
        'meta_value'       => '',
        'post_type'        => 'artist',
        'post_mime_type'   => '',
        'post_parent'      => '',
        'author'	   => '',
        'post_status'      => 'publish',
        'suppress_filters' => true 
    );
    $artistsPosts = get_posts( $args );
?>
<h1 class="alert">
    <!-- /front-page.php -->
    <?php
					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<?php echo $description; ?>
					<?php endif;
	?>
</h1>
<div class="col-md-12">
        <canvas id="viewport" width="400" height="600" style="background:url('<?php echo esc_url( get_template_directory_uri() ); ?>/img/subtle_dots.png');">
        </canvas>
        <script language="javascript" type="text/javascript">
/*
            $("#viewport").attr("height",$(window).height());
            $("#viewport").attr("width",$(".col-md-8").width());

            var sys = arbor.ParticleSystem(4, 2, 10, true, 55);
            sys.screen();
            sys.screenPadding(20, 40, 20, 40);
            sys.renderer = Renderer("#viewport");
            sys.screenSize($("col-md-8").width, $(window).height)
            
            // CLIQUE CANVAS
            var canvas = "#viewport";
*/

        </script>
</div>
<div class="col-md-4">
    <?php
        // Start the loop.
        foreach ( 
            $artistsPostsas $post ) : 
            setup_postdata( $post );
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php
            // Post thumbnail.
            //twentyfifteen_post_thumbnail();
        ?>

        <header class="entry-header">
            <?php
                if ( is_single() ) :
                    the_title( '<h1 class="entry-title">', '</h1>' );
                else :
                    the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
                endif;
            ?>
<ul>
            <?php $tax_menu_items = get_the_terms( 0, "movement" );
            foreach ( $tax_menu_items as $tax_menu_item ):?>
            <li>
                Mouvement artistique: <a href="<?php echo get_term_link($tax_menu_item,$tax_menu_item->taxonomy); ?>">
                    <?php echo $tax_menu_item->name; ?>
                </a>
            </li>
            <?php endforeach; ?>
</ul>
                <p><?PHP echo substr( get_post_meta( $post->ID, 'l_artiste_date-de-naissance')[0] ,6,4); ?></p>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php
                /* translators: %s: Name of current post */
                /*the_content( sprintf(
                    __( 'Continue reading %s', 'twentyfifteen' ),
                    the_title( '<span class="screen-reader-text">', '</span>', false )
                ) );*/
                echo "<strong>".$post->post_title."</strong>";
                //print_r($post);

                the_excerpt();

                wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                    'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
                    'separator'   => '<span class="screen-reader-text">, </span>',
                ) );
            ?>
        </div><!-- .entry-content -->

        <?php
            // Author bio.
            /*if ( is_single() && get_the_author_meta( 'description' ) ) :
                get_template_part( 'author-bio' );
            endif;*/
        ?>

        <footer class="entry-footer">
            <?php //twentyfifteen_entry_meta(); ?>
            <?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); ?>
        </footer><!-- .entry-footer -->

    </article><!-- #post-## -->
    <?PHP
		// End the loop.
		endforeach;
    ?>
    
</div> <!-- end .col-md-4 -->

    <div id="main"></div>

<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/chronologie.js"></script>
<script>
var sys = arbor.ParticleSystem(4, 2, 2, true, 55);
$(document).ready(function(){
    /*fProgressBar(1);
    var s = skrollr.init({
            forceHeight:true,
            render: function(data) {
            fProgressBar(data.curTop);
   	    }
    });
    skrollr.menu.init(s);*/
    
    getArtistes( '<?php echo esc_url( home_url( '/' ) ); ?>json_a/artist/' );
    getMouvements( '<?php echo esc_url( home_url( '/' ) ); ?>json_m/movement/' );
    
            $("#viewport").attr("height",$(window).height());
            $("#viewport").attr("width",$(".col-md-8").width());
            
            sys.screen();
            sys.screenPadding(20, 40, 20, 40);
            sys.renderer = Renderer("#viewport");
            sys.screenSize($("col-md-8").width, $(window).height)
            
            // CLIQUE CANVAS
            var canvas = "#viewport";
    
    /*$(function() {
      $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top
            }, 1000);
            return false;
          }
        }
      });
      
      
    });*/
    
});
</script>
<?PHP
    get_footer();
?>
