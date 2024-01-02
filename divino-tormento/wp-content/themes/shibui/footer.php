<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Shibui
 */
?>

		</div><!-- #content -->

		<footer id="colophon" role="contentinfo" class="clearfix">

			<?php if ( is_front_page() ) : ?>
			<div class="call-to-action-widget">
				<?php dynamic_sidebar( 'call-to-action-1' ); ?>
			</div>
			<?php endif; ?>

			<div class="footer-widgets">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>

			<div class="social-menu">
	    		<?php if ( has_nav_menu( 'social' ) ) {
			        wp_nav_menu( array( 'theme_location' => 'social', 'container' => 'false', 'menu_class' => 'menu-social' ));
			    } ?>
			</div><!-- .social-menu -->

			<div class="site-info">
		        <span><?php printf( __( 'Powered by %s %2$s theme by %3$s.', 'shibui' ), '<a href="http://wordpress.org">WordPress</a>.', '<a href="http://graphpaperpress.com/themes/shibui" rel="designer">Shibui</a>', '<a href="http://graphpaperpress.com/" rel="designer">Graph Paper Press</a>' ); ?></span>
		    </div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- .full-col -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
