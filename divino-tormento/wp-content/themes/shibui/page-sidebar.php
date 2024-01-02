<?php
/**
 * Template Name: Page with Sidebar
 *
 * @package Shibui
 */

get_header(); ?>

<?php
	$classes = get_body_class();
?>

	<div id="primary" class="content-area<?php if ( is_active_sidebar( 'sidebar-1' ) ) { echo ' three-forth-col'; } ?>">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>


			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
