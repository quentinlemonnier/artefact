<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<!--<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">-->
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/lib/js/html5.js"></script>
	<![endif]-->
    
    <!--<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/lib/bootstrap/css/bootstrap.min.css">-->
    <!--<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/lib/bootstrap/css/bootstrap-theme.min.css">-->
    <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/font/fonts.css">
    
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
    
    <!-- material -->
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
    
    <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/styleChronologie.css">
    
      <!-- Compiled and minified JavaScript -->
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
    
    <!--<script lanuage="javascript" type="text/javascript" src="http://code.jquery.com/jquery-2.2.0.min.js"></script>-->
        <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>-->
        <!-- DATAVIZ -->
            <script language="javascript" type="text/javascript" src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/lib/arbor.js" ></script>
            <script language="javascript" type="text/javascript" src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/lib/graphics.js" ></script>
            <script language="javascript" type="text/javascript" src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/chronologie-pop.js" ></script>
            <script language="javascript" type="text/javascript" src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/lib/renderer.js" ></script>
			<!--<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">-->
        <!-- END DATAVIZ -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
    
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

    <header id="masthead" role="banner">
        
        <nav class="sidebar">
          <div class="">
            <div class="brand"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/artefactlogo.png" width="100%" alt="artefact logo"><?php //bloginfo( 'name' ); ?></a></div>
            <div><?php /*
					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; ?></p>
					<?php endif;*/
				?></div>
            <div class="search">
                <?php get_search_form(); ?>
            </div>
                <?PHP
                    $terms = get_terms( 'movement' );

                    echo '<ul class="sidelink">';

                    echo '<li><a href="'. esc_url( home_url( '/' ) ) .'" rel="home">Accueil</a></li>';

                    foreach ( $terms as $term ) {

                        // The $term is an object, so we don't need to specify the $taxonomy.
                        $term_link = get_term_link( $term );

                        // If there was an error, continue to the next term.
                        if ( is_wp_error( $term_link ) ) {
                            continue;
                        }

                        // We successfully got a link. Print it out.
                        echo '<li><a href="' . esc_url( $term_link ) . '">' . $term->name . '</a></li>';
                    }

                    echo '</ul>';
                ?>
          </div>
        </nav>
        <div style="position:absolute;bottom:20px;left:20px;width:200px; height:200px;opacity:0.2"></div>
    </header><!-- .site-header -->

    <!--<?php get_sidebar(); ?>-->

	<div id="content" class="wrap">
