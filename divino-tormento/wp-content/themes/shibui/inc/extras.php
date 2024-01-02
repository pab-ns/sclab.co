<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Shibui
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function shibui_body_classes( $classes ) {

	global $theme_options;

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	if ( is_front_page() && ! empty ( $theme_options['slideshow'] ) && 'show' == $theme_options['slideshow_showhide'] ) {
		$classes[] = 'slideshow_active';
	}

	if ( is_active_sidebar( 'sidebar-1' ) && is_page_template( 'page-sidebar.php' ) || is_single() ) {
		$classes[] = 'has-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'shibui_body_classes' );

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function shibui_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'shibui' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'shibui_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function shibui_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'shibui_render_title' );
endif;

/**
 * Filter the excerpt length
 * @param  $length int
 * @return int
 */
function shibui_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'shibui_excerpt_length', 999 );

/**
 * Alter the read more text
 * @param  $more string
 * @return string
 */
function shibui_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'shibui_excerpt_more');

/**
 * Set the theme option variable for use throughout theme.
 */
function shibui_get_theme_options() {

    $default_options = array(
        'color'                     => 'default',
        'slideshow_showhide'        => 'hide',
        'slideshow_autostart'       => 'true',
        'slideshow_animation'       => 'fade',
        'slideshow_dots_showhide'   => 'true',
        'slideshow_title_showhide'  => 'show',
        'portfolio_showhide'        => 'show',
        'portfolio_grid'            => 'one-third-col',
        'portfolio_items'           => '9',
        'blog_items'           		=> '4',
        'blog_showhide'             => 'show',
        'accent_color'              => '#666666',
        'dark_color'                => '#111111',
        'font'                      => '',
        'font_alt'                  => ''
    );

    $theme_options = wp_parse_args(
        get_option( 'shibui_options', $default_options ),
        $default_options
    );

    return apply_filters( 'shibui_get_theme_options_filter', $theme_options );
}

function custom_excerpt_length( $length ) {
	return 10;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
