<?php
/**
 * Shibui functions and definitions
 *
 * @package Shibui
 */

if ( ! function_exists( 'shibui_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function shibui_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Shibui, use a find and replace
	 * to change 'shibui' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'shibui', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	set_post_thumbnail_size( 300, 300, true );
    add_image_size( 'portrait', 600, 800, true );
    add_image_size( 'square', 600, 600, true );
    add_image_size( 'landscape', 800, 600, true );
    add_image_size( 'nocrop', 600, '', false );
    add_image_size( 'blog-size', 800, 300, true );
    add_image_size( 'xl', 1200, 768, true );


	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'shibui' ),
		'social' => esc_html__( 'Social Menu', 'shibui' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'shibui_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	/**
     * Enable Sell Media if the plugin is activated
     */
    if ( class_exists( 'SellMedia' ) ) {
        add_theme_support( 'sell_media' );
    }
}
endif; // shibui_setup
add_action( 'after_setup_theme', 'shibui_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function shibui_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'shibui_content_width', 1200 );
}
add_action( 'after_setup_theme', 'shibui_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function shibui_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'shibui' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Call to Action', 'shibui' ),
		'id'            => 'call-to-action-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'shibui' ),
		'id'            => 'footer-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

}
add_action( 'widgets_init', 'shibui_widgets_init' );


/**
 * Counts the number of widgets in a specific sidebar
 *
 * @param   string  $id
 * @return  integer number of widgets in the sidebar
 */
function shibui_count_widgets( $id ) {
    $count = 0;
    $sidebars_widgets = wp_get_sidebars_widgets();
    if ($sidebars_widgets) {
	    $count = ( int ) count( ( array ) $sidebars_widgets[ $id ] );
	    return $count;
	} else {
		return 1;
	}
}

/**
 * Widget column class helper
 *
 * @param   string  $id
 * @return  string  grid class
 */
function shibui_widget_column_class( $footer_id ) {

    $count = shibui_count_widgets( $footer_id );
    $class = '';
    if ( $count >= 4 ) {
       	$class .= 'one-forth-col';
    } elseif ( $count == 3 ) {
        $class .= 'one-third-col';
    } elseif ( $count == 2 ) {
        $class .= 'half-col';
    } else {
        $class .= 'full-col';
    }

    return $class;
}


/**
 * Enqueue scripts and styles.
 */
function shibui_scripts() {

	$theme_options = shibui_get_theme_options();
	$grid = $theme_options['portfolio_grid'];


	wp_enqueue_style( 'shibui-genericons', get_template_directory_uri() . '/inc/genericons/genericons.css', array(), '3.3.1' );

	wp_enqueue_style( 'shibui-style', get_stylesheet_uri(), '', '110' );

	wp_enqueue_script( 'shibui-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20150506', true );

	wp_enqueue_script( 'shibui-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '20150206', true );

	wp_enqueue_script( 'shibui-flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ), '20150206', true );

	wp_enqueue_script( 'jquery-masonry', array( 'jquery' ), '20150208', true );

	wp_enqueue_script( 'shibui-masonryjs', get_template_directory_uri() . '/js/jquery.load-masonry.js', array( 'jquery' ), '20150408', true );

   	wp_enqueue_script( 'shibui-themejs', get_template_directory_uri() . '/js/jquery.theme.js', array( 'jquery' ), '20150407', true );

	wp_enqueue_script( 'shibui-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// locaize js for front end scripts
    wp_localize_script( 'shibui-themejs', 'shibui_theme', array(
        'slideshow_animation' => ( $theme_options['slideshow_animation'] == 'fade' ) ? 'fade' : 'slide',
        'slideshow_autostart' => ( $theme_options['slideshow_autostart'] == 'true' ) ? true : false,
        'slideshow_dots_nav' => ( $theme_options['slideshow_dots_showhide'] == 'true' ) ? true : false
    ) );

	// localize js for admin scripts
    wp_localize_script( 'shibui_customizer', 'shibui_customizer', array(
        'theme' => 'shibui'
    ) );

}
add_action( 'wp_enqueue_scripts', 'shibui_scripts' );



/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * GPP Theme Updater
 */
require( get_template_directory() . '/inc/updater.php' );

$license_manager = new GPP_Updater(
	'shibui',      // The "slug" of the theme or plugin. This must match exactly the ZIP download slug.
	'Shibui',      // A pretty name for your plugin/theme. Used for settings screens.
	'shibui',      // The plugin/theme text domain for localization.
	$type = 'theme',   // "theme" or "plugin" depending on which you are creating.
	$plugin_file = ''  // The main file of your plugin (only needed for plugins).
);

/**
 * Load Theme Options.
 */
global $theme_options;
$theme_options = shibui_get_theme_options();
