<?php

/**
 * @package Shibui Customizer
 * @version 1.0
 */

/**
 * Load customizer functionality
 */
require dirname( __FILE__ ) . '/inc/actions.php';
require dirname( __FILE__ ) . '/inc/customizer-extends.php';
require dirname( __FILE__ ) . '/inc/fonts.php';
require dirname( __FILE__ ) . '/inc/colors.php';

/**
 * Use Color class
 */
use Mexitek\PHPColors\Color;

/**
 * Implement support for the Customizer
 */
function shibui_customize_register( $wp_customize ) {

    /**
    * Common variables used below
    */
    $theme          = 'shibui';
    $color_scheme   = shibui_get_color_scheme();
    $type           = 'option'; // 'option' or 'theme_mod'

    /**
     * Enable live update for default options
     */
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
    $wp_customize->remove_control( 'header_textcolor' );

    /**
    * Panels
    *
    * Panels contain sections.
    * Sections contain settings.
    * Each setting has a control.
    */

    $general_panel = $theme .'_general';
    $wp_customize->add_panel( $general_panel, array(
        'title'     => __( 'General', 'shibui' ),
        'priority'  => 10
    ) );

    $typography_panel = $theme .'_typography';
    $wp_customize->add_panel( $typography_panel, array(
        'title'     => __( 'Typography', 'shibui' ),
        'priority'  => 20
    ) );

    $colors_panel = $theme .'_colors';
    $wp_customize->add_panel( $colors_panel, array(
        'title'     => __( 'Colors', 'shibui' ),
        'priority'  => 30
    ) );

    $header_panel = $theme .'_header';
    $wp_customize->add_panel( $header_panel, array(
        'title'     => __( 'Header', 'shibui' ),
        'priority'  => 40
    ) );

    $slideshow_panel = $theme .'_slideshow';
    $wp_customize->add_panel( $slideshow_panel, array(
        'title'     => __( 'Slideshow', 'shibui' ),
        'priority'  => 50
    ) );

    $portfolio_panel = $theme .'_portfolio';
    $wp_customize->add_panel( $portfolio_panel, array(
        'title'     => __( 'Portfolio', 'shibui' ),
        'priority'  => 60
    ) );

    $blog_panel = $theme .'_blog';
    $wp_customize->add_panel( $blog_panel, array(
        'title'     => __( 'Blog', 'shibui' ),
        'priority'  => 70
    ) );


    /**
    * Sections & Settings
    *
    * Panels contain sections.
    * Sections contain settings.
    * Each setting has a control.
    */

    /**
     * Site Title & Tagline Section
     */
    $wp_customize->add_section( 'title_tagline', array(
        'title'         => __( 'Site Title & Tagline', 'shibui' ),
        'priority'      => 10,
        'panel'         => $header_panel
    ) );

    /**
     * Logo & Favicon Section
     */
    $wp_customize->add_section( 'logo', array(
        'title'         => __( 'Logo & Favicon', 'shibui' ),
        'priority'      => 20,
        'panel'         => $header_panel
    ) );

    // Logo Setting
    $wp_customize->add_setting( $theme .'_options[logo]', array(
        'default'       => '',
        'type'          => $type,
    ) );

    // Logo Control
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $theme .'_logo', array(
        'label'         => __( 'Logo', 'shibui' ),
        'section'       => 'logo',
        'settings'      => $theme .'_options[logo]'
    ) ) );

    // Favicon Setting
    $wp_customize->add_setting( $theme .'_options[favicon]', array(
        'default'       => '',
        'type'          => $type,
        'transport'     => 'postMessage'
    ) );

    // Favicon Control
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $theme .'_favicon', array(
        'label'         => __( 'Favicon', 'shibui' ),
        'section'       => 'logo',
        'settings'      => $theme .'_options[favicon]'
    ) ) );

    /**
     * Static Front Page Section
     */
    $wp_customize->add_section( 'static_front_page', array(
        'title'         => __( 'Static Front Page', 'shibui' ),
        'priority'      => 90,
        'panel'         => $general_panel
    ) );

    /**
     * Slideshow Section
     */
    $wp_customize->add_section( 'slideshow_options', array(
        'title'         => __( 'Slideshow Options', 'shibui' ),
        'priority'      => 50,
        'panel'         => $slideshow_panel
    ) );

    // Slideshow Show/Hide Setting
    $wp_customize->add_setting( $theme .'_options[slideshow_showhide]', array(
        'default'       => 'hide',
        'type'          => $type,
    ) );

    // Slideshow Show/Hide Control
    $wp_customize->add_control( $theme .'slideshow_showhide', array(
        'label'         => __( 'Slideshow Section', 'shibui' ),
        'section'       => 'slideshow_options',
        'settings'      => $theme .'_options[slideshow_showhide]',
        'type'          => 'select',
        'choices'       => array(
            'show'      => __( 'Show', 'shibui' ),
            'hide'     => __( 'Hide', 'shibui' )
        )
    ) );

    // Slideshow Setting
    $wp_customize->add_setting( $theme .'_options[slideshow]', array(
        'default'       => '',
        'type'          => $type
    ) );

    // Slideshow Control
    $wp_customize->add_control( new Shibui_Multi_Image_Control( $wp_customize, $theme . '_slideshow', array(
        'label'         => __( 'Slideshow Images', 'shibui' ),
        'section'       => 'slideshow_options',
        'settings'      => $theme .'_options[slideshow]',
        'type'          => 'multi-image'
    ) ) );

    // Slideshow Autostart Setting
    $wp_customize->add_setting( $theme .'_options[slideshow_autostart]', array(
        'default'       => 'true',
        'type'          => $type,
    ) );

    // Slideshow Autostart Control
    $wp_customize->add_control( $theme .'_slideshow_autostart', array(
        'label'         => __( 'Slideshow Autostart', 'shibui' ),
        'section'       => 'slideshow_options',
        'settings'      => $theme .'_options[slideshow_autostart]',
        'type'          => 'select',
        'choices'       => array(
            'true'      => __( 'Auto start', 'shibui' ),
            'false'     => __( 'Click start', 'shibui' )
        )
    ) );

    // Slideshow Animation Setting
    $wp_customize->add_setting( $theme .'_options[slideshow_animation]', array(
        'default'       => 'fade',
        'type'          => $type,
    ) );

    // Slideshow Animation Control
    $wp_customize->add_control( $theme .'_slideshow_animation', array(
        'label'         => __( 'Slideshow Animation', 'shibui' ),
        'section'       => 'slideshow_options',
        'settings'      => $theme .'_options[slideshow_animation]',
        'type'          => 'select',
        'choices'       => array(
            'fade'      => __( 'Fade', 'shibui' ),
            'slide'     => __( 'Slide', 'shibui' )
        )
    ) );


    // Slideshow Dots Show/Hide Setting
    $wp_customize->add_setting( $theme .'_options[slideshow_dots_showhide]', array(
        'default'       => 'true',
        'type'          => $type,
    ) );

    // Slideshow Dots Show/Hide Control
    $wp_customize->add_control( $theme .'slideshow_dots_showhide', array(
        'label'         => __( 'Dot Navigation', 'shibui' ),
        'section'       => 'slideshow_options',
        'settings'      => $theme .'_options[slideshow_dots_showhide]',
        'type'          => 'select',
        'choices'       => array(
            'true'      => __( 'Show', 'shibui' ),
            'false'     => __( 'Hide', 'shibui' )
        )
    ) );

    // Slideshow Title Show/Hide Setting
    $wp_customize->add_setting( $theme .'_options[slideshow_title_showhide]', array(
        'default'       => 'show',
        'type'          => $type,
    ) );

    // Slideshow Title Show/Hide Control
    $wp_customize->add_control( $theme .'slideshow_title_showhide', array(
        'label'         => __( 'Slideshow Title', 'shibui' ),
        'section'       => 'slideshow_options',
        'settings'      => $theme .'_options[slideshow_title_showhide]',
        'type'          => 'select',
        'choices'       => array(
            'show'      => __( 'Show', 'shibui' ),
            'hide'     => __( 'Hide', 'shibui' )
        )
    ) );

    /**
     * Portfolio Section
     */

    $message = '';
    if( ! post_type_exists( 'jetpack-portfolio' ) ) {
        $message = '<span class="error">You need to install and activate JetPack Portfolio Custom Content Types to utilize this feature.</span>';
    }

    $wp_customize->add_section( 'portfolio_options', array(
        'title'         => __( 'Portfolio Options', 'shibui' ),
        'priority'      => 50,
        'description'   => $message,
        'panel'         => $portfolio_panel
    ) );

    // Portfolio Show/Hide Setting
    $wp_customize->add_setting( $theme .'_options[portfolio_showhide]', array(
        'default'       => 'show',
        'type'          => $type,
    ) );

    // Portfolio Show/Hide Control
    $wp_customize->add_control( $theme .'portfolio_showhide', array(
        'label'         => __( 'Portfolio Section', 'shibui' ),
        'section'       => 'portfolio_options',
        'settings'      => $theme .'_options[portfolio_showhide]',
        'type'          => 'select',
        'choices'       => array(
            'show'      => __( 'Show', 'shibui' ),
            'hide'     => __( 'Hide', 'shibui' )
        )
    ) );

    // Portfolio Columns Setting
    $wp_customize->add_setting( $theme .'_options[portfolio_grid]', array(
        'default'       => 'one-third-col',
        'type'          => $type,
    ) );

    // Portfolio Show/Hide Control
    $wp_customize->add_control( $theme .'portfolio_grid', array(
        'label'         => __( 'Portfolio Grid', 'shibui' ),
        'section'       => 'portfolio_options',
        'settings'      => $theme .'_options[portfolio_grid]',
        'type'          => 'select',
        'choices'       => array(
            //'full-col'       => __( 'One Column', 'shibui' ),
            //'half-col'       => __( 'Two Columns', 'shibui' ),
            'one-third-col'  => __( 'Three Columns', 'shibui' ),
            'one-forth-col'  =>  __( 'Four Columns', 'shibui' ),
        )
    ) );


    // Portfolio Items size Setting
    $wp_customize->add_setting( $theme .'_options[portfolio_items]', array(
        'default'       => '9',
        'type'          => $type,
    ) );

    // Portfolio Items size Control
    $wp_customize->add_control( $theme .'portfolio_items', array(
        'label'         => __( 'No of Portfolio Items', 'shibui' ),
        'section'       => 'portfolio_options',
        'settings'      => $theme .'_options[portfolio_items]',
        'type'          => 'select',
        'choices'       => array(
            '4'      => __( '4', 'shibui' ),
            '6'     => __( '6', 'shibui' ),
            '8'     => __( '8', 'shibui' ),
            '9'     => __( '9', 'shibui' ),
            '10'     => __( '10', 'shibui' ),
        )
    ) );

    /**
     * Blog Section
     */
    $wp_customize->add_section( 'blog_options', array(
        'title'         => __( 'Blog Options', 'shibui' ),
        'priority'      => 50,
        'panel'         => $blog_panel
    ) );

    // Slideshow Show/Hide Setting
    $wp_customize->add_setting( $theme .'_options[blog_showhide]', array(
        'default'       => 'show',
        'type'          => $type,
    ) );

    // Slideshow Show/Hide Control
    $wp_customize->add_control( $theme .'blog_showhide', array(
        'label'         => __( 'Blog Section', 'shibui' ),
        'section'       => 'blog_options',
        'settings'      => $theme .'_options[blog_showhide]',
        'type'          => 'select',
        'choices'       => array(
            'show'      => __( 'Show', 'shibui' ),
            'hide'     => __( 'Hide', 'shibui' )
        )
    ) );

    // Blog Items size Setting
    $wp_customize->add_setting( $theme .'_options[blog_items]', array(
        'default'       => '4',
        'type'          => $type,
    ) );

    // Portfolio Items size Control
    $wp_customize->add_control( $theme .'blog_items', array(
        'label'         => __( 'No of Blog posts', 'shibui' ),
        'section'       => 'blog_options',
        'settings'      => $theme .'_options[blog_items]',
        'type'          => 'select',
        'choices'       => array(
            '4'      => __( '4', 'shibui' ),
            '8'     => __( '8', 'shibui' ),
            '12'     => __( '12', 'shibui' ),
            '16'     => __( '16', 'shibui' ),
        )
    ) );


    /**
     * Fonts Section
     */
    $wp_customize->add_section( 'fonts', array(
        'title'         => __( 'Fonts', 'shibui' ),
        'description'   => sprintf(
            __( 'Choose from over 650 %1$s to match your personal style. %2$s.', 'shibui' ),
            sprintf(
                '<a href="%1$s" target="_blank">%2$s</a>',
                'https://www.google.com/fonts',
                __( 'Google Fonts', 'shibui' )
            ),
            sprintf(
                '<a href="%1$s" target="_blank">%2$s</a>',
                'http://femmebot.github.io/google-type/',
                __( 'Get inspired', 'shibui' )
            )
        ),
        'priority'      => 10,
        'panel'         => $typography_panel
    ) );

    // Font Setting
    $wp_customize->add_setting( $theme .'_options[font]', array(
        'default'       => '',
        'type'          => $type,
        'transport'     => 'postMessage'
    ) );

    // Font Control
    $wp_customize->add_control( $theme .'_font', array(
        'label'         => __( 'Headline Font', 'shibui' ),
        'section'       => 'fonts',
        'settings'      => $theme .'_options[font]',
        'type'          => 'select',
        'choices'       => shibui_extract_valid_options( shibui_font_array() )
    ) );

    // Font Alt Setting
    $wp_customize->add_setting( $theme .'_options[font_alt]', array(
        'default'       => '',
        'type'          => $type,
        'transport'     => 'postMessage'
    ) );

    // Font Alt Control
    $wp_customize->add_control( $theme .'_font_alt', array(
        'label'         => __( 'Body Font', 'shibui' ),
        'section'       => 'fonts',
        'settings'      => $theme .'_options[font_alt]',
        'type'          => 'select',
        'choices'       => shibui_extract_valid_options( shibui_font_array() )
    ) );

    /**
     * Color Section
     */
    $wp_customize->add_section( 'colors', array(
        'title'             => __( 'Color Scheme', 'shibui' ),
        'priority'          => 10,
        'panel'             => $colors_panel
    ) );

    // Color Scheme Setting
    $wp_customize->add_setting( $theme .'_options[color]', array(
        'default'           => 'default',
        'sanitize_callback' => 'shibui_sanitize_color_scheme',
        'type'              => $type,
        'transport' => 'postMessage'
    ) );

    // Color Scheme Control
    $wp_customize->add_control( $theme .'_color', array(
        'label'             => __( 'Color Scheme', 'shibui' ),
        'section'           => 'colors',
        'type'              => 'select',
        'settings'          => $theme .'_options[color]',
        'choices'           => shibui_get_color_scheme_choices(),
        'priority'          => 1,
    ) );

    // Accent Color Setting
    $wp_customize->add_setting( $theme .'_options[accent_color]', array(
        'default'           => $color_scheme[1],
        'panel'             => $colors_panel,
        'type'              => $type,
        'transport' => 'postMessage'
    ) );

    // Accent Color Control
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $theme .'_accent_color', array(
        'label'             => __( 'Accent Color', 'shibui' ),
        'section'           => 'colors',
        'settings'          => $theme .'_options[accent_color]'
    ) ) );

    // Dark Color Setting
    $wp_customize->add_setting( $theme .'_options[dark_color]', array(
        'default'           => $color_scheme[1],
        'panel'             => $colors_panel,
        'type'              => $type,
        'transport' => 'postMessage'
    ) );

    // Dark Color Control
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $theme .'_dark_color', array(
        'label'             => __( 'Dark Color', 'shibui' ),
        'section'           => 'colors',
        'settings'          => $theme .'_options[dark_color]'
    ) ) );

    /**
     * Background Section
     */
    $wp_customize->add_section( 'background_image', array(
        'title'         => __( 'Background Image', 'shibui' ),
        'priority'      => 30,
        'panel'         => $colors_panel,
        'transport' => 'refresh'
    ) );

    /**
     * Custom CSS Section
     */
    $wp_customize->add_section( 'custom_css', array(
        'title'         => __( 'Custom CSS', 'shibui' ),
        'priority'      => 90,
        'panel'         => $colors_panel
    ) );

    // Custom CSS Setting
    $wp_customize->add_setting( $theme .'_options[css]', array(
        'default'       => '',
        'type'          => $type,
        'transport'     => 'postMessage'
    ) );

    // Custom CSS Control
    $wp_customize->add_control( $theme .'_css', array(
        'label'         => __( 'CSS', 'shibui' ),
        'section'       => 'custom_css',
        'settings'      => $theme .'_options[css]',
        'type'          => 'textarea',
    ) );

    /**
     * Header Section
     */
    $wp_customize->add_section( 'header_image', array(
        'title'         => 'Header Image',
        'priority'      => 10,
        'panel'         => $header_panel
    ) );

    /**
     * Navigation Section
     */
    $wp_customize->add_section( 'nav', array(
        'title'         => __( 'Navigation', 'shibui' ),
        'priority'      => 20,
        'panel'         => $general_panel
    ) );

    /**
     * Welcome Message Section
     */
    $wp_customize->add_section( 'welcomemessage', array(
        'title'         => __( 'Welcome Message', 'shibui' ),
        'priority'      => 30,
        'panel'         => $header_panel
    ) );


    // Welcome Message Setting
    $wp_customize->add_setting( $theme .'_options[welcome_message]', array(
        'default'       => '',
        'type'          => $type,
    ) );

    // Welcome Message Control
    $wp_customize->add_control( $theme .'_welcome_message', array(
        'label'         => __( 'Message', 'shibui' ),
        'section'       => 'welcomemessage',
        'settings'      => $theme .'_options[welcome_message]',
        'type'          => 'textarea',
    ) );



}
add_action( 'customize_register', 'shibui_customize_register' );

