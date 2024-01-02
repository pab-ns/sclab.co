<?php
/**
 * @package Shibui
 */
?>

<?php
	global $theme_options, $grid;
	$grid = $theme_options['portfolio_grid'];
?>

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