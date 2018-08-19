<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<div class="page-title">
            <h1>
				<?php
                    the_search_query();
					//the_archive_title( '', '' );
                    //the_archive_description( '<span>', '</span>' );
                ?>
            </h1><!-- .page-header -->
                
  <div class="fixed-action-btn horizontal" style="top: 45px; right: 24px; z-index:0;">
    <a href="#slideshow" class="slideshowOn btn-floating btn-large red">
      <i class="large material-icons">slideshow</i>
    </a>
  </div>
                
            </div>
            <div class="row">
			<?php
            
            $slides = array();
                
			// Start the Loop.
			while ( have_posts() ) : the_post();
                
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'content', get_post_format() );

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
				'next_text'          => __( 'Next page', 'twentyfifteen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( '404', 'none' );

		endif;
		?>
        </div>
            
        <div id="slideshow" class="slider fullscreen hide" style="position:fixed;top:0;left:0;right:0;bottom:0;width:100%;height:100%;overflow:hidden;z-index:10;">
            <div class="fixed-action-btn horizontal" style="top: 1em; left: 1em;height:55px;width:165px;">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/artefactlogo.png" height="55px" alt="artefact logo">
            </div>
              <div class="fixed-action-btn horizontal" style="top: 1em; right: 1em;">
                <a href="#slideshow" class="slideshowOn btn-floating btn-large red">
                  <i class="large material-icons">clear</i>
                </a>
              </div>
            <ul class="slides" style="z-index:11;">

                <?PHP
                    while ( have_posts() ) : the_post();

                        /*
                         * Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part( 'slider', get_post_format() );

                    // End the loop.
                    endwhile;
                ?>
            </ul>
        </div>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

    <script>
        jQuery(document).ready(function(){
            jQuery('#slideshow').hide(1);
            jQuery(".slideshowOn").click(function() { 

                if( jQuery('#slideshow.hide').hasClass("hide") ){
                    jQuery('#slideshow').removeClass("hide");
                    jQuery("body").css("overflow","hidden");
                    $('.slider').slider({full_width: true});
                    jQuery(".indicators").css("top","30px");
                    jQuery(".indicators").css("z-index","11");
                    jQuery(".indicators").removeProp("bottom");
                }else{
                    $('.slider').slider('pause');
                    jQuery('#slideshow').addClass("hide");
                    jQuery("body").css("overflow","auto");
                }
                return false;
            });
             // $('.slider').slider({full_width: true});

        });
    </script>

<?php get_footer(); ?>