/**
 * Register color schemes for shibui.
 *
 * Can be filtered with {@see 'shibui_color_schemes'}.
 *
 * The order of colors in a colors array:
 * 1. Main Background Color.
 * 2. Base Accent Color.
 * 3. Base Dark Color.
 *
 * @since shibui 1.0
 *
 * @return array An associative array of color scheme options.
 */
function shibui_get_color_schemes() {
    return apply_filters( 'shibui_color_schemes', array(
        'default' => array(
            'label'  => __( 'Default', 'shibui' ),
            'colors' => array(
                '#ffffff', // background color
                '#888888', // link color
                '#111111' // dark color
            ),
        ),
        'dark'  => array(
            'label'  => __( 'Dark', 'shibui' ),
            'colors' => array(
                '#111111',
                '#aaaaaa',
                '#eeeeee'
            ),
        ),
        'spring'  => array(
            'label'  => __( 'Spring', 'shibui' ),
            'colors' => array(
                '#effdff',
                '#13c1b6',
                '#f96604'
            ),
        )
    ) );
}

if ( ! function_exists( 'shibui_get_color_scheme' ) ) :
/**
 * Get the current shibui color scheme.
 *
 * @since shibui 1.0
 *
 * @return array An associative array of either the current or default color scheme hex values.
 */
