<?php
/**
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

?>

<article id="post-<?php the_ID(); ?>" class="blog-grid one-forth-col">

	<figure>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="entry-image"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $image_size ); ?></a></div>
		<?php endif; ?>

		<figcaption>
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		</figcaption>
	</figure>

</article><!-- #post-## -->