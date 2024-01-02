<?php
/**
 * Template Name: Blog Page Template
 *
 * @package Shibui
 */

get_header();

    global $paged, $post, $max_pages, $theme_options, $grid;
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

    $args = array(
        'post_type' => 'post',
        'ignore_sticky_posts' => true,
        'paged' => $paged
    );

    $temp = $wp_query;
    $wp_query = null;

    $wp_query = new WP_Query();
    $wp_query->query( apply_filters( 'shibui_blog_args_filter', $args ) );
    $max_pages = $wp_query->max_num_pages;
?>
<div class="full-col container">

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <?php if ( have_posts() ) : ?>

            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header><!-- .entry-header -->



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

         <?php shibui_posts_navigation();  wp_reset_query(); $wp_query = $temp; ?>

            <?php edit_post_link( __( 'Edit', 'shibui' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>

        </main><!-- #main -->
    </div><!-- #primary -->

</div>

<?php get_footer(); ?>