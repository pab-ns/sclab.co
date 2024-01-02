<?php
	/**
     * Blog Section
     */

    global $paged, $post, $max_pages, $theme_options, $grid;
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $theme_options['blog_items'],
        'ignore_sticky_posts' => true,
        'paged' => $paged
    );

    $temp = $wp_query;
    $wp_query = null;

    $wp_query = new WP_Query();
    $wp_query->query( apply_filters( 'shibui_blog_args_filter', $args ) );
    $max_pages = $wp_query->max_num_pages;
?>

<?php if ( have_posts() ) : ?>



	<?php /* Start the Loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>

		<?php
			/* Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/blog', 'grid' );
		?>

	<?php endwhile; ?>

<?php else : ?>

	<?php get_template_part( 'template-parts/content', 'none' ); ?>

<?php endif; ?>