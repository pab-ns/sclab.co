<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Shibui
 */

$theme_options = shibui_get_theme_options();

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
	
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'shibui' ); ?></a>
	<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<div class="site-branding">
				<h1 class="site-title">
                    <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                        <?php if ( ! empty( $theme_options['logo'] ) ) : ?>
                            <img class="sitetitle" src="<?php echo esc_url( $theme_options['logo'] ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
                        <?php else : ?>
                            <?php bloginfo( 'name' ); ?>
                        <?php endif; ?>
                    </a>
                </h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle genericon genericon-menu" aria-controls="primary-menu" aria-expanded="false"></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
			</nav><!-- #site-navigation -->
		</div>

		</header><!-- #masthead -->

	<div id="page" class="hfeed site">


	<?php  if ( is_front_page() && ! empty ( $theme_options['slideshow'] ) && 'show' == $theme_options['slideshow_showhide'] ) : ?>

		<!-- Slideshow Section -->
		<div class="slideshow-section">
			<?php get_template_part( 'template-parts/section', 'slideshow' ); ?>
		</div>
		<!-- End Slideshow Section -->

	<?php endif; ?>

		<div class="full-col container">

			<div id="content" class="site-content">
