<?php
/**
 * Twenty Thirteen functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see https://codex.wordpress.org/Theme_Development
 * and https://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link https://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

/*
 * Set up the content width value based on the theme's design.
 *
 * @see twentythirteen_content_width() for template-specific adjustments.
 */
if ( ! isset( $content_width ) )
	$content_width = 604;

/**
 * Add support for a custom header image.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Twenty Thirteen only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6-alpha', '<' ) )
	require get_template_directory() . '/inc/back-compat.php';

/**
 * Twenty Thirteen setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Thirteen supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_setup() {
	/*
	 * Makes Twenty Thirteen available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Thirteen, use a find and
	 * replace to change 'twentythirteen' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'myTheme', get_template_directory() . '/languages' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', twentythirteen_fonts_url() ) );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * This theme supports all available post formats by default.
	 * See https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Navigation Menu', 'twentythirteen' ) );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 604, 270, true );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'twentythirteen_setup' );

/**
 * Return the Google font stylesheet URL, if available.
 *
 * The use of Source Sans Pro and Bitter by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function twentythirteen_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'myTheme' );

	/* Translators: If there are characters in your language that are not
	 * supported by Bitter, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$bitter = _x( 'on', 'Bitter font: on or off', 'myTheme' );

	if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro )
			$font_families[] = 'Source Sans Pro:300,400,700,300italic,400italic,700italic';

		if ( 'off' !== $bitter )
			$font_families[] = 'Bitter:400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_scripts_styles() {
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Adds Masonry to handle vertical alignment of footer widgets.
	if ( is_active_sidebar( 'sidebar-1' ) )
		wp_enqueue_script( 'jquery-masonry' );

	// Loads JavaScript file with functionality specific to Twenty Thirteen.
	//wp_enqueue_script( 'twentythirteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );

	// Add Source Sans Pro and Bitter fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentythirteen-fonts', twentythirteen_fonts_url(), array(), null );

	// Add Genericons font, used in the main stylesheet.
	//wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.03' );

	// Loads our main stylesheet.
	wp_enqueue_style( 'myTheme', get_stylesheet_uri(), array(), '2013-07-18' );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentythirteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentythirteen-style' ), '2013-07-18' );
	wp_style_add_data( 'twentythirteen-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'twentythirteen_scripts_styles' );

/**
 * Register two widget areas.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Widget Area', 'twentythirteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the footer section of the site.', 'twentythirteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary Widget Area', 'twentythirteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentythirteen_widgets_init' );

if ( ! function_exists( 'twentythirteen_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'twentythirteen_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
*
* @since Twenty Thirteen 1.0
*/
function twentythirteen_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'twentythirteen' ) ); ?>
			<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'twentythirteen' ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'twentythirteen_entry_meta' ) ) :
