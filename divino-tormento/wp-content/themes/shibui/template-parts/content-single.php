<?php
/**
 * @package Shibui
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content-container">

		<div class="entry-content">
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
		</div>

		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php shibui_posted_on(); ?>
				<?php shibui_entry_footer(); ?>
			</div><!-- .entry-meta -->
		<?php elseif ( 'jetpack-portfolio' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php shibui_entry_footer_portfolio(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->