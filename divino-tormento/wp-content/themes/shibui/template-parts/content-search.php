<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shibui
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

	<div class="entry-content-container">
		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta one-third-col">
				<?php shibui_posted_on(); ?>
				<?php shibui_entry_footer(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>

		<div class="entry-content two-third-col">
			<?php the_excerpt(); ?>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