/**
 * Print HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own twentythirteen_entry_meta() to override in a child theme.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . esc_html__( 'Sticky', 'twentythirteen' ) . '</span>';

	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		twentythirteen_entry_date();

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'twentythirteen' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'twentythirteen' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	// Post author
	if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'twentythirteen' ), get_the_author() ) ),
			get_the_author()
		);
	}
}
endif;

if ( ! function_exists( 'twentythirteen_entry_date' ) ) :
/**
 * Print HTML with date information for current post.
 *
 * Create your own twentythirteen_entry_date() to override in a child theme.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param boolean $echo (optional) Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function twentythirteen_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'twentythirteen' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'twentythirteen' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

if ( ! function_exists( 'twentythirteen_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_the_attached_image() {
	/**
	 * Filter the image attachment size to use.
	 *
	 * @since Twenty thirteen 1.0
	 *
	 * @param array $size {
	 *     @type int The attachment height in pixels.
	 *     @type int The attachment width in pixels.
	 * }
	 */
	$attachment_size     = apply_filters( 'twentythirteen_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();
	$post                = get_post();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( reset( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Return the post URL.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return string The Link format URL.
 */
function twentythirteen_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

if ( ! function_exists( 'twentythirteen_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ...
 * and a Continue reading link.
 *
 * @since Twenty Thirteen 1.4
 *
 * @param string $more Default Read More excerpt link.
 * @return string Filtered Read More excerpt link.
 */
function twentythirteen_excerpt_more( $more ) {
	$link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			sprintf( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'twentythirteen' ), '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' )
		);
	return ' &hellip;' /*. $link*/;
}
add_filter( 'excerpt_more', 'twentythirteen_excerpt_more' );
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function twentythirteen_body_class( $classes ) {
	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )
		$classes[] = 'sidebar';

	if ( ! get_option( 'show_avatars' ) )
		$classes[] = 'no-avatars';

	return $classes;
}
add_filter( 'body_class', 'twentythirteen_body_class' );

/**
 * Adjust content_width value for video post formats and attachment templates.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_content_width() {
	global $content_width;

	if ( is_attachment() )
		$content_width = 724;
	elseif ( has_post_format( 'audio' ) )
		$content_width = 484;
}
add_action( 'template_redirect', 'twentythirteen_content_width' );

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function twentythirteen_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'twentythirteen_customize_register' );

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JavaScript handlers to make the Customizer preview
 * reload changes asynchronously.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_customize_preview_js() {
	wp_enqueue_script( 'twentythirteen-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20141120', true );
}
add_action( 'customize_preview_init', 'twentythirteen_customize_preview_js' );

/*
 * Register Mouvement(s) Taxonomy
 */
function movement_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Mouvements', 'Taxonomy General Name', 'mouvement_text_domain' ),
		'singular_name'              => _x( 'Mouvement', 'Taxonomy Singular Name', 'mouvement_text_domain' ),
		'menu_name'                  => __( 'Mouvement', 'mouvement_text_domain' ),
		'all_items'                  => __( 'All Items', 'mouvement_text_domain' ),
		'parent_item'                => __( 'Parent Item', 'mouvement_text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'mouvement_text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'mouvement_text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'mouvement_text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'mouvement_text_domain' ),
		'update_item'                => __( 'Update Item', 'mouvement_text_domain' ),
		'view_item'                  => __( 'View Item', 'mouvement_text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'mouvement_text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'mouvement_text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'mouvement_text_domain' ),
		'popular_items'              => __( 'Popular Items', 'mouvement_text_domain' ),
		'search_items'               => __( 'Search Items', 'mouvement_text_domain' ),
		'not_found'                  => __( 'Not Found', 'mouvement_text_domain' ),
		'no_terms'                   => __( 'No items', 'mouvement_text_domain' ),
		'items_list'                 => __( 'Items list', 'mouvement_text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'mouvement_text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'movement', array( 'artist_post_type' ), $args );

}
add_action( 'init', 'movement_taxonomy', 0 );

/*
 * Register Artiste Post Type
 */
// Register Custom Post Type
function artist_post_type() {

	$labels = array(
		'name'                  => _x( 'Artistes', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Artiste', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Artiste', 'text_domain' ),
		'name_admin_bar'        => __( 'Post Type', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Artist:', 'text_domain' ),
		'all_items'             => __( 'All Artists', 'text_domain' ),
		'add_new_item'          => __( 'Add New Artist', 'text_domain' ),
		'add_new'               => __( 'New Artist', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Artist', 'text_domain' ),
		'update_item'           => __( 'Update Artist', 'text_domain' ),
		'view_item'             => __( 'View Artist', 'text_domain' ),
		'search_items'          => __( 'Search artists', 'text_domain' ),
		'not_found'             => __( 'No artistd found', 'text_domain' ),
		'not_found_in_trash'    => __( 'No artists found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Portrait Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set portrait image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove protrait image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as portrait image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Artiste', 'text_domain' ),
		'description'           => __( 'Artiste information pages', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'tag' ),
		'taxonomies'            => array( 'movement' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-image-filter',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'artist', $args );

}
add_action( 'init', 'artist_post_type', 0 );

/*
 * Custom Artists fields
 */
/**
 * Generated by the WordPress Meta Box Generator at http://goo.gl/8nwllb
 */
class Rational_Meta_Box {
	private $screens = array(
		'artist',
	);
	private $fields = array(
		array(
			'id' => 'date-de-naissance',
			'label' => 'date de naissance',
			'type' => 'date',
		),
		array(
			'id' => 'date-de-mort',
			'label' => 'date de mort',
			'type' => 'date',
		),
		array(
			'id' => 'biographie-url',
			'label' => 'biographie url',
			'type' => 'url',
		),
	);

	/**
	 * Class construct method. Adds actions to their respective WordPress hooks.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
	}

	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 * Goes through screens (post types) and adds the meta box.
	 */
	public function add_meta_boxes() {
		foreach ( $this->screens as $screen ) {
			add_meta_box(
				'l-artiste',
				__( 'L\'artiste', 'artist-metadox' ),
				array( $this, 'add_meta_box_callback' ),
				$screen,
				'advanced',
				'high'
			);
		}
	}

	/**
	 * Generates the HTML for the meta box
	 * 
	 * @param object $post WordPress post object
	 */
	public function add_meta_box_callback( $post ) {
		wp_nonce_field( 'l_artiste_data', 'l_artiste_nonce' );
		echo 'Informations de base';
		$this->generate_fields( $post );
	}

	/**
	 * Generates the field's HTML for the meta box.
	 */
	public function generate_fields( $post ) {
		$output = '';
		foreach ( $this->fields as $field ) {
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value = get_post_meta( $post->ID, 'l_artiste_' . $field['id'], true );
			switch ( $field['type'] ) {
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$field['type'] !== 'color' ? 'class="regular-text"' : '',
						$field['id'],
						$field['id'],
						$field['type'],
						$db_value
					);
			}
			$output .= $this->row_format( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	/**
	 * Generates the HTML for table rows.
	 */
	public function row_format( $label, $input ) {
		return sprintf(
			'<tr><th scope="row">%s</th><td>%s</td></tr>',
			$label,
			$input
		);
	}
	/**
	 * Hooks into WordPress' save_post function
	 */
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['l_artiste_nonce'] ) )
			return $post_id;

		$nonce = $_POST['l_artiste_nonce'];
		if ( !wp_verify_nonce( $nonce, 'l_artiste_data' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		foreach ( $this->fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['type'] ) {
					case 'email':
						$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
						break;
					case 'text':
						$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
						break;
				}
				update_post_meta( $post_id, 'l_artiste_' . $field['id'], $_POST[ $field['id'] ] );
			} else if ( $field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, 'l_artiste_' . $field['id'], '0' );
			}
		}
	}
}
new Rational_Meta_Box;

/*
 * DATE CONVERTER
 * $youDMYinput = DD/MM/YYY
 * return : timestamp
 */
function dateToTimestamp($yourDMYinput) {
$dt = DateTime::createFromFormat('d/m/Y', $yourDMYinput);
return $dt->getTimestamp(); # or $dt->format('U');
}

/**
 * Add Photographer Name and URL fields to media uploader
 *
 * @param $form_fields array, fields to include in attachment form
 * @param $post object, attachment record in database
 * @return $form_fields, modified form fields
 */
 
function be_attachment_field_credit( $form_fields, $post ) {
	$form_fields['be-photographer-name'] = array(
		'label' => 'Année de l\'oeuvre',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'be_photographer_name', true ),
		'helps' => 'If provided, media will be displayed as artist work',
	);
	
	/*$form_fields['be-photographer-url'] = array(
		'label' => 'Photographer URL',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'be_photographer_url', true ),
		'helps' => 'If provided, photographer name will link here',
	);*/
	
	return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'be_attachment_field_credit', 10, 2 );
/**
 * Save values of Photographer Name and URL in media uploader
 *
 * @param $post array, the post data for database
 * @param $attachment array, attachment fields from $_POST form
 * @return $post array, modified post data
 */
function be_attachment_field_credit_save( $post, $attachment ) {
	if( isset( $attachment['be-photographer-name'] ) )
		update_post_meta( $post['ID'], 'be_photographer_name', $attachment['be-photographer-name'] );
		
	/*if( isset( $attachment['be-photographer-url'] ) )
		update_post_meta( $post['ID'], 'be_photographer_url', $attachment['be-photographer-url'] );*/
	
	return $post;
}
add_filter( 'attachment_fields_to_save', 'be_attachment_field_credit_save', 10, 2 );

/*
 * Register Artists tag
 */
register_taxonomy( 
    'artistTag',
    'artist',
    array(
        'label' => 'Étiquettes',
        'labels' => array(
            'name' => 'Étiquettes',
            'singular_name' => 'Étiquette',
            'all_items' => 'Toutes les étiquettes',
            'edit_item' => 'Éditer l\'étiquette',
            'view_item' => 'Voir l\'étiquette',
            'update_item' => 'Mettre à jour l\'étiquette',
            'add_new_item' => 'Ajouter une étiquette',
            'new_item_name' => 'Nouvelle étiquette',
            'search_items' => 'Rechercher parmi les étiquettes',
            'popular_items' => 'Étiquettes les plus utilisées'),
        'hierarchical' => false
    ) 
);
register_taxonomy_for_object_type( 'artistTag', 'artist' );

/*
 * PLUGINS IMPORTATION
 */

/**
 * Class Simple_Json_Api
 */
class Simple_Json_Api {
	/**
	 * The top level argument for the endpoint.
	 * ex http://example.com/myjson/post/1
	 *
	 * @var string
	 */
	public $endpoint_base = 'json_a';
	/**
	 * Only provide json data for the post_types in this array.
	 *
	 * @var array
	 */
	public $allowed_post_types = array( 'artist' );
	/**
	 * Default WP_Query arguments for retrieving posts.
	 * Here you can limit the number of items returned, or change the order
	 * of items returned, etc.
	 *
	 * @var array
	 */
	public $default_query_arguments = array(
		'posts_per_page' => 10,
		'post_status' => array( 'publish' ),
		'orderby' => 'date',
		'order' => 'ASC',
		'ignore_sticky_posts' => true
	);
	/**
	 * Create an array of data for a single post that will be part
	 * of the json response.
	 *
	 * @param $post
	 */
	static public function make_json_data( $post ){
		// featured image urls
		$image_id = get_post_thumbnail_id( $post->ID );
		$image_full  = wp_get_attachment_image_src( $image_id, 'full' );
		$image_thumb = wp_get_attachment_image_src( $image_id, 'thumbnail' );
		$item = array(
			// The global $post object is set, so we can use template tags.
			// Additionally, we have the object, so we could get raw data.
			'title' => get_the_title(),
			'title_raw' => $post->post_title,
			'content' => get_the_content(),
			'content_raw' => $post->post_content,
			'date' => get_the_date(),
			'date_raw' => $post->post_date,
			// meta values
			'my_meta_value' => get_post_meta( $post->ID, 'my_meta_value', TRUE ),
			// all meta values ( not recommended unless you're sure you want to do this )
			//'meta' => get_post_meta( $post->ID ),
			// default image values
			'image_id' => !empty( $image_id ) ? $image_id : false,
			'image_full' => !empty( $image_full[0] ) ? $image_full[0] : false,
			'image_thumb' => !empty( $image_thumb[0] ) ? $image_thumb[0] : false,
			// taxonomy data
			'categories' => get_the_terms( $post->ID, 'category' ),
			'tags' => get_the_terms( $post->ID, 'post_tag' ),
		);
		// OPTIONAL:
		// Depending on your plugin organizational structure, you may want each
		// post_type to be able to control its own json data.  In that case, you 
		// could use a dynamic hook like this to provide that flexibility.
		// return apply_filters( "myjson_api_{$post->post_type}_data", $item, $post );
		return $item;
	}
	/**
	 * Hook the plugin into WordPress
	 */
	static public function register(){
		$plugin = new self();
		add_action( 'init', array( $plugin, 'add_endpoint' ) );
		add_action( 'template_redirect', array( $plugin, 'handle_endpoint' ) );
	}
	/**
	 * Create our json endpoint by adding new rewrite rules to WordPress
	 */
	function add_endpoint(){
		$post_type_tag = $this->endpoint_base . '_type';
		$post_id_tag   = $this->endpoint_base . '_id';
		// Add new rewrite tags to WP for our endpoint's post_type
		// and post_id arguments
		add_rewrite_tag( "%{$post_type_tag}%", '([^&]+)' );
		add_rewrite_tag( "%{$post_id_tag}%", '([0-9]+)' );
		// Add the rules that look for our rewrite tags in the route query.
		// Most specific rule first, then fallback to the general rule
		// specific rule finds a single post
		// http://example.com/myjson/post/1
		add_rewrite_rule(
			$this->endpoint_base . '/([^&]+)/([0-9]+)/?',
			'index.php?'.$post_type_tag.'=$matches[1]&'.$post_id_tag.'=$matches[2]',
			'top' );
		// general rule finds "all" (post_per_page) of a given post_type
		// http://example.com/myjson/post
		add_rewrite_rule(
			$this->endpoint_base . '/([^&]+)/?',
			'index.php?'.$post_type_tag.'=$matches[1]',
			'top' );
	}
	/**
	 * Handle the request of an endpoint
	 */
	function handle_endpoint(){
        
		global $wp_query;
		// get the query args and sanitize them for confidence
		$type = sanitize_text_field( $wp_query->get( $this->endpoint_base . '_type' ) );
		$id   = intval( $wp_query->get( $this->endpoint_base . '_id' ) );
		
		// only allowed post_types
		if ( ! in_array( $type, $this->allowed_post_types ) ) {
			return;
		}
		// the post_type of the given id must match the requested post_type
		if ( $id && get_post_type( $id ) != $type ) {
			return;
		}
		
		// start with our default query arguments
		$args = $this->default_query_arguments;
		// add the post_type
		$args['post_type'] = array( $type );
		// add the post ID if specified
		if ( $id ) {
			$args['post__in'] = array( $id );
		}
		$query = new WP_Query( $args );
		$data = array();
        $dataExport = array();
        $ii = 0;
		// loop through the posts and build our endpoint data arrays
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				global $post;
                $ii++;
                $movement = null;
                
                /*
                 * GET MOVEMENT
                 */
                /*$tax_menu_items = get_categories( array('taxonomy' => 'movement') );
                    foreach ( $tax_menu_items as $tax_menu_item ):
                        $movement = $tax_menu_item->name; // THE MOVMENT
                endforeach;*/
                
                
               /* $args = array('taxonomy' => 'movement');
                $tax_menu_items = get_categories( $args );
            foreach ( $tax_menu_items as $tax_menu_item ):
                get_term_link($tax_menu_item,$tax_menu_item->taxonomy); 
                $tax_menu_item->name;
            endforeach;*/
                
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
                
                $dataExport[] = array(
                    "artisteID" => $post->ID,
                    "artiste" => $post->post_title,
                    "start" => 1808,
                    "end" => 1879,
                    /*"artisteNom" => "Daumier",
                    "artistePrenom" => "Honoré",
                    "work" => "graveur, caricaturiste, peintre, sculpteur français.",
                    "description" => "",
                    "oeuvreDate" => "1831",
                    "oeuvreTitre" => "Gargantua",
                    "oeuvreCartel" => "Caricature de Louis-Philippe ",
                    "source" => "http://fr.wikipedia.org/wiki/Honor%C3%A9_Daumier",*/
                    "oeuvreUrl" => esc_url ( $attachment_image_src ),
                    "artisteUrl" => esc_url( wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) ),
                    "permalink" => esc_url( get_permalink() )
                );
			}
			wp_reset_query();
		}
		// data is built. print as json and stop
		wp_send_json( $dataExport ); exit;
	}
}
// huzzah!
Simple_Json_Api::register();

