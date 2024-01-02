<?php
/**
 * Template Name: Homepage Template
 *
 * @package WordPress
 * @subpackage Shibui
 * @since Shibui 1.0
 */
$theme_options = shibui_get_theme_options();

get_header(); ?>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php  if ( isset ( $theme_options['welcome_message'] ) && '' <> $theme_options['welcome_message'] ) : ?>
			<!-- Welcome Section -->
			<div class="welcome-section">
				<?php get_template_part( 'template-parts/section', 'welcome' ); ?>
			</div>
			<!-- End Welcome Section -->
		<?php endif; ?>


		<?php if( post_type_exists( 'jetpack-portfolio' ) ) : ?>
			<?php  if ( '' == ( $theme_options['portfolio_showhide'] )  || 'show' == $theme_options['portfolio_showhide'] ) : ?>
				<!-- Portfolio Section -->
				<div class="portfolio-section">
					<?php get_template_part( 'template-parts/section', 'portfolio' ); ?>
				</div>
				<!-- End Portfolio Section -->
			<?php endif; ?>
		<?php endif; ?>

		<?php  if ( 'show' == $theme_options['blog_showhide'] ) : ?>
			<!-- Blog Section -->
			<h2 class="section-title"><?php echo apply_filters( 'shibui_blog_title', __( 'Blog', 'shibui' ) ); ?></h2>

			<div class="blog-section">
				<?php get_template_part( 'template-parts/section', 'blog' ); ?>
			</div>
			<!-- End Blog Section -->
		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