function shibui_get_color_scheme() {
    global $theme_options;

    $color_scheme_option = $theme_options['color'];
    $color_schemes       = shibui_get_color_schemes();

    if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
        return $color_schemes[ $color_scheme_option ]['colors'];
    }

    return $color_schemes['default']['colors'];
}
endif; // shibui_get_color_scheme

if ( ! function_exists( 'shibui_get_color_scheme_choices' ) ) :
/**
 * Returns an array of color scheme choices registered for Twenty Fifteen.
 *
 * @since shibui 1.1
 *
 * @return array Array of color schemes.
 */
function shibui_get_color_scheme_choices() {
    $color_schemes                = shibui_get_color_schemes();
    $color_scheme_control_options = array();

    foreach ( $color_schemes as $color_scheme => $value ) {
        $color_scheme_control_options[ $color_scheme ] = $value['label'];
    }

    return $color_scheme_control_options;
}
endif; // shibui_get_color_scheme_choices

if ( ! function_exists( 'shibui_sanitize_color_scheme' ) ) :
/**
 * Sanitization callback for color schemes.
 *
 * @since shibui 1.0
 *
 * @param string $value Color scheme name value.
 * @return string Color scheme name.
 */
function shibui_sanitize_color_scheme( $value ) {
    $color_schemes = shibui_get_color_scheme_choices();

    if ( ! array_key_exists( $value, $color_schemes ) ) {
        $value = 'default';
    }

    return $value;
}
endif; // shibui_sanitize_color_scheme


