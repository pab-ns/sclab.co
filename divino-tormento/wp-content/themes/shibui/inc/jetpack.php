<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package Shibui
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function shibui_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'type'		=> 'click',
		'render'    => 'shibui_infinite_scroll_render',
		'footer'    => 'page',
		'footer_widgets' => array( 'footer-1' )
	) );
} // end function shibui_jetpack_setup
add_action( 'after_setup_theme', 'shibui_jetpack_setup' );


function shibui_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( shibui_is_jetpack_portfolio_archive() ) {
			get_template_part( 'template-parts/portfolio', 'grid' );
		} else {
			get_template_part( 'template-parts/blog', 'grid' );
		}
	}
} // end function shibui_infinite_scroll_render
