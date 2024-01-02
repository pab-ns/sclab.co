<?php

    /**
     * Portfolio Section
     */

    global $paged, $post, $max_pages, $theme_options, $grid;
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

    $args = array(
        'post_type' => 'jetpack-portfolio',
        'posts_per_page' => $theme_options['portfolio_items'],
        'ignore_sticky_posts' => true,
        'paged' => $paged
    );

    $temp = $wp_query;
    $wp_query = null;

    $wp_query = new WP_Query();
    $wp_query->query( apply_filters( 'shibui_portfolio_args_filter', $args ) );
    $max_pages = $wp_query->max_num_pages;

    $grid = $theme_options['portfolio_grid'];


?>

<?php if ( have_posts() ) : ?>

<section id="section-portfolio" class="section portfolio">

    <div class="portfolio-content">

        <div class="grid-sizer <?php echo $grid; ?>"></div>
        <div class="gutter-sizer"></div>

        <?php /* Start the Loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" class="portfolio-grid grid-item <?php echo $grid; ?>">
            <figure>
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="entry-image"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'nocrop' ); ?></a></div>
                <?php endif; ?>

                <figcaption>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </figcaption>
            </figure>
        </article>

        <?php endwhile; wp_reset_query(); $wp_query = $temp; ?>

    </div><!--  .portfolio-content -->

</section>

<?php endif; ?>