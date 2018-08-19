<?php
/**
 * The template for displaying 404 page
 *
 **/

get_header(); ?>

<div class="page-title">
    <h1>
        Page introuvable
    </h1>
    
</div>

<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/404.gif" style="position:absolute;top:0;right:0;bottom:0;left:0;width:100%;max-height:100%;z-index:-1;">
<?PHP
get_footer(); ?>