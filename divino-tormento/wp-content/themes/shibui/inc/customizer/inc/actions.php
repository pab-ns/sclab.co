<?php

/**
 * Inline CSS
 */
function shibui_inline_style() {

    global $theme_options;
    $css = null;

    // Custom CSS
    if ( ! empty( $theme_options['css'] ) ) {
        $css .= wp_filter_nohtml_kses( $theme_options['css'] );
    }

    // Font
    if ( ! empty( $theme_options['font'] ) ) {
        $font = explode( ':', $theme_options['font'] );
        $font_name = str_replace('+', ' ', $font[0] );
        $font_name = "'" . $font_name . "'";

        $css .= 'h1, h2, .main-navigation a, .footer-widgets, .navigation a, input[type="button"], input[type="reset"], input[type="submit"]{ font-family: ' . $font_name .'; }' . "\n";
    }

    // Font Alt
    if ( ! empty( $theme_options['font_alt'] ) ) {
        $font_alt = explode( ':', $theme_options['font_alt'] );
        $font_alt_name = str_replace( '+', ' ', $font_alt[0] );
        $font_alt_name = "'" . $font_alt_name . "'";

        $css .= 'body, p, textarea, input, select, label, h1.site-title, h2.site-description, .entry-title { font-family: ' . $font_alt_name .'; }' . "\n";
    }

    wp_add_inline_style( 'shibui-style', $css );
}
add_action( 'wp_enqueue_scripts', 'shibui_inline_style' );

/**
 * Enqueue Fonts
 */
function shibui_enqueue_fonts() {

    $theme_options = get_option( 'shibui_options' );

    if ( ! empty( $theme_options['font'] ) || ! empty( $theme_options['font_alt'] ) ) {
        $protocol = is_ssl() ? 'https' : 'http';

        // Font Family
        $header = explode( ':', $theme_options['font'] );
        $header_name = str_replace(' ', '+', $header[0] );

        // Font Attributes
        $header_params = ( ! empty( $header[1] ) ) ? ':' . $header[1] : null;

        // Body Font Family
        $body = explode( ':', $theme_options['font_alt'] );
        $body_name = str_replace(' ', '+', $body[0] );

        // Body Font Attributes
        $body_params = ( ! empty( $body[1] ) ) ? ':' . $body[1] : null;

        // Font Separator
        $sep = ( ! empty( $theme_options['font'] ) && ! empty( $theme_options['font_alt'] ) ) ? '|' : '';

        // Final Fonts
        $fonts = ( $theme_options['font'] == $theme_options['font_alt'] ) ? rawurldecode( $header_name . $header_params ) : rawurldecode( $header_name . $header_params . $sep . $body_name . $body_params );

        wp_enqueue_style( 'shibui-custom-fonts', "$protocol://fonts.googleapis.com/css?family={$fonts}", array(), null );
    }
}

add_action( 'wp_enqueue_scripts', 'shibui_enqueue_fonts' );