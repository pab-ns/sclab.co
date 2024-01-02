<?php

	// Get Portfolio Image Size
	global $paged, $post, $max_pages, $theme_options, $grid;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', false, false, false );
			if ( $categories_list ) :
		?>
			<span class="entry-meta entry-meta-categories"><?php echo $categories_list; ?></span>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'eighties' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<div class="entry-meta entry-meta-tags">
			<?php esc_html_e( 'Tags: ', 'shibui' ); ?><?php echo get_the_term_list( get_the_ID(), 'jetpack-portfolio-tag', false, false, false ) ?>
		</div>
	</footer>
</article><!-- #post-## -->