/**
 * Class Simple_Json_Api2
 */
class Simple_Json_Api2 {
	/**
	 * The top level argument for the endpoint.
	 * ex http://example.com/myjson/post/1
	 *
	 * @var string
	 */
	public $endpoint_base = 'json_m';
	/**
	 * Only provide json data for the post_types in this array.
	 *
	 * @var array
	 */
	public $allowed_post_types = array( 'movement' );
    public $movement = null;

    /**
	 * Hook the plugin into WordPress
	 */
	static public function register(){
		$plugin = new self();
		add_action( 'init', array( $plugin, 'add_endpoint' ) );
		add_action( 'template_redirect', array( $plugin, 'handle_endpoint' ) );
	}
    
	/**
	 * Create an array of data for a single post that will be part
	 * of the json response.
	 *
	 * @param $post
	 */
	static public function make_json_data( $post ){
        
        /*$default_query_arguments = array(
        'tax_query' => array(
            array(
                'taxonomy' => 'movement',
                'field' => 'slug',
                'terms' => $movement
            )
        )
    );*/
        
		$item = array(
			// The global $post object is set, so we can use template tags.
			// Additionally, we have the object, so we could get raw data.
			'title' => "the title"//get_the_title(),
		);
		// OPTIONAL:
		// Depending on your plugin organizational structure, you may want each
		// post_type to be able to control its own json data.  In that case, you 
		// could use a dynamic hook like this to provide that flexibility.
		// return apply_filters( "myjson_api_{$post->post_type}_data", $item, $post );
		return $item;
	}
    
