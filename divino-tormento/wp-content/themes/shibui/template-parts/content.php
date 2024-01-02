<?php
/**
 * @package Shibui
 */
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
        <div class="entry-image"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'blog-size' ); ?></a></div>
    <?php endif; ?>

	<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

	<div class="entry-content-container">
		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta one-third-col">
				<?php shibui_posted_on(); ?>
				<?php shibui_entry_footer(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>

		<div class="entry-content two-third-col<?php if ( is_home() || is_category() || is_archive() ) { echo ' excerpt-content'; } ?>">
			<?php if ( is_single()) : ?>

				<?php
					/* translators: %s: Name of current post */
					the_content( sprintf(
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'shibui' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );
				?>

				<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'shibui' ),
						'after'  => '</div>',
					) );
				?>

			<?php endif; ?>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->