/**
 * Enqueues front-end CSS for color scheme.
 *
 * @since shibui 1.0
 *
 * @see wp_add_inline_style()
 */
function shibui_color_scheme_css() {
    global $theme_options;

    $default_bg_color = ( get_theme_mod( 'background_color' ) != false ? get_theme_mod( 'background_color' ) : 'FFFFFF' );

    $bg_color = new Color( $default_bg_color );

    if( isset( $theme_options ) )
        $accent_color_value = $theme_options['accent_color'];
    else
        $accent_color_value = '#ffffff';

    if( isset( $theme_options ) )
        $dark_color_value = $theme_options['dark_color'];
    else
        $dark_color_value = '#111111';

    $accent_color = new Color( $accent_color_value );
    $dark_color = new Color( $dark_color_value );


    if ( $bg_color->isDark() ) {
        $font_color = $dark_color_value;
    } else {
        $font_color = '#111111';
    }
    $final_font_color = new Color( $font_color );

    if ( $dark_color->isDark() ) {
        $header_font_color = '#' . $dark_color->lighten(30);
        $header_link_color = '#' . $dark_color->lighten(40);
    } else {
        $header_font_color = '#' . $dark_color->darken(30);
        $header_link_color = '#' . $dark_color->darken(40);
    }

    $accent_color_darker_15      = '#' . $accent_color->darken(15);
    $dark_color_darker_10        = '#' . $dark_color->darken(10);
    $dark_color_darker_5         = '#' . $dark_color->darken(5);
    $background_color_darker_25  = '#' . $bg_color->darken(25);
    $background_color_lighter_50 = '#' . $bg_color->lighten(50);
    $font_color_darker_30        = '#' . $final_font_color->darken(25);
    $font_color_lighter_15       = '#' . $final_font_color->lighten(15);

    $colors = array(
        'background_color'            => '#' . get_theme_mod( 'background_color' ), // needs to change
        'font_color'                  => $font_color,
        'accent_color'                => $theme_options['accent_color'],
        'accent_color_darker_30'      => $accent_color_darker_15,
        'dark_color'                  => $theme_options['dark_color'],
        'dark_color_darker_10'        => $dark_color_darker_10,
        'dark_color_darker_5'         => $dark_color_darker_5,
        'header_font_color'           => $header_font_color,
        'header_link_color'           => $header_link_color,
        'background_color_darker_25'  => $background_color_darker_25,
        'background_color_lighter_50' => $background_color_lighter_50,
        'font_color_darker_30'        => $font_color_darker_30,
        'font_color_lighter_15'       => $font_color_lighter_15,

    );

    $color_scheme_css = shibui_get_color_scheme_css( $colors );

    wp_add_inline_style( 'shibui-style', $color_scheme_css );
}
add_action( 'wp_enqueue_scripts', 'shibui_color_scheme_css' );