    /*
     *
     */
    function get_artists_by_movement($movement){
        global $wp_query;
        global $post;
        
        $args = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'movement',
                    'field' => 'slug',
                    'terms' => $movement
                )
            )
        );
        $query = new WP_Query( $args );
        $artists = array();//array();
        while ( $query->have_posts() ) : $query->the_post();
            $artists[] = $post->ID;
            //$artists  = $post->post_title;
        endwhile;
        //wp_reset_postdata();
        return( $artists );
    }
    
	/**
	 * Create our json endpoint by adding new rewrite rules to WordPress
	 */
	function add_endpoint(){
		$post_type_tag = $this->endpoint_base . '_type';
		$post_id_tag   = $this->endpoint_base . '_id';
		// Add new rewrite tags to WP for our endpoint's post_type
		// and post_id arguments
		add_rewrite_tag( "%{$post_type_tag}%", '([^&]+)' );
		//add_rewrite_tag( "%{$post_id_tag}%", '([0-9]+)' );
		// Add the rules that look for our rewrite tags in the route query.
		// Most specific rule first, then fallback to the general rule
		// specific rule finds a single post
		// http://example.com/myjson/post/1
		/*add_rewrite_rule(
			$this->endpoint_base . '/([^&]+)/([0-9]+)/?',
			'index.php?'.$post_type_tag.'=$matches[1]&'.$post_id_tag.'=$matches[2]',
			'top' );*/
		// general rule finds "all" (post_per_page) of a given post_type
		// http://example.com/myjson/post
		add_rewrite_rule(
			$this->endpoint_base . '/([^&]+)/?',
			'index.php?'.$post_type_tag.'=$matches[1]',
			'top' );
	}
	/**
	 * Handle the request of an endpoint
	 */
	function handle_endpoint(){
        
		global $wp_query;
		// get the query args and sanitize them for confidence
		$type = sanitize_text_field( $wp_query->get( $this->endpoint_base . '_type' ) );
        
		// only allowed post_types
		if ( ! in_array( $type, $this->allowed_post_types ) ) {
			return;
		}        
        
        $dataExport = array();
        /*$taxonomies = get_terms("movement"); 
        foreach ( $taxonomies as $taxonomy ) {
            $artists[$taxonomy->name] = get_artists_by_movement($taxonomy->name);
        }*/
        //$dataExport = array("test","test2");
        
        // Get all terms WP_Query argument (as of 3.1)
        //$taxonomy_query = new WP_Query( array( 'taxonomy' => 'movement' ) );
        
        $taxonomies = get_terms("movement");
        foreach ( $taxonomies as $taxonomy ) {
            $artists = $this->get_artists_by_movement( $taxonomy->name );
            $dataExport[] = array(
                "mouvementID" => $taxonomy->term_id,
                "mouvement" => $taxonomy->name,     
                "start" => 2016,
                "end" => 2017,
                "color" => "4C4C4C",
                "description" => $taxonomy->description,
                "artistesObj" => $artists,
                "artistes" => implode(",", $artists),
                "colorBis" => null,
                "image" => "",
                "contexte" => "",
                "contexteDate" => "",
                "permalink" => esc_url( get_term_link ($taxonomy->term_id, "movement" ) )
            );
            // json_encode( get_artists_by_movement($taxonomy->name) );
        }
        
        
		wp_send_json( $dataExport ); exit;
        
	}
}
// huzzah!
Simple_Json_Api2::register();


/**
 * Generate custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML.
 */
function wpdocs_my_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <div>@<label class="screen-reader-text" for="s">' . __( 'Search for:' ) . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__( 'Search' ) .'" />
    </div>
    </form>';
    $form = '
  <nav style="background:transparent">
    <div class="nav-wrapper">
      <form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '">
        <div class="input-field">
          <input id="search" name="s" type="search" value="' . get_search_query() . '" required>
          <label for="search"><i class="material-icons">search</i></label>
          <i class="material-icons">close</i>
        </div>
      </form>
    </div>
  </nav>';
  
    return $form;
}
add_filter( 'get_search_form', 'wpdocs_my_search_form' );