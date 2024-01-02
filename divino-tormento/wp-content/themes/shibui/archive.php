<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shibui
 */

global $theme_options, $grid;

// Get Portfolio Image Size
if ( shibui_is_jetpack_portfolio_archive() ) {
	$grid = $theme_options['portfolio_grid'];
	$image_size = 'nocrop';
} else {
	$grid = 'one-forth-col';
	$image_size = 'landscape';
}

get_header(); ?>

	<div id="primary" class="content-area">

		<header class="page-header">
			<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
		</header><!-- .page-header -->

		<main id="main" class="site-main" role="main">

			<div class="<?php if ( shibui_is_jetpack_portfolio_archive() ) { ?>portfolio-content<?php } else { ?>blog-content<?php } ?>">

	        	<div class="grid-sizer <?php echo $grid; ?>"></div>
				<div class="gutter-sizer"></div>

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" class="<?php if ( shibui_is_jetpack_portfolio_archive() ) { ?>portfolio-grid<?php } else { ?>blog-grid<?php } ?> grid-item <?php echo $grid; ?>">
		                <figure>
		                    <?php if ( has_post_thumbnail() ) : ?>
		                        <div class="entry-image"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $image_size ); ?></a></div>
		                    <?php endif; ?>

		                    <figcaption>
		                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		                    </figcaption>
		                </figure>
		            </article>

				<?php endwhile; ?>

				<?php if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' )) { echo''; } else { shibui_posts_navigation(); } ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>

			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