/**
 * Binds JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 *
 * @since shibui 1.0
 */
function shibui_customize_control_js() {
    wp_enqueue_script( 'color-scheme-control', get_template_directory_uri() . '/inc/customizer/js/customizer-color-schemes-control.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '20150123', true );
    wp_localize_script( 'color-scheme-control', 'colorScheme', shibui_get_color_schemes() );
}
add_action( 'customize_controls_enqueue_scripts', 'shibui_customize_control_js' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function shibui_customize_preview_js() {
    wp_enqueue_script( 'shibui_customizer', get_template_directory_uri() . '/inc/customizer/js/customizer.js', array( 'customize-preview' ), '20150129', true );
}
add_action( 'customize_preview_init', 'shibui_customize_preview_js' );

/**
 * Binds to customizer options panel.
 */
function shibui_customize_panel() {
    wp_enqueue_style( 'shibui_customizer_css', get_template_directory_uri() . '/inc/customizer/css/customizer.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'shibui_customize_panel' );

/**
 * Returns CSS for the color schemes.
 *
 * @since shibui 1.0
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function shibui_get_color_scheme_css( $colors ) {
    $defaults = array(
        'background_color'              => $colors['background_color'],
        'font_color'                    => $colors['dark_color'],
        'accent_color'                  => $colors['accent_color'],
        'dark_color'                    => $colors['dark_color'],
        'background_color_darker_25'    => $colors['background_color_darker_25'],
        'background_color_lighter_50'   => $colors['background_color_lighter_50'],
        'accent_color_darker_30'        => $colors['accent_color_darker_30'],
        'dark_color_darker_10'          => $colors['dark_color_darker_10'],
        'dark_color_darker_5'           => $colors['dark_color_darker_5'],
        'header_font_color'             => $colors['header_font_color'],
        'header_link_color'             => $colors['header_link_color'],
        'font_color_darker_30'          => $colors['font_color_darker_30'],
        'font_color_lighter_15'         => $colors['font_color_lighter_15']
    );
    $colors = wp_parse_args( $colors, $defaults );

    $css = <<<CSS
    /* Color Scheme */

    /* Background Color */
    body, .custom-background-image .site, .main-navigation ul  {
        background-color: {$colors['background_color']};
    }

    /* Font Color */
    body,
    .entry-meta,
    .button-border,
    .button-border:hover {
        color: {$colors['font_color']};
    }
    .button-border {
        border-color: {$colors['font_color']};
    }
    .button-border:hover {
        border-color: {$colors['font_color']} !important;
    }
    .comments-area .comment-list .comment .comment-meta .comment-metadata .fn {
        color: {$colors['font_color_darker_30']};
    }

    /* Font Color 15% lighter */
    blockquote {
        color: {$colors['font_color_lighter_15']};
    }

    /* Accent Color */
    a {
        color: {$colors['accent_color']};
    }
    .button,
    button,
    input[type=submit],
    input[type="submit"] {
        background-color: {$colors['accent_color']};
    }
    .button:hover:not(:disabled),
    button:hover:not(:disabled),
    input[type=submit]:hover:not(:disabled),
    input[type="submit"]:hover:not(:disabled) {
        background-color: {$colors['accent_color_darker_30']};
    }
    .entry-meta a,
    .entry-footer a {
        color: {$colors['accent_color_darker_30']};
    }

    /* Accent Color 30% darker */
    a:hover,
    a:active,
    a:focus,
    .entry-meta a:hover,
    .entry-footer a:hover {
        color: {$colors['accent_color_darker_30']};
    }

    /* Dark Color */
    .site-title a,
    .site-welcome,
    .entry-title a,
    .widget-title,
    .section-title {
        color: {$colors['dark_color']};
    }

    /* Dark Color 10% darker */
    .site-header .main-navigation ul.sub-menu:before,
    .site-header .main-navigation ul.sub-menu:after {
        border-bottom-color: {$colors['dark_color_darker_10']};
    }

    /* Dark Color 25% lighter */
    h2.entry-title,
    .entry-title a:hover,
    .site-footer {
        color: {$colors['header_font_color']};
    }
    .main-navigation a:hover,
    .main-navigation li:hover > a {
        color: {$colors['dark_color_darker_5']};
    }
    .site-description,
    .site-action a,
    .site-header .site-action .button-border,
    .site-header .site-action .button-border:hover,
    .site-header .social a,
    .main-navigation ul li a,
    .site-footer a {
        color: {$colors['accent_color']};
    }

    /* Dark Color 50% lighter */
    .site-header .site-action .button-border {
        border-color: {$colors['header_link_color']};
    }
    .site-header .site-action .button-border:hover {
        border-color: {$colors['header_link_color']} !important;
    }

    /* Background Color 25% darker */
    textarea,
    input,
    table tbody tr:first-child th,
    table tbody tr:first-child td,
    table tbody th,
    table tbody td,
    hr,
    form textarea,
    input[type="email"],
    input[type="number"],
    input[type="password"],
    input[type="search"],
    input[type="tel"],
    input[type="text"],
    input[type="url"],
    input[type="color"],
    input[type="date"],
    input[type="datetime"],
    input[type="datetime-local"],
    input[type="month"],
    input[type="time"],
    input[type="week"],
    select[multiple=multiple],
    .widget-area ul li.recentcomments,
    .widget-area ul li a,
    .comments-title {
        border-color: {$colors['background_color_darker_25']};
    }

    /* Background Color 50% lighter */
    blockquote {
        background: {$colors['background_color_lighter_50']};
    }

    .has-header-image.customizer-preview .site-title a,
    .has-header-image.customizer-preview .main-navigation ul li a,
    .has-header-image.customizer-preview .site-action a,
    .has-header-image.customizer-preview .site-header .social a,
    .has-header-image.customizer-preview .site-welcome {
        color: #FFFFFF;
    }

    .has-header-image.customizer-preview .site-header .site-action .button-border,
    .has-header-image.customizer-preview .site-header .site-action .button-border:hover {
        border-color: #FFFFFF;
        color: #FFFFFF;
    }

CSS;

    return $css;
}

/**
 * Output an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the Customizer
 * preview.
 *
 * @since shibui 1.0
 */
function shibui_color_scheme_css_template() {
    $colors = array(
        'background_color'            => '{{ data.background_color }}',
        'font_color'                  => '{{ data.font_color }}',
        'accent_color'                => '{{ data.accent_color }}',
        'dark_color'                  => '{{ data.dark_color }}',
        'accent_color_darker_30'      => '{{ data.accent_color_darker_30 }}',
        'dark_color_darker_10'        => '{{ data.dark_color_darker_10 }}',
        'dark_color_darker_5'         => '{{ data.dark_color_darker_5 }}',
        'header_font_color'           => '{{ data.header_font_color }}',
        'header_link_color'           => '{{ data.header_link_color }}',
        'background_color_darker_25'  => '{{ data.background_color_darker_25 }}',
        'background_color_lighter_50' => '{{ data.background_color_lighter_50 }}',
        'font_color_darker_30'        => '{{ data.font_color_darker_30 }}',
        'font_color_lighter_15'       => '{{ data.font_color_lighter_15 }}',
    );
    ?>
    <script type="text/html" id="tmpl-shibui-color-scheme">
        <?php echo shibui_get_color_scheme_css( $colors ); ?>
    </script>
    <?php
}
add_action( 'customize_controls_print_footer_scripts', 'shibui_color_scheme_css_template' );

/**
 * Validates theme customizer options
 */
function shibui_extract_valid_options( $options ) {
    $new_options = array();
    foreach( $options as $option ) {
        if ( isset( $option['variants'] ) && '' != $option['variants'] ) {
            $variants = implode( ',', $option['variants'] );
            $opt =  $option['label'] . ':' . $variants;
        } else {
            $opt = $option['name'];
        }
        if ( isset ( $option['label'] ) ) {
            $new_options[ $opt ] = $option['label'];
        } else {
            $new_options[ $opt ] = $option['title'];
        }
    }
    return $new_options;
}